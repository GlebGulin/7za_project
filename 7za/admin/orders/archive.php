<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController 
{
    var $contentFile        = "admin/orders/archive.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	//$this->tpl->debugging = true;
    	//$this->core->showQuery = true;    	
    	
        $mode = $this->getParam("GET", "mode", "string");
        $id   = $this->getParam("GET", "id", "int");
        $smIndex = $this->getParam("GET", "smIndex", "int");
        
        $Orders =& $this->getClassOf("Orders");
		
        if ( $mode == "view_order" && $id )
        {
            $this->tpl->assign( "order", $Orders->getOrder( $id ) );
            $this->contentFile = "admin/orders/view_order.tpl.html";
        }

        $this->tpl->assign( "orders" , $Orders->getArchiveOrders());
        $this->tpl->assign( "splitMenuCode", $Orders->sm->makeLinkMenu());
 		$this->tpl->assign( "smIndex", intval($smIndex) );        
    }
    
    function render()
    {
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