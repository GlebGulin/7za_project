<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:06:35
         compiled from admin/orders/edit_order.tpl.html */ ?>
 <h3>Просмотр заказа </h3>
 
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/orders/order.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 
 <br />
 <form action="index.php?mode=next_status&id=<?php echo $this->_tpl_vars['order']['order_id']; ?>
" method="post">  	
 	<div align="center">
				<?php if ($this->_tpl_vars['order']['status_id'] == 1): ?><input type="submit" value="Принять заказ"><?php endif; ?>
				<?php if ($this->_tpl_vars['order']['status_id'] == 1): ?>&nbsp;&nbsp;<input type="button" value="Удалить" onclick="location.href='index.php?mode=delete&id=<?php echo $this->_tpl_vars['order']['order_id']; ?>
'" ><?php endif; ?>
				<?php if ($this->_tpl_vars['order']['status_id'] == 2): ?><input type="submit" value="Доставлен"><?php endif; ?>
 				&nbsp;&nbsp;
 				<input type="button" value="Отмена" onclick="location.href='index.php'" />
 	</div> 			
 </form>