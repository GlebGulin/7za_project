<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController
{
    var $contentFile        = "admin/products/categories.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
        $mode   = $this->getParam($_REQUEST, "mode", "string");
        $cat_id = $this->getParam("GET", "cat_id", "int");
        $subcat_id = $this->getParam("GET", "subcat_id", "int");
        $product_id = $this->getParam("GET", "product_id", "int");
        $photo_id = $this->getParam("GET", "photo_id", "int");
        $keyword = $this->getParam("POST", "keyword", "string");
        $Products =& $this->getClassOf("Products");
        
        

        // Categories

        if ( $mode == "save_new_category" )
        {
            $Products->importIntoClass("POST");
            $Products->addNewCategory();
            $this->redirect("index.php", "msg=category_added");
        }

        if ( $mode == "save_category" && $cat_id)
        {
            $Products->importIntoClass("POST");
            $Products->saveCategory($cat_id);
            $this->redirect("index.php", "mode=subcategories&cat_id=".$cat_id."&msg=category_saved");
        }

        if ( $mode == "move_cat_up" && $cat_id )
        {
        	$Products->moveCategoryUp($cat_id);
        }

        if ( $mode == "move_cat_down" && $cat_id )
        {
        	$Products->moveCategoryDown($cat_id);
        }

        if ( $mode == "cat_delete" && $cat_id )
        {
        	$Products->deleteCategory($cat_id);
        	$this->redirect("?msg=category_deleted");
        }


        // Subcategories

        if ( $mode == "save_new_subcategory" && $cat_id )
        {
            $Products->importIntoClass("POST");
            $Products->addNewSubcategory($cat_id);
            $this->redirect("index.php", "mode=subcategories&cat_id=".$cat_id."&msg=subcategory_added");
        }

        if ( $mode == "save_subcategory" && $subcat_id)
        {
            $Products->importIntoClass("POST");
            $Products->saveSubcategory($subcat_id);
            $this->redirect("index.php", "mode=products&subcat_id=".$subcat_id."&msg=subcategory_saved");
        }

        if ( $mode == "subcategories" && $cat_id )
        {
            $this->contentFile = "admin/products/subcategories.tpl.html";
            $this->tpl->assign("subcategories", $Products->getSubcategories($cat_id, true));
            $this->tpl->assign("category", $Products->getCategoryById($cat_id));
        	$this->tpl->assign("groups", $Products->getParametersGroups());
        }

        if ( $mode == "move_subcat_up" && $subcat_id )
        {
        	$Products->moveSubcategoryUp($subcat_id);
        	$subcategory = $Products->getSubcategoryById($subcat_id);
        	$this->redirect("?mode=subcategories&cat_id=".$subcategory['category_id']);
        }

        if ( $mode == "move_subcat_down" && $subcat_id )
        {
        	$Products->moveSubcategoryDown($subcat_id);
        	$subcategory = $Products->getSubcategoryById($subcat_id);
        	$this->redirect("?mode=subcategories&cat_id=".$subcategory['category_id']);
        }

        if ( $mode == "subcat_delete" && $subcat_id )
        {
        	$subcategory = $Products->getSubcategoryById($subcat_id);
        	$Products->deleteSubcategory($subcat_id);
        	$this->redirect("?mode=subcategories&cat_id=".$subcategory['category_id']."&msg=subcategory_deleted");
        }

        if ( $mode == "hide_subcat" && $subcat_id )
        {
        	$subcategory = $Products->getSubcategoryById($subcat_id);
            $Products->hideSubcategory($subcat_id);
            $this->redirect("index.php", "mode=subcategories&cat_id=".$subcategory["category_id"]);
        }


        // Products

        if ( $mode == "search" && $keyword )
        {
            $products = $Products->searchProductsForAdmin($keyword);
            $this->tpl->assign("products", $products);
            $this->tpl->assign("keyword", $keyword);
            $this->contentFile = "admin/products/search.tpl.html";
        }

        if ( $mode == 'products' && $subcat_id )
        {
        	$this->contentFile = "admin/products/products.tpl.html";
        	$subcategory = $Products->getSubcategoryById($subcat_id);
        	$this->tpl->assign("subcategory", $subcategory);
        	$this->tpl->assign("category", $Products->getCategoryById($subcategory['category_id']));
        	$this->tpl->assign("products", $Products->getProductsBySubcat($subcat_id));
        	$this->tpl->assign("groups", $Products->getParametersGroups());
        	$this->tpl->assign("all_categories", $Products->getCategoriesForStartPage());
        }

        if( $mode == 'edit_product' && $product_id )
        {
        	$this->contentFile = "admin/products/edit_product.tpl.html";
        	$product =     $Products->getProductById($product_id);
        	$subcategory = $Products->getSubcategoryById($product['subcategory_id']);
        	$this->initEditor("description", $product['description'] , "editor_code" );
        	$this->tpl->assign("product",      $product);
        	$this->tpl->assign("subcategory",  $subcategory);
        	$this->tpl->assign("category",     $Products->getCategoryById($subcategory['category_id']));
       		$this->tpl->assign("parameters", $Products->getParametersValues( $product_id , $subcategory['group_id'] ));
        }

        if( $mode == 'save_product' && $product_id)
        {
        	$Products->importIntoClass("POST");
        	$Products->description = $this->getEditorCode("description");
            $Products->discount_start = $_POST["discount_start_array"]["Date_Year"] . "-" .
                $_POST["discount_start_array"]["Date_Month"] . "-" .
                $_POST["discount_start_array"]["Date_Day"];
            $Products->discount_finish = $_POST["discount_finish_array"]["Date_Year"] . "-" .
                $_POST["discount_finish_array"]["Date_Month"] . "-" .
                $_POST["discount_finish_array"]["Date_Day"];
        	$Products->saveProduct($product_id);
        	$product = $Products->getProductById($product_id);
        	$this->redirect("?mode=products&subcat_id=".$product['subcategory_id']."&msg=product_saved");
        }

        if ( $mode == 'delete_add_photo' && $product_id && $photo_id )
        {
        	$item = $Products->getProductById( $product_id );
            $Products->deleteAddPhoto($product_id, $photo_id);
			$this->redirect("index.php", "mode=edit_product&product_id=$product_id" );
        }

        if( $mode == 'hide_product' && $product_id)
        {
        	$Products->hideProduct($product_id);
        	$product = $Products->getProductById($product_id);
        	$this->redirect("?mode=products&subcat_id=".$product['subcategory_id']);
        }

        if( $mode == 'delete_product' && $product_id)
        {
        	$product = $Products->getProductById($product_id);
        	$Products->deleteProductItem($product_id);
        	$this->redirect("?mode=products&subcat_id=".$product['subcategory_id']."&msg=product_deleted");
        }

        if( $mode == 'add_product' && $subcat_id )
        {
        	$this->contentFile = "admin/products/add_product.tpl.html";
        	$subcategory = $Products->getSubcategoryById( $subcat_id );
        	$this->tpl->assign("subcategory",  $subcategory);
        	$this->tpl->assign("category",     $Products->getCategoryById($subcategory['category_id']));
        	$this->initEditor("description", "" , "editor_code" );
       		$this->tpl->assign("parameters", $Products->getParametersValues(0 , $subcategory['group_id'] ));
        }

        if( $mode == 'save_new_product' && $subcat_id )
        {
        	$Products->importIntoClass("POST");
            $Products->discount_start = $_POST["discount_start_array"]["Date_Year"] . "-" .
                $_POST["discount_start_array"]["Date_Month"] . "-" .
                $_POST["discount_start_array"]["Date_Day"];
            $Products->discount_finish = $_POST["discount_finish_array"]["Date_Year"] . "-" .
                $_POST["discount_finish_array"]["Date_Month"] . "-" .
                $_POST["discount_finish_array"]["Date_Day"];
        	$Products->saveNewProduct($subcat_id);
        	$this->redirect("?mode=products&subcat_id=".$subcat_id."&msg=product_added");
        }

        if( $mode == 'move_product_up' && $product_id )
        {
        	$Products->moveProductUp($product_id);
            $product = $Products->getProductById($product_id);
        	$this->redirect("?mode=products&subcat_id=".$product['subcategory_id']);
        }

        if( $mode == 'move_product_down' && $product_id )
        {
        	$Products->moveProductDown($product_id);
            $product = $Products->getProductById($product_id);
        	$this->redirect("?mode=products&subcat_id=".$product['subcategory_id']);
        }

        if ( $mode == "hide_selected" )
        {
            foreach ( $_POST["selected"] as $product_id )
                $Products->hideProduct($product_id, 0);
            $this->redirect("index.php", "mode=products&subcat_id=".$subcat_id);
        }

        if ( $mode == "show_selected" )
        {
            foreach ( $_POST["selected"] as $product_id )
                $Products->hideProduct($product_id, 1);
            $this->redirect("index.php", "mode=products&subcat_id=".$subcat_id);
        }

        if ( $mode == "absent_selected" )
        {
            foreach ( $_POST["selected"] as $product_id )
                $Products->absentProduct($product_id, 1);
            $this->redirect("index.php", "mode=products&subcat_id=".$subcat_id);
        }

        if ( $mode == "present_selected" )
        {
            foreach ( $_POST["selected"] as $product_id )
                $Products->absentProduct($product_id, 0);
            $this->redirect("index.php", "mode=products&subcat_id=".$subcat_id);
        }
        if ( $mode == "moveto_category" )
        {
            $category_id = $this->getParam('POST', "move_category", "int");
            if ($category_id) {
                $maxposition = $Products->getMaxProductPosition($category_id);
                if (isset($_POST['selected']) and is_array($_POST['selected'])) {
                    foreach ($_POST['selected'] as $id) {
                        $maxposition++;
                        $this->saveItem($id, '#__product', array('subcategory_id' => $category_id, 'position' => $maxposition));
                    }
                }
            }
            $this->redirect("index.php", "mode=products&subcat_id=".$subcat_id);
        }        
        


        // Messages

        $msg = $this->getParam("GET", "msg", "string");

        if($msg)
        {
        	switch ($msg)
        	{
        		case 'category_added':       $msg_text = "Новая категория добавлена";     break;
        		case 'category_deleted':     $msg_text = "Категория удалена";             break;
        		case 'category_saved':       $msg_text = "Категория сохранена";           break;

        		case 'subcategory_added':    $msg_text = "Новая подкатегория добавлена";  break;
        		case 'subcategory_deleted':  $msg_text = "Подкатегория удалена";          break;
        		case 'subcategory_saved':    $msg_text = "Подкатегория сохранена";        break;

        		case 'product_saved':        $msg_text = "Продукт сохранен";              break;
        		case 'product_deleted':      $msg_text = "Продукт удален";                break;
        		case 'product_added':        $msg_text = "Продукт добавлен";              break;
            }
            $this->showMessage($msg_text);
        }

        $this->tpl->assign("categories", $Products->getCategories());

    }

    function render()
    {
        $this->tpl->assign("contentFile", $this->contentFile);
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>