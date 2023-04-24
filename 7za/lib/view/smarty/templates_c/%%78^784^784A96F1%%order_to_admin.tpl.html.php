<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:30:01
         compiled from mails/order_to_admin.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'mails/order_to_admin.tpl.html', 29, false),array('modifier', 'price_format', 'mails/order_to_admin.tpl.html', 103, false),)), $this); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body>
<?php echo '
<style type="text/css">

.tableHeaderLeft{
	width:25%;
	text-align:right;
}

.tableRow1{
	width:30%;
	text-align:left;
}

</style>
'; ?>


Информация о покупателе:

	<table width="70%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td class="tableHeaderLeft">ID:</td>
			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['order_id']; ?>
</td>
 			<td class="tableHeaderLeft">Дата и время:</td>
 			<td class="tableRow1">&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['order']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %H:%M") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %H:%M")); ?>
</td>
		</tr>
		<tr>
			<td class="tableHeaderLeft">Фамилия:</td>
			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['surname']; ?>
</td>
 			<td class="tableHeaderLeft">Контактный е-mail:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['email']; ?>
</td>
		</tr>
		<tr>
        	<td class="tableHeaderLeft">Имя:</td>
  			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['firstname']; ?>
</td>
			<td class="tableHeaderLeft">Контактный телефон:</td>
			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['phone']; ?>
</td>
  		</tr>
  		<tr>
        	<td class="tableHeaderLeft">Отчество:</td>
  			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['lastname']; ?>
</td>
 			<td class="tableHeaderLeft">&nbsp;</td>
 			<td class="tableRow1">&nbsp;</td>
 		</tr>
 		<tr>
 			<td colspan="4" align="center"><strong>Точный адрес доставки</strong></td>
 		</tr>
 		<tr>
 			<td class="tableHeaderLeft">Город:</td>
 			<td class="tableRow1" colspan="3">&nbsp;<?php echo $this->_tpl_vars['order']['city_name']; ?>
</td>
 		</tr>
 		<tr>
 			<td class="tableHeaderLeft">Улица:</td>
 			<td class="tableRow1" colspan="3">&nbsp;<?php echo $this->_tpl_vars['order']['street']; ?>
</td>
 		</tr>
 		<tr>
 			<td class="tableHeaderLeft">Дом:</td>
 			<td class="tableRow1" colspan="3">&nbsp;<?php echo $this->_tpl_vars['order']['number']; ?>
</td>
 		</tr>
 		<tr>
 			<td class="tableHeaderLeft">Подъезд:</td>
 			<td class="tableRow1" colspan="3">&nbsp;<?php echo $this->_tpl_vars['order']['entrance']; ?>
</td>
 		</tr>
 		<tr>
	 		<td class="tableHeaderLeft">Код:</td>
 			<td class="tableRow1" colspan="3">&nbsp;<?php echo $this->_tpl_vars['order']['code']; ?>
</td>
 		</tr>
 		<tr>
 			<td class="tableHeaderLeft">Этаж:</td>
 			<td class="tableRow1" colspan="3">&nbsp;<?php echo $this->_tpl_vars['order']['floor']; ?>
</td>
 		</tr>
 		<tr>
 			<td class="tableHeaderLeft">Квартира (офис):</td>
 			<td class="tableRow1" colspan="3">&nbsp;<?php echo $this->_tpl_vars['order']['office']; ?>
</td>
 		</tr>
 		<tr>
 			<td class="tableHeaderLeft">Дополнительная информация:</td>
 			<td class="tableRow1" colspan="3">&nbsp;<?php echo $this->_tpl_vars['order']['comment']; ?>
</td>
 		</tr>

 	</table>

 <br />
Заказ:
<table border="1" cellspacing="0" cellpadding="2" width="70%">
 <tr>
  <th>№</th>
  <th>ID</th>
  <th>Название продукта</th>
  <th>Цена</th>
  <th>Количество</th>
  <th>Сумма</th>
 </tr>
<?php if (isset($this->_foreach['order'])) unset($this->_foreach['order']);
$this->_foreach['order']['total'] = count($_from = (array)$this->_tpl_vars['order']['items']);
$this->_foreach['order']['show'] = $this->_foreach['order']['total'] > 0;
if ($this->_foreach['order']['show']):
$this->_foreach['order']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['item']):
        $this->_foreach['order']['iteration']++;
        $this->_foreach['order']['first'] = ($this->_foreach['order']['iteration'] == 1);
        $this->_foreach['order']['last']  = ($this->_foreach['order']['iteration'] == $this->_foreach['order']['total']);
?>
 <tr>
  <td align="center"><?php echo $this->_foreach['order']['iteration']; ?>
</td>
  <td align="center"><?php echo $this->_tpl_vars['item']['product_id']; ?>
</td>
  <td align="left"><?php echo $this->_tpl_vars['item']['product']['product_name']; ?>
</td>
  <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_price'])) ? $this->_run_mod_handler('price_format', true, $_tmp, ' грн') : smarty_modifier_price_format($_tmp, ' грн')); ?>
</td>
  <td align="center"><?php echo $this->_tpl_vars['item']['product_qnt']; ?>
</td>
  <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_summ'])) ? $this->_run_mod_handler('price_format', true, $_tmp, ' грн') : smarty_modifier_price_format($_tmp, ' грн')); ?>
</td>
 </tr>
<?php endforeach; unset($_from); endif; ?>
 <tr>
  <td colspan="4" align="right">Доставка:</td>
  <td>&nbsp;</td>
  <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['order']['order_delivery'])) ? $this->_run_mod_handler('price_format', true, $_tmp, ' грн') : smarty_modifier_price_format($_tmp, ' грн')); ?>
</td>
 </tr>

 <tr>
  <td colspan="4" align="right">Всего:</td>
  <td align="center">&nbsp;</td>
  <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['order']['order_common_summ'])) ? $this->_run_mod_handler('price_format', true, $_tmp, ' грн') : smarty_modifier_price_format($_tmp, ' грн')); ?>
</td>
 </tr>

</table>
</body>
</html>