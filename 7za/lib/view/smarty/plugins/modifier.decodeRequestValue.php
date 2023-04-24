<?php
/**
 * Smarty plugin
 * @package SmartMVC
 * @subpackage utils
 */


/**
 * Smarty modifier plugin for decoding special chars added during request data saving
 *
 * Type:     modifier<br>
 * Name:     decodeRequestValue<br>
 * Purpose:  replaces special HTML chars into normal chars
 * @param string
 * @return string
 */
function smarty_modifier_decodeRequestValue( $string )
{
    global $core;
    return $core->decodeRequestValue( $string );
}

?>
