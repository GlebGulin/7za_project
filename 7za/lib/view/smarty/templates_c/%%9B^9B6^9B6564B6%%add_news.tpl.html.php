<?php /* Smarty version 2.6.5-dev, created on 2016-10-07 13:43:02
         compiled from admin/news/add_news.tpl.html */ ?>
<h3>���������� �������</h3>
<form action="index.php?mode=save_new_news" method="POST" onSubmit="if (hasEmptyFields('title_rus', false, '��������� �����, ����������.')) return false;" enctype="multipart/form-data">
  <table width="100%"  border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td class="tableHeaderLeft" width="150">��������� �������</td>
      <td class="tableRow1"><input name="title_rus" type="text" class="text" id="title_rus" value="" style="width:100%;"></td>
    </tr>
    <tr>
      <td class="tableHeaderLeft">����� �������</td>
      <td class="tableRow2"><?php echo $this->_tpl_vars['editor_code_rus']; ?>
</td>
    </tr>
    <tr>
      <td class="tableHeaderLeft" width="150">�������� �������</td>
      <td class="tableRow1"><input name="image_file" type="file" class="text" id="image_file"></td>
    </tr>
    <tr>
      <td class="tableHeaderLeft">���������� �������</td>
      <td class="tableRow1"><input name="visible" type="checkbox" id="visible" value="1" checked></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
      	<input name="Submit" type="submit" class="button" value="��������">&nbsp;
      	<input type="button" class="button" value="������" onclick="location.href='index.php'"></td>
    </tr>
  </table>
  </form>