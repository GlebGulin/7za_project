<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:07:28
         compiled from admin/exch_rates/index.tpl.html */ ?>
<h3>Курсы валют</h3>

<form action="index.php?mode=save_rate" method="POST" onSubmit="if (hasEmptyFields('rate_cash rate_bank', false, 'Заполните форму, пожалуйста')) return false;">

  <table width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
        <td class="tableHeaderLeft">Наличные</td>
        <td class="tableRow1"><input type="text" name="rate_cash" id="rate_cash" value="<?php echo $this->_tpl_vars['cash']; ?>
" class="short_text"></td>
    </tr>
    <tr>
        <td class="tableHeaderLeft">Безналичные</td>
        <td class="tableRow1"><input type="text" name="rate_bank" id="rate_bank" value="<?php echo $this->_tpl_vars['bank']; ?>
" class="short_text"></td>
    </tr>
    <tr>
      <td class="tableHeaderLeft">Телефон</td>
      <td class="tableRow1">(
        <input name="phone_pre" type="text" class="short_text" value="<?php echo $this->_tpl_vars['phone_pre']; ?>
" size="4" />
        )
        <input type="text" name="phone_number" value="<?php echo $this->_tpl_vars['phone_number']; ?>
" class="short_text" /></td>
    </tr>    
    <tr>
      <td>&nbsp;</td>
      <td>
      	<br />
      	<input name="Submit" type="submit" class="button" value="Сохранить">&nbsp;
      	<input type="button" class="button" value="Отмена" onclick="location.href='index.php'"></td>
    </tr>
  </table>
</form>