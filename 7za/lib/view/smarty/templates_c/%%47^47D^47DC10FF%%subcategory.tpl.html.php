<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:14:02
         compiled from products/subcategory.tpl.html */ ?>
<h1><a href="/cat/<?php echo $this->_tpl_vars['category']['category_id']; ?>
/"><?php echo $this->_tpl_vars['category']['category_name']; ?>
</a>: <?php echo $this->_tpl_vars['subcategory']['subcategory_name']; ?>
</h1>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "products/sortby.tpl.html", 'smarty_include_vars' => array('url' => "/subcat/".($this->_tpl_vars['subcategory_id'])."/")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "products/products.tpl.html", 'smarty_include_vars' => array('products' => $this->_tpl_vars['products'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

