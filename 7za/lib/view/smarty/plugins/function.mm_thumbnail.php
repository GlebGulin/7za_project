<?php
/**
 * Smarty plugin
 * @package SmartMVC
 * @subpackage MediaManager
 */


/**
 * Plugin for showing the preview of the image.
 *
 * Type:     function<br>
 * Name:     mm_thumbnail<br>
 * Purpose:  makes image thumbnail
 *
 * Possible params:
 * file_id
 * delete_icon
 *
 * @param   array   $params
 * @param   Smarty  $smarty
 * @return  string
 */
function smarty_function_mm_thumbnail($params, &$smarty)
{
    $output = "";
    
    // return if no file specified
    if ( !isset($params["file_id"]) )
    {
        $smarty->trigger_error("'file_id' parameter required");
        return "";
    }
    
    if ( $params["file_id"] == 0 )
        return '<img src="/resources/images/Modules/MediaManager/noimage.gif" border="0" alt="">';
        
    // outputting the script for deleting image
    if ( isset($params["delete_icon"]) && $params["delete_icon"] && !isset($smarty->outputedDeleteImagesJS) )
    {
        $smarty->outputedDeleteImagesJS = "yes";
        $output .= '<script language="JavaScript" type="text/javascript"><!--' . "\n" .
            'function deleteImage(image_id) {' . "\n" .
            '    var url = "/Modules/MediaManager/show_image.php?mode=delete&file="+image_id;' . "\n" .
            '    if (window.pop == null || window.pop.closed) {' . "\n" .
            '      pop = window.open(url, "deleteimage", "width=300,height=150,status=no,scrollbars=no,menubar=no,directories=no,toolbar=no,left="+((screen.width-300)/2)+",top="+((screen.height-150)/2));' . "\n" .
            '    } else {' . "\n" .
            '      window.pop.close();' . "\n" .
            '      pop = window.open(url, "deleteimage", "width=300,height=150,status=no,scrollbars=no,menubar=no,directories=no,toolbar=no,left="+((screen.width-300)/2)+",top="+((screen.height-150)/2));' . "\n" .
            '      window.pop.location.href = url;' . "\n" .
            '      window.pop.focus();' . "\n" .
            '    }' . "\n" .
            '}' . "\n" .
            '//-->' . "\n" .
            '</script>';
    }
    
    global $core;
    $MM = $core->getClassOf("Modules.MediaManager");
    
    $file = $MM->getImage($params["file_id"]);
    if ( $file && $file["file_type"] == "image" )
    {
        $output .= '<img src="'.$file["thumb_file"].'" width="'.$file["thumb_width"].'" height="'.$file["thumb_height"].'" border="0" alt="'.(isset($params["alt"])?htmlspecialchars($params["alt"], ENT_QUOTES, 'cp1251'):htmlspecialchars($file["title"], ENT_QUOTES, 'cp1251')).'" title="'.(isset($params["alt"])?htmlspecialchars($params["alt"], ENT_QUOTES, 'cp1251'):htmlspecialchars($file["title"], ENT_QUOTES, 'cp1251')).'" />';
        if ( isset($params["delete_icon"]) && $params["delete_icon"] )
        {
            $output .= '<a href="javascript: deleteImage(\''.$file["file_id"].'\');"><img src="/resources/images/Modules/MediaManager/delete.gif" border="0"></a>';
        }
    }
    else return '<img src="/resources/images/Modules/MediaManager/noimage.gif" border="0" alt="">';
    
    
    return $output;
}

?>
