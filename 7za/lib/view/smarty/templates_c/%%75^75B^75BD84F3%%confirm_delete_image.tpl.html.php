<?php /* Smarty version 2.6.5-dev, created on 2016-12-20 11:43:34
         compiled from Modules/MediaManager/confirm_delete_image.tpl.html */ ?>
<html>
<head>
 <title>�������� �����������</title>
</head>
<body onBlur="window.close()" bgcolor="#FFFFFF" topmargin="0" bottommargin="0" rightmargin="0" leftmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
 <tr>
  <td height="20" bgcolor="#3333CC">&nbsp;</td>
 </tr>
 <tr>
  <td align="center" valign="middle"><font style="font-family: Verdana, Arial, Helvetica, Geneva, sans-serif; font-size: 11px;">������� �����������?</font><br>
    <br>
   <button onClick="location.href='show_image.php?mode=delete&confirm=1&file=<?php echo $this->_tpl_vars['file_id']; ?>
';">��</button>&nbsp;��
   <button onClick="window.close();">���</button>
  </td>
 </tr>
 <tr>
  <td height="20" bgcolor="#3333CC">&nbsp;</td>
 </tr>
</table>
</body>
</html>