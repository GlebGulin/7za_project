<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("./../../controller/MasterController.class.php");
class Controller extends MasterController
{
    
    /**
     * Correctly removes the image from system with updating FK on it.
     *
     * @return   void
     * @param    int     $image_id
     * @access   public
     */
    function deleteImage( $image_id )
    {
        $MM =& $this->getClassOf("Modules.MediaManager");
        $MM->deleteFile( $image_id );
        /*echo '152';
        $DR =& $this->getClassOf("db.mysql.deleteableReferences");
        $DR->updateReferences("ImageDeleted", $image_id);*/
    }

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
        $MM =& $this->getClassOf("Modules.MediaManager");
        $file_id = $this->getParam("GET", "file", "int");
        $mode    = $this->getParam("GET", "mode", "string");
        $confirm = $this->getParam("GET", "confirm", "int");
        $file    = $MM->getFile($file_id);
        if ( $mode == "delete" && $confirm && $file )
        {
            if ( !isset($_SESSION["user_id"]) && !isset($_SESSION["admin_user"]) )
                $this->addDebugMsg("Session 'user_id' or 'admin_user' variable required for deleting files", "MediaManager image viewer");
            if ( @$_SESSION["admin_user"] == 1 ) {
                $this->deleteImage( $file["file_id"] );
            } else {
                // allow deleting files only to their owners
                if ( @$_SESSION["user_id"] == $file["user_id"] )
                    $this->deleteImage( $file["file_id"] );
            }
            // output JS for reloading referer and closing the window
            print '<script language="JavaScript" type="text/javascript">' .
                ' opener.location.reload(); window.close(); ' .
                '</script>';
            die();
        }

        if ( $mode == "delete" && !$confirm && $file )
        {
            $this->tplToDisplay = "Modules/MediaManager/confirm_delete_image.tpl.html";
            $this->tpl->assign("file_id", $file_id);
        }
        
        if ( !$mode )
        {
            $this->tpl->assign("image", $file["file_url"]);
            $this->tplToDisplay = "Modules/MediaManager/show_image.tpl.html";
        }
    }
    
    function render()
    {
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>