<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:07:49
         compiled from admin/products/edit_product.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'admin/products/edit_product.tpl.html', 17, false),array('modifier', 'count', 'admin/products/edit_product.tpl.html', 64, false),array('function', 'mm_image_preview', 'admin/products/edit_product.tpl.html', 48, false),array('function', 'html_select_date', 'admin/products/edit_product.tpl.html', 119, false),)), $this); ?>
<h3>Редактирование продукта "<?php echo $this->_tpl_vars['product']['product_name']; ?>
"</h3>
<p><a href="index.php">Все категории</a> -&gt;
    <a href="index.php?mode=subcategories&cat_id=<?php echo $this->_tpl_vars['subcategory']['category_id']; ?>
"><?php echo $this->_tpl_vars['category']['category_name']; ?>
</a> -&gt;
      <a href="?mode=products&subcat_id=<?php echo $this->_tpl_vars['subcategory']['subcategory_id']; ?>
"><?php echo $this->_tpl_vars['subcategory']['subcategory_name']; ?>
</a> </p>
<form action="index.php?mode=save_product&product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
" method="POST" onSubmit="if (hasEmptyFields('link_to_product', false, 'Заполните форму, пожалуйста')) return false;">
<script type="text/javascript">
<?php echo '
function selectProducts(value,field)
{
    document.getElementById(field).value = value;
}
'; ?>

</script>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeaderLeft">Вставить копию продукта</td>
  <td class="tableRow1"><input type="text" name="linked_to_product" class="input" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['product']['linked_to_product'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
" id="linked_to_product">
  <a onClick="var win = window.open('about:blank', 'selector', 'menubar=no,scrollbars=yes,toolbar=no,directiories=no,status=no,location=no,width=600,height=500,left='+((screen.width-600)/2)+',top='+((screen.height-500)/2)); win.focus();" href="/admin/products/selector.php?field=linked_to_product" target="selector">Выбрать продукт</a>
  <input type="hidden" name="shown" value="1">
  <input type="submit" value="Сохранить" class="button">
  <input type="button" onClick="location.href='index.php?mode=products&subcat_id=<?php echo $this->_tpl_vars['product']['subcategory_id']; ?>
'; return false;" class="button" value="Отмена">
  </td>
 </tr>
</table>
</form>

<?php if ($this->_tpl_vars['product']['linked_to_product'] == 0): ?>
<form action="index.php?mode=save_product&product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
" method="POST" enctype="multipart/form-data" onSubmit="if (hasEmptyFields('product_name', false, 'Заполните форму, пожалуйста')) return false;">
<table width="100%" border="0" cellpadding="3" cellspacing="1">

 <tr>
  <td class="tableHeaderLeft">Название продукта</td>
  <td class="tableRow1"><input type="text" name="product_name" class="input" value="<?php echo $this->_tpl_vars['product']['product_name']; ?>
" id="product_name" style="width:100%;"></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Описание продукта</td>
  <td class="tableRow1"><?php echo $this->_tpl_vars['editor_code']; ?>
</td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Стоимость</td>
  <td class="tableRow1"><input type="text" name="price" class="input" value="<?php echo $this->_tpl_vars['product']['price']; ?>
"></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Картинка</td>
  <td class="tableRow1"><?php echo smarty_function_mm_image_preview(array('file_id' => $this->_tpl_vars['product']['image_file_id'],'delete_icon' => '1'), $this);?>
</td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">&nbsp;</td>
  <td class="tableRow1"><input type="file" name="img_file" class="input"></td>
 </tr>

 <tr><td class="tableRow2" colspan="2" align="center">Дополнительные фото</td></tr>
 <?php if (isset($this->_foreach['add_photos'])) unset($this->_foreach['add_photos']);
$this->_foreach['add_photos']['total'] = count($_from = (array)$this->_tpl_vars['product']['add_photos']);
$this->_foreach['add_photos']['show'] = $this->_foreach['add_photos']['total'] > 0;
if ($this->_foreach['add_photos']['show']):
$this->_foreach['add_photos']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['photo']):
        $this->_foreach['add_photos']['iteration']++;
        $this->_foreach['add_photos']['first'] = ($this->_foreach['add_photos']['iteration'] == 1);
        $this->_foreach['add_photos']['last']  = ($this->_foreach['add_photos']['iteration'] == $this->_foreach['add_photos']['total']);
?>
 <tr>
  <td class="tableHeaderLeft">Дополнительное фото:</td>
  <td class="tableRow1" valign="middle"><?php echo smarty_function_mm_image_preview(array('file_id' => $this->_tpl_vars['photo'],'delete_icon' => '1'), $this);?>
&nbsp;<a href="#" onClick="if (confirm('Вы действительно хотите удалить это фото?')) location.href='index.php?mode=delete_add_photo&product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
&photo_id=<?php echo $this->_tpl_vars['photo']; ?>
'"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" title="Удалить" alt="Удалить"></a></td>
 </tr>
 <?php endforeach; unset($_from); endif; ?>


 <?php if (count($this->_tpl_vars['product']['add_photos']) < 8): ?>
 <script language="JavaScript">
 <!--
 <?php echo '
 var numlines = 1;
 function addFile(btn) {
 	if (numlines>7-';  echo count($this->_tpl_vars['product']['add_photos']);  echo ') return true;
    tr = btn;
    while (tr.tagName != \'TR\') tr = tr.parentNode;
    var newTr = tr.parentNode.insertBefore(tr.cloneNode(true),tr.nextSibling);
    var input = newTr.getElementsByTagName(\'INPUT\')[0];
    input.value = \'\';
    numlines++;
 }
 function delFile(btn) {
    if (numlines>1) {
        tr = btn;
        while (tr.tagName != \'TR\') tr = tr.parentNode;
        tr.parentNode.removeChild(tr);
        numlines--;
    } else alert(\'Нельзя удалить последнюю строку\');
 }
 '; ?>

 //-->
 </script>

 <tr>
  <td class="tableHeaderLeft">Добавить фото:</td>
  <td class="tableRow1">
  	<input type="file" name="add_photos[]" class="input">&nbsp;&nbsp;
  	<a onClick="if (document.getElementById) delFile(this)" title="Удалить эту строку" href="javascript:void(0);">
  	<img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" alt="Удалить эту строку" align="absmiddle"></a>&nbsp;
  	<a onClick="if (document.getElementById) addFile(this)" title="Добавить еще одну строку" href="javascript:void(0);">
  	<img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/add.gif" border="0" alt="Добавить еще одну строку" align="absmiddle"></a>
  </td>
 </tr>
 <?php endif; ?>

 <tr>
  <td class="tableHeaderLeft">Связанные товары</td>
  <td class="tableRow1"><input type="text" name="conn_goods" id="conn_goods" value="<?php echo $this->_tpl_vars['product']['conn_goods']; ?>
" class="input"> <button onClick="var win = window.open('/admin/products/selector.php?mode=multiple&field=conn_goods&selected=<?php echo $this->_tpl_vars['product']['conn_goods']; ?>
', 'selector', 'menubar=no,scrollbars=yes,toolbar=no,directiories=no,status=no,location=no,width=600,height=500,left='+((screen.width-600)/2)+',top='+((screen.height-500)/2)); win.focus(); return false;" class="button">Выбрать</button> (ID товаров через запятую)</td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Просмотров</td>
  <td class="tableRow1"><input type="text" name="view" value="<?php echo $this->_tpl_vars['product']['view']; ?>
" class="input"></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Скидка, %</td>
  <td class="tableRow1"><input type="text" name="discount" value="<?php echo $this->_tpl_vars['product']['discount']; ?>
" class="input"></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Начало распродажи</td>
  <td class="tableRow1"><?php echo smarty_function_html_select_date(array('end_year' => "+1",'field_array' => 'discount_start_array','field_order' => 'DMY','time' => $this->_tpl_vars['product']['discount_start']), $this);?>
</td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Конец распродажи</td>
  <td class="tableRow1"><?php echo smarty_function_html_select_date(array('end_year' => "+1",'field_array' => 'discount_finish_array','field_order' => 'DMY','time' => $this->_tpl_vars['product']['discount_finish']), $this);?>
</td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Показывать продукт</td>
  <td class="tableRow1"><input type="checkbox" name="shown" value="1"<?php if ($this->_tpl_vars['product']['shown']): ?> checked<?php endif; ?>></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Товар ожидается</td>
  <td class="tableRow1"><input type="checkbox" name="absent" value="1"<?php if ($this->_tpl_vars['product']['absent']): ?> checked<?php endif; ?>></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Рекомендованный товар</td>
  <td class="tableRow1"><input type="checkbox" name="recommended" value="1"<?php if ($this->_tpl_vars['product']['recommended']): ?> checked<?php endif; ?>></td>
 </tr>

 <tr>
  <td class="tableHeaderLeft">Специальное предложение</td>
  <td class="tableRow1"><input type="checkbox" name="special_offer" value="1"<?php if ($this->_tpl_vars['product']['special_offer']): ?> checked<?php endif; ?>></td>
 </tr>

 <?php if (count($this->_tpl_vars['parameters'])): ?>
 <tr><td class="tableRow1" colspan="2" align="center"><strong>Параметры продукта</strong></td></tr>
 <?php if (isset($this->_foreach['parameters'])) unset($this->_foreach['parameters']);
$this->_foreach['parameters']['total'] = count($_from = (array)$this->_tpl_vars['parameters']);
$this->_foreach['parameters']['show'] = $this->_foreach['parameters']['total'] > 0;
if ($this->_foreach['parameters']['show']):
$this->_foreach['parameters']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['parameters']['iteration']++;
        $this->_foreach['parameters']['first'] = ($this->_foreach['parameters']['iteration'] == 1);
        $this->_foreach['parameters']['last']  = ($this->_foreach['parameters']['iteration'] == $this->_foreach['parameters']['total']);
?>
 <tr>
 <?php if ($this->_tpl_vars['item']['is_header']): ?>
  <td class="tableHeaderLeft" colspan="2"><?php echo $this->_tpl_vars['item']['parameter_name']; ?>
</td>
 <?php else: ?>
  <td class="tableHeaderLeft"><?php echo $this->_tpl_vars['item']['parameter_name'];  if ($this->_tpl_vars['item']['unit']): ?>, <?php echo $this->_tpl_vars['item']['unit'];  endif; ?></td>
  <td class="tableRow1"><input class="input" type="text" name="parameters[<?php echo $this->_tpl_vars['item']['parameter_id']; ?>
]" value="<?php echo $this->_tpl_vars['item']['value']; ?>
" /></td>
 <?php endif; ?>
 </tr>
 <?php endforeach; unset($_from); endif; ?>
 <?php endif; ?>

 <tr>
  <td>&nbsp;</td>
  <td><br><input type="submit" class="button" value="Сохранить">&nbsp; <input type="button" onClick="location.href='index.php?mode=products&subcat_id=<?php echo $this->_tpl_vars['product']['subcategory_id']; ?>
'; return false;" class="button" value="Отмена"></td>
 </tr>
</table>
</form>
<?php endif; ?>