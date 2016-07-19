<?php
/* ================================= 連接資料庫 ======================================= */
require_once 'config.php';
require_once 'login_session.php';
session_start();

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
	$mon_income=mysql_real_escape_string($_POST['mon_income']);
    $transportation=mysql_real_escape_string($_POST['transportation']);


    $live_people=mysql_real_escape_string($_POST['live_people']);
    $homeowner=mysql_real_escape_string($_POST['homeowner']);
    $house_type=mysql_real_escape_string($_POST['house_type']);
    $house_old=mysql_real_escape_string($_POST['house_old']);


    $house_pattern1=mysql_real_escape_string($_POST['house_pattern1']);
    $house_pattern2=mysql_real_escape_string($_POST['house_pattern2']);
    $house_pattern3=mysql_real_escape_string($_POST['house_pattern3']);
    $floor_num=mysql_real_escape_string($_POST['floor_num']);


    $media=$_POST['media'];
    $media=implode(',', $media);


    $dem_product=$_POST['dem_product'];
    $dem_product=implode(',', $dem_product);


    $dem_floor_num=$_POST['dem_floor_num'];
    $dem_floor_num=implode(',', $dem_floor_num);


    $dem_money=$_POST['dem_money'];
    $dem_money=implode(',', $dem_money);


    $dem_mon_pay=$_POST['dem_mon_pay'];
    $dem_mon_pay=implode(',', $dem_mon_pay);


    $dem_have=$_POST['dem_have'];
    $dem_have=implode(',', $dem_have);


    $pay_motive=$_POST['pay_motive'];
    $pay_motive=implode(',', $pay_motive);


    $pay_time=mysql_real_escape_string($_POST['pay_time']);
    


    $dem_pattern1=mysql_real_escape_string($_POST['dem_pattern1']);
    $dem_pattern2=mysql_real_escape_string($_POST['dem_pattern2']);
    $dem_pattern3=mysql_real_escape_string($_POST['dem_pattern3']);
    $dem_car=mysql_real_escape_string($_POST['dem_car']);
    $dem_car_txt=mysql_real_escape_string($_POST['dem_car_txt']);


    $dem_floor=$_POST['dem_floor'];
    $dem_floor=implode(',', $dem_floor);

    $dem_side=$_POST['dem_side'];
    $dem_side=implode(',', $dem_side);


    $pay_num=mysql_real_escape_string($_POST['pay_num']);
    $Introduction=mysql_real_escape_string($_POST['Introduction']);


    $com_name=mysql_real_escape_string($_POST['com_name']);
    $is_buy=mysql_real_escape_string($_POST['is_buy']);
    $buy_name=mysql_real_escape_string($_POST['buy_name']);

	mysql_close($conn);
}



echo iconv('utf-8', 'big5', $dem_floor_num) ;
echo iconv('utf-8', 'big5', $dem_floor) ;
//echo iconv('utf-8', 'big5', $mar_state) ;
//echo iconv('utf-8', 'big5', $house_type) ;
//echo iconv('utf-8', 'big5', $is_buy) ;

?>