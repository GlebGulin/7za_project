<?php /* Smarty version 2.6.5-dev, created on 2018-01-16 14:41:44
         compiled from admin/comments/edit.tpl.html */ ?>
<h3>Редактирование комментария</h3>
<form action="index.php?mode=save&id=<?php echo $this->_tpl_vars['comment']['comment_id']; ?>
" method="POST" enctype="multipart/form-data" name="frm" onSubmit="if (hasEmptyFields('author comment_text', false, 'Заполните форму, пожалуйста')) return false;">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeaderLeft">Автор</td>
  <td class="tableRow1"><input type="text" name="author" id="author" class="input" value="<?php echo $this->_tpl_vars['comment']['author']; ?>
"></td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">Комментарий</td>
  <td class="tableRow1"><textarea name="comment_text" id="comment_text" class="input" style="width: 100%;"><?php echo $this->_tpl_vars['comment']['comment_text']; ?>
</textarea></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td><br><input type="submit" class="button" value="Сохранить">&nbsp; <input type="button" onClick="location.href='index.php'; return false;" class="button" value="Отмена"></td>
 </tr>
</table>
</form>