<?php
$error=iconv('utf-8', 'big5', '無法連線');
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 公司資料庫連線 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
function db_conn($query) {
	$conn = mysql_connect("localhost", "rxznet2_admin", "xm20926056565") OR die($error); //資料庫連結
	$db = mysql_select_db("rxznet2_system_db", $conn); //選定資料庫
	mysql_query("SET NAMES 'UTF8'");
	return mysql_query($query);
	mysql_close($conn);
}
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 家裡資料庫連線 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
function home_db_conn($query) {
	$conn = mysql_connect("localhost", "root", "") OR die($error); //資料庫連結
	$db = mysql_select_db("rxznet_system_db", $conn); //選定資料庫
	mysql_query("SET NAMES 'UTF8'");
	return mysql_query($query);
	mysql_close($conn);
}


/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ PDO連線 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

function pdo_conn()
{
	$dsn="mysql:host=localhost;dbname=rxznet2_system_db";
    $db = new PDO($dsn, 'rxznet2_admin','xm20926056565' );
    $db->exec("SET NAMES UTF8");
    return $db;
}

?>