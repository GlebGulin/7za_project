<?php /* Smarty version 2.6.5-dev, created on 2016-09-26 14:54:11
         compiled from admin/pages/edit_page.tpl.html */ ?>
 <h3>�������������� �������� "<?php echo $this->_tpl_vars['page']['title']; ?>
"</h3>
 	<form action="index.php?mode=save_page&page_id=<?php echo $this->_tpl_vars['page']['page_id']; ?>
" method="POST" enctype="multipart/form-data" onSubmit="if (hasEmptyFields('title', false, '��������� �����, ����������.')) return false;">
 		  <table width="100%"  border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td class="tableHeaderLeft">�������� �������� </td>
              <td class="tableRow1"><input name="title" id="title" type="text" class="text" value="<?php echo $this->_tpl_vars['page']['title']; ?>
"></td>
            </tr>
            <tr>
              <td class="tableHeaderLeft">������ �������� </td>
              <td class="tableRow1"><input name="link" type="text" class="text" value="<?php echo $this->_tpl_vars['page']['link']; ?>
"></td>
            </tr>
            <tr>
              <td class="tableHeaderLeft">����� �������� </td>
              <td class="tableRow1"><?php echo $this->_tpl_vars['editor_code']; ?>
</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input type="submit" class="button" value="���������">&nbsp;
                <input type="button" class="button" value="������" onclick="location.href='index.php'"></td>
            </tr>
          </table>
    </form>     