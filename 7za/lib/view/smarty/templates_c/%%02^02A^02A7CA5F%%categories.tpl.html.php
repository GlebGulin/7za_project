<?php /* Smarty version 2.6.5-dev, created on 2016-10-07 13:38:57
         compiled from admin/articles/categories.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/articles/categories.tpl.html', 12, false),array('modifier', 'htmlspecialchars', 'admin/articles/categories.tpl.html', 21, false),)), $this); ?>
<h3>Категории статей</h3>
<div align="right"><a href="index.php?mode=add_category"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_add.gif" border="0" align="absmiddle"> Добавить категорию</a></div>
  <table width="100%"  border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="40" class="tableHeader">ID</td>
      <td class="tableHeader">Название категории</td>
      <td class="tableHeader">Позиция</td>
      <td width="120" class="tableHeader">&nbsp;</td>
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
      <td><a href="index.php?mode=articles&id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></td>
      <td align="center">
      	<a href="index.php?mode=category_up&id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
" title="Переместить верх"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_up.gif" alt="Переместить верх" width="24" height="24" border="0" align="absmiddle"></a>
      	<a href="index.php?mode=category_down&id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
" title="Переместить вниз"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_down.gif" alt="Переместить вниз" width="24" height="24" border="0" align="absmiddle"></a>
      </td>
      <td align="center" nowrap>
      	<a href="index.php?mode=edit_category&id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
" title="Редактировать"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_edit.gif" width="24" height="24" border="0" alt="Редактировать"></a>
      	<a href="#" onClick="if (confirm('Вы действительно хотите удалить эту категорию со всеми статьями?\n<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp, ENT_QUOTES, 'cp1251')); ?>
')) location.href='index.php?mode=delete_category&id=<?php echo $this->_tpl_vars['item']['category_id']; ?>
';" title="Удалить"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_delete.gif" width="24" height="24" border="0" alt="Удалить"></a>
      </td>
    </tr>
    <?php endforeach; unset($_from); else: ?>
    <tr>
     <td colspan="5" align="center" class="tableRow1">Нет категорий</td>
    </tr>
    <?php endif; ?>

  </table>