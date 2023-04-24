<?php
/**
 * This controller used for generating the dump for using it in a2b
 * system.
 */

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

        $cats = $Products->getCategoriesForStartPage();
        //var_dump($cats);
        $this->tpl->assign("categories", $cats);
        $fp = fopen(IMAGE_PATH . "mm_files/001.txt", "w+");
        $content = $this->tpl->fetch("tools/categories.tpl.txt");
        fputs($fp, $content);
        fclose($fp);

        $fp2 = fopen(IMAGE_PATH . "mm_files/002.txt", "w+");
        $products = $Products->getAllVisibleProducts();
        $this->tpl->assign("products", $products);
        $content = $this->tpl->fetch("tools/products.tpl.txt");
        fputs($fp2, $content);
        fclose($fp2);
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