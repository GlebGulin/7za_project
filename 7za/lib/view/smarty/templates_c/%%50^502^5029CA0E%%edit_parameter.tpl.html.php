<?php /* Smarty version 2.6.5-dev, created on 2016-10-06 14:25:09
         compiled from admin/products/edit_parameter.tpl.html */ ?>
<h1>Редактирование параметра "<?php echo $this->_tpl_vars['parameter']['parameter_name']; ?>
"</h1>

<form action="parameters.php?mode=save_parameter&parameter_id=<?php echo $this->_tpl_vars['parameter']['parameter_id']; ?>
" method="POST" enctype="multipart/form-data" onSubmit="if (hasEmptyFields('parameter_name', false, 'Заполните форму, пожалуйста.')) return false;">
<table width="100%" border="0" cellpadding="3" cellspacing="1" align="center">

 <tr>
  <td class="tableHeaderLeft">Название параметра:</td>
  <td class="tableRow1"><input type="text" name="parameter_name" class="input" value="<?php echo $this->_tpl_vars['parameter']['parameter_name']; ?>
" id="parameter_name" /></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Единица измерения:</td>
  <td class="tableRow1"><input type="text" name="unit" class="input" value="<?php echo $this->_tpl_vars['parameter']['unit']; ?>
" id="unit" /></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Отображать как заголовок:</td>
  <td class="tableRow1"><input type="checkbox" name="is_header" <?php if ($this->_tpl_vars['parameter']['is_header']): ?>checked<?php endif; ?> value="1" id="is_header" /></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Использовать в поиске:</td>
  <td class="tableRow1"><input type="checkbox" name="use_in_search" <?php if ($this->_tpl_vars['parameter']['use_in_search']): ?>checked<?php endif; ?> value="1" id="use_in_search" /></td>
 </tr>

 <tr>
  <td>&nbsp;</td>
  <td>
    <input type="submit" class="button" value="Сохранить">&nbsp;
    <input type="button" onClick="location.href='parameters.php?mode=edit_group&group_id=<?php echo $this->_tpl_vars['parameter']['group_id']; ?>
'; return false;" class="button" value="Отмена">
   </td>
 </tr>
</table>
</form>