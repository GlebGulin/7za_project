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
        //var_dump($categories);
        for ( $i = 0; $i < count($categories); $i++ )
        {
            for ( $j = 0; $j < count($categories[$i]["subcategories"]); $j++ )
                $categories[$i]["subcategories"][$j]["products"] = $Products->getVisibleProductsOfSubcategory($categories[$i]["subcategories"][$j]["subcategory_id"]);

            //$categories[$i]["products"] = $Products->getVisibleProductsOfSubcategory($categories[$i]["category_id"]);
        }

		$this->tpl->assign( "categories" , $categories );
		$this->tpl->assign( "date", date("Y-m-d H:i") );
    }

    function render()
    {
        $this->tplToDisplay = "products/xml_for_bigmir.tpl.html";
        //$fp = fopen(IMAGE_PATH . "mm_files/1.xml", "w+");
        //fputs($fp, $this->tpl->fetch($this->tplToDisplay));
        //fclose($fp);
        $this->display();
    }
}


/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>