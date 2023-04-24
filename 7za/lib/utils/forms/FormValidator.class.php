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

/**
 * The class for HTML form validation [<i>utils.forms.FormValidator</i>].
 *
 * Uses XML format for defining forms.
 *
 * @package SmartMVC
 * @version 0.3 (13/10/2004)
 * @author Alex Koshel <alex@belisar.de>
 */

class FormValidator extends wrapper
{

    var $passed_items       = array();
    var $wrong_items        = array();
    
    /**
     * Construtor for the class.
     *
     * @return  FormValidator
     */
    function FormValidator()
    {
        parent::wrapper();
    }

    /**
    * Validates given array for the template.
    *
    * @see      matchConditions()
    * @return   array
    * @param    array   $form       associative array received from a form
    * @param    array   $tpl        form template
    */
    function validateForm( $form, $tpl )
    {
        if (!is_array($tpl))
            $this->addDebugMsg("validateForm() method requires an array as 2nd param, use validateFormXML() for specifying xml file", "validateForm()");
            
        // clearing arrays
        $this->wrong_items  = array();
        //$this->passed_items = array();
            
        // template fields are mandatory by default
        for ($i=0; $i<count($tpl); $i++)
            if (!isset($tpl[$i]["mandatory"]))
                $tpl[$i]["mandatory"] = "yes";
        
        for ($i=0; $i<count($tpl); $i++)
        {
            // checking if type="file" is specified and copy the record from $_FILES array to the form
            $item_name = $tpl[$i]["name"];
            if (@$tpl[$i]["type"] == "file" && isset($_FILES[$item_name]))
            {
                $form[$item_name] = $_FILES[$item_name];
            }
            
            if (isset($form[$tpl[$i]["name"]]))
            {
                if ( $this->matchConditions($tpl[$i], $form[$tpl[$i]["name"]]) )
                    $this->passed_items[$tpl[$i]["name"]] = $form[$tpl[$i]["name"]];
                else 
                    $this->wrong_items[] = $tpl[$i]["name"];
            }
            else
            {
                // if field missed
                if (isset($tpl[$i]["mandatory"]) && $tpl[$i]["mandatory"] == "yes")
                    $this->wrong_items[] = $tpl[$i]["name"];
            }
        }
        return $this->passed_items;
    }
    
    /**
    * Validates given array for the template from XML file.
    *
    * Template for the form must be taken from XML file and contain conditions
    * for every field of a form.
    *
    * @see      matchConditions()
    * @return   array
    * @param    array   $form       associative array received from a form
    * @param    string  $template   XML file with form template
    */
    function validateFormXML( $form, $template )
    {
        $reader = $this->getClassOf("utils.forms.XMLFormReader");
        $tpl = $reader->readXMLFile($template);

        return $this->validateForm($form, $tpl);
    }
    
   /**
    * Returns the list of mandatory fields of the form separated by space.
    *
    * Used for JavaScript form validation.
    *
    * @return   string
    * @param    string  $xml_file
    * @access   public
    */
    function getMandatoryFields( $xml_file )
    {
        $reader = $this->getClassOf("utils.forms.XMLFormReader");
        $tpl = $reader->readXMLFile( $xml_file );
        
        $fields = "";
        for ( $i = 0; $i < count($tpl); $i++ )
            if ( isset( $tpl[$i]["mandatory"] ) && $tpl[$i]["mandatory"] == "yes" )
                $fields .= $tpl[$i]["name"] . ' ';
        
        if ( strlen($fields) > 0 )
            $fields = substr($fields, 0, strlen($fields) - 1);
            
        return $fields;
    }
    
    /**
    * Checks whether given value fits to conditions specified in the array.
    *
    * The following conditions to be checked:<br>
    * $tpl["type"] - for the type of a variable<br>
    * $tpl["length"] - for maximum length<br>
    * $tpl["regexp"] - whether value correspons to given pattern<br>
    * $tpl["mandatory"] - whether field is mandatory (yes|no)<br>
    * $tpl["filemask"] - allowed file extensions separated with | (only for type="file")<br>
    * $tpl["size"] - maximum file size (only for type="file")
    *
    * Function returns <i>true</i> if all conditions passed, <i>false</i> otherwise.
    *
    * @return   boolean
    * @param    array       $tpl
    * @param    mixed       $value
    * @access   private
    */
    function matchConditions( $tpl, $value )
    {
        if ($tpl["type"] == "file")
        {
            $match = true;
            if (!is_array($value) && $tpl["mandatory"] == "yes")
                return false;
                
            if (!is_uploaded_file($value["tmp_name"]) && $tpl["mandatory"] == "yes")
                return false;
                
            // checking for file extension
            if (is_uploaded_file($value["tmp_name"]) && isset($tpl["filemask"]))
            {
                $file_ext = substr($value["name"], strrpos($value["name"], ".")+1);
                
                // files extensions must be separated with |
                $ext = explode("|", $tpl["filemask"]);
                for ($i=0; $i<count($ext); $i++)
                    $ext[$i] = strtolower($ext[$i]);

                if (!in_array(strtolower($file_ext), $ext))
                    $match = false;
            }
            
            // checking for maximum file size
            if (is_uploaded_file($value["tmp_name"]) && isset($tpl["size"]))
            {
                $tpl["size"] = strtolower($tpl["size"]);
                if (preg_match("/(\d+)\s?(kb?|mb?)?/i", $tpl["size"], $matches))
                {
                    $size = $matches[1];
                    if (isset($matches[2]) && is_integer(strpos($matches[2], 'k')))
                        $size *= 1024;
                    if (isset($matches[2]) && is_integer(strpos($matches[2], 'm')))
                        $size *= 1024*1024;
                }
                if ($value["size"]>$size)
                    $match = false;
            }
            
            return $match;
        }
        
        if (is_array($value))
        {
            $match = true;
            foreach ($value as $item)
                $match = $match && $this->matchConditions($tpl, $item);
                
            return $match;
        }
        else 
        {
            $match = true;
            
            // Checking for a type
            if (isset($tpl["type"]) && !empty($tpl["type"]) && $value != "")
            {
                switch ($tpl["type"])
                {
                    case "int":
                    case "integer":
                                $match = $match && ((boolean) preg_match("/^\d+\$/", $value));
                                break;
                    case "varchar":
                    case "string":
                                $match = $match && settype($value, "string");
                                break;
                    case "float":
                                $match = $match && ((boolean) preg_match("/^\d*(\.\d*)?\$/", $value));
                                break;
                    case "email":
                                $tpl["regexp"] = "/^[a-z][\w\-\.]*\w\@([\w\-]+\.)+[a-z]{2,7}\$/i";
                                break;
                    case "url":
                                $tpl["regexp"] = "/^(http:\/\/|ftp:\/\/)([\w\-]+\.)+[a-z]{2,7}[~\w\-\/\.\?\&=]*\$/i";
                                break;
                }
            }
            
            // Checking for maximum length
            if (isset($tpl["max_length"]) && !empty($tpl["max_length"]) && $match)
            {
                $match = $match && (strlen($value) <= $tpl["max_length"]);
            }
            
            // Checking for empty value
            if ($tpl["mandatory"] == "yes" && $value == "")
                $match = false;
            
            // Checking for minimum length
            if (isset($tpl["min_length"]) && !empty($tpl["min_length"]) && $match)
            {
                $match = $match && (strlen($value) >= $tpl["min_length"]);
            }
            
            // Checking for regexp pattern
            if (isset($tpl["regexp"]) && !empty($tpl["regexp"]) && $match)
            {
                if (preg_match($tpl["regexp"], $value))
                    $match = $match && true;
                else
                    $match = false;
            }
        
            return $match;
        }
    }

    /**
    * Returns an array of names which are not passed conditions.
    *
    * @return   array
    */
    function getWrongFields()
    {
        return $this->wrong_items;
    }
    
    /**
    * Returns a request array which passed the validation.
    *
    * @return   array
    */
    function getValidated()
    {
        //foreach ($this->passed_items as $key=>$value)
            //$this->passed_items[$key] = str_replace("'", "\\'", $value);
        return $this->passed_items;
    }
    
}

?>