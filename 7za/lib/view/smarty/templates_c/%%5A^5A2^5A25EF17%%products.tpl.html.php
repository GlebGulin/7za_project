<?php /* Smarty version 2.6.5-dev, created on 2018-11-14 15:14:31
         compiled from products/products.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'products/products.tpl.html', 1, false),array('modifier', 'decodeRequestValue', 'products/products.tpl.html', 8, false),array('modifier', 'strip_tags', 'products/products.tpl.html', 11, false),array('modifier', 'truncate', 'products/products.tpl.html', 11, false),array('modifier', 'price_format', 'products/products.tpl.html', 16, false),array('function', 'mm_thumbnail', 'products/products.tpl.html', 8, false),)), $this); ?>
<?php if (((is_array($_tmp=@$this->_tpl_vars['products'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, ''))): ?>
<?php if ($this->_tpl_vars['splitMenu']): ?><div align="center" style="padding: 10px;">Страницы: <?php echo $this->_tpl_vars['splitMenu']; ?>
</div><?php endif; ?>
<?php if (isset($this->_foreach['prod_list'])) unset($this->_foreach['prod_list']);
$this->_foreach['prod_list']['total'] = count($_from = (array)$this->_tpl_vars['products']);
$this->_foreach['prod_list']['show'] = $this->_foreach['prod_list']['total'] > 0;
if ($this->_foreach['prod_list']['show']):
$this->_foreach['prod_list']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['prod_list']['iteration']++;
        $this->_foreach['prod_list']['first'] = ($this->_foreach['prod_list']['iteration'] == 1);
        $this->_foreach['prod_list']['last']  = ($this->_foreach['prod_list']['iteration'] == $this->_foreach['prod_list']['total']);
?>
  <div class="product">
    <div class="pr_title"><a href="/product/<?php echo $this->_tpl_vars['item']['product_id']; ?>
/<?php if ($this->_tpl_vars['item']['sefu_title']):  echo $this->_tpl_vars['item']['sefu_title']; ?>
.html<?php endif; ?>"><?php echo $this->_tpl_vars['item']['product_name']; ?>
</a>  
    </div>
    <div style="text-align:center">
      <a href="/product/<?php echo $this->_tpl_vars['item']['product_id']; ?>
/<?php if ($this->_tpl_vars['item']['sefu_title']):  echo $this->_tpl_vars['item']['sefu_title']; ?>
.html<?php endif; ?>" title="<?php echo $this->_tpl_vars['item']['title']; ?>
"><?php echo smarty_function_mm_thumbnail(array('file_id' => $this->_tpl_vars['item']['image_file_id'],'alt' => ((is_array($_tmp=$this->_tpl_vars['item']['product_name'])) ? $this->_run_mod_handler('decodeRequestValue', true, $_tmp) : smarty_modifier_decodeRequestValue($_tmp))), $this);?>
</a>
    </div>
    <div class="pr_description">
      <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['description'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?>
<br />
      <a href="/product/<?php echo $this->_tpl_vars['item']['product_id']; ?>
/<?php if ($this->_tpl_vars['item']['sefu_title']):  echo $this->_tpl_vars['item']['sefu_title']; ?>
.html<?php endif; ?>" class="more">подробнее</a>  </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="price_wraper">
      <tr>
        <td class="price_content"><span class="price">
        <?php if (! $this->_tpl_vars['item']['discount_price']):  echo ((is_array($_tmp=$this->_tpl_vars['item']['price'])) ? $this->_run_mod_handler('price_format', true, $_tmp) : smarty_modifier_price_format($_tmp));  else: ?><del><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['price'])) ? $this->_run_mod_handler('price_format', true, $_tmp) : smarty_modifier_price_format($_tmp)); ?>
</del>&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['discount_price'])) ? $this->_run_mod_handler('price_format', true, $_tmp) : smarty_modifier_price_format($_tmp));  endif; ?></span> грн.    
        </td>
        <td class="to_cart">
        <?php if (! $this->_tpl_vars['item']['absent']): ?>
      <a href="/tocart/<?php echo $this->_tpl_vars['item']['product_id']; ?>
/">в корзину</a> <a href="/tocart/<?php echo $this->_tpl_vars['item']['product_id']; ?>
/"><img src="<?php echo $this->_tpl_vars['URL_IMAGE']; ?>
cart_in.gif" width="27" height="27" border="0" align="absmiddle" /></a>
    <?php else: ?>
    товар ожидается
      <?php endif; ?>    
    </td>
  </tr>
</table>
</div>

<?php if (( $this->_tpl_vars['key']+1 ) % 3 == 0): ?>
<div style="clear:both"></div>
<?php endif; ?>
<?php endforeach; unset($_from); endif; ?>
<div style="clear:both"></div>
<?php if ($this->_tpl_vars['splitMenu']): ?><div align="center" style="padding: 10px;">Страницы: <?php echo $this->_tpl_vars['splitMenu']; ?>
</div><?php endif; ?>
<?php else: ?>
<p>Нет товаров</p>
<?php endif; ?>