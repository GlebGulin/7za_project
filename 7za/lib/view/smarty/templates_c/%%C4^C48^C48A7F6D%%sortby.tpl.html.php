<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:14:02
         compiled from products/sortby.tpl.html */ ?>
<div style="text-align:right">
Сортировать по: <a href="<?php echo $this->_tpl_vars['url']; ?>
?sortby=<?php if ($this->_tpl_vars['sortby'] == 'price'): ?>price_desc<?php else: ?>price<?php endif; ?>">цене</a><?php if ($this->_tpl_vars['sortby'] == 'price'): ?><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
up.gif" align="absmiddle" /><?php elseif ($this->_tpl_vars['sortby'] == 'price_desc'): ?><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
desc.gif" align="absmiddle" /><?php endif; ?>&nbsp;&nbsp;
<a href="<?php echo $this->_tpl_vars['url']; ?>
?sortby=<?php if ($this->_tpl_vars['sortby'] == 'name'): ?>name_desc<?php else: ?>name<?php endif; ?>">наименованию</a>
<?php if ($this->_tpl_vars['sortby'] == 'name'): ?><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
up.gif" align="absmiddle" /><?php elseif ($this->_tpl_vars['sortby'] == 'name_desc'): ?><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
desc.gif" align="absmiddle" /><?php endif; ?>
</div>