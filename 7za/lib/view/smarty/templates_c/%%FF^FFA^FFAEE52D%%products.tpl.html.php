<?php /* Smarty version 2.6.5-dev, created on 2016-09-26 15:04:41
         compiled from admin/products/products.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'admin/products/products.tpl.html', 21, false),array('function', 'mm_image', 'admin/products/products.tpl.html', 34, false),array('function', 'cycle', 'admin/products/products.tpl.html', 71, false),)), $this); ?>
<h3>Продукты подкатегории "<?php echo $this->_tpl_vars['subcategory']['subcategory_name']; ?>
"</h3>
<p><a href="index.php">Все категории</a> -&gt; <a href="index.php?mode=subcategories&cat_id=<?php echo $this->_tpl_vars['subcategory']['category_id']; ?>
"><?php echo $this->_tpl_vars['category']['category_name']; ?>
</a> -&gt; <?php echo $this->_tpl_vars['subcategory']['subcategory_name']; ?>
 </p>
<script type="text/javascript">
<?php echo '
function hide() {
	if (document.getElementById(\'mode\').value == \'moveto_category\') {
		document.getElementById(\'move_category\').style.display=\'inline\'
	} else {
		document.getElementById(\'move_category\').style.display=\'none\'
	}
}
'; ?>

</script>
<form action="index.php?mode=save_subcategory&subcat_id=<?php echo $this->_tpl_vars['subcategory']['subcategory_id']; ?>
" enctype="multipart/form-data" method="POST" onSubmit="if (hasEmptyFields('subcategory_name', false, 'Заполните форму, пожалуйста')) return false;">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td colspan="2" class="tableHeader">Редактирование подкатегории</td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">Название подкатегории</td>
  <td class="tableRow1"><input type="text" name="subcategory_name" id="subcategory_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['subcategory']['subcategory_name'])) ? $this->_run_mod_handler('replace', true, $_tmp, '"', "&quot;") : smarty_modifier_replace($_tmp, '"', "&quot;")); ?>
" class="input"></td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">Группа параметров</td>
  <td><select name="group_id" class="input">
  <option value="0"></option>
  <?php if (count($_from = (array)$this->_tpl_vars['groups'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
  <option value="<?php echo $this->_tpl_vars['item']['group_id']; ?>
"<?php if ($this->_tpl_vars['item']['group_id'] == $this->_tpl_vars['subcategory']['group_id']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['group_name']; ?>
</option>
  <?php endforeach; unset($_from); endif; ?>
  </select></td>
 </tr>
 <tr>
  <td class="tableHeaderLeft" rowspan="2">Картинка подкатегории</td>
  <td class="tableRow1"><?php echo smarty_function_mm_image(array('file_id' => $this->_tpl_vars['subcategory']['image_file_id']), $this);?>
</td>
 </tr>
 <tr>
  <td class="tableRow1"><input type="file" name="image_file" class="input"></td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">Выделить</td>
  <td class="tableRow1"><input type="checkbox" name="marked" id="marked" value="1"<?php if ($this->_tpl_vars['subcategory']['marked']): ?> checked<?php endif; ?>></td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">Скрыть</td>
  <td class="tableRow1"><input type="checkbox" name="hidden" id="hidden" value="1"<?php if ($this->_tpl_vars['subcategory']['hidden']): ?> checked<?php endif; ?>></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td><input type="submit" value="Сохранить" class="button"></td>
 </tr>
</table>
</form>

<form action="index.php?subcat_id=<?php echo $this->_tpl_vars['subcategory']['subcategory_id']; ?>
" method="POST">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
 	<td colspan="9" align="right"><a href="index.php?mode=add_product&subcat_id=<?php echo $this->_tpl_vars['subcategory']['subcategory_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/add.gif" border="0" align="absmiddle">&nbsp;Добавить продукт</a></td>
 </tr>
 <tr>
  <td class="tableHeader">ID</td>
  <td class="tableHeader" width="20">&nbsp;</td>
  <td class="tableHeader">Название продукта</td>
  <td class="tableHeader">Цена</td>
  <td class="tableHeader" width="120">Добавлен</td>
  <td class="tableHeader">Показывать</td>
  <td class="tableHeader">В наличии</td>
  <td class="tableHeader" width="70">Позиция</td>
  <td class="tableHeader" width="90">&nbsp;</td>
 </tr>
 <?php if (isset($this->_foreach['products'])) unset($this->_foreach['products']);
$this->_foreach['products']['total'] = count($_from = (array)$this->_tpl_vars['products']);
$this->_foreach['products']['show'] = $this->_foreach['products']['total'] > 0;
if ($this->_foreach['products']['show']):
$this->_foreach['products']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['products']['iteration']++;
        $this->_foreach['products']['first'] = ($this->_foreach['products']['iteration'] == 1);
        $this->_foreach['products']['last']  = ($this->_foreach['products']['iteration'] == $this->_foreach['products']['total']);
?>
 <tr class="tableRow<?php echo smarty_function_cycle(array('values' => "1,2"), $this);?>
">
  <td align="center"><?php echo $this->_tpl_vars['item']['product_id']; ?>
</td>
  <td align="center"><input type="checkbox" name="selected[]" value="<?php echo $this->_tpl_vars['item']['product_id']; ?>
"></td>
  <td align="center"><?php if ($this->_tpl_vars['item']['linked_to_product']): ?><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/ref.gif" border="0" align="absmiddle">&nbsp;<?php endif; ?><a href="index.php?mode=edit_product&product_id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
"><?php echo $this->_tpl_vars['item']['product_name']; ?>
</a></td>
  <td align="center"><?php echo $this->_tpl_vars['item']['price']; ?>
</td>
  <td align="center"><?php echo $this->_tpl_vars['item']['added_time']; ?>
</td>
  <td align="center"><?php if ($this->_tpl_vars['item']['shown'] == 1): ?>да<?php else: ?>нет<?php endif; ?></td>
  <td align="center"><?php if ($this->_tpl_vars['item']['absent'] == 1): ?>нет<?php else: ?>есть<?php endif; ?></td>
  <td align="center">
   <a href="index.php?mode=move_product_up&product_id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/up.gif" border="0" alt="Вверх"></a>&nbsp;
   <a href="index.php?mode=move_product_down&product_id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/down.gif" border="0" alt="Вниз"></a>
  </td>
  <td align="center">
   <a href="index.php?mode=edit_product&product_id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/edit.gif" border="0" align="absmiddle" alt="Редактировать"></a>&nbsp;
   <a href="index.php?mode=hide_product&product_id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/show.gif" border="0" align="absmiddle" alt="Скрыть/показать"></a>&nbsp;
   <a href="#" onClick="if (confirm('Вы действительно хотите удалить этот продукт?\n<?php echo $this->_tpl_vars['item']['product_name']; ?>
')) location.href='index.php?mode=delete_product&product_id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
';"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" align="absmiddle" alt="Удалить"></a>
  </td>
 </tr>
 <?php endforeach; unset($_from); else: ?>
 <tr>
  <td align="center" colspan="9">Нет продуктов в этой подкатегории</td>
 </tr>
 <?php endif; ?>
</table>
<?php if ($this->_tpl_vars['products']): ?>
<div style="padding-top: 10px;">
С отмеченными: <select name="mode" id ="mode" class="input" onchange="hide()">
<option value="">Выберите операцию</option>
<option value="hide_selected">Скрыть</option>
<option value="show_selected">Показать</option>
<option value="absent_selected">Нет в наличии</option>
<option value="present_selected">Есть в наличии</option>
<option value="moveto_category">Переместить в категорию</option>
</select>
<select name="move_category" id ="move_category" class="input" style="display:none">
<option value="0">Выберите категорию</option>
<?php if (count($_from = (array)$this->_tpl_vars['all_categories'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<option value="0"><?php echo $this->_tpl_vars['item']['category_name']; ?>
</option>
<?php if ($this->_tpl_vars['item']['subcategories']): ?>
<?php if (count($_from = (array)$this->_tpl_vars['item']['subcategories'])):
    foreach ($_from as $this->_tpl_vars['item1']):
?>
<option value="<?php echo $this->_tpl_vars['item1']['subcategory_id']; ?>
">-<?php echo $this->_tpl_vars['item1']['subcategory_name']; ?>
</option>
<?php endforeach; unset($_from); endif; ?>
<?php endif; ?>
<?php endforeach; unset($_from); endif; ?>
</select>
<input type="submit" value="Выполнить операцию" class="button">
</div>
<?php endif; ?>
</form>