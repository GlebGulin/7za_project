<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:16:38
         compiled from CMS/news/news.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'mm_image', 'CMS/news/news.tpl.html', 2, false),array('modifier', 'date_format', 'CMS/news/news.tpl.html', 3, false),array('modifier', 'strip_tags', 'CMS/news/news.tpl.html', 11, false),array('modifier', 'truncate', 'CMS/news/news.tpl.html', 11, false),)), $this); ?>
<h1><?php echo $this->_tpl_vars['news']['title']; ?>
</h1>
<?php if ($this->_tpl_vars['news']['image_file_id']): ?><div style="float:right;"><?php echo smarty_function_mm_image(array('file_id' => $this->_tpl_vars['news']['image_file_id']), $this);?>
</div><?php endif; ?>
<p  class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['news']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</p>
<div><?php echo $this->_tpl_vars['news']['text']; ?>
</div>
<br />
<?php if ($this->_tpl_vars['last_news']): ?>
<h2>Другие новости:</h2>
<?php if (count($_from = (array)$this->_tpl_vars['last_news'])):
    foreach ($_from as $this->_tpl_vars['n']):
?>
<p><span class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['n']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</span><br />
  <a href="/news/<?php echo $this->_tpl_vars['n']['news_id']; ?>
/" class="item_title"><?php echo $this->_tpl_vars['n']['title']; ?>
</a></p>
<p><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['n']['text'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 200) : smarty_modifier_truncate($_tmp, 200)); ?>
</p>
<p><a href="/news/<?php echo $this->_tpl_vars['n']['news_id']; ?>
/" class="more">подробнее</a></p>
<?php endforeach; unset($_from); endif; ?>
<?php endif; ?>
<p><a href="/pages/3/">Все новости</a></p>