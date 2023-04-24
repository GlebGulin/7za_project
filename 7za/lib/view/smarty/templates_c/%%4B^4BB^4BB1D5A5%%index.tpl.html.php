<?php /* Smarty version 2.6.5-dev, created on 2016-10-07 13:39:31
         compiled from admin/articles/index.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/articles/index.tpl.html', 13, false),array('modifier', 'date_format', 'admin/articles/index.tpl.html', 16, false),array('modifier', 'htmlspecialchars', 'admin/articles/index.tpl.html', 24, false),)), $this); ?>
 <h3>Статьи категории "<?php echo $this->_tpl_vars['category']['name']; ?>
"</h3>
<div align="right"><a href="index.php?mode=add&id=<?php echo $this->_tpl_vars['category']['category_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_add.gif" border="0" align="absmiddle"> Добавить статью</a></div>
  <table width="100%"  border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="40" class="tableHeader">ID</td>
      <td class="tableHeader">Заголовок</td>
      <td class="tableHeader">Дата</td>
      <td class="tableHeader">Показывать</td>
      <td width="120" class="tableHeader">&nbsp;</td>
    </tr>

    <?php if (isset($this->_foreach['articles'])) unset($this->_foreach['articles']);
$this->_foreach['articles']['total'] = count($_from = (array)$this->_tpl_vars['articles']);
$this->_foreach['articles']['show'] = $this->_foreach['articles']['total'] > 0;
if ($this->_foreach['articles']['show']):
$this->_foreach['articles']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['articles']['iteration']++;
        $this->_foreach['articles']['first'] = ($this->_foreach['articles']['iteration'] == 1);
        $this->_foreach['articles']['last']  = ($this->_foreach['articles']['iteration'] == $this->_foreach['articles']['total']);
?>
    <tr class="tableRow<?php echo smarty_function_cycle(array('values' => "1,2"), $this);?>
">
      <td align="center"><?php echo $this->_tpl_vars['item']['article_id']; ?>
</td>
      <td><?php echo $this->_tpl_vars['item']['title']; ?>
</td>
      <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</td>
      <td align="center">
      	<a href="index.php?mode=visible&id=<?php echo $this->_tpl_vars['item']['article_id']; ?>
">
       		<img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/<?php if ($this->_tpl_vars['item']['visible']): ?>allowed<?php else: ?>restricted<?php endif; ?>.gif" alt="Показать/скрыть" title="Показать/скрыть" width="24" height="24" border="0" align="absmiddle">
      	</a>
      </td>
      <td align="center" nowrap>
      	<a href="index.php?mode=edit&id=<?php echo $this->_tpl_vars['item']['article_id']; ?>
" title="Редактировать"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_edit.gif" width="24" height="24" border="0" alt="Редактировать"></a>
      	<a href="#" onClick="if (confirm('Вы действительно хотите удалить эту статью?\n<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp, ENT_QUOTES, 'cp1251')); ?>
')) location.href='index.php?mode=delete&id=<?php echo $this->_tpl_vars['item']['article_id']; ?>
';" title="Удалить"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_delete.gif" width="24" height="24" border="0" alt="Удалить"></a>
      </td>
    </tr>
    <?php endforeach; unset($_from); else: ?>
    <tr>
     <td colspan="5" align="center" class="tableRow1">Нет статей</td>
    </tr>
    <?php endif; ?>

  </table>