<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/PublicBaseController.class.php");

class Controller extends PublicBaseController
{

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
        if ( isset($_SESSION["captcha_code"]) )
        {
            $img_text = $_SESSION["captcha_code"];

            $this->setDontCacheHeaders();
            $Captcha = $this->getClassOf("utils.image.gd.Captcha");
            $Captcha->outputImage($img_text);
        }
        die();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>
