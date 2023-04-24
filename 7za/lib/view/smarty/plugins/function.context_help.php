<?php
/**
 * Smarty plugin
 * @package SmartMVC
 * @subpackage ContextHelp
 */


/**
 * Plugin for showing the context help window.
 *
 * Type:     function<br>
 * Name:     context_help<br>
 * Purpose:  makes JS and html code for showing context help
 *
 * Possible params:
 * text
 *
 * How to use: attach context_help.css and context_help.js to the page,
 * then use {context_help text="Any text, even html"} in the template.
 *
 * The width of the popup window may be configured in JS file.
 *
 * @param   array   $params
 * @param   Smarty  $smarty
 * @return  string
 */
function smarty_function_context_help($params, &$smarty)
{
    $output = "";
    
    // return if no text specified
    if ( !isset($params["text"]) && !isset($params["file"]) )
    {
        $smarty->trigger_error("'text' or 'file' parameter required");
        return "";
    }
    
    if ( isset($params["title"]) )
        $title = str_replace("'", '\\\'', $params["title"]);
    else 
        $title = "ContextHelp";
        
    // outputting the script for showing context help window
    if ( !isset($smarty->numberContextHelpItems) )
    {
        $smarty->numberContextHelpItems = 1;
        $output .= '<script language="JavaScript" type="text/javascript"><!--' . "\n" .
            'var texts = new Array();' . "\n" .
            '//-->' . "\n" .
            '</script>'; 
        $output .= '<div id="ContextWindow" style="position: absolute; visibility: hidden;"></div>';
    }
    else 
    {
        $smarty->numberContextHelpItems++;
    }

    $text = "";
    
    if ( isset($params["text"]) )
        $text = $params["text"];
        
    if ( isset($params["file"]) )
    {
        $text = implode(" ", file(TEMPLATE_DIR . DIR_SEP . "context_help" . DIR_SEP . $params["file"]) );
        if ( get_magic_quotes_runtime() )
            $text = stripslashes($text);
        $text = str_replace("\r", "", $text);
        $text = str_replace("\n", "", $text);
    }
    
    $text = str_replace("'", '\\\'', $text);
    
    $output .= '<script language="JavaScript"><!--' . "\n" .
        'texts['.$smarty->numberContextHelpItems.'] = \'' . $text . '\';' . "\n" .
        '//-->' . "\n" .
        '</script>' . "\n";
    $output .= '<a href="javascript:showContextHelpWindow('.$smarty->numberContextHelpItems.',\''.$title.'\');"><img src="/resources/images/Modules/ContextHelp/help.gif" id="help_img_'.$smarty->numberContextHelpItems.'" border="0" alt="Click to view help" title="Click to view help" align="absmiddle"></a>';
    
    
    return $output;
}

?>
