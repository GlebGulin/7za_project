<?php /* Smarty version 2.6.5-dev, created on 2016-09-08 22:12:05
         compiled from products/product.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'mm_image', 'products/product.tpl.html', 4, false),array('function', 'mm_image_preview', 'products/product.tpl.html', 18, false),array('function', 'cycle', 'products/product.tpl.html', 30, false),array('function', 'eval', 'products/product.tpl.html', 44, false),array('modifier', 'decodeRequestValue', 'products/product.tpl.html', 4, false),array('modifier', 'price_format', 'products/product.tpl.html', 10, false),array('modifier', 'date_format', 'products/product.tpl.html', 44, false),array('modifier', 'nl2br', 'products/product.tpl.html', 46, false),array('modifier', 'beautify', 'products/product.tpl.html', 46, false),)), $this); ?>
<h1><?php echo $this->_tpl_vars['product']['product_name']; ?>
</h1>
<table border="0" width="100%" align="center" cellpadding="10" cellspacing="0">
<tr>
  <td align="center" valign="top"><?php echo smarty_function_mm_image(array('file_id' => $this->_tpl_vars['product']['image_file_id'],'alt' => ((is_array($_tmp=$this->_tpl_vars['product']['product_name'])) ? $this->_run_mod_handler('decodeRequestValue', true, $_tmp) : smarty_modifier_decodeRequestValue($_tmp))), $this);?>
</td>
  <td align="left" valign="top" >
    <?php if (! $this->_tpl_vars['product']['absent']): ?><div class="to_cart"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "products/to_cart.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div><?php endif; ?>
   <strong>
    <?php if ($this->_tpl_vars['product']['absent']): ?><span class="price"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
clock.gif" border="0" alt="Товар ожидается" align="absmiddle"> товар ожидается</span>
    <?php else: ?>
    Цена: <span class="price"><?php if ($this->_tpl_vars['product']['discount_price']): ?><del><?php endif;  echo ((is_array($_tmp=$this->_tpl_vars['product']['price'])) ? $this->_run_mod_handler('price_format', true, $_tmp, "") : smarty_modifier_price_format($_tmp, ""));  if ($this->_tpl_vars['product']['discount_price']): ?></del><?php endif; ?> грн </span> <?php if ($this->_tpl_vars['product']['discount_price']): ?><br />Сегодня: <span class="price"><?php echo ((is_array($_tmp=$this->_tpl_vars['product']['discount_price'])) ? $this->_run_mod_handler('price_format', true, $_tmp, "") : smarty_modifier_price_format($_tmp, "")); ?>
 грн. </span><?php endif; ?>
    <?php endif; ?>
   </strong>
    <div><?php echo $this->_tpl_vars['product']['description']; ?>
</div>
    <?php if ($this->_tpl_vars['product']['add_photos']): ?>
    <div align="center"><strong>Другие фотографии <?php echo $this->_tpl_vars['product']['product_name']; ?>
</strong></div>
    <div align="center" style="padding:10px 0 20px 0;">
    <?php if (count($_from = (array)$this->_tpl_vars['product']['add_photos'])):
    foreach ($_from as $this->_tpl_vars['photo']):
?>
    <?php echo smarty_function_mm_image_preview(array('file_id' => $this->_tpl_vars['photo']), $this);?>

    <?php endforeach; unset($_from); endif; ?>
    </div>
    <?php endif; ?>
  </td>
 </tr>
</table>
  <?php if ($this->_tpl_vars['product']['parameters']): ?>
  <h1>Характеристики <?php echo $this->_tpl_vars['product']['product_name']; ?>
</h1>
     <table width="90%" border="0" cellpadding="3" cellspacing="0" class="grid" align="center">
       <?php if (isset($this->_foreach['params'])) unset($this->_foreach['params']);
$this->_foreach['params']['total'] = count($_from = (array)$this->_tpl_vars['product']['parameters']);
$this->_foreach['params']['show'] = $this->_foreach['params']['total'] > 0;
if ($this->_foreach['params']['show']):
$this->_foreach['params']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['param']):
        $this->_foreach['params']['iteration']++;
        $this->_foreach['params']['first'] = ($this->_foreach['params']['iteration'] == 1);
        $this->_foreach['params']['last']  = ($this->_foreach['params']['iteration'] == $this->_foreach['params']['total']);
?>
       <?php if ($this->_tpl_vars['param']['value'] || $this->_tpl_vars['param']['is_header']): ?>
       <tr class="tableRow<?php echo smarty_function_cycle(array('values' => "1,2"), $this);?>
">
       <?php if ($this->_tpl_vars['param']['is_header']): ?>
         <td colspan="2"><strong><?php echo $this->_tpl_vars['param']['parameter_name']; ?>
</strong></td>
       <?php else: ?>
         <td width="50%"><?php echo $this->_tpl_vars['param']['parameter_name']; ?>
:</td>
         <td><?php echo $this->_tpl_vars['param']['value']; ?>
 <?php echo $this->_tpl_vars['param']['unit']; ?>
</td>
       <?php endif; ?>
       </tr>
       <?php endif; ?>
       <?php endforeach; unset($_from); endif; ?>
     </table>
  <?php endif; ?>
  <h1>Отзывы к <?php echo $this->_tpl_vars['product']['product_name']; ?>
</h1>
   <?php if (count($_from = (array)$this->_tpl_vars['comments'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
   <div class="comment_global"><?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['item']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m") : smarty_modifier_date_format($_tmp, "%m")),'assign' => 'month_num'), $this);?>

    <div class="comment_header"><strong><?php echo $this->_tpl_vars['item']['author']; ?>
</strong> писал(а) <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e") : smarty_modifier_date_format($_tmp, "%e")); ?>
 <?php echo $this->_tpl_vars['monthNames'][$this->_tpl_vars['month_num']]; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['added_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
 г.:</div>
    <div class="comment_text"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['comment_text'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('beautify', true, $_tmp) : smarty_modifier_beautify($_tmp)); ?>
</div>
   </div>
   <?php endforeach; unset($_from); else: ?>
   <div>Нет отзывов</div>
   <?php endif; ?>
   <?php if ($this->_tpl_vars['allow_posting']): ?>
   <form action="/products/index.php?product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
&mode=save_comment" method="POST" onSubmit="if (hasEmptyFields('author comment_text check_image', false, 'Заполните форму, пожалуйста')) return false;">
   <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr>
     <td class="tableHeaderLeft" width="50%">Ваше имя:</td>
     <td><input type="text" name="author" id="author" class="field" style="width:200px;"></td>
    </tr>
    <tr>
     <td class="tableHeaderLeft">Текст комментария:</td>
     <td><textarea name="comment_text" id="comment_text" rows="3"  class="field" style="width:200px;"></textarea></td>
    </tr>
    <tr>
     <td class="tableHeaderLeft">Введите код с картинки: <?php echo $this->_tpl_vars['captcha_image']; ?>
</td>
     <td><input type="text" name="check_image" id="check_image"  class="field" style="width:200px;"></td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td><input type="submit" value="Добавить комментарий" /></td>
    </tr>
   </table>
   </form>
   <?php endif; ?>
 <?php if ($this->_tpl_vars['connected']): ?>
 <h1>С этим товаром мы рекомендуем:</h1>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "products/products.tpl.html", 'smarty_include_vars' => array('products' => $this->_tpl_vars['connected'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <?php endif; ?>