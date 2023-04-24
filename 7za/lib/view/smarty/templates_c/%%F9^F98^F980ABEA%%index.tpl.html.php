<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:06:17
         compiled from admin/orders/index.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin/orders/index.tpl.html', 16, false),array('modifier', 'price_format', 'admin/orders/index.tpl.html', 17, false),)), $this); ?>
<h3>Заказы</h3>

<table width="95%" border="0" cellpadding="3" cellspacing="1" align="center">
 <tr>
  <td class="tableHeader">ID</td>
  <td class="tableHeader">ФИО</td>
  <td class="tableHeader">Дата и время</td>
  <td class="tableHeader">Сумма заказа, грн</td>
  <td class="tableHeader">Статус</td>  
  <td class="tableHeader"> &nbsp;</td>
 </tr>
 <?php if (isset($this->_foreach['orders'])) unset($this->_foreach['orders']);
$this->_foreach['orders']['total'] = count($_from = (array)$this->_tpl_vars['orders']);
$this->_foreach['orders']['show'] = $this->_foreach['orders']['total'] > 0;
if ($this->_foreach['orders']['show']):
$this->_foreach['orders']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['orders']['iteration']++;
        $this->_foreach['orders']['first'] = ($this->_foreach['orders']['iteration'] == 1);
        $this->_foreach['orders']['last']  = ($this->_foreach['orders']['iteration'] == $this->_foreach['orders']['total']);
?>
 <tr class="tableRow<?php if ((1 & $this->_foreach['orders']['iteration'])): ?>1<?php else: ?>2<?php endif; ?>">
  <td align="center"><?php echo $this->_tpl_vars['item']['order_id']; ?>
</td>
  <td align="center"><a href="index.php?mode=edit&id=<?php echo $this->_tpl_vars['item']['order_id']; ?>
"><?php echo $this->_tpl_vars['item']['surname']; ?>
 <?php echo $this->_tpl_vars['item']['firstname']; ?>
 <?php echo $this->_tpl_vars['item']['lastname']; ?>
</a></td>
  <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %H:%M") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %H:%M")); ?>
</td>
  <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['order_summ'])) ? $this->_run_mod_handler('price_format', true, $_tmp, "") : smarty_modifier_price_format($_tmp, "")); ?>
</td>  
  <td align="center"><a href="index.php?mode=next_status&id=<?php echo $this->_tpl_vars['item']['order_id']; ?>
"><?php echo $this->_tpl_vars['item']['status_name']; ?>
</a></td>
  <td align="center"><?php if ($this->_tpl_vars['item']['status_id'] == 1): ?><a href="#" onClick="if (confirm('Вы действительно хотите удалить этот заказ?\nID = <?php echo $this->_tpl_vars['item']['order_id']; ?>
')) location.href='index.php?mode=delete&id=<?php echo $this->_tpl_vars['item']['order_id']; ?>
';"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" align="absmiddle" alt="Удалить"></a><?php else: ?>&nbsp;<?php endif; ?></td>
 </tr>
 <?php endforeach; unset($_from); endif; ?>
</table>