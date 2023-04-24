<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("./controller/PublicBaseController.class.php");

class Controller extends PublicBaseController
{

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	//$this->tpl->debugging = true;

    	$Products = $this->getClassOf('Products');
    	$this->tpl->assign('catnav' , $Products->getCategoriesForStartPage() );
    	$this->tpl->assign('products', $Products->getSaleLeaders(3));
    	$this->tpl->assign('new_products', $Products->getNewProducts(3));
    	$this->tpl->assign('sales', $Products->getSaleForStartPage());
    	$this->tpl->assign('recommended', $Products->getRecommendedProducts(3));
	    //$this->tpl->assign("offers", $Products->getSpecialOffers());


    	$Pages =& $this->getClassOf("Pages");
        $page = $Pages->getPageById( 1 );
    	$this->tpl->assign( "path", $Pages->getPagePath( 1 ) );
    	$this->pageTitle = "Товары для здоровья - Интернет магазин 7za";
    	$this->pageDescription = "Товары для здоровья - Интернет магазин 7za";
    	//$this->pageKeywords = "";
    }

    function render()
    {
        // page displaying
        $this->contentFile = "home.tpl.html";
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>