<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController 
{
    var $contentFile        = "admin/home.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    }
    
    function render()
    {
        $this->tplToDisplay = "admin/main.tpl.html";
        $this->tpl->assign("contentFile", $this->contentFile);
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>