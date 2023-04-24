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
        $Products = $this->getClassOf("Products");
        $Products->sendProductStats();
        $Products->resetTopProducts();
        die();
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