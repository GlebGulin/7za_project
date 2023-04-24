<?php

    $Products = $this->getClassOf("Products");
    $items = $Products->getSales();

    $this->tpl->assign("sales", $items);
    $this->moduleTpl = "CMS/discounts/index.tpl.html";
?>