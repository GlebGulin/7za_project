<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:30:01
         compiled from mails/order_to_user.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'price_format', 'mails/order_to_user.tpl.html', 24, false),)), $this); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body>
На ваш e-mail адрес выполнен заказ на сайте <?php echo $_SERVER['HTTP_HOST']; ?>
<br />

<br />
Заказ:
<table border="1" cellspacing="0" cellpadding="2">
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

<p>Благодарим за покупку в магазине "7za".</p>
<p>--<br />
Администрация интернет-магазина 7ZA.COM.UA<br />
<a href="http://www.7za.com.ua">www.7za.com.ua</a><br />
(044) 353 77 35</p>
</body>
</html>