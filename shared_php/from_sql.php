<?php
if ($_POST) {

	$conn = mysql_connect("localhost", "rxznet_work_test", "xm20926056565") OR die('無法連線'); //資料庫連結
	
	$set_time=mysql_real_escape_string($_POST['set_time']);
	$case_name=mysql_real_escape_string($_POST['case_name']);


	$name=mysql_real_escape_string($_POST['name']);
	$gender=mysql_real_escape_string($_POST['gender']);
	$tel_H=mysql_real_escape_string($_POST['tel_H']);
	$tel_O=mysql_real_escape_string($_POST['tel_O']);
	$phone=mysql_real_escape_string($_POST['phone']);
	$email=mysql_real_escape_string($_POST['email']);


	$adds=mysql_real_escape_string($_POST['zipcode'].$_POST['county'].$_POST['district'].$_POST['adds']);


	$job=mysql_real_escape_string($_POST['job']);
	$job_title=mysql_real_escape_string($_POST['job_title']);
	$cust_old=mysql_real_escape_string($_POST['cust_old']);


	$job_area=mysql_real_escape_string($_POST['job_area']);
	$job_company=mysql_real_escape_string($_POST['job_company']);


	$mar_state=mysql_real_escape_string($_POST['mar_state']);
	$mar_child=mysql_real_escape_string($_POST['mar_child']);

	

	mysql_close($conn);
}


$media=$_POST['media'];
$media=implode(',', $media);
echo iconv('utf-8', 'big5', $media) ;


?>