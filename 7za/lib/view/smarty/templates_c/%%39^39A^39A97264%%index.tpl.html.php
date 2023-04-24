<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:12:06
         compiled from CMS/articles/index.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'CMS/articles/index.tpl.html', 8, false),)), $this); ?>
<h1>Статьи</h1>
<p><a href="/pages/4/"<?php if ($this->_tpl_vars['curr_a_category'] == 0): ?> style="font-weight:bold;"<?php endif; ?>>Все</a>&nbsp;&nbsp;
<?php if (count($_from = (array)$this->_tpl_vars['articles_categories'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<a href="/articles/cat/<?php echo $this->_tpl_vars['item']['category_id']; ?>
/"<?php if ($this->_tpl_vars['curr_a_category'] == $this->_tpl_vars['item']['category_id']): ?> style="font-weight:bold;"<?php endif; ?>><?php echo $this->_tpl_vars['item']['name']; ?>
</a>&nbsp;&nbsp;
<?php endforeach; unset($_from); endif; ?>
</p>
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
<p><span class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</span>&nbsp; <a href="/article/<?php echo $this->_tpl_vars['item']['article_id']; ?>
/" class="item_title"><strong><?php echo $this->_tpl_vars['item']['title']; ?>
</strong></a></p>
<?php endforeach; unset($_from); endif; ?>

<?php if ($this->_tpl_vars['splitMenu']): ?><div align="center">Страницы: <?php echo $this->_tpl_vars['splitMenu']; ?>
</div><?php endif; ?>