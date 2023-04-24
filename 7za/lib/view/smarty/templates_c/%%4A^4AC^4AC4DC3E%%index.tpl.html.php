<?php /* Smarty version 2.6.5-dev, created on 2016-09-26 14:07:32
         compiled from admin/comments/index.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/comments/index.tpl.html', 13, false),array('modifier', 'nl2br', 'admin/comments/index.tpl.html', 15, false),array('modifier', 'date_format', 'admin/comments/index.tpl.html', 17, false),)), $this); ?>
<h3>Комментарии к товарам</h3>

<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeader">ID</td>
  <td class="tableHeader">Комментарий</td>
  <td class="tableHeader">Товар</td>
  <td class="tableHeader">Дата</td>
  <td class="tableHeader">Автор</td>
  <td class="tableHeader" width="90">&nbsp;</td>
 </tr>
 <?php if (isset($this->_foreach['comments'])) unset($this->_foreach['comments']);
$this->_foreach['comments']['total'] = count($_from = (array)$this->_tpl_vars['comments']);
$this->_foreach['comments']['show'] = $this->_foreach['comments']['total'] > 0;
if ($this->_foreach['comments']['show']):
$this->_foreach['comments']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['comments']['iteration']++;
        $this->_foreach['comments']['first'] = ($this->_foreach['comments']['iteration'] == 1);
        $this->_foreach['comments']['last']  = ($this->_foreach['comments']['iteration'] == $this->_foreach['comments']['total']);
?>
 <tr class="tableRow<?php echo smarty_function_cycle(array('values' => "1,2"), $this);?>
">
  <td align="center"><?php echo $this->_tpl_vars['item']['comment_id']; ?>
</td>
  <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['comment_text'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
  <td align="center"><a href="/product/<?php echo $this->_tpl_vars['item']['item_id']; ?>
/" target="_blank"><?php echo $this->_tpl_vars['item']['product_name']; ?>
</a></td>
  <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</td>
  <td align="center"><?php echo $this->_tpl_vars['item']['author']; ?>
 (<?php echo $this->_tpl_vars['item']['author_ip']; ?>
)</td>
  <td align="center">
   <a href="index.php?mode=edit&id=<?php echo $this->_tpl_vars['item']['comment_id']; ?>
" title="Редактировать"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/edit.gif" border="0" align="absmiddle"></a>&nbsp;
   <a href="#" title="Удалить" onClick="if (confirm('Вы действительно хотите удалить этот комментарий?')) location.href='index.php?mode=delete&id=<?php echo $this->_tpl_vars['item']['comment_id']; ?>
'; return false;"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/delete.gif" border="0" align="absmiddle"></a>
  </td>
 </tr>
 <?php endforeach; unset($_from); else: ?>
 <tr>
  <td class="header" align="center" colspan="5">Отсутствуют комментарии</td>
 </tr>
 <?php endif; ?>
</table>