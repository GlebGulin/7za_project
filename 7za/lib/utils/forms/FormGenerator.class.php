<?PHP 

class FormGenerator extends wrapper
{ 
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/
    
    var $tpl_items          = array();
    var $validCode          = "";
    var $num_items          = array();
    var $valid_queue        = array();
    var $smarty             = true;
  
/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/   
  
    /**
     * constructor
     * each contructor within this framework must at least look like this one
     */
    function FormGenerator()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/ 	

    /**
     * Main method for generating HTML code for a form.
     *
     * @return   string
     * @param    string     $xml_file
     * @param    boolean    $smarty_code    whether to insert Smarty code
     * @access   public
     */
    function generateHTMLForm( $xml_file, $smarty_code = true )
    {
        $this->readXMLTemplate( $xml_file );
        $this->smarty = $smarty_code;
        
        $output = '<form action="" method="POST" enctype="multipart/form-data" onSubmit="return validateForm();">' . "\r\n";
        // putting hidden fields first
        for ( $i = 0; $i < count($this->tpl_items); $i++ )
        {
            if ( $this->tpl_items[$i]["item"] == "hidden" )
                $output .= $this->getFormItem($this->tpl_items[$i]["name"]) . "\r\n";
        }
        $output .= '<table width="100%" cellpadding="2" cellspacing="0" border="0">' . "\n\r";
        
        for ( $i = 0; $i < count($this->tpl_items); $i++ )
        {
            if ( $this->tpl_items[$i]["item"] != "hidden" )
            {
                $output .= '<tr>' . "\r\n";
                if ( $this->tpl_items[$i]["item"] == "input_submit" )
                    $output .= ' <td colspan="2" align="center">';
                else
                    $output .= ' <td>' . $this->tpl_items[$i]["name"] . ($this->tpl_items[$i]["mandatory"] == "yes"?"*":"") . '</td>' . "\r\n" . " <td>";
                    
                $output .= $this->getFormItem($this->tpl_items[$i]["name"]);
                $output .= "</td>\r\n</tr>\r\n";
            }
        }
                  
        $output .= '</table>'.($this->smarty ? '{$js_validation}' : '').'</form>';
        return $output;
    }
    
    /**
    * Reads the form template from XML file.
    *
    * @return   void
    * @param    string  $xml_file
    * @access   private
    */
    function readXMLTemplate( $xml_file )
    {
        $reader = $this->getClassOf("utils.forms.XMLFormReader");
        $this->tpl_items = $reader->readXMLFile($xml_file);
    }
    
    /**
    * Returns associative array with the structure of form item based on XML template.
    *
    * @return   array
    * @param    string  $name   the name of an item
    * @access   private
    */
    function getTplItem( $name )
    {
        $i = 0;
        while ($i<count($this->tpl_items) && $this->tpl_items[$i]["name"] != $name)
            $i++;
            
        if ($i == count($this->tpl_items))
            $this->addDebugMsg("There is no definition for ".$name." item.", "FormGeneratorError");
        else 
            return $this->tpl_items[$i];
    }
    
    /**
    * Returns generated HTML code for specified form item.
    *
    * @return   string
    * @param    string  $name       the name of an item
    * @access   private
    */
    function getFormItem( $name )
    {
        $item = $this->getTplItem($name);
        
        switch ($item["item"])
        {
            case "input_text":
                                return $this->getInputTextItem($item);
                                break;
            case "input_password":
                                return $this->getInputPasswordItem($item);
                                break;
            case "input_submit":
                                return $this->getInputSubmitItem($item);
                                break;
            case "radio":
                                return $this->getRadioItem($item);
                                break;
            case "checkbox":
                                return $this->getCheckboxItem($item);
                                break;
            case "checkbox_array":
                                return $this->getCheckboxArrayItem($item);
                                break;
            case "hidden":
                                return $this->getInputHiddenItem($item);
                                break;
            case "textarea":
                                return $this->getTextareaItem($item);
                                break;
            case "select":
                                return $this->getSelectItem($item);
                                break;
            case "file":
                                return $this->getFileItem($item);
                                break;
        }
        
    }
    
    /**
    * Generates HTML code for text input field.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getInputTextItem( $tpl )
    {
        $code = '<input type="text" name="'.$tpl["name"].'" id="'.$tpl["name"].'" value="'.
                ($this->smarty ? '{$'.$tpl["name"].'}' : '').'" />';
        
        return $code;
    }
    
    /**
    * Generates HTML code for text input field of type password.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getInputPasswordItem( $tpl )
    {
        $code = '<input type="password" name="'.$tpl["name"].'" id="'.$tpl["name"].'" />';
        
        return $code;
    }
    
    /**
    * Generates HTML code for hidden input field.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getInputHiddenItem( $tpl )
    {
        $code = '<input type="hidden" name="'.$tpl["name"].'" id="'.$tpl["name"].'" value="'.
                ($this->smarty ? '{$'.$tpl["name"].'}' : '').'" />';
        
        return $code;
    }
    
    /**
    * Generates HTML code for submit button of a form.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getInputSubmitItem( $tpl )
    {
        $code = '<input type="submit" value="Submit" />';
        
        return $code;
    }
    
    /**
    * Generates HTML code for radio buttons on the form.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getRadioItem( $tpl )
    {
        $code = '<input type="radio" name="'.$tpl["name"].'" id="'.$tpl["name"].'0" value="1"'.
                ($this->smarty ? '{if $'.$tpl["name"].'} checked{/if}' : '').' />';
        
        return $code;
    }
    
    /**
    * Generates HTML code for checkbox item on the form.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getCheckboxItem( $tpl )
    {
        $code = '<input type="checkbox" name="'.$tpl["name"].'" id="'.$tpl["name"].'" value="1"'.
                ($this->smarty ? '{if $'.$tpl["name"].'} checked{/if}' : '').' />';
        
        return $code;
    }
    
    /**
    * Generates HTML code for textarea item on the form.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getTextareaItem( $tpl )
    {
        $code = '<textarea name="'.$tpl["name"].'" id="'.$tpl["name"].'">'.
                ($this->smarty ? '{$'.$tpl["name"].'}' : '').'</textarea>';
        
        return $code;
    }
    
    /**
    * Generates HTML code for array of checkboxes on the form.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getCheckboxArrayItem( $tpl )
    {
        $code = '<input type="checkbox" name="'.$tpl["name"].'[]" id="'.$tpl["name"].'0" value="1"'.
                ($this->smarty ? '{if $'.$tpl["name"].'} checked{/if}' : '').' />';
        
        return $code;
    }
    
    /**
    * Generates HTML code for select item on the form.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getSelectItem( $tpl )
    {
        $code = '<select name="'.$tpl["name"].'" id="'.$tpl["name"].'">' . "\r\n" .
                ($this->smarty ? '{foreach name="'.$tpl["name"].'s" from=$'.$tpl["name"].'s key=key item=item}' . "\r\n" : '').
                ' <option value="'.($this->smarty ? '{$key}' : '').'"'.($this->smarty?'{if $key==$'.$tpl["name"].'} selected{/if}':'').'>'.($this->smarty?'{$item}':'').'</option>' . "\r\n" .
                ($this->smarty ? '{/foreach}' . "\r\n" : '') . '</select>';
        return $code;
    }
    
    /**
    * Generates HTML code for file input field.
    *
    * @return   string
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function getFileItem( $tpl )
    {
        $code = '<input type="file" name="'.$tpl["name"].'" id="'.$tpl["name"].'" />';
        
        return $code;
    }
    
    /**
    * Generates JavaScript code for validation of form element input.
    *
    * @return   void
    * @param    array   $tpl        the structure of an item from XML template
    * @access   private
    */
    function addValidationCode( $tpl )
    {
        switch ($tpl["item"])
        {
            case "input_text":
            case "input_password":
            case "textarea":
                                if (isset($tpl["min_length"]))
                                    $this->validCode .= 'if (document.getElementById("'.$tpl["name"].'").value.length < '.$tpl["min_length"].') { if (!fieldFocused) fieldFocused = "'.$tpl["name"].'"; markWrong("'.$tpl["name"].'", true); } else markRight("'.$tpl["name"].'");'."\r\n";
                                elseif (isset($tpl["mandatory"]) && $tpl["mandatory"] == "yes")
                                    $this->validCode .= 'if (document.getElementById("'.$tpl["name"].'").value=="") { if (!fieldFocused) fieldFocused="'.$tpl["name"].'"; markWrong("'.$tpl["name"].'", true); } else markRight("'.$tpl["name"].'");'."\r\n";
                                if (isset($tpl["max_length"]))
                                    $this->validCode .= 'if (document.getElementById("'.$tpl["name"].'").value.length > '.$tpl["max_length"].') { if (!fieldFocused) fieldFocused="'.$tpl["name"].'"; markWrong("'.$tpl["name"].'", true); } else markRight("'.$tpl["name"].'");'."\r\n";
                                if (isset($tpl["type"]))
                                {
                                    switch ($tpl["type"])
                                    {
                                        case "int":
                                        case "integer":
                                                    $this->validCode .= 'var regexp = /^\d+$/; if (document.getElementById("'.$tpl["name"].'").value!="" && document.getElementById("'.$tpl["name"].'").value.search(regexp) == -1) { if (!fieldFocused) fieldFocused="'.$tpl["name"].'"; markWrong("'.$tpl["name"].'", true); } else markRight("'.$tpl["name"].'");'."\r\n";
                                                    break;
                                        case "float":
                                                    $this->validCode .= 'var regexp = /^\d*(\.\d*)?$/; if (document.getElementById("'.$tpl["name"].'").value!="" && document.getElementById("'.$tpl["name"].'").value.search(regexp) == -1) { if (!fieldFocused) fieldFocused="'.$tpl["name"].'"; markWrong("'.$tpl["name"].'", true); } else markRight("'.$tpl["name"].'");'."\r\n";
                                                    break;
                                        case "email":
                                                    $this->validCode .= 'var regexp = /^[a-z][\w\-\.]*\w\@([\w\-]+\.)+[a-z]{2,7}$/i; if (document.getElementById("'.$tpl["name"].'").value!="" && document.getElementById("'.$tpl["name"].'").value.search(regexp) == -1) { if (!fieldFocused) fieldFocused="'.$tpl["name"].'"; markWrong("'.$tpl["name"].'", true); } else markRight("'.$tpl["name"].'");'."\r\n";
                                                    break;
                                        case "url":
                                                    $this->validCode .= 'var regexp = /^(http:\/\/|ftp:\/\/)([\w\-]+\.)+[a-z]{2,7}[~\w\-\/\.\?\&=]*$/i; if (document.getElementById("'.$tpl["name"].'").value!="" && document.getElementById("'.$tpl["name"].'").value.search(regexp) == -1) { if (!fieldFocused) fieldFocused="'.$tpl["name"].'"; markWrong("'.$tpl["name"].'", true); } else markRight("'.$tpl["name"].'");'."\r\n";
                                                
                                    }
                                }
                                break;
            case "radio":
                                if (isset($tpl["mandatory"]) && $tpl["mandatory"] == "yes")
                                {
                                    $this->validCode .= 'var i = 0;'."\r\n";
                                    $this->validCode .= 'while (document.getElementById("'.$tpl["name"].'"+i) != undefined && !document.getElementById("'.$tpl["name"].'"+i).checked) i++;'."\r\n".
                                        'if (document.getElementById("'.$tpl["name"].'"+i) == undefined) {'."\r\n".
                                        ' markWrong("'.$tpl["name"].'", false);'."\r\n".
                                        '}'."\r\n";
                                }
                                break;
            case "checkbox":
                                if (isset($tpl["mandatory"]) && $tpl["mandatory"] == "yes")
                                    $this->validCode .= 'if (!document.getElementById("'.$tpl["name"].'").checked) { markWrong("'.$tpl["name"].'", false); }'."\r\n";
                                break;
            case "checkbox_array":
                                if (isset($tpl["mandatory"]) && $tpl["mandatory"] == "yes")
                                {
                                    $this->validCode .= 'var i = 0;'."\r\n";
                                    $this->validCode .= 'while (document.getElementById("'.$tpl["name"].'"+i) != undefined && !document.getElementById("'.$tpl["name"].'"+i).checked) $i++;'."\r\n".
                                    'if (document.getElementById("'.$tpl["name"].'"+i) == undefined) {'."\r\n".
                                    ' markWrong("'.$tpl["name"].'", false);'."\r\n".
                                    '}'."\r\n";
                                }
                                break;
            case "select":
                                if (isset($tpl["mandatory"]) && $tpl["mandatory"] == "yes")
                                    $this->validCode .= 'if (document.getElementById("'.$tpl["name"].'").selectedIndex == -1 || document.getElementById("'.$tpl["name"].'").options[document.getElementById("'.$tpl["name"].'").selectedIndex].value == "") { markWrong("'.$tpl["name"].'", false); }'."\r\n";
                                break;
            case "file":
                                if (isset($tpl["mandatory"]) && $tpl["mandatory"] == "yes")
                                    $this->validCode .= 'if (document.getElementById("'.$tpl["name"].'").value == "") { if (!fieldFocused) fieldFocused="'.$tpl["name"].'"; markWrong("'.$tpl["name"].'"); }'."\r\n";
                                break;
        }
    }
    
    /**
    * Returns JavaScript validation code for the form.
    *
    * @return   string
    * @param    string  $xml_file
    * @param    string  $error_msg  Error message alerted when the form filled incorrectly
    * @access   public
    */
    function getValidationCode( $xml_file, $error_msg )
    {
        $code  = '<script language="JavaScript" type="text/javascript"><!--'."\r\n".
                 'var fields = new Array();'."\r\n".
                 'function markWrong(name, show) {'."\r\n".
                 ' if (show) document.getElementById(name).style.border = "1px dotted red";'."\r\n".
                 ' fields[name] = true;'."\r\n".
                 ' fields.length++;'."\r\n".
                 '}'."\r\n".
                 'function markRight(name) {'."\r\n".
                 ' if (fields[name] == undefined || !fields[name])'."\r\n".
                 '  document.getElementById(name).style.border = "1px dotted green";'."\r\n".
                 '}'."\r\n".
                 'function wrongExist() {'."\r\n".
                 ' if (fields.length > 0) return true;'."\r\n".
                 ' else return false;;'."\r\n".
                 '}'."\r\n".
                 'var fieldFocused = "";'."\r\n";
        $code .= 'function validateForm() {'."\r\n".
                 ' fieldFocused = "";'."\r\n".
                 ' fields = new Array();'."\r\n";
        
        $this->readXMLTemplate($xml_file);
        foreach ($this->tpl_items as $item)
            $this->addValidationCode($item);
        
        // generating validation code for queued items
        //foreach ($this->valid_queue as $name => $item)
            //$this->addValidationCode($item["tpl"], $item["error_msg"]);
        
        $code .= $this->validCode;
        $code .= ' if (wrongExist()) {'."\r\n".
                 '  if (fieldFocused) document.getElementById(fieldFocused).focus();'."\r\n".
                 '  alert("'.$error_msg.'");'.
                 '  return false;'."\r\n".
                 ' }'."\r\n";
        $code .= ' return true;'."\r\n";
        $code .= "\r\n".'}'."\r\n".'//--></script>';
        return $code;
    }
    
/****************************************************************************
 *                      Helper functions                                    *
 ****************************************************************************/  

    /**
     * wrapper around the runQuery method in dbHandler.class.php
     *
     * requires the appropiate query file for this class and
     * passes the query to dbHandler::runQuery()
     * returns an array or a string in accordance to the wanted result
     * The requirement for query file: it must have filename
     * <classname>.sql.php
     *
     * @author  Ralf Kramer, Alex Koshel
     * @param   int  query_id ( array index of the query within the 
     *                          required query file ) 
     * @param   string result ( specifies the type of the expected
     *          result set
     *          e.g. "getArray", "getIndexArray", "getSingleValue" etc. )
     * @param   msq_id ( a hint that is thrown by the system when an error occurs )
     *
     * @return  mixed
     */
    function runQuery( $query_id, $result, $msg_id ) {
        $queryFName = str_replace( ".class.php", ".sql.php", __FILE__ );
        require( $queryFName );
        return dbHandler::runQuery( $query[$query_id], $result, $msg_id );
    }
   
}
?>