<?php /* Smarty version 2.6.5-dev, created on 2016-10-07 13:58:04
         compiled from admin/news/edit_news.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'admin/news/edit_news.tpl.html', 1, false),array('function', 'mm_image', 'admin/news/edit_news.tpl.html', 14, false),)), $this); ?>
<h3>Редактирование новости "<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['title_rus'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp, ENT_QUOTES, 'cp1251')); ?>
"</h3>
<form action="index.php?mode=save_news&news_id=<?php echo $this->_tpl_vars['item']['news_id']; ?>
" method="POST" onSubmit="if (hasEmptyFields('title_rus title_ukr', false, 'Заполните форму, пожалуйста.')) return false;" enctype="multipart/form-data">
  <table width="100%"  border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td class="tableHeaderLeft">Заголовок новости</td>
      <td class="tableRow1"><input name="title_rus" type="text" class="text" id="title_rus" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['title_rus'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp, ENT_QUOTES, 'cp1251')); ?>
" style="width:100%;"></td>
    </tr>
    <tr>
      <td class="tableHeaderLeft">Текст новости</td>
      <td class="tableRow2"><?php echo $this->_tpl_vars['editor_code_rus']; ?>
</td>
    </tr>
    <tr>
      <td class="tableHeaderLeft" width="150">Картинка новости</td>
      <td class="tableRow1"><?php echo smarty_function_mm_image(array('file_id' => $this->_tpl_vars['item']['image_file_id']), $this);?>
<br><input name="image_file" type="file" class="text" id="image_file"></td>
    </tr>
    <tr>
      <td class="tableHeaderLeft">Показывать новость</td>
      <td class="tableRow1"><input name="visible" type="checkbox" id="visible" value="1"<?php if ($this->_tpl_vars['item']['visible']): ?> checked<?php endif; ?>></td>
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