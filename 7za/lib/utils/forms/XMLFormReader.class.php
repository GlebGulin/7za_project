<?PHP
/**
 *  SmartMVC Framework.
 *  Copyright (C) 2004  Belisar Systems
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2.1 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public
 *  License along with this library; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
 *
 */

require_once(LIB . "utils/xml/XML_Parser_Simple.class.php");

/**
 * Reads and parses form definition.
 *
 * Uses XML format for defining forms.
 *
 * @package SmartMVC
 * @version 0.4 (01/11/2004)
 * @author Alex Koshel <alex@belisar.de>
 */
class XMLFormReader extends wrapper 
{

    var $forms_prefix       = "";
    var $num_items          = 0;
    var $items              = array();
    var $xml_items          = array();
    var $root               = array();
    var $children           = array();
    var $parser             = "";
    
    /**
     * Construtor for the class.
     *
     * @return  XMLFormReader
     */
    function XMLFormReader()
    {
        parent::wrapper();
        
        // Set path to place where xml files reside
        $this->forms_prefix = TEMPLATE_DIR . DIR_SEP . 'forms' . DIR_SEP;
    }

    /**
    * Used by XML parser for handling the node.
    *
    * @return void
    * @param    string  $name
    * @param    array   $attr
    * @param    string  $data
    */
    function handleElement($name, $attr, $data)
    {
        $item = array();
        $item["name"] = strtolower($name);
        $item["data"] = $data;
        foreach ($attr as $key=>$value)
        {
            $key = strtolower($key);
            $item[$key] = $value;
        }
        
        if ($this->parser->getCurrentDepth() == 1)
        {
            if (count($this->children) > 0)
            {
                $item["children"] = $this->children;
                $this->children = array();
            }
            
            $this->xml_items[] = $item;
        }
        elseif ($this->parser->getCurrentDepth() == 2)
        {
            $this->children[] = $item;
        }
        elseif ($this->parser->getCurrentDepth() == 0)
            $this->root = $item;
    }
    
    /**
    * Reads the XML form template from a file.
    *
    * @return   array
    * @param    string  $file
    */
    function readXMLFile( $file )
    {
        $this->parser = $this->getClassOf("utils.xml.XML_Parser_Simple");
        $this->parser->setHandlerObj($this);
        
        if (!is_file($this->forms_prefix . $file))
            $this->addDebugMsg("Cannot find file ". $this->forms_prefix . $file, "XMLFormReaderError");
        
        $this->parser->setInputFile($this->forms_prefix . $file );
        $this->parser->parse();

        $nodes = $this->xml_items;
        foreach ($nodes as $node)
        {
            $item = $node["item"];
            switch ($item)
            {
                case "input_text":
                case "input_password":
                case "textarea":
                case "input_submit":
                case "radio":
                case "checkbox":
                case "checkbox_array":
                case "select":
                case "hidden":
                case "file":
                                $this->addCommonItem($node);
                                break;
            }
        }
        
        return $this->items;
    }
    
    /**
    * Adds a node to common structure.
    *
    * @return void
    * @param    array   $node
    */
    function addCommonItem( $node )
    {
        $this->items[$this->num_items]["name"] = $node["name"];

        if ($node["item"] == "input_submit")
            $this->items[$this->num_items]["mandatory"] = "no";
            
        // template fields are mandatory by default
        if (!isset($this->items[$this->num_items]["mandatory"]))
            $this->items[$this->num_items]["mandatory"] = "yes";
            
        // Some syntax checkings
        if ($node["item"] == "file" && isset($node["type"]) && $node["type"] != "file")
            $this->addDebugMsg("You must use type='file' with item='file'.", "XMLFormReaderError");
        if ($node["item"] == "file" && !isset($node["type"]))
            $node["type"] = "file";
            
        // Getting attributes of a node
        foreach ($node as $key=>$value)
            if ($key != "name")
                $this->items[$this->num_items][$key] = $value;
                
        if ($node["item"] != "input_submit" && !isset($node["type"]))
            $this->addDebugMsg("You nust specify type parameter for item ".$node["name"].".", "XMLFormReaderError");
                
        $this->num_items++;
    }
}

?>