<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {block_switch}{/block_switch} block plugin
 *
 * Type:     block function<br>
 * Name:     block_switch<br>
 * Purpose:  gives opportunity to display one block from described several.<br>
 * This plugin developed for using alongside with SmartMVC framework.
 *
 * @param   array   $params
 * <pre>
 * Params:   id: string (if omitted then integer, started from 0)
 *           show: string: yes|no, true|false
 * </pre>
 * @param   string  $content    content of the block
 * @param   class   $smarty     reference to Smarty object
 * @return  string
 * @author  Alex Koshel <alex@belisar.de>
 */
function smarty_block_block_switch( $params, $content, &$smarty )
{
    if ( is_null($content) )
        return;

    if ( !isset($smarty->blockSwitchCounter) )
        $smarty->blockSwitchCounter = 0;

    if ( isset($params["id"]) )
        $block_id = $params["id"];
    else 
        $block_id = $smarty->blockSwitchCounter;

    if ( isset($params["show"]) && ($params["show"] == "yes" || $params["show"] == "true") )
        $visibility = "visibility: visible; display: inline;";
    else 
        $visibility = "visibility: hidden; display: none;";
        
    $content = '<div id="'.$block_id.'" style="'.$visibility.'">' . $content . '</div>';
    
    if ( $smarty->blockSwitchCounter == 0 )
    {
        // add JS function for managing blocks
        $js =   '<script language="JavaScript" type="text/javascript"><!--' . "\n" .
                ' var blocks = new Array();' . "\n" .
                ' function showBlock(block_id) {' . "\n" .
                '   for (var i=0; i<blocks.length; i++) {' . "\n" .
                '     document.getElementById(blocks[i]).style.visibility = "hidden";' . "\n" .
                '     document.getElementById(blocks[i]).style.display = "none";' . "\n" .
                '   }' . "\n" .
                '   if (document.getElementById(block_id) != undefined) {' . "\n" .
                '     document.getElementById(block_id).style.visibility = "visible";' . "\n" .
                '     document.getElementById(block_id).style.display = "inline";' . "\n" .
                '   }' . "\n" .
                ' }' . "\n" .
                '//-->' . "\n" .
                '</script>';
        $content = $js . $content;
    }
    
    // add blocks array item
    $content .= '<script language="JavaScript" type="text/javascript"><!--' . "\n" .
                'blocks['.$smarty->blockSwitchCounter.'] = \''.$block_id.'\';' . "\n" .
                '//-->' . "\n" .
                '</script>';
        
    // increasing the blockSwitch counter   
    $smarty->blockSwitchCounter++;
    
    return $content;
}

?>
