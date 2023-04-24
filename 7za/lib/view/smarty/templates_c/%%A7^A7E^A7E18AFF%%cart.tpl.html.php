<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:10:29
         compiled from order/cart.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'order/cart.tpl.html', 3, false),array('function', 'mm_image_preview', 'order/cart.tpl.html', 69, false),)), $this); ?>
<h1>Корзина</h1>

<?php if (count($this->_tpl_vars['cart_list'])): ?>
 <script language="JavaScript" type="text/javascript" src="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
priceformat.js"></script>
 <script language="JavaScript" type="text/javascript"><!--
  <?php echo '

        product_count = ';  echo count($this->_tpl_vars['cart_list']);  echo ';
        cost_delivery = ';  echo $this->_tpl_vars['cost_delivery'];  echo ';
        cost_threshold = ';  echo $this->_tpl_vars['cost_threshold'];  echo ';

		function calculate_summ()
		{
			common_summ = 0;
			for(i=1;i<=product_count;i++)
			{
				count = document.getElementById(\'product_count_\'+i).value;
				price = document.getElementById(\'product_price_\'+i).innerHTML;
				common_summ = common_summ + count*price;
  			    document.getElementById(\'product_summ_\'+i).innerHTML = formatPrice(Math.round(count*price*100)/100);
			}
			summ = formatPrice(Math.round(common_summ*100)/100);
			if ( common_summ < cost_threshold )
			{
				document.getElementById(\'deliv\').innerHTML = formatPrice(cost_delivery);
				document.getElementById(\'comm_summ\').innerHTML = formatPrice(common_summ+cost_delivery);
			}
			else
			{
				document.getElementById(\'deliv\').innerHTML = formatPrice(0);
				document.getElementById(\'comm_summ\').innerHTML = formatPrice(common_summ);
			}
			//document.getElementById(\'summ\').innerHTML = summ;

			return true;
		}

		function check_numeral(m)
		{
			var strTable="01234567890";
			var strRet = "";
			var cTmp, nTmp;
			for(i=0;i<m.value.length; i++)
			{
				cTmp = m.value.charAt(i);
				nTmp = strTable.indexOf(cTmp);
				if (cTmp==\',\')cTmp=\'.\';
				if (nTmp >= 0) strRet += cTmp;
			}
			if (m.value != strRet) m.value = strRet;
		}
  '; ?>

 --></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
counts.js" language="javascript"></script>


<form action="/order/index.php?mode=show_order" method="post">
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1">
 <tr class="tableHeader">
  <th>Фото</th>
  <th>Название продукта</th>
  <th width="70">Количество</th>
  <th>Цена</th>
  <th>Сумма</th>
  <th>Удалить</th>
 </tr>
 <?php if (isset($this->_foreach['cart_list'])) unset($this->_foreach['cart_list']);
$this->_foreach['cart_list']['total'] = count($_from = (array)$this->_tpl_vars['cart_list']);
$this->_foreach['cart_list']['show'] = $this->_foreach['cart_list']['total'] > 0;
if ($this->_foreach['cart_list']['show']):
$this->_foreach['cart_list']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['cart_list']['iteration']++;
        $this->_foreach['cart_list']['first'] = ($this->_foreach['cart_list']['iteration'] == 1);
        $this->_foreach['cart_list']['last']  = ($this->_foreach['cart_list']['iteration'] == $this->_foreach['cart_list']['total']);
?>
 <tr align="center">
  <td align="center"><?php echo smarty_function_mm_image_preview(array('file_id' => $this->_tpl_vars['item']['image_file_id']), $this);?>
</td>
  <td><a href="/product/<?php echo $this->_tpl_vars['item']['product_id']; ?>
/"><?php echo $this->_tpl_vars['item']['product_name']; ?>
</a></td>
  <td>
  <table border="0" cellspacing="0" cellpadding="0" name="stepper" id="stepper">
	  <tr>
		<td rowspan="2"><input type="text" class="count" name="products[<?php echo $this->_tpl_vars['item']['product_id']; ?>
]" id="product_count_<?php echo $this->_foreach['cart_list']['iteration']; ?>
" value="<?php echo $this->_tpl_vars['item']['quantity']; ?>
" /></td>
		<td valign="bottom"><img alt="Увеличить количество" src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
top.gif"></td>
	  </tr>
	  <tr>
		<td valign="top"><img alt="Уменьшить количество" src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
down.gif"></td>
	  </tr>
	</table>
  </td>
  <td id="product_price_<?php echo $this->_foreach['cart_list']['iteration']; ?>
"><?php echo $this->_tpl_vars['item']['price']; ?>
</td>
  <td id="product_summ_<?php echo $this->_foreach['cart_list']['iteration']; ?>
">&nbsp;</td>
  <td align="center"><a href="#" onClick="if (confirm('Удалить товар из корзины?\n<?php echo $this->_tpl_vars['item']['product_name']; ?>
')) location.href='/order/index.php?mode=delete_from_cart&product_id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
';"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" align="absmiddle"></a></td>
 </tr>
 <?php endforeach; unset($_from); endif; ?>

 <!--
 <tr class="tableBody">
  <td colspan="5" align="right">Сумма, $:</td>
  <td align="center"><span id="summ">&nbsp;</span></td>
  <td>&nbsp;</td>
 </tr>
 -->

 <tr class="tableBody">
  <td colspan="5" align="right">Доставка, грн:</td>
  <td align="center"><span id="deliv">&nbsp;</span></td>
  <td>&nbsp;</td>
 </tr>

 <tr class="tableBody">
  <td colspan="5" align="right" class="red"><strong>Всего, грн.:</strong></td>
  <td align="center"><span id="comm_summ">&nbsp;</span></td>
  <td>&nbsp;</td>
 </tr>

</table>
<script type="text/javascript">
initSteppers();
</script>

<div align="center" style="padding-top: 15px;"><input type="submit" value="Оформить заказ"></div>
</form>

<?php echo '<script type="text/javascript">calculate_summ();</script>'; ?>


<?php else: ?>

 <p style="padding-left: 30px;">Ваша корзина пуста</p>

<?php endif; ?>