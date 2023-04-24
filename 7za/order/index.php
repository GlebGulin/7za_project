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
        $Order     = $this->getClassOf("Orders");

        $this->tpl->assign( "catnav" , $Order->getCategoriesForStartPage() );

        $cat_id     = $this->getParam("GET", "cat_id", "int");
        $subcat_id  = $this->getParam("GET", "subcat_id", "int");
        $product_id = $this->getParam("GET", "product_id", "int");
        $mode       = $this->getParam("GET", "mode", "string");
        $products   = $this->getParam("POST", "products", "array");

        $this->pageTitle = "Онлайн-Заказ ";

        $this->tpl->assign("path" , $Order->getNavPathForCart() );

        $this->contentFile = "order/cart.tpl.html";

        $this->tpl->assign("cart_list", $Order->getCartForPage());

        $this->tpl->assign("cost_delivery", COST_DELIVERY );
        $this->tpl->assign("cost_threshold", COST_THRESHOLD );

        //$this->tpl->assign("cities", $Order->getCities() );

        if ( $mode == 'show_order' && $products!=null )
        {
        	$this->contentFile = "order/order.tpl.html";
        	$this->tpl->assign("path" , $Order->getNavPathForOrder() );
			$Order->setCart( $products );
			$this->tpl->assign("products_ser", serialize($products));
        }

        if ( $mode == 'send_order' )
        {
        	$this->tpl->assign("path" , $Order->getNavPathForOrder() );
        	$Order->importIntoClass("POST");
        	$empty = $Order->checkOrder();
        	if( count($empty) )
        	{
        		$this->passToTemplate($_POST);
        		$this->contentFile = "order/order.tpl.html";
        		$this->tpl->assign( "warning", "Форма заполнена не полностью" );
        		$this->tpl->assign( "empty", $empty);
        	}
        	else
        	{
				$Order->sendOrder( $Order->addOrder() );
				$this->redirect("/order/index.php?mode=sent_order");
        	}

        }

        if ( $mode == 'sent_order' )
        {
        	$this->tpl->assign("path" , $Order->getNavPathForOrder() );
        	$this->contentFile = "order/sent_order.tpl.html";
        }

        if ( $mode == 'delete_from_cart' && $product_id )
        {
        	$this->contentFile = "order/sent_order.tpl.html";
 			$Order->deleteFromCart($product_id);
			$this->redirect("/order/");
        }

        $this->tpl->assign("categories", $Order->getCategories());


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