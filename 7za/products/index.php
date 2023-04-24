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
    	//$this->tpl->debugging = true;

        $Products = $this->getClassOf("Products");
        $Cart     = $this->getClassOf("Cart");
        $Comments = $this->getClassOf("Comments");
        $Captcha  = $this->getClassOf("utils.image.gd.Captcha");

        $category_id    = $this->getParam("GET", "category_id", "int");
        $subcategory_id = $this->getParam("GET", "subcategory_id", "int");
        $product_id 	= $this->getParam("GET", "product_id", "int");
        $product_qnt 	= $this->getParam("GET", "product_qnt", "int");
        $mode       	= $this->getParam("GET", "mode", "string");
        $from       	= $this->getParam("GET", "from", "string");
        $sortby       	= $this->getParam("GET", "sortby", "string");
        $smIndex 	   	= $this->getParam("GET", "smIndex", "int");
        
        
        $this->tpl->assign('sortby', $sortby);
        if ($sortby == 'price') {
            $Products->field = 'price';
            $Products->direction = 'ASC';
        } elseif ($sortby == 'price_desc') {
            $Products->field = 'price';
            $Products->direction = 'DESC';
        } elseif ($sortby == 'name') {
            $Products->field = 'product_name';
            $Products->direction = 'ASC';
        } elseif ($sortby == 'name_desc') {
            $Products->field = 'product_name';
            $Products->direction = 'DESC';
        }


        if ( $mode == 'show_subcategory' && $subcategory_id )
        {
            
            //Вывод прайса
            $Products->setSubcategoryRedirect( $smIndex, $subcategory_id );
            $this->contentFile = "products/subcategory.tpl.html";
            $Products->productsPerPage = PRODUCTS_PER_PAGE;
            $this->tpl->assign( "products", $Products->getProductsForPage( $subcategory_id, "/subcat/$subcategory_id/" ) );
            $Products->field = 'position';
            $Products->direction = 'ASC';            
           
			$this->sm->setCssClass("sm");
			$this->sm->setCssSelectedClass("sm_sel");
			if ($sortby) {
			    $this->sm->additionalParams = '&sortby=' . $sortby;
			}
            $this->tpl->assign( "splitMenu", $Products->sm->makeLinkMenu());
            $subcategory = $Products->getSubcategoryById( $subcategory_id );
            if ( $subcategory )
            {
                $this->tpl->assign( "subcategory", $subcategory );
                $category_id = $subcategory['category_id'];
                $this->tpl->assign( "subcategories", $Products->getSubcategories( $category_id ) );
                $category = $Products->getCategoryById($category_id);
                $this->tpl->assign( "category_id", $category_id );
                $this->tpl->assign( "category", $category );
			    //$this->tpl->assign("pagePath", $Products->getNavPath($category, $subcategory));
			    $this->pageTitle = $subcategory['subcategory_name'] . " | " . $category["category_name"] . " | Магазин 7za";
			    $this->pageDescription = $subcategory['subcategory_name'] . " в Магазине 7za";
			    $this->pageKeywords = $subcategory['subcategory_name'];
            }
            else
            {
                $this->redirect("/");
                die();
            }
        }

		if ( $mode == 'back' )
        {
        	$this->redirect( $Products->getSubcategoryRedirect() );
        }

		if ( $mode == 'show_category' && $category_id )
		{
			$this->contentFile = "products/category.tpl.html";
			$this->tpl->assign( "subcategories", $Products->getSubcategories( $category_id ) );
			$this->tpl->assign( "category_id", $category_id );
			$category = $Products->getCategoryById( $category_id );
			$this->tpl->assign( "category", $category );
			$this->pageTitle = $category['category_name'] . " в интернет-магазине 7za";
			$this->tpl->assign( "products", $Products->getPopularProductsOfCategory($category_id, "/cat/".$category_id."/"));
			
			$this->sm->setCssClass("sm");
			$this->sm->setCssSelectedClass("sm_sel");
			$this->tpl->assign( "splitMenu", $this->sm->makeLinkMenu());
		}


        if ( $mode == 'add_to_cart' && $product_id )
        {
        		if( $product_qnt )
        			$Cart->addToCart( $product_id , $product_qnt );
        		else
        			$Cart->addToCart( $product_id );
        		$this->redirect( "/order/" );

        		/*
        	    $product = $Products->getProductById($product_id);
        	    $this->tpl->assign("product", $product);

        	    echo '<script type="text/javascript">
        	    		if(confirm(" В корзину добавлен товар. Посмотреть корзину? "))
	 						location.href="/order/";
	 					else ';
        	    if ( $from == 'search')
        	    	echo 'location.href="/products/search.php?mode=back" </script>';
        	    else
        	    	echo 'location.href="/products/index.php?mode=show_subcategory&subcategory_id='.$product['subcategory_id'].'" </script>';

        		$this->redirect( "/products/index.php?mode=show_subcategory&subcategory_id=".$product['subcategory_id'] );
        		*/
        }

        if ( $mode == 'show_product' && $product_id )
        {
        	$this->contentFile = "products/product.tpl.html";

            $product = $Products->getProductById($product_id);
            if ( !$product )
                $this->redirect("/");
            if ( $product["linked_to_product"] != 0 )
                $this->redirect("/product/".$product["linked_to_product"]."/");
            $this->tpl->assign("product", $product);

            $subcategory = $Products->getSubcategoryById($product['subcategory_id']);
            $this->tpl->assign("subcategory",$subcategory);

            $this->tpl->assign("category", $Products->getCategoryById($subcategory['category_id']));
            $cat_id = $subcategory['category_id'];
            $this->tpl->assign("category_id", $cat_id);

			$this->pageTitle = $this->decodeRequestValue($product['product_name']) . " | " .$this->decodeRequestValue($subcategory["subcategory_name"]). ' | Магазин "7Za"';
//			$this->pageDescription = $this->decodeRequestValue($product['product_name']) . " в Магазине 7Za";
			$this->pageDescription = strip_tags($this->decodeRequestValue($product['description']));
			$this->pageKeywords = $this->decodeRequestValue($product['product_name']) . "";

            $this->tpl->assign("connected", $Products->getConnectedProducts( $product_id ));
            $Products->addProductView( $product_id );

            $comments = $Comments->getCommentsForItem($product_id);
            $this->tpl->assign("comments", $comments);
            $allow_posting = true;
            for ( $i = 0; $i < count($comments); $i++ )
                if ( $comments[$i]["author_ip"] == $_SERVER['REMOTE_ADDR'] && substr($comments[$i]["added_time"], 0, 10) == date("Y-m-d") )
                    $allow_posting = false;
            $this->tpl->assign("allow_posting", $allow_posting);
        }

        if ( $mode == "save_comment" && $product_id )
        {
            $check_image = $this->getParam("POST", "check_image", "string");

            if ( !empty($check_image) && $Captcha->checkCaptcha($check_image) )
            {
                $Comments->importIntoClass("POST");
                $Comments->addCommentForItem($product_id);
                $Captcha->killCaptcha();
                $this->redirect("/product/".$product_id."/?msg=comment_added");
            }
            $this->redirect("/product/".$product_id."/?msg=comment_failed");
        }

        if ( $mode == 'set_sort' && $subcategory_id )
        {
        	$Products->importIntoClass("POST");
        	$Products->setSortForSubcategory( $subcategory_id );
        	$this->redirect(  "/subcat/$subcategory_id/" );
        }

        if( $product_id )
        {
        	$product = $Products->getProductById($product_id);
        	if ( !$product )
        	    $this->redirect("/");
        	$subcategory_id = $product['subcategory_id'];
        	$subcategory = $Products->getSubcategoryById( $subcategory_id );
        	$category = $Products->getCategoryById( $subcategory['category_id'] );
        }
        elseif ( $subcategory_id )
        {
        	$subcategory = $Products->getSubcategoryById( $subcategory_id );
        	$category = $Products->getCategoryById( $subcategory['category_id'] );
        	$product = array();
        }
        elseif ( $category_id )
        {
        	$category = $Products->getCategoryById( $category_id );
        	$subcategory = array();
        	$product = array();
        }
        else
        	$this->redirect( URL_ROOT . "products/");

        $this->tpl->assign("path" , $Products->getNavPath( $category , $subcategory , $product ) );

        $this->tpl->assign("catnav" , $Products->getCategoriesForCatalog( $category['category_id'] ));
        $this->tpl->assign("subcategory_id", $subcategory_id );
        $this->tpl->assign("from", $from );

        $this->tpl->assign("product_sorting" , $Products->getSortForSubcategory() );

		if ( $mode == 'show_product_popup' && $product_id )
		{
			$Products->addProductView( $product_id );
            $product = $Products->getProductById($product_id);
            $this->tpl->assign("product", $product);
			$this->pageTitle = "Продукт :: ".$product['product_name'];
			$this->tplToDisplay = "products/product_popup.tpl.html";
			$this->display();
			exit;
		}

		$Captcha->initCaptcha();

		$msg = $this->getParam("GET", "msg", "string");

        if ( $msg == "comment_added" )
            $this->showMessage("Ваш отзыв добавлен. Спасибо.");

        if ( $msg == "comment_failed" )
            $this->showMessage("Введите правильно код с картинки");
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