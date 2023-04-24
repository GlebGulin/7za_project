<?php /* Smarty version 2.6.5-dev, created on 2016-09-26 15:35:44
         compiled from admin/products/selector.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'admin/products/selector.tpl.html', 24, false),)), $this); ?>
<html>
<head>
<title>Выбор продукта</title>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
 <link href="<?php echo $this->_tpl_vars['URL_STYLE']; ?>
admin_styles.css" rel="stylesheet" type="text/css">
<SCRIPT src="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
treeview/ua.js"></SCRIPT>
<SCRIPT src="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
treeview/ftiens4.js"></SCRIPT>
<SCRIPT SRC="<?php echo $this->_tpl_vars['URL_SCRIPT']; ?>
treeview/selector.js"></SCRIPT>

  <SCRIPT>

// The following code constructs the tree.
foldersTree = gFld("Категории товаров", "javascript:void(0);");
foldersTree.treeID = "checkboxTree";
var useCheckbox = <?php if ($this->_tpl_vars['mode'] == 'multiple'): ?>true<?php else: ?>false<?php endif; ?>;
var field = '<?php echo $this->_tpl_vars['field']; ?>
';
var cats = new Array();
var subcats = new Array();
<?php if (count($_from = (array)$this->_tpl_vars['categories'])):
    foreach ($_from as $this->_tpl_vars['cat_id'] => $this->_tpl_vars['category']):
?>
cats[<?php echo $this->_tpl_vars['cat_id']; ?>
] = insFld(foldersTree, gFld("<?php echo $this->_tpl_vars['category']['category_name']; ?>
", "javascript:void(0)"))
 <?php if (count($_from = (array)$this->_tpl_vars['category']['subcategories'])):
    foreach ($_from as $this->_tpl_vars['subcat']):
?>
 subcats[<?php echo $this->_tpl_vars['subcat']['subcategory_id']; ?>
] = insFld(cats[<?php echo $this->_tpl_vars['cat_id']; ?>
], gFld("<?php echo $this->_tpl_vars['subcat']['subcategory_name']; ?>
", "javascript:parent.op()"))
  <?php if (count($_from = (array)$this->_tpl_vars['subcat']['products'])):
    foreach ($_from as $this->_tpl_vars['product']):
?>
   generateCheckBox(subcats[<?php echo $this->_tpl_vars['subcat']['subcategory_id']; ?>
], "<?php echo $this->_tpl_vars['product']['product_name']; ?>
", "box<?php echo smarty_function_counter(array(), $this);?>
", <?php echo $this->_tpl_vars['product']['product_id']; ?>
, useCheckbox, <?php if ($this->_tpl_vars['selected'][$this->_tpl_vars['product']['product_id']]): ?>1<?php else: ?>0<?php endif; ?>)
  <?php endforeach; unset($_from); endif; ?>
 <?php endforeach; unset($_from); endif;  endforeach; unset($_from); endif; ?>
  <?php echo '
  var winopener = window.opener;
  function selectItem(value)
  {
      winopener.selectProducts(value,field);
      window.close();
  }

    function submitTreeForm()
    {
        var i = 1;
        var prods = new String();
        while (document.getElementById(\'box\'+i) != undefined)
        {
            if (document.getElementById(\'box\'+i).checked)
                prods += "," + document.getElementById(\'box\'+i).name.substr(4);
            i++
        }
        if (prods.length > 0)
            prods = prods.substr(1);
        selectItem(prods);
    }
  '; ?>

  </SCRIPT>
</head>

<body topmargin="10" bottommargin="0" rightmargin="10" leftmargin="10" bgcolor="#ffffff">
<h3>Выбор продукта</h3>


<form name="ft" method="POST">

 <SCRIPT>initializeDocument()</SCRIPT>
 <NOSCRIPT>
  Необходимо включить поддержку JavaScript для работы этого приложения.
 </NOSCRIPT>

 <br />
 <input type="button" onClick="submitTreeForm()" class="button" value="Взять отмеченные товары">
</form>

</body>
</html>