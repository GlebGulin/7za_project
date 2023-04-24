<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_modifier_beautify($string)
{
    $string = str_replace(':&#41;&#41;', '<img src="/resources/images/smiles/happy.png" border="0" align="absmidle">', $string);
    $string = str_replace(':-&#41;&#41;', '<img src="/resources/images/smiles/happy.png" border="0" align="absmidle">', $string);
    $string = str_replace(':&#41;', '<img src="/resources/images/smiles/smile.png" border="0" align="absmidle">', $string);
    $string = str_replace(':-&#41;', '<img src="/resources/images/smiles/smile.png" border="0" align="absmidle">', $string);
    $string = str_replace(':&#40;', '<img src="/resources/images/smiles/sad.png" border="0" align="absmidle">', $string);
    $string = str_replace(':-&#40;', '<img src="/resources/images/smiles/sad.png" border="0" align="absmidle">', $string);
    $string = str_replace(':P', '<img src="/resources/images/smiles/goofy.png" border="0" align="absmidle">', $string);
    $string = str_replace(':-P', '<img src="/resources/images/smiles/goofy.png" border="0" align="absmidle">', $string);
    $string = str_replace(':Ð', '<img src="/resources/images/smiles/goofy.png" border="0" align="absmidle">', $string);
    $string = str_replace(':-Ð', '<img src="/resources/images/smiles/goofy.png" border="0" align="absmidle">', $string);
    $string = str_replace(':o', '<img src="/resources/images/smiles/surprised.png" border="0" align="absmidle">', $string);
    $string = str_replace(':-o', '<img src="/resources/images/smiles/surprised.png" border="0" align="absmidle">', $string);
    $string = str_replace(':î', '<img src="/resources/images/smiles/surprised.png" border="0" align="absmidle">', $string);
    $string = str_replace(':-î', '<img src="/resources/images/smiles/surprised.png" border="0" align="absmidle">', $string);
    return $string;
}


?>
