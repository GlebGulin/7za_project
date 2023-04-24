<?php /* Smarty version 2.6.5-dev, created on 2016-09-09 11:51:06
         compiled from CMS/contacts/index.tpl.html */ ?>
<?php if ($this->_tpl_vars['page_msg']): ?>
<div class="messageBox"><?php echo $this->_tpl_vars['page_msg']; ?>
</div>
<?php endif; ?>
<form action="/pages/8/" method="POST" onSubmit="return validateForm();">
<input type="hidden" name="mode" value="send">
<script language="JavaScript" type="text/javascript" src="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
forms.js"></script>
<script language="JavaScript" type="text/javascript"><!--
var msg = 'Пожалуйста, заполните форму';
<?php echo '
function validateForm() {
    if (hasEmptyFields(\'name phone_field subject message captcha_code\', false, msg))
        return false;
    return true;
}
'; ?>

//-->
</script>
<table width="500" border="0" cellpadding="3" cellspacing="0" align="center">
 <tr>
  <td align="left" colspan="2" height="50">Чтобы отправить нам письмо прямо с сайта, заполните эту форму и нажмите кнопку "Отправить". Поля, помеченные звездочкой (<span class="red">*</span>) обязательны для заполнения.</td>
 </tr>
 <tr>
  <td width="150">Ваше имя<span class="red">*</span>:</td>
  <td><input type="text" name="name" id="name" class="text" value="<?php echo $this->_tpl_vars['name']; ?>
"></td>
 </tr>
 <tr>
  <td>Ваш e-mail адрес:</td>
  <td><input type="text" name="email_sender" id="email_sender" class="text" value="<?php echo $this->_tpl_vars['email_sender']; ?>
"></td>
 </tr>
 <tr>
  <td>Контактный телефон*:</td>
  <td><input type="text" name="phone" id="phone_field" class="text" value="<?php echo $this->_tpl_vars['phone']; ?>
"></td>
 </tr>
 <tr>
  <td>Тема сообщения<span class="red">*</span>:</td>
  <td><input type="text" name="subject" id="subject" class="text" value="<?php echo $this->_tpl_vars['subject']; ?>
"></td>
 </tr>
 <tr>
  <td valign="top">Текст сообщения<span class="red">*</span>:</td>
  <td valign="top"><textarea name="message" id="message" rows="7" class="text"><?php echo $this->_tpl_vars['message']; ?>
</textarea></td>
 </tr>
 <tr>
  <td>Введите текст с картинки<span class="red">*</span>:<br /><?php echo $this->_tpl_vars['captcha_image']; ?>
</td>
  <td><input type="text" name="captcha_code" id="captcha_code" class="text" value=""></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td height="50"><input type="submit" value="Отправить"></td>
 </tr>

</table>
</form>