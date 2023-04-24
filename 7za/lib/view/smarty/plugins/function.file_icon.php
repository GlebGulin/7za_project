<?php
/**
 * Smarty plugin
 * @package SmartMVC
 * @subpackage MediaManager
 */


/**
 * Plugin for displaying file icon by file extension.
 *
 * Type:     function<br>
 * Name:     file_icon<br>
 * Purpose:  makes img html tag for specified file
 *
 * Possible params:
 * file_name
 *
 * @param   array   $params
 * @param   Smarty  $smarty
 * @return  string
 */
function smarty_function_file_icon($params, &$smarty)
{
    $output = "";
    
    // return if no file specified
    if ( !isset($params["file_name"]) )
    {
        $smarty->trigger_error("'file_name' parameter required");
        return "";
    }
    
    $filename = $params["file_name"];
    if ( is_integer(strpos($filename, ".")) )
    {
        $ext = substr($filename, strrpos($filename, ".")+1);
        if ( is_file(IMAGE_PATH . "Modules/FileIcon/" . $ext . ".gif") )
            $output = '<img src="'.URL_IMAGE.'Modules/FileIcon/'.$ext.'.gif" border="0" align="absmiddle">';
        else 
            $output = '<img src="'.URL_IMAGE.'Modules/FileIcon/empty.gif" border="0" align="absmiddle">';
    }
    
    return $output;
}

?>
