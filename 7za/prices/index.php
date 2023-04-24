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
        $Prices = $this->getClassOf("PriceFiles");
        $this->tpl->assign("prices", $Prices->getPricesForLanguage($this->language));
    }
    
    function render()
    {
        $this->contentFile = "prices/index.tpl.html";
        $this->parseLanguagePage("prices");
        $this->pageTitle = $this->lang["prices"]["L_PRICES"];
        $this->topMenuItem = 3;
        $this->display();
    }
}


/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>