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

    	$this->contentFile = "products/offers.tpl.html";
        $Products = $this->getClassOf("Products");
        $this->pageTitle = "Акции магазина 7Za";
        $this->tpl->assign("products", $Products->getSpecialOffers());
        $this->tpl->assign("catnav" , $Products->getCategoriesForStartPage() );
        //$this->tpl->assign("path" , $Products->getNavPathForNew() );
    }

    function render()
    {
        //$this->rssURL = "rss/new_gifts/";
        $this->display();
    }
}


/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>