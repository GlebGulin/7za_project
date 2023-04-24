<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:06:10
         compiled from admin/main.tpl.html */ ?>
<html>
<head>
<title>Admin :: Магазин 7za</title>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
 <link href="<?php echo $this->_tpl_vars['URL_STYLE']; ?>
admin_styles.css" rel="stylesheet" type="text/css">
 <link href="<?php echo $this->_tpl_vars['URL_STYLE']; ?>
calendar.css" rel="stylesheet" type="text/css">
 <script language="JavaScript" type="text/javascript" src="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
forms.js"></script>
</head>

<body topmargin="0" bottommargin="0" rightmargin="0"  leftmargin="0" bgcolor="#ffffff">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%" align="center">
 <tr>
  <td align="center" class="top_line_left"><a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
admin/logo.gif" border="0" align="absmiddle"></a></td>
  <td height="100" class="top_line" align="left">
   7za. Административный интерфейс
  </td>
 </tr>
 <tr>
  <td width="15%" valign="top" class="menu_column">
   <!-- menu column -->
   <a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/products/">Каталог продукции</a>
   <a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/products/parameters.php">Группы параметров</a>
   <a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/news/">Новости</a>
   <a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/articles/">Статьи</a>
   <a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/pages/">Страницы</a>
   <a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/orders/">Заказы</a>
   <a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/orders/archive.php">Архив заказов</a>
   <a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/comments/">Комментарии</a>
   <a href="<?php echo $this->_tpl_vars['URL_ROOT']; ?>
admin/exch_rates/">Курсы и телефон</a>
  </td>
  <td width="85%" valign="top" class="content_column">
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/messages.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['contentFile'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  </td>
 </tr>
</table>
</body>
</html>