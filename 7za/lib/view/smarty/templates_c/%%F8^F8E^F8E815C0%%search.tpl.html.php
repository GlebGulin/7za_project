<?php /* Smarty version 2.6.5-dev, created on 2016-09-16 09:07:45
         compiled from admin/products/search.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/products/search.tpl.html', 27, false),)), $this); ?>
<h3>Результаты поиска</h3>

<form action="index.php?mode=search" method="POST" onSubmit="if (hasEmptyFields('keyword', false, 'Введите слово для поиска')) return false;">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeader" colspan="2">Поиск товара</td>
 </tr>
 <tr>
  <td class="tableHeaderLeft">Слово для поиска:</td>
  <td class="tableRow1"><input type="text" name="keyword" id="keyword" value="<?php echo $this->_tpl_vars['keyword']; ?>
" class="input">
   <input type="submit" value="Найти" class="button">
  </td>
 </tr>
</table>
</form>

<table width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr>
  <td class="tableHeader">ID</td>
  <td class="tableHeader">Название продукта</td>
  <td class="tableHeader">Цена</td>
  <td class="tableHeader" width="120">Добавлен</td>
  <td class="tableHeader">Показывать</td>
  <td class="tableHeader">В наличии</td>
 </tr>
 <?php if (isset($this->_foreach['products'])) unset($this->_foreach['products']);
$this->_foreach['products']['total'] = count($_from = (array)$this->_tpl_vars['products']);
$this->_foreach['products']['show'] = $this->_foreach['products']['total'] > 0;
if ($this->_foreach['products']['show']):
$this->_foreach['products']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['products']['iteration']++;
        $this->_foreach['products']['first'] = ($this->_foreach['products']['iteration'] == 1);
        $this->_foreach['products']['last']  = ($this->_foreach['products']['iteration'] == $this->_foreach['products']['total']);
?>
 <tr class="tableRow<?php echo smarty_function_cycle(array('values' => "1,2"), $this);?>
">
  <td align="center"><?php echo $this->_tpl_vars['item']['product_id']; ?>
</td>
  <td align="center"><a href="index.php?mode=edit_product&product_id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
"><?php echo $this->_tpl_vars['item']['product_name']; ?>
</a></td>
  <td align="center"><?php echo $this->_tpl_vars['item']['price']; ?>
</td>
  <td align="center"><?php echo $this->_tpl_vars['item']['added_time']; ?>
</td>
  <td align="center"><?php if ($this->_tpl_vars['item']['shown'] == 1): ?>да<?php else: ?>нет<?php endif; ?></td>
  <td align="center"><?php if ($this->_tpl_vars['item']['absent'] == 1): ?>нет<?php else: ?>есть<?php endif; ?></td>
 </tr>
 <?php endforeach; unset($_from); else: ?>
 <tr>
  <td align="center" colspan="6">Ничего не найдено</td>
 </tr>
 <?php endif; ?>
</table>