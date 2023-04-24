<?php /* Smarty version 2.6.5-dev, created on 2016-09-26 14:54:11
         compiled from admin/pages/edit_page.tpl.html */ ?>
 <h3>Редактирование страницы "<?php echo $this->_tpl_vars['page']['title']; ?>
"</h3>
 	<form action="index.php?mode=save_page&page_id=<?php echo $this->_tpl_vars['page']['page_id']; ?>
" method="POST" enctype="multipart/form-data" onSubmit="if (hasEmptyFields('title', false, 'Заполните форму, пожалуйста.')) return false;">
 		  <table width="100%"  border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td class="tableHeaderLeft">Название страницы </td>
              <td class="tableRow1"><input name="title" id="title" type="text" class="text" value="<?php echo $this->_tpl_vars['page']['title']; ?>
"></td>
            </tr>
            <tr>
              <td class="tableHeaderLeft">Ссылка перехода </td>
              <td class="tableRow1"><input name="link" type="text" class="text" value="<?php echo $this->_tpl_vars['page']['link']; ?>
"></td>
            </tr>
            <tr>
              <td class="tableHeaderLeft">Текст страницы </td>
              <td class="tableRow1"><?php echo $this->_tpl_vars['editor_code']; ?>
</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input type="submit" class="button" value="Сохранить">&nbsp;
                <input type="button" class="button" value="Отмена" onclick="location.href='index.php'"></td>
            </tr>
          </table>
    </form>     