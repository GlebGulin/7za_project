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
        $mode = $this->getParam("GET", "mode", "string");
        $product_id = $this->getParam("GET", "product_id", "int");
        $quantity = $this->getParam("GET", "q", "int");
        $key = $this->getParam("GET", "key", "string");

        $Products = $this->getClassOf("Products");

        // outputting all categories for export
        if ( !$mode )
        {
            $categories = $Products->getCategoriesForStartPage();
            for ( $i = 0; $i < count($categories); $i++ )
            {
                for ( $j = 0; $j < count($categories[$i]["subcategories"]); $j++ )
                    $categories[$i]["subcategories"][$j]["products"] = $Products->getVisibleProductsOfSubcategory($categories[$i]["subcategories"][$j]["subcategory_id"]);

                //$categories[$i]["products"] = $Products->getVisibleProductsOfSubcategory($categories[$i]["category_id"]);
            }

            $this->tplToDisplay = "products/xml_for_bigmir.tpl.html";
            $this->tpl->assign( "categories" , $categories );
            $this->tpl->assign( "date", date("Y-m-d H:i") );

            $xml = $this->tpl->fetch($this->tplToDisplay);
            header("Accept-Ranges: bytes");
            header("Content-Length: " . strlen($xml));
            header("Content-type: text/xml");
            print $xml;
            exit();
        }

        if ( $mode == "change_q" && $product_id && $key == KEY_1C )
        {
            $absent = $quantity ? 0 : 1;
            $Products->absentProduct($product_id, $absent);
            print "OK";
            die();
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