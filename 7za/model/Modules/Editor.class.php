<?PHP
require_once( LIB . "utils/cms/FCKeditor.class.php" );
class Editor extends wrapper 
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    var $inputName      = "editor";
    var $counter        = 1;
    var $value          = "";

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     */
    function Editor()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/

    /**
     * Sets the name parameter of an editor input item on a form.
     *
     * @param   string  $input_name
     */
    function setInputName( $input_name )
    {
        $this->inputName = $input_name;
    }
    
    /**
     * Sets the value for the editor.
     *
     * @param   string  $value
     */
    function setValue( $value )
    {
        $this->value = $value;
    }
    
    /**
     * Generates HTML code for the editor item.
     *
     * @return  string
     */
    function createHtml()
    {
        if ( $this->counter != 1 )
            $editor_name = $this->inputName . $this->counter;
        else 
            $editor_name = $this->inputName;
            
        $editor = new FCKeditor($editor_name);
        $editor->BasePath = "/resources/fckeditor/";
        $editor->Height = 350;
        $editor->ToolbarSet = "SmartMVC";
        $editor->Value = $this->value;
        $editor->Config['SkinPath'] = $editor->BasePath . "editor/skins/office2003/";
        $this->counter++;
        return $editor->CreateHtml();
    }

/****************************************************************************
 *                      Helper functions                                    *
 ****************************************************************************/

}
?>