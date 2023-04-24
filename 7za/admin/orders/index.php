<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController 
{
    var $contentFile        = "admin/orders/index.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	//$this->tpl->debugging = true;
    	//$this->core->showQuery = true;    	
    	
        $mode = $this->getParam("GET", "mode", "string");
        $id   = $this->getParam("GET", "id", "int");
        
        $Orders =& $this->getClassOf("Orders");
		
        $this->tpl->assign( "orders" , $Orders->getCurrentOrders() );
        
        if ( $mode == "delete" && $id )
        {
        	$order = $Orders->getOrder( $id );
        	if( $order['status_id'] !=1 )
        		$this->redirect( $_SERVER['PHP_SELF'] , "msg=cannot_deleted" );
            $Orders->deleteOrder( $id );
            $this->redirect( $_SERVER['PHP_SELF'] , "msg=order_deleted" );
        }
        
        if ( $mode == "next_status" && $id )
        {
			$Orders->nextStatusOrder( $id );
			$this->redirect( $_SERVER['PHP_SELF'] );
        }        
        
        if ( $mode == "edit" && $id )
        {
            $this->tpl->assign("order", $Orders->getOrder($id));
            $this->contentFile = "admin/orders/edit_order.tpl.html";
        }

        $msg  = $this->getParam("GET", "msg", "string");
        
        if ( $msg == "order_deleted" )
            $this->showMessage("Заказ удален");
            
        if ( $msg == "cannot_deleted" )
            $this->showMessage("Нельзя удалить заказ с данным статусом");

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