<?php /* Smarty version 2.6.5-dev, created on 2018-09-12 09:44:21
         compiled from main.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'main.tpl.html', 6, false),array('modifier', 'price_format', 'main.tpl.html', 31, false),array('modifier', 'default', 'main.tpl.html', 50, false),array('modifier', 'date_format', 'main.tpl.html', 56, false),array('modifier', 'strip_tags', 'main.tpl.html', 58, false),array('modifier', 'truncate', 'main.tpl.html', 58, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title><?php if ($this->_tpl_vars['pageTitle']):  echo $this->_tpl_vars['pageTitle'];  else: ?>Интернет магазин 7za<?php endif; ?></title>
<meta name="description" content="<?php if ($this->_tpl_vars['pageDescription']):  echo ((is_array($_tmp=$this->_tpl_vars['pageDescription'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp));  else: ?>Интернет-магазин 7za является поставщиком продукции для здорового образа жизни. У нас вы можете найти всё для здорового питания, витамины, БАДы, бальзамы, фиточаи, лечебную косметику, а также все для похода в баню или сауну: веники, эфирные масла<?php endif; ?>" />
<meta name="keywords" content="<?php if ($this->_tpl_vars['pageKeywords']):  echo ((is_array($_tmp=$this->_tpl_vars['pageKeywords'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp));  else: ?>всё для суши, бальзамы, сиропы, эфирные масла, веники, все для бани и сауны, правильное питание, аюрведа, пищевые добавки, восточные сладости, все для бани, фиточай, все для сауны, здоровое питание, иммунитет, БАДы, лечебная косметика, витамины, здоровый образ жизни, товары для здоровья<?php endif; ?>" />
<meta name="robots" content="index,follow" />
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['URL_STYLE']; ?>
styles.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
forms.js"></script>
<meta name="MSSmartTagsPreventParsing" content="TRUE">
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td id="d_h1"><div id="d_h2">&nbsp;</div></td><td id="d_container">
<div style="position:relative; height:200px">
<div id="d_navigation">
<a href="/pages/2/"<?php if ($this->_tpl_vars['page']['page_id'] == 2): ?> class="selected"<?php endif; ?>>О магазине</a><span>|</span>
<a href="/pages/3/"<?php if ($this->_tpl_vars['page']['page_id'] == 3): ?> class="selected"<?php endif; ?>>Новости сайта</a><span>|</span>
<a href="/pages/4/"<?php if ($this->_tpl_vars['page']['page_id'] == 4): ?> class="selected"<?php endif; ?>>Статьи</a><span>|</span>
<a href="/pages/5/"<?php if ($this->_tpl_vars['page']['page_id'] == 5): ?> class="selected"<?php endif; ?>>Как купить</a><span>|</span>
<a href="/pages/6/"<?php if ($this->_tpl_vars['page']['page_id'] == 6): ?> class="selected"<?php endif; ?>>Оплата и доставка</a><span>|</span>
<a href="/pages/7/"<?php if ($this->_tpl_vars['page']['page_id'] == 7): ?> class="selected"<?php endif; ?>>Гарантии</a><span>|</span>
<a href="/pages/8/"<?php if ($this->_tpl_vars['page']['page_id'] == 8): ?> class="selected"<?php endif; ?>>Контакты</a> </div>
<div id="d_h3">&nbsp;</div><div id="d_h4">&nbsp;</div><div id="d_h5">&nbsp;</div><div id="d_h6">&nbsp;</div>
<a href="/" id="d_logo">Интернет магазин 7za</a>

<div id="d_phone">(<?php echo $this->_tpl_vars['phone_pre']; ?>
)<span> <?php echo $this->_tpl_vars['phone_number']; ?>
</span></div>
<a href="/order/" id="d_cart"><span>ВАША КОРЗИНА</span> <img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
cart.gif" hspace="9" border="0" align="absmiddle" /> товаров <span class="price"><?php echo $this->_tpl_vars['cart_count']; ?>
</span> на сумму <span class="price"><?php echo ((is_array($_tmp=$this->_tpl_vars['cart_total'])) ? $this->_run_mod_handler('price_format', true, $_tmp) : smarty_modifier_price_format($_tmp)); ?>
</span> грн.</a></div>
<div id="d_left">
<div id="d_menu">


<?php if (isset($this->_foreach['c'])) unset($this->_foreach['c']);
$this->_foreach['c']['total'] = count($_from = (array)$this->_tpl_vars['catnav']);
$this->_foreach['c']['show'] = $this->_foreach['c']['total'] > 0;
if ($this->_foreach['c']['show']):
$this->_foreach['c']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['cat']):
        $this->_foreach['c']['iteration']++;
        $this->_foreach['c']['first'] = ($this->_foreach['c']['iteration'] == 1);
        $this->_foreach['c']['last']  = ($this->_foreach['c']['iteration'] == $this->_foreach['c']['total']);
?>
<span>&nbsp;</span>
<a href="/cat/<?php echo $this->_tpl_vars['cat']['category_id']; ?>
/"<?php if ($this->_tpl_vars['cat']['category_id'] == $this->_tpl_vars['category_id']): ?> class="active"<?php endif; ?>><?php echo $this->_tpl_vars['cat']['category_name']; ?>
</a>
<?php if ($this->_tpl_vars['cat']['subcategories']): ?>
<div id="d_submenu">
	<?php if (isset($this->_foreach['s'])) unset($this->_foreach['s']);
$this->_foreach['s']['total'] = count($_from = (array)$this->_tpl_vars['cat']['subcategories']);
$this->_foreach['s']['show'] = $this->_foreach['s']['total'] > 0;
if ($this->_foreach['s']['show']):
$this->_foreach['s']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['subcat']):
        $this->_foreach['s']['iteration']++;
        $this->_foreach['s']['first'] = ($this->_foreach['s']['iteration'] == 1);
        $this->_foreach['s']['last']  = ($this->_foreach['s']['iteration'] == $this->_foreach['s']['total']);
?>
	<span>&nbsp;</span>
	<a href="/subcat/<?php echo $this->_tpl_vars['subcat']['subcategory_id']; ?>
/"<?php if ($this->_tpl_vars['subcat']['subcategory_id'] == $this->_tpl_vars['subcategory_id']): ?> class="active"<?php endif; ?>><?php echo $this->_tpl_vars['subcat']['subcategory_name']; ?>
</a>
	<?php endforeach; unset($_from); endif; ?>
</div>
<?php endif; ?>
<?php endforeach; unset($_from); endif; ?>
</div>

<?php if (((is_array($_tmp=@$this->_tpl_vars['front_news'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')) && $this->_tpl_vars['page']['page_id'] != 3): ?>
<div class="title">
Новости
</div>
<div class="left_content">
<?php if (count($_from = (array)$this->_tpl_vars['front_news'])):
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
</div>
<?php endif; ?>
<?php if (((is_array($_tmp=@$this->_tpl_vars['front_articles'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')) && $this->_tpl_vars['page']['page_id'] != 4): ?>
<div class="title">
Статьи
</div>
<div class="left_content">
<?php if (count($_from = (array)$this->_tpl_vars['front_articles'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<p><a href="/article/<?php echo $this->_tpl_vars['item']['article_id']; ?>
/" class="item_title"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></p>
<p><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['text'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 200) : smarty_modifier_truncate($_tmp, 200)); ?>
</p>
<p><a href="/article/<?php echo $this->_tpl_vars['item']['article_id']; ?>
/" class="more">подробнее</a></p>
<?php endforeach; unset($_from); endif; ?>
</div>
<?php endif; ?>
</div>
<div id="d_right">
<?php if ($this->_tpl_vars['pagePath']): ?>
  <p><a href="/">на главную</a>
  <?php if (count($_from = (array)$this->_tpl_vars['pagePath'])):
    foreach ($_from as $this->_tpl_vars['item']):
?><span class="delim">&nbsp;</span> <a href="<?php echo $this->_tpl_vars['item']['link']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a><?php endforeach; unset($_from); endif; ?></p>
<?php endif; ?>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="700" height="120" id="7za_ksv" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="/resources/images/b/7za_ksv.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="/resources/images/b/7za_ksv.swf" quality="high" bgcolor="#ffffff" width="700" height="120" name="7za_ksv" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
	</object>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['contentFile'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<div style="clear:both"></div>
<div id="links" style="paddin-left: 250px; text-align: center;"><?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'templates/links.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
</div>
<div id="footer_menu">
<a href="/pages/2/">О магазине</a><span>|</span>
<a href="/pages/3/">Новости сайта</a><span>|</span>
<a href="/pages/4/">Статьи</a><span>|</span>
<a href="/pages/5/">Как купить</a><span>|</span>
<a href="/pages/6/">Оплата и доставка</a><span>|</span>
<a href="/pages/7/">Гарантии</a><span>|</span>
<a href="/pages/8/">Контакты</a>
</div>
<div id="footer1"><div id="footer2">
© 2008-<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
, Интернет-магазин 7ZA<span>|</span>(044) 35 377 35<span>|</span><a href="/pages/8/">написать письмо</a><span id="d_developed"><a href="http://www.fairpoint.com.ua/">Разработка сайта</a>: <a href="http://www.fairpoint.com.ua/">Fair Point Development</a></span></div>
</div>
</td><td id="d_h7">&nbsp;</td></tr></table>
<?php echo '
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7152412-2");
pageTracker._trackPageview();
} catch(err) {}</script>
'; ?>

</body>
</html>