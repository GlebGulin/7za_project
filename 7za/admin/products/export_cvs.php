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
        $Products =& $this->getClassOf("Products");
        $all_products = $Products->getAllProducts();
        
        $content = "";
        $last_cat_id = 0;
        $last_subcat_id = 0;
        for ( $i = 0; $i < count($all_products); $i++ )
        {
            if ( $last_cat_id != $all_products[$i]["category_id"] )
                $content .= "# " . $all_products[$i]["category_name"] . "\n";
                
            if ( $last_subcat_id != $all_products[$i]["subcategory_id"] )
                $content .= "\n## " . $all_products[$i]["subcategory_name"] . "\n";
                
            $content .= $this->decodeRequestValue($all_products[$i]["product_name"]) . ";" . $all_products[$i]["price"] . ";" . $all_products[$i]["view"] . "\n";
                
            $last_cat_id = $all_products[$i]["category_id"];
            $last_subcat_id = $all_products[$i]["subcategory_id"];
        }
        
        $download_size = strlen($content);
        header("Content-type: application/x-download");
        header("Content-Disposition: attachment; filename=tnd.csv;");
        header("Accept-Ranges: bytes");
        header("Content-Length: $download_size");
        print $content;
        die;
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