<?php /* Smarty version 2.6.5-dev, created on 2016-10-07 13:40:02
         compiled from admin/articles/add.tpl.html */ ?>
<h3>Добавление новой статьи, раздел "<?php echo $this->_tpl_vars['category']['name']; ?>
"</h3>
<form action="index.php?mode=save_new&id=<?php echo $this->_tpl_vars['category']['category_id']; ?>
" method="POST" onSubmit="if (hasEmptyFields('title', false, 'Заполните форму, пожалуйста.')) return false;" enctype="multipart/form-data">
  <table width="100%"  border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td class="tableHeaderLeft">Заголовок статьи</td>
      <td class="tableRow1"><input name="title" type="text" class="text" id="title" value="" style="width:100%;"></td>
    </tr>
    <tr>
      <td class="tableHeaderLeft">Текст статьи</td>
      <td class="tableRow2"><?php echo $this->_tpl_vars['editor_code']; ?>
</td>
    </tr>
    <tr>
      <td class="tableHeaderLeft">Картинка к статье</td>
      <td class="tableRow1"><input name="image_file" type="file" class="text" id="image_file"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
      	<input name="Submit" type="submit" class="button" value="Добавить">&nbsp;
      	<input type="button" class="button" value="Отмена" onclick="location.href='index.php?mode=articles&id=<?php echo $this->_tpl_vars['category']['category_id']; ?>
'"></td>
    </tr>
  </table>
  </form>