<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {frm_item} function plugin
 *
 * Type:     function<br>
 * Name:     frm_item<br>
 * Purpose:  inserts a form field (SmartMVC form generation feature)<br>
 * @param array
 * @param Smarty
 */
function smarty_function_frm_item($params, &$smarty)
{
    if (!isset($params["name"]))
    {
        $smarty->trigger_error("frm_item: missing 'name' parameter");
        return ;
    }
    
    $name = $params["name"];
    
    return $smarty->frmGenerator->getFormItem($name, $params);
}

/* vim: set expandtab: */

?>
