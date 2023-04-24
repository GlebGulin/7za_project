<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin for preparing text for URLs
 *
 * Type:     modifier<br>
 * Name:     sefu_prepare<br>
 * @param string
 * @return string
 */
function smarty_modifier_sefu_prepare( $string )
{
    $string = preg_replace("/&#[0-9]+;/", "-", $string);
    $string = str_replace(" ", "-", strtolower(html_entity_decode($string)));
    $string = preg_replace("/[^a-z0-9\-]/", "", $string);
    while ( is_integer(strpos($string, "--")) )
    	$string = str_replace("--", "-", $string);

    // replace '-' in start of string
    if ( strlen($string) > 0 && $string{0} == "-" )
        $string = substr($string, 1);

    // replace '-' in end of string
    if ( strlen($string) > 0 && $string{strlen($string)-1} == "-" )
        $string = substr($string, 0, strlen($string)-1);

    if ( empty($string) )
        $string = "1";

    return $string;
}



?>
