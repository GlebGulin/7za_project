<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:13:51
         compiled from admin/products/subcategories.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'admin/products/subcategories.tpl.html', 11, false),array('function', 'cycle', 'admin/products/subcategories.tpl.html', 29, false),)), $this); ?>
<h3>������������ ��������� "<?php echo $this->_tpl_vars['category']['category_name']; ?>
"</h3>
<p><a href="index.php">��� ���������</a> -&gt; <?php echo $this->_tpl_vars['category']['category_name']; ?>
</p>

<form action="index.php?mode=save_category&cat_id=<?php echo $this->_tpl_vars['category']['category_id']; ?>
" method="POST" onSubmit="if (hasEmptyFields('category_name', false, '��������� �����, ����������')) return false;">
<table border="0" width="100%" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeader" colspan="2">�������������� ���������</td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">�������� ���������</td>
  <td class="tableRow1"><input type="text" name="category_name" id="category_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['category']['category_name'])) ? $this->_run_mod_handler('replace', true, $_tmp, '"', "&quot;") : smarty_modifier_replace($_tmp, '"', "&quot;")); ?>
" class="input"></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td><input type="submit" value="���������" class="button"></td>
 </tr>
</table>
</form>

<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeader">ID</td>
  <td class="tableHeader">�������� ������������</td>
  <td class="tableHeader" width="70">�������</td>
  <td class="tableHeader" width="70">����������</td>
  <td class="tableHeader" width="90">&nbsp;</td>
 </tr>
 <?php if (isset($this->_foreach['subcategories'])) unset($this->_foreach['subcategories']);
$this->_foreach['subcategories']['total'] = count($_from = (array)$this->_tpl_vars['subcategories']);
$this->_foreach['subcategories']['show'] = $this->_foreach['subcategories']['total'] > 0;
if ($this->_foreach['subcategories']['show']):
$this->_foreach['subcategories']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['subcategories']['iteration']++;
        $this->_foreach['subcategories']['first'] = ($this->_foreach['subcategories']['iteration'] == 1);
        $this->_foreach['subcategories']['last']  = ($this->_foreach['subcategories']['iteration'] == $this->_foreach['subcategories']['total']);
?>
 <tr class="tableRow<?php echo smarty_function_cycle(array('values' => "1,2"), $this);?>
">
  <td align="center"><?php echo $this->_tpl_vars['item']['subcategory_id']; ?>
</td>
  <td align="center"><a href="index.php?mode=products&subcat_id=<?php echo $this->_tpl_vars['item']['subcategory_id']; ?>
"><?php echo $this->_tpl_vars['item']['subcategory_name']; ?>
</a></td>
  <td align="center">
   <a href="index.php?mode=move_subcat_up&subcat_id=<?php echo $this->_tpl_vars['item']['subcategory_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/up.gif" border="0" alt="�����"></a>&nbsp;
   <a href="index.php?mode=move_subcat_down&subcat_id=<?php echo $this->_tpl_vars['item']['subcategory_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/down.gif" border="0" alt="����"></a>
  </td>
  <td align="center"><?php if ($this->_tpl_vars['item']['hidden']): ?>���<?php else: ?>��<?php endif; ?></td>
  <td align="center">
   <a href="index.php?mode=products&subcat_id=<?php echo $this->_tpl_vars['item']['subcategory_id']; ?>
" title="�������������"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/edit.gif" border="0" align="absmiddle" alt="�������������"></a>&nbsp;
   <a href="index.php?mode=hide_subcat&subcat_id=<?php echo $this->_tpl_vars['item']['subcategory_id']; ?>
" title="������/��������"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/show.gif" border="0" align="absmiddle" alt="������/��������"></a>&nbsp;
   <a href="#" onClick="if (confirm('�� ������������� ������ ������� ��� ������������ �� ����� ���������� � ���?\n<?php echo $this->_tpl_vars['item']['subcategory_name']; ?>
')) location.href='index.php?mode=subcat_delete&subcat_id=<?php echo $this->_tpl_vars['item']['subcategory_id']; ?>
';" title="�������"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" align="absmiddle" alt="�������"></a>
  </td>
 </tr>
 <?php endforeach; unset($_from); else: ?>
 <tr>
  <td align="center" colspan="4">��� ������������ � ���� ���������</td>
 </tr>
 <?php endif; ?>
</table>
<br/><br/>

<form action="index.php?mode=save_new_subcategory&cat_id=<?php echo $this->_tpl_vars['category']['category_id']; ?>
" method="POST" enctype="multipart/form-data" onSubmit="if (hasEmptyFields('subcategory_name', false, '������� �������� ������������')) return false;">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeader" colspan="2">���������� ����� ������������</td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">�������� ������������</td>
  <td class="tableRow1"><input type="text" name="subcategory_name" id="subcategory_name" class="input"></td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">������ ����������</td>
  <td><select name="group_id" class="input">
  <option value="0"></option>
  <?php if (count($_from = (array)$this->_tpl_vars['groups'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
  <option value="<?php echo $this->_tpl_vars['item']['group_id']; ?>
"><?php echo $this->_tpl_vars['item']['group_name']; ?>
</option>
  <?php endforeach; unset($_from); endif; ?>
  </select></td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">�������� ������������</td>
  <td class="tableRow1"><input type="file" name="image_file" id="image_file" class="input"></td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">��������</td>
  <td class="tableRow1"><input type="checkbox" name="marked" id="marked" value="1"></td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">������</td>
  <td class="tableRow1"><input type="checkbox" name="hidden" id="hidden" value="1"></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td><input type="submit" value="���������" class="button"></td>
 </tr>
</table>
</form>