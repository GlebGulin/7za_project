<?php /* Smarty version 2.6.5-dev, created on 2017-05-23 08:11:56
         compiled from rss/popular_gifts.tpl.xml */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', 'rss/popular_gifts.tpl.xml', 22, false),array('modifier', 'trim', 'rss/popular_gifts.tpl.xml', 22, false),array('modifier', 'truncate', 'rss/popular_gifts.tpl.xml', 22, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="windows-1251"<?php echo '?>'; ?>

<rss version="2.0">

<channel>
	<title>Интернет-магазин подарков "Товары На Дом"</title>
	<link>http://www.tnd.kiev.ua/</link>
	<description>Оригинальные подарки в магазине оригинальных подарков и сувениров TND.KIEV.UA</description>
	<pubDate><?php echo $this->_tpl_vars['pub_date']; ?>
</pubDate>
	<language>ru</language>
	<ttl>300</ttl>
	<image>
	   <url>http://<?php echo $_SERVER['HTTP_HOST']; ?>
/resources/images/admin/logo.gif</url>
	   <title>Интернет-магазин подарков "Товары На Дом"</title>
	</image>
	<?php if (count($_from = (array)$this->_tpl_vars['products'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	<item>
		<title><?php echo $this->_tpl_vars['item']['product_name']; ?>
</title>
		<link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
/product/<?php echo $this->_tpl_vars['item']['product_id']; ?>
/</link>
		<guid>http://<?php echo $_SERVER['HTTP_HOST']; ?>
/product/<?php echo $this->_tpl_vars['item']['product_id']; ?>
/</guid>
		<description><![CDATA[<img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>
/resources/images/mm_files/<?php echo $this->_tpl_vars['item']['image_file_id']; ?>
t.jpg" border=0 vspace=10 hspace=10><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['description'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('trim', true, $_tmp) : trim($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 300, "...") : smarty_modifier_truncate($_tmp, 300, "...")); ?>
]]></description>
	</item>
	<?php endforeach; unset($_from); endif; ?>
	</channel>
</rss>