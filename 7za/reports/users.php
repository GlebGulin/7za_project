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
		header("Content-Disposition: attachment; filename=users.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		$fields = array('added_time', 'surname', 'firstname', 'lastname', 'phone', 'email');
		$query = "SELECT ".implode(", ", $fields)." FROM za_orders;";
		$res = mysql_query($query);
		if ($res) {
			while ($row = mysql_fetch_array($res)) {
				$data = array();
				foreach ($fields as $field) {
					$data[] = $row[$field];
				}
				print(implode("\t", $data)."\n");
			}
			mysql_free_result($res);
		}
	}
	mysql_close();
}
?>
