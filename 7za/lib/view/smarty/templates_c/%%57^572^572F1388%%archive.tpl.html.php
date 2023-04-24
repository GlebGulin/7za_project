<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:07:13
         compiled from admin/orders/archive.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin/orders/archive.tpl.html', 15, false),)), $this); ?>
<h3>Архив заказов</h3>
<div align="center"><?php echo $this->_tpl_vars['splitMenuCode']; ?>
</a></div><br />
<table width="95%" border="0" cellpadding="3" cellspacing="1" align="center">
 <tr>
  <td class="tableHeader">ID</td>
  <td class="tableHeader">ФИО</td>
  <td class="tableHeader">Дата и время</td>
  <td class="tableHeader">Сумма заказа</td>
  <td class="tableHeader">Статус</td>  
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
  <td align="center"><a href="archive.php?mode=view_order&id=<?php echo $this->_tpl_vars['item']['order_id']; ?>
&smIndex=<?php echo $this->_tpl_vars['smIndex']; ?>
"><?php echo $this->_tpl_vars['item']['surname']; ?>
 <?php echo $this->_tpl_vars['item']['firstname']; ?>
 <?php echo $this->_tpl_vars['item']['lastname']; ?>
</a></td>
  <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %H:%M") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %H:%M")); ?>
</td>
  <td align="center"><?php echo $this->_tpl_vars['item']['order_summ']; ?>
</td>  
  <td align="center"><?php echo $this->_tpl_vars['item']['status_name']; ?>
</td>
 </tr>
 <?php endforeach; unset($_from); endif; ?>
</table>
<br /><div align="center"><?php echo $this->_tpl_vars['splitMenuCode']; ?>
</a></div>