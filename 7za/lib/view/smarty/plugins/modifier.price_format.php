<?php
/**
 * Smarty plugin
 * @package SmartMVC
 * @subpackage utils
 */


/**
 * Smarty modifier plugin for price formatting
 *
 * Type:     modifier<br>
 * Name:     price_format<br>
 * Purpose:  outputs the float number in a format of 23.456,78
 * @param string
 * @return string
 */
function smarty_modifier_price_format( $string, $currency_sign = "" )
{
    if ( !preg_match("/^\d*(\.\d*)?\$/", $string) )
        return "0,00" . $currency_sign;

    $string = round($string, 2);

    if ( is_integer(strpos($string, ".")) )
    {
        $int = substr($string, 0, strpos($string, "."));
        $float = "," . substr($string, strpos($string, ".") + 1);
        if ( strlen($float) == 2 )
            $float .= '0';
    }
    else
    {
        $int = $string;
        $float = ",00";
    }

    $i = strlen($int);
    $int_wd = "";
    while ( $i > 0 )
    {
        $i--;
        $int_wd = substr($int, $i, 1) . $int_wd;
        //print "<br>" . substr($int, $i, 1);
        if ( (strlen($int) - $i) % 3 == 0 && $i != 0 )
            $int_wd = "." . $int_wd;
    }

    return $int_wd . $float . $currency_sign;
    //return $int_wd . $currency_sign;
}

?>
