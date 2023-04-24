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
   	
    	$this->contentFile = "products/sales.tpl.html";
        $Products = $this->getClassOf("Products");
        $this->pageTitle = "����������";
        $this->tpl->assign( "products", $Products->getSales() );
        $this->tpl->assign( "catnav" , $Products->getCategoriesForStartPage() );  
        
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