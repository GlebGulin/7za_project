<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController
{

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	//$this->tpl->debugging = true;
    	//$this->core->showQuery = true;

        $mode   = $this->getParam("GET", "mode", "string");
        $selected = $this->getParam("GET", "selected", "string");
        $field = $this->getParam("GET", "field", "string");

        $Products = $this->getClassOf("Products");

        if ( $mode == "multiple" )
            $this->tpl->assign("mode", "multiple");
        else
            $this->tpl->assign("mode", "single");

        if ( $selected )
        {
            $sel_items = array();
            $items = explode(",", $selected);
            foreach ( $items as $key => $value )
                $sel_items[$value] = true;

            $this->tpl->assign("selected", $sel_items);
        }

        $categories = $Products->getProductsForSelector();
        $this->tpl->assign("categories", $categories);
        $this->tpl->assign("field", $field);
    }

    function render()
    {
        $this->tplToDisplay = "admin/products/selector.tpl.html";
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>