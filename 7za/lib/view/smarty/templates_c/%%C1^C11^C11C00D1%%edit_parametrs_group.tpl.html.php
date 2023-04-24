<?php /* Smarty version 2.6.5-dev, created on 2016-09-26 14:53:08
         compiled from admin/products/edit_parametrs_group.tpl.html */ ?>
<h1>Редактирование группы параметров продуктов</h1>

<form action="parameters.php?mode=save_group&group_id=<?php echo $this->_tpl_vars['group']['group_id']; ?>
" method="POST" enctype="multipart/form-data" onSubmit="if (hasEmptyFields('group_name', false, 'Заполните форму, пожалуйста.')) return false;">
<table width="100%" border="0" cellpadding="3" cellspacing="1" align="center">

 <tr>
  <td class="tableHeaderLeft">Название группы параметров:</td>
  <td class="tableRow1"><input type="text" name="group_name" class="input" value="<?php echo $this->_tpl_vars['group']['group_name']; ?>
" id="group_name" /></td>
 </tr>

 <tr>
  <td>&nbsp;</td>
  <td>
    <input type="submit" class="button" value="Сохранить">&nbsp;
    <input type="button" onClick="location.href='parameters.php'; return false;" class="button" value="Отмена">
   </td>
 </tr>
</table>
</form>

	<table width="100%" border="0" cellpadding="3" cellspacing="1" align="center">
		<tr>
			<td colspan="5" align="right"><a href="parameters.php?mode=add_parameter&group_id=<?php echo $this->_tpl_vars['group']['group_id']; ?>
">Добавить параметр</a></td>
		</tr>
		<tr>
			<td class="tableHeader" colspan="5">Параметры</td>
		</tr>
		<tr>
			<td class="tableHeader">ID</td>
			<td class="tableHeader">Название</td>
			<td class="tableHeader">Ед.Изм.</td>
			<td class="tableHeader" width="60">&nbsp;</td>
			<td class="tableHeader" width="60">&nbsp;</td>
		</tr>
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
			<tr class="tableRow<?php if ((1 & $this->_foreach['parameters']['iteration'])): ?>1<?php else: ?>2<?php endif; ?>">
				<td align="center"><?php echo $this->_tpl_vars['item']['parameter_id']; ?>
</td>
				<td align="center"><?php if ($this->_tpl_vars['item']['is_header']): ?><strong><?php echo $this->_tpl_vars['item']['parameter_name']; ?>
</strong><?php else:  echo $this->_tpl_vars['item']['parameter_name'];  endif; ?></td>
				<td align="center"><?php echo $this->_tpl_vars['item']['unit']; ?>
</td>
				<td align="center">
					<a href="parameters.php?mode=move_parameter_up&parameter_id=<?php echo $this->_tpl_vars['item']['parameter_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/up.gif" border="0" alt="Вверх" title="Вверх"></a>&nbsp;
					<a href="parameters.php?mode=move_parameter_down&parameter_id=<?php echo $this->_tpl_vars['item']['parameter_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/down.gif" border="0" alt="Вниз" title="Вниз"></a>
				</td>
				<td align="center">
					<a href="parameters.php?mode=edit_parameter&parameter_id=<?php echo $this->_tpl_vars['item']['parameter_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/edit.gif" border="0" align="absmiddle" alt="Редактировать" title="Редактировать"></a>&nbsp;
					<a href="#" onClick="if (confirm('Вы действительно хотите удалить этот параметр?\n<?php echo $this->_tpl_vars['item']['parameter_name']; ?>
')) location.href='parameters.php?mode=delete_parameter&parameter_id=<?php echo $this->_tpl_vars['item']['parameter_id']; ?>
';"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" align="absmiddle" alt="Удалить" title="Удалить"></a>
				</td>
			</tr>
		<?php endforeach; unset($_from); endif; ?>
	</table>