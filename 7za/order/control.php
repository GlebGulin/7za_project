<?php

/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../controller/PublicBaseController.class.php");

class Controller extends PublicBaseController 
{

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {   
    	//$this->tpl->debugging = true;
    	
    	$this->contentFile = "order/control_request.tpl.html";
    	
        $mode = $this->getParam("GET", "mode", "string");
        $id   = $this->getParam("GET", "id", "int");    	
    	
        $Order = $this->getClassOf("Orders");
        $this->tpl->assign( "catnav" , $Order->getCategoriesForStartPage() ); 
        $this->pageTitle = "Контроль заказа";
        
        $this->tpl->assign("path" , $Order->getNavPathForControl() );
        
        if ( $mode == 'show_orders' )	
        {
        	$Order->importIntoClass("POST");
        	$this->tpl->assign( "orders" , $Order->getControlOrders() );
        	$this->contentFile = "order/control_orders.tpl.html";
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