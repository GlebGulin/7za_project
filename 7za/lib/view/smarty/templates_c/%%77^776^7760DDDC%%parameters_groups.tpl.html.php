<?php /* Smarty version 2.6.5-dev, created on 2016-09-26 14:53:03
         compiled from admin/products/parameters_groups.tpl.html */ ?>
<h3>Параметры товаров</h3>

	<table width="100%" border="0" cellpadding="3" cellspacing="1" align="center">
		<tr>
			<td colspan="4" align="right"><a href="parameters.php?mode=add_group">Добавить группу</a></td>
		</tr>
		<tr>
			<td class="tableHeader" colspan="4">Группы параметров</td>
		</tr>
		<tr>
			<td class="tableHeader">ID</td>
			<td class="tableHeader">Название</td>
			<td class="tableHeader" width="90">&nbsp;</td>
		</tr>
		<?php if (isset($this->_foreach['groups'])) unset($this->_foreach['groups']);
$this->_foreach['groups']['total'] = count($_from = (array)$this->_tpl_vars['groups']);
$this->_foreach['groups']['show'] = $this->_foreach['groups']['total'] > 0;
if ($this->_foreach['groups']['show']):
$this->_foreach['groups']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['groups']['iteration']++;
        $this->_foreach['groups']['first'] = ($this->_foreach['groups']['iteration'] == 1);
        $this->_foreach['groups']['last']  = ($this->_foreach['groups']['iteration'] == $this->_foreach['groups']['total']);
?>
			<tr class="tableRow<?php if ((1 & $this->_foreach['groups']['iteration'])): ?>1<?php else: ?>2<?php endif; ?>">
				<td align="center"><?php echo $this->_tpl_vars['item']['group_id']; ?>
</td>
				<td align="center"><a href="parameters.php?mode=edit_group&group_id=<?php echo $this->_tpl_vars['item']['group_id']; ?>
"><?php echo $this->_tpl_vars['item']['group_name']; ?>
</a></td>
				<td align="center">
					<a href="parameters.php?mode=edit_group&group_id=<?php echo $this->_tpl_vars['item']['group_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/edit.gif" border="0" align="absmiddle" alt="Редактировать" title="Редактировать"></a>&nbsp;
					<a href="#" onClick="if (confirm('Вы действительно хотите удалить эту группу параметров?\n<?php echo $this->_tpl_vars['item']['group_name']; ?>
')) location.href='parameters.php?mode=delete_group&group_id=<?php echo $this->_tpl_vars['item']['group_id']; ?>
';"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" align="absmiddle" alt="Удалить" title="Удалить"></a>
				</td>
			</tr>
		<?php endforeach; unset($_from); endif; ?>
	</table>