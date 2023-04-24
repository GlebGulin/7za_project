<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:16:32
         compiled from home.tpl.html */ ?>
<h1>Популярные товары</h1>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "products/products.tpl.html", 'smarty_include_vars' => array('products' => $this->_tpl_vars['products'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div style="text-align:right"><a href="/leaders/">весь список</a></div>
<h1>Новые поступления</h1>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "products/products.tpl.html", 'smarty_include_vars' => array('products' => $this->_tpl_vars['new_products'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div style="text-align:right"><a href="/new/">весь список</a></div>
<?php if ($this->_tpl_vars['recommended']): ?>
<h1>Мы рекомендуем</h1>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "products/products.tpl.html", 'smarty_include_vars' => array('products' => $this->_tpl_vars['recommended'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div style="text-align:right"><a href="/recommended/">весь список</a></div>
<?php endif; ?>
<?php if ($this->_tpl_vars['sales']): ?>
<h1>Специальные предложения</h1>
<div style="text-align:right"><a href="/sales/">весь список</a></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "products/products.tpl.html", 'smarty_include_vars' => array('products' => $this->_tpl_vars['sales'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>