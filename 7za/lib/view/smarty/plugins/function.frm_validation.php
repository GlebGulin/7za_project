<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {frm_validation} function plugin
 *
 * Type:     function<br>
 * Name:     frm_validation<br>
 * Purpose:  inserts a JS validation code (SmartMVC form generation feature)<br>
 * @param array
 * @param Smarty
 */
function smarty_function_frm_validation($params, &$smarty)
{
    if (!isset($params["form"]))
    {
        $smarty->trigger_error("frm_validation: missing 'form' parameter");
        return ;
    }
    
    return $smarty->frmGenerator->getValidationCode($params["form"]);
}

/* vim: set expandtab: */

?>
