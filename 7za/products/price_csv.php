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

        $categories = $Products->getCategoriesForStartPage();
        for ( $i = 0; $i < count($categories); $i++ )
        {
            for ( $j = 0; $j < count($categories[$i]["subcategories"]); $j++ )
                $categories[$i]["subcategories"][$j]["products"] = $Products->getVisibleProductsOfSubcategory($categories[$i]["subcategories"][$j]["subcategory_id"]);

            //$categories[$i]["products"] = $Products->getVisibleProductsOfSubcategory($categories[$i]["category_id"]);
        }

		$this->tpl->assign( "categories" , $categories );
		$output = $this->tpl->fetch("products/price_csv.tpl.html");

        $this->setDontCacheHeaders();
        header("Content-type: application/x-download");
        header("Content-Disposition: attachment; filename=price.csv;");
        header("Accept-Ranges: bytes");
        header("Content-Length: " . strlen($output));
        print $output;

        exit();
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