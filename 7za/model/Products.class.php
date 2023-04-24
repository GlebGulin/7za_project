<?PHP

class Products extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    var $category_id                = 0;
    var $category_name              = "";

    var $subcategory_id             = 0;
    var $subcategory_name           = "";
    var $marked                     = 0;

    var $product_id                 = 0;
    var $linked_to_product          = 0;
    var $product_name               = "";
    var $description                = "";
    var $image_file_id              = 0;
    var $add_photos                 = "";
    var $price                      = "";
    var $shown                      = "";
    var $hidden                     = 0;
    var $view                       = 0;
    var $absent                     = 0;
    var $special_offer              = 0;
    var $recommended                = 0;

    var $group_id                   = 0;
    var $group_name                 = "";
    var $parameter_id               = 0;
    var $parameter_name             = "";
    var $unit                       = "";
    var $is_header                  = 0;
    var $use_in_search              = 0;
    var $value                      = "";
    var $parameters                 = "";

    var $discount					= "00.0";
    var $discount_start				= "0000-00-00";
    var $discount_finish			= "0000-00-00";

    var $subcategory_image_width    = 150;
    var $subcategory_image_height   = 150;
    var $product_image_width        = 250;
    var $product_image_height       = 400;
    var $product_thumbnail_width    = 180;
    var $product_thumbnail_height   = 110;
    var $position                   = 0;
    var $conn_goods                 = "";

    var $addPhotoThumbWidth         = 95;
    var $addPhotoThumbHeight        = 95;
    var $addPhotoWidth              = 900;
    var $addPhotoHeight             = 600;

    var $direction					= "ASC";
    var $direction_values			= array("ASC","DESC");
    var $field						= "position";
    var $field_values				= array("product_name","price");
    var $min_price					= "";
    var $max_price					= "";

    var $productsPerPage            = PRODUCTS_PER_PAGE;
    var $leaders_count				= PRODUCTS_PER_PAGE;

    var $sales_qnt					= 3;
    var $new_items_qnt				= PRODUCTS_PER_PAGE;
    var $seacrh_per_page			= PRODUCTS_PER_PAGE;
    var $search_result_qnt			= 0;


    var $condition					= "";
    var $limit                      = '';


/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     */
    function Products()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/

	/**
	 * Search product by its name and description
	 *
	 * @param string $word
	 * @param string $target_url
	 * @param string $params
	 * @return array
	 */
	function getSearchProducts( $word, $target_url , $params )
	{
	    $word = preg_replace("/^[^\s]{1,2}\s/", "", $word);
	    $word = preg_replace("/\s[^\s]{1,2}\s/", " ", $word);
	    $word = preg_replace("/^[^\s]{1,2}$/", "", $word);
		//$words = explode( " ", $word );
		$this->condition = "";
        if ($word) {
            $this->condition =  "AND (product_name LIKE '%$word%' OR description LIKE '%$word%') ";
    	    $this->search_result_qnt = Products::runQuery(32, "getNumRows", __FILE__ . ":" . __LINE__);
    	    $this->initSplitMenu($target_url, $this->seacrh_per_page, $this->search_result_qnt, $params);
    	    $items = Products::runQuery(32, "getIndexArray", __FILE__ . ":" . __LINE__);
            for ( $i = 0; $i < count($items); $i++ )
            {
                if ( $items[$i]['discount_start'] <= date("Y-m-d") && $items[$i]['discount_finish'] >= date("Y-m-d") && $items[$i]['discount'] )
                    $items[$i]['discount_price'] = $items[$i]['price'] - $items[$i]['price']*$items[$i]['discount']/100;
                else
                    $items[$i]['discount_price'] = 0;
            }

    	   return $this->sefuPrepareArray($items, "product_name");
        } else {
            $this->search_result_qnt = 0;
            $this->initSplitMenu($target_url, $this->seacrh_per_page, $this->search_result_qnt, $params);
            return array();
        }
		/*if( $word && count($words) > 0 )
		{
			$this->condition .= " AND ( ";
			$first = 1;
			foreach ( $words as $value )
			{
				if(!$first)
    				$this->condition .= " OR product_name LIKE '%$value%' ";
    			else
    				$this->condition .= " product_name LIKE '%$value%' ";
    			$first = 0;

				$this->condition .= " OR description LIKE '%$value%' ";
			}
			$this->condition .= " ) ";

    	   $this->search_result_qnt = Products::runQuery(32, "getNumRows", __FILE__ . ":" . __LINE__);
    	   $this->initSplitMenu($target_url, $this->seacrh_per_page, $this->search_result_qnt, $params);
    	   $items = Products::runQuery(32, "getIndexArray", __FILE__ . ":" . __LINE__);
            for ( $i = 0; $i < count($items); $i++ )
            {
                if ( $items[$i]['discount_start'] <= date("Y-m-d") && $items[$i]['discount_finish'] >= date("Y-m-d") && $items[$i]['discount'] )
                    $items[$i]['discount_price'] = $items[$i]['price'] - $items[$i]['price']*$items[$i]['discount']/100;
                else
                    $items[$i]['discount_price'] = 0;
            }

    	   return $this->sefuPrepareArray($items, "product_name");
		}
		else
		{
            $this->search_result_qnt = 0;
            $this->initSplitMenu($target_url, $this->seacrh_per_page, $this->search_result_qnt, $params);
            return array();
		}*/
	}

	function searchProductsForAdmin( $keyword )
	{
		$words = explode( " ", $keyword );
		$this->condition = "";

		if( count($words) > 0 )
		{
			$this->condition .= " AND ( ";
			$first = true;
			foreach ( $words as $value )
			{
				if ( !$first )
    				$this->condition .= " OR product_name LIKE '%$value%' ";
    			else
    				$this->condition .= " product_name LIKE '%$value%' ";
    			$first = false;

				$this->condition .= " OR description LIKE '%$value%' ";
				$this->condition .= " OR product_id LIKE '%$value%' ";
			}
			$this->condition .= " ) ";

    	   return Products::runQuery( 43, "getIndexArray", __FILE__ . ":" . __LINE__);
		}
		else
            return array();
	}

	function getNavPathForSearch()
    {
		$Pages = $this->getClassOf("Pages");
        $main_page = $Pages->getPageById( 1 );
        $path[0]['title']   = $main_page['title'];
    	$path[0]['page_id'] = $main_page['page_id'];
    	$path[0]['link']    = URL_ROOT ;
        $path[1]['title']   = "Результаты поиска";
    	$path[1]['page_id'] = "0";
    	$path[1]['link']    = "#";
    	return $path;
    }

    /**
     * Save parameters of search
     *
     * @param int $
     * Index
     * @param string $mode
     * @param string $word
     */
    function setSearchRedirect( $smIndex, $mode, $word )
    {
    	$_SESSION['products_search']['smIndex']   = $smIndex;
    	$_SESSION['products_search']['mode'] 	   = $mode;
     	$_SESSION['products_search']['word']      = $word;
    }

    /**
     * Returns parameters of search
     *
     * @return string
     */
    function getSearchRedirect()
    {
    	$smIndex  = isset($_SESSION['products_search']['smIndex'])?$_SESSION['products_search']['smIndex']:0;
    	$mode     = isset($_SESSION['products_search']['mode'])?$_SESSION['products_search']['mode']:"";
     	$word     = isset($_SESSION['products_search']['word'])?$_SESSION['products_search']['word']:"";

     	return 			  "smIndex=$smIndex&".
     			          "mode=$mode&".
     			          "word=$word";
    }

    /**
     * Save parameters of subcategory view
     *
     * @param int $smIndex
     * @param int $subcategory_id
     */

    function setSubcategoryRedirect( $smIndex, $subcategory_id )
    {
    	$_SESSION['subcategory']['smIndex']   = $smIndex;
	 	$_SESSION['subcategory']['subcategory_id']      = $subcategory_id;
    }

    /**
     * Returns parameters of subcategory view
     *
     * @return string
     */
    function getSubcategoryRedirect()
    {
    	$smIndex  = isset($_SESSION['subcategory']['smIndex'])?$_SESSION['subcategory']['smIndex']:0;
     	$subcategory_id     = isset($_SESSION['subcategory']['subcategory_id'])?$_SESSION['subcategory']['subcategory_id']:"";

     	return 			  "/subcat/$subcategory_id/?smIndex=$smIndex";
    }

    /**
     * Returns products with sale status for start page
     *
     * @return array
     */
	function getSaleForStartPage()
	{
		/*$list = $this->getSales();
		if( !count($list) ) return array();
		$item_key = array_rand( $list, $this->sales_qnt );*/
    	$list = $this->getSales();
    	if(!count($list))
    		return array();
    	if( count($list) < $this->sales_qnt )
    		$this->sales_qnt = count($list);
		$rand_keys = array_rand( $list, $this->sales_qnt );
		$sales = array();
		if( is_array($rand_keys) )
			foreach( $rand_keys as $value )
				$sales[] = $this->getProductById( $list[$value]['product_id'] );
		else
			$sales[$rand_keys] = $this->getProductById( $list[$rand_keys]['product_id'] ) ;
		return $sales;
	}

	/**
	 * Returns all sales products
	 *
	 * @return array
	 */
	function getSales()
	{
		$products = Products::runQuery( 31, "getIndexArray", __FILE__.":".__LINE__ );

		if ( !$products )
            return array();

		for ( $i = 0; $i < count($products); $i++ )
		{
        	if( $products[$i]['discount_start'] <= date("Y-m-d") && $products[$i]['discount_finish'] >= date("Y-m-d") && $products[$i]['discount'] )
        		$products[$i]['discount_price'] = $products[$i]['price'] - $products[$i]['price']*$products[$i]['discount']/100;
        	else
        		$products[$i]['discount_price'] = 0;
		}

		return $this->sefuPrepareArray($products, "product_name");
	}

	/**
	 * Returns navigation path for sales
	 *
	 * @return unknown
	 */
    function getNavPathForSales()
    {
		$Pages = $this->getClassOf("Pages");
        $main_page = $Pages->getPageById( 1 );
        $path[0]['title']   = $main_page['title'];
    	$path[0]['page_id'] = $main_page['page_id'];
    	$path[0]['link']    = URL_ROOT ;
        $path[1]['title']   = "Распродажа";
    	$path[1]['page_id'] = "0";
    	$path[1]['link']    = "#";
    	return $path;
    }

	/**
	 * Returns sales leaders
	 *
	 * @return array
	 */
	function getSaleLeaders($limit = 0)
	{
	    if ($limit) {
	        $this->leaders_count = $limit;
	    }
		$products = Products::runQuery( 30 , "getIndexArray", __FILE__ . ":" . __LINE__);
		for ( $i = 0; $i < count($products); $i++ )
		{
        	if( $products[$i]['discount_start'] <= date("Y-m-d") && $products[$i]['discount_finish'] >= date("Y-m-d") && $products[$i]['discount'] )
        		$products[$i]['discount_price'] = $products[$i]['price'] - $products[$i]['price']*$products[$i]['discount']/100;
        	else
        		$products[$i]['discount_price'] = 0;
		}
		return $this->sefuPrepareArray($products, "product_name");
	}

	/**
	 * Add one product view
	 *
	 * @param int $product_id
	 */
	function addProductView( $product_id )
	{
		$this->product_id = $product_id;
		Products::runQuery( 29 , "getIndexArray", __FILE__ . ":" . __LINE__);
	}

	/**
	 * Return connected products for product by its id
	 *
	 * @param int $product_id
	 * @return array
	 */
	function getConnectedProducts( $product_id )
	{
		$products = array();
		$product = $this->getProductById( $product_id );
		$items = explode(",",$product['conn_goods'] );
		if( count($items) )
			foreach ( $items as $value )
				if( intval($value) )
					$products[]=$this->getProductById( intval($value) );
		return $products;
	}

	/**
	 * Return navigator for catalogue of production
	 *
	 * @param array $category
	 * @param array $subcategory
	 * @return array
	 */
	function getNavPath( $category, $subcategory = null )
	{
        $path[1]['title']   = $category['category_name'];
    	$path[1]['page_id'] = $category['category_id'];
    	$path[1]['link']    = "/cat/".$category['category_id']."/";
    	if ( $subcategory )
    	{
    		$path[2]['title']   = $subcategory['subcategory_name'];
    		$path[2]['page_id'] = $subcategory['subcategory_id'];
    		$path[2]['link']    = "/subcat/".$subcategory['subcategory_id']."/";
    	}
    	return $path;
	}

	/**
	 * returns sorting array for subcategory
	 *
	 * @return array
	 */
	function getSortForSubcategory()
	{
		$sorting['field'] =  $this->field;
		$sorting['direction'] =  $this->direction;
		$sorting['min_price'] =  $this->min_price;
		$sorting['max_price'] =  $this->max_price;
		return $sorting;
	}

	/**
	 * Save sorting options in session
	 *
	 * @param int $subcategory_id
	 */
	function setSortForSubcategory( $subcategory_id )
	{
		if( !in_array($this->field,$this->field_values) ) return false;
		if( !in_array($this->direction,$this->direction_values) ) return false;
		$_SESSION['product_sorting']['direction'] = $this->direction;
		$_SESSION['product_sorting']['field'] = $this->field;
		$_SESSION['product_sorting']['subcategory_id'] = $subcategory_id;
		$_SESSION['product_sorting']['min_price'] = $this->min_price;
		$_SESSION['product_sorting']['max_price'] = $this->max_price;
	}

	/**
	 * Return product for page
	 *
	 * @param int $subcategory_id
	 * @param string $target_url
	 * @param string $params
	 * @return array
	 */
    function getProductsForPage( $subcategory_id, $target_url, $params = "" )
    {
        $this->condition = "";
        $this->subcategory_id = $subcategory_id;
        if ( isset( $_SESSION['product_sorting'] ) && $this->subcategory_id == $_SESSION['product_sorting']['subcategory_id'] )
        {
        	$this->direction = $_SESSION['product_sorting']['direction'];
        	$this->field = $_SESSION['product_sorting']['field'];
        	if( $_SESSION['product_sorting']['min_price'] )
        	{
        		$this->min_price = $_SESSION['product_sorting']['min_price'];
        		$this->condition = " AND IFNULL(p2.price,p.price) >= '$this->min_price' ";
        	}

        	if( $_SESSION['product_sorting']['max_price'] )
        	{
        		$this->max_price = $_SESSION['product_sorting']['max_price'];
        		$this->condition.= " AND IFNULL(p2.price,p.price) <= '$this->max_price' ";
        	}


        }
        elseif( isset( $_SESSION['product_sorting'] ) )
        	unset( $_SESSION['product_sorting'] );

    	$num_products = Products::runQuery( 28, "getNumRows", __FILE__ . ":" . __LINE__);
    	$this->initSplitMenu($target_url, $this->productsPerPage, $num_products, $params );
    	$products = Products::runQuery( 28 , "getIndexArray", __FILE__ . ":" . __LINE__);

		for ( $i = 0; $i < count($products); $i++ )
		{
        	if( $products[$i]['discount_start'] <= date("Y-m-d") && $products[$i]['discount_finish'] >= date("Y-m-d") && $products[$i]['discount'] )
        		$products[$i]['discount_price'] = $products[$i]['price'] - $products[$i]['price']*$products[$i]['discount']/100;
        	else
        		$products[$i]['discount_price'] = 0;
		}
		return $products;
    }

    /**
     * Return all categories
     *
     * @return unknown
     */
    function getCategories()
    {
        return Products::runQuery( 0, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Add new category in db
     *
     * @return int
     */
    function addNewCategory()
    {
        $this->position = Products::runQuery( 2, "getSingleValue", __FILE__ . ':' . __LINE__ ) + 1;
        Products::runQuery( 1, "none", __FILE__ . ':' . __LINE__ );
        return $this->lastInsertId();
    }

    /**
     * Returns category by its id
     *
     * @param int $category_id
     * @return array
     */
    function getCategoryById( $category_id )
    {
        $this->category_id = $category_id;
        return Products::runQuery( 3, "getArray", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Returns subcategory by its id
     *
     * @param int $subcategory_id
     * @return array
     */
    function getSubcategoryById( $subcategory_id )
    {
        $this->subcategory_id = $subcategory_id;
        $this->condition = "";
        $subcategory = Products::runQuery( 7, "getArray", __FILE__ . ':' . __LINE__ );
        $this->smLimitClause = "";
        if ( !$subcategory )
            return array();
        $subcategory['product_qnt'] = Products::runQuery( 28, "getNumRows", __FILE__ . ":" . __LINE__);
        return $subcategory;
    }

    /**
     * Return subcategories for category
     *
     * @param int $category_id
     * @return array
     */
    function getSubcategories( $category_id, $show_hidden = false )
    {
        $this->category_id = $category_id;
        if ( !$show_hidden )
            $this->condition = " AND hidden=0";
        else
            $this->condition = "";
        return Products::runQuery( 4, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Add new subcategory in category
     *
     * @param int $category_id
     * @return int
     */
    function addNewSubcategory( $category_id )
    {
        $MM =& $this->getClassOf("Modules.MediaManager");
        $MM->setImageSize($this->subcategory_image_width, $this->subcategory_image_height);
        $this->image_file_id = $MM->addImageResized("image_file");

        $this->category_id = $category_id;
        $this->position = Products::runQuery( 6, "getSingleValue", __FILE__ . ':' . __LINE__ ) + 1;
        Products::runQuery( 5, "none", __FILE__ . ':' . __LINE__ );
        return $this->lastInsertId();
    }

    /**
     * Returns products for subcategory
     *
     * @param int $subcategory_id
     * @return array
     */
    function getProductsBySubcat( $subcategory_id )
    {
    	$this->subcategory_id = $subcategory_id;
    	return Products::runQuery( 8, "getIndexArray", __FILE__ . ':' . __LINE__ );

    }

    /**
     * Returns a list of visible products with prices>0 of specified subcategory.
     *
     * Used for importing.
     *
     * @param   int     $subcategory_id
     * @return  array
     */
    function getVisibleProductsOfSubcategory( $subcategory_id )
    {
        $this->subcategory_id = $subcategory_id;
        return $this->sefuPrepareArray(Products::runQuery( 39, "getIndexArray", __FILE__ . ':' . __LINE__ ), "product_name");
    }

    /**
     * Returns product by its id
     *
     * @param int $product_id
     * @return array
     */
    function getProductById( $product_id )
    {
    	$this->product_id = $product_id;
    	$product = Products::runQuery( 9, "getArray", __FILE__ . ':' . __LINE__ );
    	if ( !$product )
    	    return false;
    	if( $product['discount_start'] <= date("Y-m-d") &&  $product['discount_finish'] >= date("Y-m-d") && $product['discount'] )
    		$product['discount_price'] = $product['price'] - $product['price']*$product['discount']/100;
    	else
    		$product['discount_price'] = 0;

        if ( $product['add_photos'] != "")
            $product['add_photos'] = explode(",",$product['add_photos']);
        else
            $product['add_photos'] = array();

        $product["sefu_title"] = $this->sefuPrepare($product["product_name"]);

    	$subcategory = $this->getSubcategoryById($product["subcategory_id"]);
        $parameters = $this->getParametersValues($product_id , $subcategory["group_id"]);

        $i = 0;
        $empty = true;
        while ( isset($parameters[$i]) && $empty )
        {
            if ( !empty($parameters[$i]["value"]) )
                $empty = false;
            $i++;
        }
        if ( !$empty )
            $product["parameters"] = $parameters;

    	return $product;
    }

    /**
     * Save product
     *
     * @param int $product_id
     */
    function saveProduct( $product_id )
    {
    	$this->product_id = $product_id;
    	$this->price = str_replace(',', '.', $this->price);
    	$this->discount = str_replace(',', '.', $this->discount);
    	$this->description = $this->getEditorCode("description");
    	$item = $this->getProductById($this->product_id);

        $MM =& $this->getClassOf("Modules.MediaManager");
        $MM->setImageSize($this->product_image_width, $this->product_image_height);
        $MM->setThumbnailSize($this->product_thumbnail_width, $this->product_thumbnail_height);

        if ( $image_id = $MM->addImageResizedWithPreview("img_file") )
        {
            $MM->deleteFile($item["image_file_id"]);
            $this->image_file_id = $image_id;
        }
        else
            $this->image_file_id = $item["image_file_id"];

        $MM->setThumbnailSize($this->addPhotoThumbWidth, $this->addPhotoThumbHeight);
        $MM->setImageSize($this->addPhotoWidth, $this->addPhotoHeight);
        if ( $add_photos = $MM->addImageResizedWithPreviewMulti("add_photos") )
            $this->add_photos = implode( "," , array_merge ( $item['add_photos'] , $add_photos ) );
        else
            $this->add_photos = implode( "," , $item["add_photos"] );

        Products::runQuery( 10, "none", __FILE__.':'.__LINE__ );

        if( count($this->parameters) )
        {
            Products::runQuery( 61, "none", __FILE__ . ':' . __LINE__ );
            if (is_array($this->parameters)) {
                foreach( $this->parameters as $this->parameter_id => $this->value )
                {
                    $this->value = $this->decodeRequestValue($this->value);
                    Products::runQuery( 62, "none", __FILE__ . ':' . __LINE__ );
                }
            }
        }
    }

    function deleteAddPhoto( $product_id , $photo_id )
    {
        $this->product_id = $product_id;
        $item = $this->getProductById( $this->product_id );
        $add_photos = $item['add_photos'];

        foreach ( $add_photos as $key => $value )
            if ( $value == $photo_id )
            {
                $MM = $this->getClassOf("Modules.MediaManager");
                $MM->deleteFile( $photo_id );
                unset( $add_photos[$key] );
            }

        $this->add_photos = implode( ",", $add_photos );
        Products::runQuery( 65, "none", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Change visibility for product
     *
     * @param int $product_id
     */

    function hideProduct( $product_id, $value = false )
    {
    	$this->product_id = $product_id;
    	$product = $this->getProductById($this->product_id);
    	if ( $product['linked_to_product'] )
    	   $this->product_id = $product['linked_to_product'];

        $this->shown = $product["shown"] == 1 ? 0 : 1;

        if ( is_integer($value) )
            $this->shown = $value;

    	Products::runQuery( 11, "none", __FILE__.':'.__LINE__ );
    }

    /**
     * Remove product from DB
     *
     * @param int $product_id
     */
    function deleteProductItem( $product_id )
    {
        $product = $this->getProductById($product_id);
        if ( !$product )
            return false;

        if ( $product["image_file_id"] )
        {
            $MM =& $this->getClassOf("Modules.MediaManager");
            $MM->deleteFile($product["image_file_id"]);
        }

        $this->product_id = $product_id;
        $this->runQuery(12, "none", __FILE__ . ':' . __LINE__ );
    }

    
    
    
    
    
    function getMaxProductPosition($subcat_id) {
        $this->subcategory_id = $subcat_id;
        return Products::runQuery( 14, "getSingleValue", __FILE__.':'.__LINE__ );
    }
    /**
     * Add new product
     *
     * @param int $subcat_id
     */
    function saveNewProduct( $subcat_id )
    {
    	$this->subcategory_id = $subcat_id;
    	$this->price = str_replace(',', '.', $this->price);
    	$this->discount = str_replace(',', '.', $this->discount);
    	$this->description = $this->getEditorCode("description");
    	$this->position = 1 + Products::runQuery( 14, "getSingleValue", __FILE__.':'.__LINE__ );
        $MM =& $this->getClassOf("Modules.MediaManager");
        $MM->setImageSize($this->product_image_width, $this->product_image_height);
        $MM->setThumbnailSize($this->product_thumbnail_width, $this->product_thumbnail_height);
        if ( $image_id = $MM->addImageResizedWithPreview("img_file") )
            $this->image_file_id = $image_id;

        $MM->setThumbnailSize($this->addPhotoThumbWidth, $this->addPhotoThumbHeight);
        $MM->setImageSize($this->addPhotoWidth, $this->addPhotoHeight);
        if ( $add_photos = $MM->addImageResizedWithPreviewMulti("add_photos") )
            $this->add_photos = implode( ",", $add_photos );
        else
            $this->add_photos = "";

    	Products::runQuery( 13, "none", __FILE__ . ':' . __LINE__ );

        if( count($this->parameters) )
        {
            $this->product_id = $this->lastInsertId();
            Products::runQuery( 61, "none", __FILE__ . ':' . __LINE__ );
            if (is_array($this->parameters)) {
                foreach( $this->parameters as $this->parameter_id => $this->value )
                {
                    $this->value = $this->decodeRequestValue($this->value);
                    Products::runQuery( 62, "none", __FILE__ . ':' . __LINE__ );
                }
            }
        }
    }

    /**
     * Change position for product
     *
     * @param int $product_id
     */
    function moveProductUp( $product_id )
    {
    	$item = $this->getProductById($product_id);
    	$this->position = $item["position"];
    	$this->subcategory_id = $item["subcategory_id"];
        // get product with less position
        $item2 = Products::runQuery( 15, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->product_id  = $item["product_id"];
            $this->position    = $item2["position"];
            Products::runQuery( 17, "none", __FILE__ . ':' . __LINE__ );

            $this->product_id  = $item2["product_id"];
            $this->position = $item["position"];
            Products::runQuery( 17, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    /**
     * Change position for product
     *
     * @param int $product_id
     */
    function moveProductDown( $product_id )
    {
    	$item = $this->getProductById($product_id);
        $this->position = $item["position"];
        $this->subcategory_id = $item["subcategory_id"];
        // get product with more position
        $item2 = Products::runQuery( 16, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->product_id  = $item["product_id"];
            $this->position    = $item2["position"];
            Products::runQuery( 17, "none", __FILE__ . ':' . __LINE__ );

            $this->product_id  = $item2["product_id"];
            $this->position = $item["position"];
            Products::runQuery( 17, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    /**
     * Change position for category
     *
     * @param int $cat_id
     */
    function moveCategoryUp( $cat_id )
    {
    	$item = $this->getCategoryById($cat_id);
    	$this->position = $item["position"];
    	$this->category_id = $item["category_id"];
        // get category with less position
        $item2 = Products::runQuery( 18, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->category_id  = $item["category_id"];
            $this->position    = $item2["position"];
            Products::runQuery( 20, "none", __FILE__ . ':' . __LINE__ );

            $this->category_id  = $item2["category_id"];
            $this->position = $item["position"];
            Products::runQuery( 20, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    /**
     * Change position for category
     *
     * @param int $cat_id
     */
    function moveCategoryDown( $cat_id )
    {
    	$item = $this->getCategoryById($cat_id);
    	$this->position = $item["position"];
    	$this->category_id = $item["category_id"];
        // get category with more position
        $item2 = Products::runQuery( 19, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->category_id  = $item["category_id"];
            $this->position    = $item2["position"];
            Products::runQuery( 20, "none", __FILE__ . ':' . __LINE__ );

            $this->category_id  = $item2["category_id"];
            $this->position = $item["position"];
            Products::runQuery( 20, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    /**
     * Change position for subcategory
     *
     * @param int $subcat_id
     */
    function moveSubcategoryUp( $subcat_id )
    {
    	$item = $this->getSubcategoryById($subcat_id);
    	$this->position = $item["position"];
    	$this->category_id = $item["category_id"];
        // get category with less position
        $item2 = Products::runQuery( 21, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->subcategory_id  = $item["subcategory_id"];
            $this->position    = $item2["position"];
            Products::runQuery( 23, "none", __FILE__ . ':' . __LINE__ );

            $this->subcategory_id  = $item2["subcategory_id"];
            $this->position = $item["position"];
            Products::runQuery( 23, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    /**
     * Change position for subcategory
     *
     * @param int $subcat_id
     */
    function moveSubcategoryDown( $subcat_id )
    {
    	$item = $this->getSubcategoryById($subcat_id);
    	$this->position = $item["position"];
    	$this->category_id = $item["category_id"];
        // get category with more position
        $item2 = Products::runQuery( 22, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->subcategory_id  = $item["subcategory_id"];
            $this->position    = $item2["position"];
            Products::runQuery( 23, "none", __FILE__ . ':' . __LINE__ );

            $this->subcategory_id  = $item2["subcategory_id"];
            $this->position = $item["position"];
            Products::runQuery( 23, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    /**
     * remove subcategory with its products from db
     *
     * @param int $subcat_id
     */
    function deleteSubcategory( $subcat_id )
    {
    	// delete products from subcategory
    	$products = $this->getProductsBySubcat($subcat_id);
    	if(count($products))
    		foreach ($products as $key=>$value)
    			$this->deleteProductItem($value['product_id']);

    	// delete subcategory
    	$this->subcategory_id = $subcat_id;
    	Products::runQuery( 24, "none", __FILE__ . ':' . __LINE__ );
    }

    /**
     * remove category with its subcategory with its products from db
     *
     * @param int $cat_id
     */
    function deleteCategory( $cat_id )
    {
    	// delete subcategories from category
    	$subcategories = $this->getSubcategories($cat_id);
    	if(count($subcategories))
    		foreach ($subcategories as $key=>$value)
    			$this->deleteSubcategory($value['subcategory_id']);

    	// delete category
    	$this->category_id = $cat_id;
    	Products::runQuery( 25, "none", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Save category
     *
     * @param int $cat_id
     */
    function saveCategory( $cat_id )
    {
    	$this->category_id = $cat_id;
    	Products::runQuery( 26, "none", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Save subcategory
     *
     * @param int $subcat_id
     */
    function saveSubcategory( $subcat_id )
    {
        $item = $this->getSubcategoryById($subcat_id);
        $MM =& $this->getClassOf("Modules.MediaManager");
        $MM->setImageSize($this->subcategory_image_width, $this->subcategory_image_height);
        if ( $image_id = $MM->addImageResized("image_file") )
        {
            $MM->deleteFile($item["image_file_id"]);
            $this->image_file_id = $image_id;
        }
        else
            $this->image_file_id = $item["image_file_id"];

    	$this->subcategory_id = $subcat_id;
    	Products::runQuery( 27, "none", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Returns categories with subcategories for start page
     *
     * @return array
     */
    function getCategoriesForStartPage()
    {
        $categories = $this->getCategories();
        if ( count($categories) )
            foreach ( $categories as $key => $value )
	    		$categories[$key]['subcategories'] = $this->getSubcategories( $value['category_id'] );
    	return $categories;
    }

    /**
     * Returns categories with subcategories for catalogue of production
     *
     * @return array
     */
    function getCategoriesForCatalog( $cat_id )
    {
    	$categories = $this->getCategories();
    	if(count($categories))
    		foreach( $categories as $key => $value )
    		{
    			if( $categories[$key]['category_id'] == $cat_id )
    			$categories[$key]['subcategories'] = $this->getSubcategories( $value['category_id'] );
    		}
    	return $categories;
    }

    /**
     * Returns new products
     *
     * @return array
     */
    function getNewProducts($limit = 0)
    {
        if ($limit) {
            $this->new_items_qnt = $limit;
        }
    	return Products::runQuery( 33, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Returns navigation path for new products
     *
     * @return array
     */
    function getNavPathForNew()
    {
		$Pages = $this->getClassOf("Pages");
        $main_page = $Pages->getPageById( 1 );
        $path[0]['title']   = $main_page['title'];
    	$path[0]['page_id'] = $main_page['page_id'];
    	$path[0]['link']    = URL_ROOT ;
        $path[1]['title']   = "Новинки";
    	$path[1]['page_id'] = "0";
    	$path[1]['link']    = "#";
    	return $path;
    }

    /**
     * Reset all view counters to 0 and sets top viewed products' counters to 1.
     *
     * This method should be used periodically to reset top stats.
     *
     */
    function resetTopProducts()
    {
        $top_products = Products::runQuery( 34, "getIndexArray", __FILE__ . ':' . __LINE__ );
        // reset all counters to 0
        Products::runQuery( 35, "none", __FILE__ . ':' . __LINE__ );

        for ( $i = 0; $i < count($top_products); $i++ )
        {
            $this->product_id = $top_products[$i]["product_id"];
            Products::runQuery( 36, "none", __FILE__ . ':' . __LINE__ );
            print $top_products[$i]["product_name"] . "\n";
        }
    }

    /**
     * Exports all products.
     *
     * @return array
     */
    function getAllProducts()
    {
        return Products::runQuery( 37, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    function sendProductStats()
    {
        $all_products = $this->getAllProducts();

        $content = "id;ТОВАР;СТОИМОСТЬ;ПРОСМОТРОВ\n";
        $last_cat_id = 0;
        $last_subcat_id = 0;
        for ( $i = 0; $i < count($all_products); $i++ )
        {
            if ( $last_cat_id != $all_products[$i]["category_id"] )
                $content .= "\n# " . $all_products[$i]["category_name"] . "\n";

            if ( $last_subcat_id != $all_products[$i]["subcategory_id"] )
                $content .= "\n## " . $all_products[$i]["subcategory_name"] . "\n";

            $content .= $all_products[$i]["product_id"] . ";" . $this->decodeRequestValue($all_products[$i]["product_name"]) . ";" . $all_products[$i]["price"] . ";" . $all_products[$i]["view"] . "\n";

            $last_cat_id = $all_products[$i]["category_id"];
            $last_subcat_id = $all_products[$i]["subcategory_id"];
        }
        $fp = fopen(LIB . "view/smarty/templates_c/".date("dmY").".csv", "w+");
        fputs($fp, $content);
        fclose($fp);

/*
        $ML =& $this->getClassOf("utils.mail.MailLauncher");
        $ML->init(REPORTS_EMAIL, "Недельная статистика 7za.com.ua", FROM_EMAIL);
        $this->tpl->assign("start_date", date("d.m.Y", strtotime("-7 days")));
        $this->tpl->assign("end_date", date("d.m.Y"));
        $ML->setBody($this->tpl->fetch("mails/weekly_stats.tpl.html"));
        $ML->addAttachment(LIB . "view/smarty/templates_c/".date("dmY").".csv");
        $ML->send();
*/
        unlink(LIB . "view/smarty/templates_c/".date("dmY").".csv");
    }

    /**
     * Returns an array with all visible products.
     *
     * @return  array
     */
    function getAllVisibleProducts()
    {
        return Products::runQuery( 38, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Returns products tree for product selector.
     *
     * @return  array
     */
    function getProductsForSelector()
    {
        $cats = $this->getCategoriesForStartPage();

        for ( $i = 0; $i < count($cats); $i++ )
        {
            for ( $j = 0; $j < count($cats[$i]['subcategories']); $j++ )
            {
                 $products = $this->getProductsBySubcat($cats[$i]['subcategories'][$j]['subcategory_id']);
                 $cats[$i]['subcategories'][$j]['products'] = array();
                 for ( $k = 0; $k < count($products); $k++ )
                    if ( $products[$k]['linked_to_product'] == 0 && $products[$k]['shown'] )
                        $cats[$i]['subcategories'][$j]['products'][] = $products[$k];
            }
        }
        return $cats;
    }

    function getProductsByList( $product_list )
    {
        $this->condition = "";
        foreach ( $product_list as $product_id )
            $this->condition .= " OR product_id='$product_id'";

        $products = Products::runQuery( 40, "getIndexArray", __FILE__ . ':' . __LINE__ );
        return $products;
    }

    function absentProduct( $product_id, $value )
    {
        $product = $this->getProductById($product_id);
        if ( $product["linked_to_product"] )
            $this->product_id = $product["linked_to_product"];
        else
            $this->product_id = $product_id;

        $this->absent = $value;
        Products::runQuery( 41, "none", __FILE__ . ':' . __LINE__ );
    }

    function hideSubcategory( $subcategory_id )
    {
        $subcategory = $this->getSubcategoryById($subcategory_id);
        if ( !$subcategory )
            return false;

        if ( $subcategory["hidden"] )
            $this->hidden = 0;
        else
            $this->hidden = 1;

        $this->subcategory_id = $subcategory_id;
        Products::runQuery( 42, "none", __FILE__ . ':' . __LINE__ );
    }

    function getPopularProductsOfCategory( $category_id, $target_url, $params = "" )
    {
        $this->category_id = $category_id;
        $this->smLimitClause = "";
        if ($this->field == 'position') {
            $this->field = 'p.view';
            $this->direction = 'DESC';
        }
    	$num_products = Products::runQuery( 44, "getNumRows", __FILE__ . ":" . __LINE__);
    	$this->initSplitMenu($target_url, $this->productsPerPage, $num_products, $params );
    	$products = Products::runQuery( 44, "getIndexArray", __FILE__ . ":" . __LINE__);

		for ( $i = 0; $i < count($products); $i++ )
		{
        	if( $products[$i]['discount_start'] <= date("Y-m-d") && $products[$i]['discount_finish'] >= date("Y-m-d") && $products[$i]['discount'] )
        		$products[$i]['discount_price'] = $products[$i]['price'] - $products[$i]['price']*$products[$i]['discount']/100;
        	else
        		$products[$i]['discount_price'] = 0;
		}

        return $this->sefuPrepareArray($products, "product_name");
    }

    function getSpecialOffers()
    {
        return Products::runQuery( 45, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    function getRecommendedProducts($limit = 0)
    {
        if ($limit) {
            $this->limit = ' ORDER BY RAND() LIMIT ' . $limit;
        }
        return Products::runQuery( 64, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }


    function getParametersGroups()
    {
        return Products::runQuery( 46, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    function getParametersGroupById( $group_id )
    {
        $this->group_id = $group_id;
        return Products::runQuery( 47, "getArray", __FILE__ . ':' . __LINE__ );
    }

    function saveGroup( $group_id )
    {
        $this->group_id = $group_id;
        Products::runQuery( 48, "none", __FILE__ . ':' . __LINE__ );
    }

   function saveNewGroup()
   {
        Products::runQuery( 49, "none", __FILE__ . ':' . __LINE__ );
   }

   function deleteGroup( $group_id )
   {
        $this->group_id = $group_id;
        Products::runQuery( 50, "none", __FILE__ . ':' . __LINE__ );
        Products::runQuery( 60, "none", __FILE__ . ':' . __LINE__ );
   }

   function getParametersByGroup( $group_id )
   {
           $this->group_id = $group_id;
           return Products::runQuery( 51, "getIndexArray", __FILE__ . ':' . __LINE__ );
   }

   function getParameterById( $parameter_id )
   {
           $this->parameter_id = $parameter_id;
           return Products::runQuery( 52, "getArray", __FILE__ . ':' . __LINE__ );
   }

   function saveParameter( $parameter_id )
   {
           $this->parameter_id = $parameter_id;
           $this->unit = $this->decodeRequestValue($this->unit);
           Products::runQuery( 53, "none", __FILE__ . ':' . __LINE__ );
   }

    function saveNewParameter( $group_id )
    {
           $this->group_id = $group_id;
           $this->unit = $this->decodeRequestValue($this->unit);
           $this->position = 1 + Products::runQuery( 59, "getSingleValue", __FILE__ . ':' . __LINE__ );
           Products::runQuery( 54, "none", __FILE__ . ':' . __LINE__ );
    }

    function deleteParameter( $parameter_id )
    {
           $this->parameter_id = $parameter_id;
           Products::runQuery( 55, "none", __FILE__ . ':' . __LINE__ );
    }

    function moveParameterUp( $parameter_id )
    {
        $item = $this->getParameterById( $parameter_id );
        $this->position = $item["position"];
        $this->group_id = $item["group_id"];
        // get parameter with less position
        $item2 = Products::runQuery( 56, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->parameter_id  = $item["parameter_id"];
            $this->position    = $item2["position"];
            Products::runQuery( 58, "none", __FILE__ . ':' . __LINE__ );

            $this->parameter_id  = $item2["parameter_id"];
            $this->position = $item["position"];
            Products::runQuery( 58, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    function moveParameterDown( $parameter_id )
    {
        $item = $this->getParameterById( $parameter_id );
        $this->position = $item["position"];
        $this->group_id = $item["group_id"];
        // get parameter with more position
        $item2 = Products::runQuery( 57, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->parameter_id  = $item["parameter_id"];
            $this->position    = $item2["position"];
            Products::runQuery( 58, "none", __FILE__ . ':' . __LINE__ );

            $this->parameter_id  = $item2["parameter_id"];
            $this->position = $item["position"];
            Products::runQuery( 58, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    function getParametersValues( $product_id , $group_id )
    {
        $items = $this->getParametersByGroup( $group_id );
        $this->product_id = $product_id;
        if ( $items )
            foreach( $items as $key => $value )
            {
                $this->parameter_id = $value['parameter_id'];
                $val = Products::runQuery( 63, "getSingleValue", __FILE__ . ':' . __LINE__ );
                $items[$key]['value'] = $val?$val:"";
            }
        return $items;
    }

/****************************************************************************
 *                      Helper functions                                    *
 ****************************************************************************/

    /**
     * wrapper around the runQuery method in dbHandler.class.php
     *
     * requires the appropiate query file for this class and
     * passes the query to dbHandler::runQuery()
     * returns an array or a string in accordance to the wanted result
     * The requirement for query file: it must have filename
     * <classname>.sql.php
     *
     * @author  Ralf Kramer, Alex Koshel
     * @param   int  query_id ( array index of the query within the
     *                          required query file )
     * @param   string result ( specifies the type of the expected
     *          result set
     *          e.g. "getArray", "getIndexArray", "getSingleValue" etc. )
     * @param   msq_id ( a hint that is thrown by the system when an error occurs )
     *
     * @return  mixed
     */
    function runQuery( $query_id, $result, $msg_id ) {
        $queryFName = str_replace( ".class.php", ".sql.php", __FILE__ );
        require( $queryFName );
        //echo $query[28];
        return $this->core->runQuery( $query[$query_id], $result, $msg_id );
    }

}
?>