<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:28:21
         compiled from order/order.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'order/order.tpl.html', 36, false),)), $this); ?>
<script language="JavaScript" type="text/javascript"><!--
<?php echo '
function validateForm() {
    if (hasEmptyFields(\'surname firstname email cnt_phone city street number\', false, \'Заполните, пожалуйста, форму\'))
        return false;
    return true;
}
'; ?>

//-->
</script>
<h1>Оформление заказа</h1>
<p>Обратите, пожалуйста, внимание - поля, помеченные звездочкой (<span class="red">*</span>) должны быть обязательно заполнены!</p>
<form action="/order/index.php?mode=send_order" method="post" onSubmit="return validateForm();">
<input type="hidden" name="products_ser" value='<?php echo $this->_tpl_vars['products_ser']; ?>
'>
  	<table width="400"  border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
			<td width="50%" class="tableHeaderLeft">Фамилия<span class="red">*</span>:</td>
			<td><input type="text" name="surname" class="field" id="surname" value="<?php echo $this->_tpl_vars['surname']; ?>
" style="width:200px" /><?php if (isset ( $this->_tpl_vars['empty']['surname'] )): ?><span style="color:red;">*</span><?php endif; ?></td></tr>
        <tr>
        	<td class="tableHeaderLeft">Имя<span class="red">*</span>:</td>
  			<td><input type="text" name="firstname" class="field" id="firstname" value="<?php echo $this->_tpl_vars['firstname']; ?>
" style="width:200px"/><?php if (isset ( $this->_tpl_vars['empty']['firstname'] )): ?><span style="color:red;">*</span><?php endif; ?></td></tr>
 		<tr>
        	<td class="tableHeaderLeft">Отчество:</td>
  			<td><input type="text" name="lastname" class="field" id="name" value="<?php echo $this->_tpl_vars['lastname']; ?>
" style="width:200px"/></td></tr>
 		<tr>
 			<td class="tableHeaderLeft">Контактный е-mail<span class="red">*</span>:</td>
 			<td><input type="text" name="email" class="field" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
" style="width:200px"/><?php if (isset ( $this->_tpl_vars['empty']['email'] )): ?><span style="color:red;">*</span><?php endif; ?></td></tr>
		<tr>
			<td class="tableHeaderLeft">Контактный телефон<span class="red">*</span>:</td>
			<td><input type="text" name="phone" id="cnt_phone" class="field" value="<?php echo $this->_tpl_vars['phone']; ?>
" style="width:200px"/><?php if (isset ( $this->_tpl_vars['empty']['phone'] )): ?><span style="color:red;">*</span><?php endif; ?></td></tr>

 		<tr><td colspan="2" class="tableHeader" align="center"><strong>Точный адрес доставки</strong></td></tr>

 		<tr>
 			<td class="tableHeaderLeft">Город<span class="red">*</span>:</td>
 			<td><input type="text" name="city" id="city" class="field" style="width:200px" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['city'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Киев') : smarty_modifier_default($_tmp, 'Киев')); ?>
"></td>
 		</tr>
 		<tr>
 			<td class="tableHeaderLeft">Улица<span class="red">*</span>:</td>
 			<td><input type="text" name="street" class="field" id="street" value="<?php echo $this->_tpl_vars['street']; ?>
" style="width:200px" /><?php if (isset ( $this->_tpl_vars['empty']['street'] )): ?><span style="color:red;">*</span><?php endif; ?></td></tr>
 		<tr>
 			<td class="tableHeaderLeft">Дом<span class="red">*</span>:</td>
 			<td><input type="text" name="number" class="field" id="number" value="<?php echo $this->_tpl_vars['number']; ?>
" style="width:200px" /><?php if (isset ( $this->_tpl_vars['empty']['number'] )): ?><span style="color:red;">*</span><?php endif; ?></td></tr>
 		<tr>
 			<td class="tableHeaderLeft">Квартира (офис):</td>
 			<td><input type="text" name="office" class="field" id="office" value="<?php echo $this->_tpl_vars['office']; ?>
" style="width:200px" /></td></tr>
 		<tr>
 			<td class="tableHeaderLeft">Подъезд:</td>
 			<td><input type="text" name="entrance" class="field" id="entrance" value="<?php echo $this->_tpl_vars['entrance']; ?>
" style="width:200px" /></td></tr>
 		<tr>
 			<td class="tableHeaderLeft">Код на дверях:</td>
 			<td><input type="text" name="code" class="field" id="code" value="<?php echo $this->_tpl_vars['code']; ?>
" style="width:200px" /></td></tr>
 		<tr>
 			<td class="tableHeaderLeft">Этаж:</td>
 			<td><input type="text" name="floor" class="field" id="floor" value="<?php echo $this->_tpl_vars['floor']; ?>
" style="width:200px" /></td></tr>
 		<tr>
 			<td valign="top" class="tableHeaderLeft">Дополнительная информация и Ваши пожелания:</td>
 			<td><textarea name="comment" id="comment" rows="4"  class="field" style="width:200px"><?php echo $this->_tpl_vars['comment']; ?>
</textarea></td></tr>

 		<tr>
 			<td>&nbsp;</td>
 			<td align="left">
 				<input type="submit" value="Заказать" >
 				&nbsp;&nbsp;
 				<input type="button" value="Отмена" onclick="location.href='/order/'" />
 			</td>
 		</tr>
</table>
</form>