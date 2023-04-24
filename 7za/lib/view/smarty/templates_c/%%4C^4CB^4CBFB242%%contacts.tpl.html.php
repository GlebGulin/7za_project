<?php /* Smarty version 2.6.5-dev, created on 2016-10-07 22:57:42
         compiled from mails/contacts.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'mails/contacts.tpl.html', 8, false),)), $this); ?>
<html>
<body>
С контактной формы сайта <?php echo $_SERVER['HTTP_HOST']; ?>
 поступило сообщение:<br /><br />
Имя отправителя: <?php echo $this->_tpl_vars['name']; ?>
<br />
<?php if ($this->_tpl_vars['email']): ?>E-mail: <?php echo $this->_tpl_vars['email']; ?>
<br /><?php endif;  if ($this->_tpl_vars['phone']): ?>Контактный телефон: <?php echo $this->_tpl_vars['phone']; ?>
<br /><?php endif; ?>
Тема сообщения: <?php echo $this->_tpl_vars['subject']; ?>
<br /><br />
<?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

</body>
</html>