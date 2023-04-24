<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:06:35
         compiled from admin/orders/order.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin/orders/order.tpl.html', 7, false),array('modifier', 'price_format', 'admin/orders/order.tpl.html', 120, false),array('function', 'cycle', 'admin/orders/order.tpl.html', 116, false),)), $this); ?>
	<table width="90%"  border="0" align="center" cellpadding="3" cellspacing="1">
  		<tr><td colspan="4" align="center">Для физических и юридических лиц</td></tr>
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
 			<td class="tableHeaderLeft">Факс:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['fax']; ?>
</td>  			
 		</tr>
 		<tr>
 			<td colspan="4" align="center">Точный адрес доставки</td>
 		</tr>  
 		<tr>
 			<td class="tableHeaderLeft">Индекс:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['ind']; ?>
</td>
 			<td class="tableHeaderLeft">Дом:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['number']; ?>
</td> 			 			
 		</tr>  	
 		<tr>
 			<td class="tableHeaderLeft">Регион:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['region']; ?>
</td>
 			<td class="tableHeaderLeft">Корпус:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['building']; ?>
</td> 	 			
 		</tr>  	
 		<tr>
 			<td class="tableHeaderLeft">Район:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['district']; ?>
</td>
 			<td class="tableHeaderLeft">Квартира (офис):</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['office']; ?>
</td> 			
 		</tr>  	
 		<tr>
 			<td class="tableHeaderLeft">Город:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['city_name']; ?>
</td> 	 		
 			<td class="tableHeaderLeft">Подъезд:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['entrance']; ?>
</td> 	
 		</tr>   				
 		<tr>
 			<td class="tableHeaderLeft">Улица:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['street']; ?>
</td> 					 		
	 		<td class="tableHeaderLeft">Код:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['code']; ?>
</td> 
 		</tr>  
 		<tr>
 			<td class="tableHeaderLeft">Дополнительная информация:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['comment']; ?>
</td>
 			<td class="tableHeaderLeft">Этаж:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['floor']; ?>
</td> 			
 		</tr>   
 		
		<tr>
 			<td colspan="4" align="center">Для юридических лиц</td>
 		</tr>  
 		
 		<tr>
 			<td class="tableHeaderLeft">Компания:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['company']; ?>
</td>
 			<td class="tableHeaderLeft">ОКПО:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['okpo']; ?>
</td> 			 			
 		</tr>  	
 		<tr>
 			<td class="tableHeaderLeft">Юридический адрес:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['legal_address']; ?>
</td>
 			<td class="tableHeaderLeft">Наименование банка:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['bank_name']; ?>
</td> 	 			
 		</tr>  	
 		<tr>
 			<td class="tableHeaderLeft">фактический адрес(почтовый):</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['postal_address']; ?>
</td>
 			<td class="tableHeaderLeft">Pасчетный счет:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['settl_account']; ?>
</td> 			
 		</tr>  	
 		<tr>
 			<td class="tableHeaderLeft">ИНН:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['inn']; ?>
</td> 	 		
 			<td class="tableHeaderLeft">Кор. счет:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['corr_account']; ?>
</td> 	
 		</tr>   				
 		<tr>
 			<td class="tableHeaderLeft">КПП:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['kpp']; ?>
</td> 					 		
	 		<td class="tableHeaderLeft">БИК:</td>
 			<td class="tableRow1">&nbsp;<?php echo $this->_tpl_vars['order']['bik']; ?>
</td> 
 		</tr>  
 		 		
 	</table>
 	
 	<br /><br />
 	
<table width="90%"  border="0" align="center" cellpadding="3" cellspacing="1">
 <tr class="tableHeader">
  <td>№</td>
  <td>ID</td>
  <td>Название продукта</td>
  <td>Цена</td>
  <td>Количество</td>
  <td>Сумма</td>
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
 <tr class="tableRow<?php echo smarty_function_cycle(array('values' => "1,2"), $this);?>
">
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
  <td colspan="4" align="right">Всего:</td>
  <td align="center"><?php echo $this->_tpl_vars['order']['order_qnt']; ?>
</td>
  <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['order']['order_summ'])) ? $this->_run_mod_handler('price_format', true, $_tmp, ' грн') : smarty_modifier_price_format($_tmp, ' грн')); ?>
</td>
 </tr>
</table>