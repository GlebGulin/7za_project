<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:13:29
         compiled from admin/pages/index.tpl.html */ ?>
<script language="JavaScript" type="text/javascript" src="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
images.js"></script>
 	<h3>Редактирование страниц</h3>
 	      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      		<?php if (isset($this->_foreach['pl1'])) unset($this->_foreach['pl1']);
$this->_foreach['pl1']['total'] = count($_from = (array)$this->_tpl_vars['pages']);
$this->_foreach['pl1']['show'] = $this->_foreach['pl1']['total'] > 0;
if ($this->_foreach['pl1']['show']):
$this->_foreach['pl1']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['paglev1']):
        $this->_foreach['pl1']['iteration']++;
        $this->_foreach['pl1']['first'] = ($this->_foreach['pl1']['iteration'] == 1);
        $this->_foreach['pl1']['last']  = ($this->_foreach['pl1']['iteration'] == $this->_foreach['pl1']['total']);
?>
            <tr>
              <td width="24"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page.gif" width="24" height="24"></td>
              <td colspan="5" class="page_line"><?php echo $this->_tpl_vars['paglev1']['title']; ?>
</td>
              <td align="right" class="page_line">
                <table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                   <td width="24"><a href="index.php?mode=popup&page_id=<?php echo $this->_tpl_vars['paglev1']['page_id']; ?>
" target="popup" onClick="openWindow(300, 150)"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/link.gif" width="24" height="24" border="0" align="absmiddle" title="Показать адрес страницы" alt="Показать адрес страницы"></a></td>
                   <td width="24"><a href="index.php?mode=edit_page&page_id=<?php echo $this->_tpl_vars['paglev1']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_edit.gif" width="24" height="24" align="absmiddle" border="0" alt="Редактировать страницу" title="Редактировать страницу"></a></td>
                   <td width="24">&nbsp;</td>
                   <td width="24">&nbsp;</td>
                   <td width="24"><a href="index.php?mode=add_page&page_id=<?php echo $this->_tpl_vars['paglev1']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_add.gif" width="24" height="24" border="0" align="absmiddle" alt="Добавить страницу" title="Добавить страницу"></a></td>
                   <td width="24">&nbsp;</td>
                   <td width="24">&nbsp;</td>
				  </tr>  
				</table>	                   
              </td>
            </tr>
              <?php if (isset($this->_foreach['pl2'])) unset($this->_foreach['pl2']);
$this->_foreach['pl2']['total'] = count($_from = (array)$this->_tpl_vars['paglev1']['pages']);
$this->_foreach['pl2']['show'] = $this->_foreach['pl2']['total'] > 0;
if ($this->_foreach['pl2']['show']):
$this->_foreach['pl2']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['paglev2']):
        $this->_foreach['pl2']['iteration']++;
        $this->_foreach['pl2']['first'] = ($this->_foreach['pl2']['iteration'] == 1);
        $this->_foreach['pl2']['last']  = ($this->_foreach['pl2']['iteration'] == $this->_foreach['pl2']['total']);
?>
              <tr>
                <td width="24" nowrap><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/<?php if ($this->_foreach['pl2']['last']): ?>line_v_r_b<?php else: ?>line_v_r<?php endif; ?>.gif" width="24" height="24"></td>
                <td width="24" nowrap ><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page.gif" width="24" height="24"></td>
                <td colspan="4" class="page_line"><?php echo $this->_tpl_vars['paglev2']['title']; ?>
</td>
                <td align="right" class="page_line">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
	                  <td width="24"><a href="index.php?mode=popup&page_id=<?php echo $this->_tpl_vars['paglev2']['page_id']; ?>
" target="popup" onClick="openWindow(300, 150)"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/link.gif" width="24" height="24" border="0" align="absmiddle" title="Показать адрес страницы" alt="Показать адрес страницы"></a></td>
	                  <td width="24"><a href="index.php?mode=edit_page&page_id=<?php echo $this->_tpl_vars['paglev2']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_edit.gif" width="24" height="24" align="absmiddle" border="0" alt="Редактировать страницу" title="Редактировать страницу"></a></td>
					  <td width="24"><a href="index.php?mode=move_page_up&page_id=<?php echo $this->_tpl_vars['paglev2']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_up.gif" width="24" height="24" align="absmiddle" border="0" alt="Переместить вверх" title="Переместить вверх"></a></td>
					  <td width="24"><a href="index.php?mode=move_page_down&page_id=<?php echo $this->_tpl_vars['paglev2']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_down.gif" width="24" height="24" align="absmiddle" border="0" alt="Переместить вниз" title="Переместить вниз"></a></td>
					  <td width="24"><a href="index.php?mode=add_page&page_id=<?php echo $this->_tpl_vars['paglev2']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_add.gif" width="24" height="24" border="0" align="absmiddle" alt="Добавить страницу" title="Добавить страницу"></a></td>
					  <td width="24"><a href="index.php?mode=visible&page_id=<?php echo $this->_tpl_vars['paglev2']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_<?php if ($this->_tpl_vars['paglev2']['visible']): ?>shown<?php else: ?>hidden<?php endif; ?>.gif" width="24" height="24" align="absmiddle" border="0" alt="Показать / скрыть" title="Показать / скрыть"></a></td>
					  <td width="24"><?php if (! $this->_tpl_vars['paglev2']['forbid_remove']): ?><a href="#" onclick="if (confirm('Вы действительно хотите удалить эту папку и все страницы в ней?\n<?php echo $this->_tpl_vars['paglev2']['title']; ?>
')) location.href='index.php?mode=delete_page&page_id=<?php echo $this->_tpl_vars['paglev2']['page_id']; ?>
';"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_delete.gif" width="24" height="24" align="absmiddle" border="0" alt="Удалить страницу" title="Удалить страницу"></a><?php else: ?>&nbsp;<?php endif; ?></td>
					</tr>  
				  </table>			 
                </td>
              </tr> 
                <?php if (isset($this->_foreach['pl3'])) unset($this->_foreach['pl3']);
$this->_foreach['pl3']['total'] = count($_from = (array)$this->_tpl_vars['paglev2']['pages']);
$this->_foreach['pl3']['show'] = $this->_foreach['pl3']['total'] > 0;
if ($this->_foreach['pl3']['show']):
$this->_foreach['pl3']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['paglev3']):
        $this->_foreach['pl3']['iteration']++;
        $this->_foreach['pl3']['first'] = ($this->_foreach['pl3']['iteration'] == 1);
        $this->_foreach['pl3']['last']  = ($this->_foreach['pl3']['iteration'] == $this->_foreach['pl3']['total']);
?>
                <tr>
                  <td width="24" nowrap ><?php if (! $this->_foreach['pl2']['last']): ?><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/line_v.gif" width="24" height="24"><?php else: ?>&nbsp<?php endif; ?></td>
                  <td width="24" nowrap ><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/<?php if ($this->_foreach['pl3']['last']): ?>line_v_r_b<?php else: ?>line_v_r<?php endif; ?>.gif" width="24" height="24"></td>
                  <td width="24" nowrap ><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page.gif" width="24" height="24"></td>
                  <td colspan="3" class="page_line"><?php echo $this->_tpl_vars['paglev3']['title']; ?>
</td>
                  <td align="right" class="page_line">
                <table border="0" cellpadding="0" cellspacing="0">
                  <tr>                  
	                  <td width="24"><a href="index.php?mode=popup&page_id=<?php echo $this->_tpl_vars['paglev3']['page_id']; ?>
" target="popup" onClick="openWindow(300, 150)"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/link.gif" width="24" height="24" border="0" align="absmiddle" title="Показать адрес страницы" alt="Показать адрес страницы"></a></td>
	                  <td width="24"><a href="index.php?mode=edit_page&page_id=<?php echo $this->_tpl_vars['paglev3']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_edit.gif" width="24" height="24" align="absmiddle" border="0" alt="Редактировать страницу" title="Редактировать страницу"></a></td>
					  <td width="24"><a href="index.php?mode=move_page_up&page_id=<?php echo $this->_tpl_vars['paglev3']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_up.gif" width="24" height="24" align="absmiddle" border="0" alt="Переместить вверх" title="Переместить вверх"></a></td>
					  <td width="24"><a href="index.php?mode=move_page_down&page_id=<?php echo $this->_tpl_vars['paglev3']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_down.gif" width="24" height="24" align="absmiddle" border="0" alt="Переместить вниз" title="Переместить вниз"></a></td>
					  <td width="24">&nbsp;</td>
					  <td width="24"><a href="index.php?mode=visible&page_id=<?php echo $this->_tpl_vars['paglev3']['page_id']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_<?php if ($this->_tpl_vars['paglev3']['visible']): ?>shown<?php else: ?>hidden<?php endif; ?>.gif" width="24" height="24" align="absmiddle" border="0" alt="Показать / скрыть" title="Показать / скрыть"></a></td>
					  <td width="24"><?php if (! $this->_tpl_vars['paglev3']['forbid_remove']): ?><a href="#" onclick="if (confirm('Вы действительно хотите удалить эту папку и все страницы в ней?\n<?php echo $this->_tpl_vars['paglev3']['title']; ?>
')) location.href='index.php?mode=delete_page&page_id=<?php echo $this->_tpl_vars['paglev3']['page_id']; ?>
';"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/page_delete.gif" width="24" height="24" align="absmiddle" border="0" alt="Удалить страницу" title="Удалить страницу"></a><?php else: ?>&nbsp;<?php endif; ?></td>
				  </tr>  
				</table>					  
                  </td>
                </tr> 
                <?php endforeach; unset($_from); endif; ?>
              <?php endforeach; unset($_from); endif; ?>
            <?php endforeach; unset($_from); endif; ?>
            
          </table>