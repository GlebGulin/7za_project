<?php

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
	$this->moduleTpl = "CMS/prices/index.tpl.html";


?>