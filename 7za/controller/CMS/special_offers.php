<?php

    $Products = $this->getClassOf("Products");

    $offers = $Products->getSpecialOffers();

	$this->tpl->assign( "offers" , $offers );
	$this->moduleTpl = "CMS/special_offers/index.tpl.html";


?>