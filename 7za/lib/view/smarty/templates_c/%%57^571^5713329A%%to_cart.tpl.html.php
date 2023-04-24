<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:12:05
         compiled from products/to_cart.tpl.html */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
count.js" language="javascript"></script>
<form action="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
products/index.php" method="GET">
	<input type="hidden" name="mode" value="add_to_cart" />
	<input type="hidden" name="product_id" value="<?php echo $this->_tpl_vars['product']['product_id']; ?>
" />
<div class="qnt_block">
<table border="0" cellspacing="0" cellpadding="0" id="stepper">
  <tr>
	<td rowspan="2" id="pa0"><input type="text" class="count" name="product_qnt" id="product_qnt" value="1" /></td>
	<td valign="bottom"><img alt="Увеличить количество" src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
top.gif"></td>
  </tr>
  <tr>
	<td valign="top"><img alt="Уменьшить количество" src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
down.gif"></td>
  </tr>
</table></div>&nbsp;шт.&nbsp;<button onclick="submit();">В корзину</button>
</form>
<script type="text/javascript">
initStepper();
</script>