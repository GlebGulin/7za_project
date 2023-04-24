<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:07:33
         compiled from admin/products/categories.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/products/categories.tpl.html', 25, false),)), $this); ?>
<h3>������� ���������</h3>

<form action="index.php?mode=search" method="POST" onSubmit="if (hasEmptyFields('keyword', false, '������� ����� ��� ������')) return false;">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeader" colspan="2">����� ������</td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">����� ��� ������:</td>
  <td class="tableRow1"><input type="text" name="keyword" id="keyword" class="input">
   <input type="submit" value="�����" class="button">
  </td>
 </tr>
</table>
</form>

<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeader">ID</td>
  <td class="tableHeader">��������</td>
  <td class="tableHeader">�������</td>
  <td class="tableHeader" width="90">&nbsp;</td>
 </tr>
 <?php if (isset($this->_foreach['categories'])) unset($this->_foreach['categories']);
$this->_foreach['categories']['total'] = count($_from = (array)$this->_tpl_vars['categories']);
$this->_foreach['categories']['show'] = $this->_foreach['categories']['total'] > 0;
if ($this->_foreach['categories']['show']):
$this->_foreach['categories']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['categories']['iteration']++;
        $this->_foreach['categories']['first'] = ($this->_foreach['categories']['iteration'] == 1);
        $this->_foreach['categories']['last']  = ($this->_foreach['categories']['iteration'] == $this->_foreach['categories']['total']);
?>
 <tr class="tableRow<?php echo smarty_function_cycle(array('values' => "1,2"), $this);?>
">
  <td align="center"><?php echo $this->_tpl_vars['item']['category_id']; ?>
</td>
  <td align="center"><a href="index.php?mode=subcategories&cat_id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
"><?php echo $this->_tpl_vars['item']['category_name']; ?>
</a></td>
  <td align="center">
   <a href="index.php?mode=move_cat_up&cat_id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/up.gif" border="0" alt="�����"></a>&nbsp;
   <a href="index.php?mode=move_cat_down&cat_id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/down.gif" border="0" alt="����"></a>
  </td>
  <td align="center">
   <a href="?mode=subcategories&cat_id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/edit.gif" border="0" align="absmiddle" alt="�������������"></a>&nbsp;
   <a href="#" onClick="if (confirm('�� ������������� ������ ������� ��� ��������� �� ����� �������������� � ���������� � ���?\n<?php echo $this->_tpl_vars['item']['category_name']; ?>
')) location.href='index.php?mode=cat_delete&cat_id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
';"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" align="absmiddle" alt="�������"></a>
  </td>
 </tr>
 <?php endforeach; unset($_from); else: ?>
 <tr>
  <td class="header" align="center" colspan="4">����������� ���������</td>
 </tr>
 <?php endif; ?>
</table>
<br>

<form action="index.php?mode=save_new_category" method="POST" onSubmit="if (hasEmptyFields('category_name', false, '������� �������� ���������')) return false;">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeader" colspan="2">���������� ����� ���������</td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">�������� ���������</td>
  <td class="tableRow1"><input type="text" name="category_name" id="category_name" class="input"></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td><br><input type="submit" value="���������" class="button"></td>
 </tr>
</table>
</form>