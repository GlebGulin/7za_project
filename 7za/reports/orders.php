<?php
include('../lib/config.inc.php');

define ( 'DB_SERVER'		, 'localhost' );
define ( 'DB_USER'			, '7za' );
define ( 'DB_PASSWORD'		, 'pF95pUwj8HAWsmmb' );
define ( 'DB_NAME'		    , '7za' );

if (mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD)) {
	if (mysql_select_db(DB_NAME)) {
//		header("Content-Type: text/plain");
//		header("Content-Type: application/vnd.ms-excel; charset=windows-1251");
		header("Content-Type: application/msexcel; charset=windows-1251");
		header("Content-Disposition: attachment; filename=orders.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);

		$fields = array('za_orders.added_time AS order_date', 'za_orders.order_id AS order_no', 'za_orders.surname', 'za_orders.firstname', 'za_orders.lastname', 'za_orders.phone', 'za_orders.email',
			'za_product.product_name', 'za_order_products.product_qnt AS qty', 'za_order_products.product_price AS price'
		);
		$query = "SELECT ".implode(", ", $fields)." FROM za_orders, za_order_products, za_product WHERE za_orders.order_id = za_order_products.order_id AND za_order_products.product_id = za_product.product_id;";
		$res = mysql_query($query);
		if ($res) {
			while ($row = mysql_fetch_array($res)) {
				$data = array();
				foreach (array_keys($row) as $key) {
					if (!is_numeric($key)) $data[] = $row[$key];
				}
				print(implode("\t", $data)."\n");
			}
			mysql_free_result($res);
		}
	}
	mysql_close();
}
?>
