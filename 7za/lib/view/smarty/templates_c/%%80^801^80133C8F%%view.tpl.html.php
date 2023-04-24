<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:16:34
         compiled from CMS/articles/view.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'CMS/articles/view.tpl.html', 8, false),array('function', 'mm_image', 'CMS/articles/view.tpl.html', 9, false),)), $this); ?>
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
<h2><?php echo $this->_tpl_vars['article']['title']; ?>
</h2>
<p class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['article']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</p>
<?php if ($this->_tpl_vars['article']['image_file_id']): ?><div style="float:right;"><?php echo smarty_function_mm_image(array('file_id' => $this->_tpl_vars['article']['image_file_id']), $this);?>
</div><?php endif; ?>
<div><?php echo $this->_tpl_vars['article']['text']; ?>
</div>
<div style="clear:both;"></div>

<?php if ($this->_tpl_vars['other_articles']): ?>
<h2>Другие статьи</h2>
<?php if (isset($this->_foreach['other_articles'])) unset($this->_foreach['other_articles']);
$this->_foreach['other_articles']['total'] = count($_from = (array)$this->_tpl_vars['other_articles']);
$this->_foreach['other_articles']['show'] = $this->_foreach['other_articles']['total'] > 0;
if ($this->_foreach['other_articles']['show']):
$this->_foreach['other_articles']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['other_articles']['iteration']++;
        $this->_foreach['other_articles']['first'] = ($this->_foreach['other_articles']['iteration'] == 1);
        $this->_foreach['other_articles']['last']  = ($this->_foreach['other_articles']['iteration'] == $this->_foreach['other_articles']['total']);
?>
<p><span class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</span>&nbsp; <a href="/article/<?php echo $this->_tpl_vars['item']['article_id']; ?>
/" class="item_title"><strong><?php echo $this->_tpl_vars['item']['title']; ?>
</strong></a></p>
<?php endforeach; unset($_from); endif; ?>
<?php endif; ?>