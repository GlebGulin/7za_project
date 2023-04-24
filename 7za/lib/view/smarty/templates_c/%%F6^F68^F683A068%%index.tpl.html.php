<?php /* Smarty version 2.6.5-dev, created on 2017-05-15 12:38:52
         compiled from prices/index.tpl.html */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'file_icon', 'prices/index.tpl.html', 5, false),)), $this); ?>
<h1><?php echo $this->_tpl_vars['L_PRICES']; ?>
</h1>
<p><?php echo $this->_tpl_vars['L_CHOOSE_THE_PRICE_FOR_DOWNLOAD']; ?>
</p>
<ul class="green">
<?php if (isset($this->_foreach['prices'])) unset($this->_foreach['prices']);
$this->_foreach['prices']['total'] = count($_from = (array)$this->_tpl_vars['prices']);
$this->_foreach['prices']['show'] = $this->_foreach['prices']['total'] > 0;
if ($this->_foreach['prices']['show']):
$this->_foreach['prices']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['prices']['iteration']++;
        $this->_foreach['prices']['first'] = ($this->_foreach['prices']['iteration'] == 1);
        $this->_foreach['prices']['last']  = ($this->_foreach['prices']['iteration'] == $this->_foreach['prices']['total']);
?>
 <li><a href="<?php echo $this->_tpl_vars['item']['file']['file_url']; ?>
"><?php echo smarty_function_file_icon(array('file_name' => $this->_tpl_vars['item']['file']['file_name']), $this);?>
 <?php echo $this->_tpl_vars['item']['title']; ?>
</a>
<?php endforeach; unset($_from); endif; ?>
</ul>