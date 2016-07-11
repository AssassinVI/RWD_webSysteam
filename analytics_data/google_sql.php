<?php
/* ================================= 連接資料庫 ======================================= */
include '../shared_php/config.php';
session_start();
$case_no=htmlspecialchars($_POST['case_no']);

date_default_timezone_set('Asia/Taipei');
$set_time=date("Y-m-d H:i:s");

$report_week=htmlspecialchars($_POST['report_week']);
$report_month=htmlspecialchars($_POST['report_month']);
$report_total=htmlspecialchars($_POST['report_total']);

//$device_name=htmlspecialchars($_POST['device_name']);
$device_num=htmlspecialchars($_POST['device_num']);

$sex_num=htmlspecialchars($_POST['sex_num']);

$event_name=htmlspecialchars($_POST['event_name']);
$event_num=htmlspecialchars($_POST['event_num']);

$city_name=htmlspecialchars($_POST['city_name']);
$city_num=htmlspecialchars($_POST['city_num']);

$years_zone=htmlspecialchars($_POST['years_zone']);
$year_num=htmlspecialchars($_POST['year_num']);

$src_name=htmlspecialchars($_POST['src_name']);
$src_num=htmlspecialchars($_POST['src_num']);

$user_date=htmlspecialchars($_POST['user_date']);
$user_num=htmlspecialchars($_POST['user_num']);

$device_num=explode(',', $device_num);
   $desktop=$device_num[0];
   $mobile=$device_num[1];
   $tablet=$device_num[2];

$sex_num=explode(',', $sex_num);
   $male=$sex_num[0];
   $female=$sex_num[1];

$result=db_conn("SELECT * FROM google_analytics WHERE case_no='$case_no'");
if (mysql_num_rows($result)<1){

 db_conn("INSERT INTO google_analytics (
                                        case_no,
                                        set_time, 
                                        week_user, 
                                        month_user,  
                                        total_user,
                                        desktop,
                                        mobile,
                                        tablet,
                                        male,
                                        female,
                                        event_name,
                                        event_num,
                                        city_name,
                                        city_num,
                                        years_zone,
                                        year_num,
                                        src_name,
                                        src_num,
                                        user_date,
                                        user_num
                                        ) 
                                VALUES (
                                        '$case_no', 
                                        '$set_time', 
                                        '$report_week', 
                                        '$report_month', 
                                        '$report_total',
                                        '$desktop',
                                        '$mobile',
                                        '$tablet',
                                        '$male',
                                        '$female',
                                        '$event_name',
                                        '$event_num',
                                        '$city_name',
                                        '$city_num',
                                        '$years_zone',
                                        '$year_num',
                                        '$src_name',
                                        '$src_num',
                                        '$user_date',
                                        '$user_num'
                                        )");

}
else{


   db_conn("UPDATE google_analytics SET 
                                     set_time='$set_time',
                                     week_user='$report_week',
                                     month_user='$report_month',
                                     total_user='$report_total',

                                     desktop='$desktop',
                                     mobile='$mobile',
                                     tablet='$tablet',

                                     male='$male',
                                     female='$female',

                                     event_name='$event_name',
                                     event_num='$event_num',

                                     city_name='$city_name',
                                     city_num='$city_num',

                                     years_zone='$years_zone',
                                     year_num='$year_num',

                                     src_name='$src_name',
                                     src_num='$src_num',

                                     user_date='$user_date',
                                     user_num='$user_num'
                                      WHERE case_no='$case_no'");
}


$txt=iconv('utf-8', 'big5', '儲存資料!!');
location_up('../google_analytics_set.php',$txt);

function location_up($location_path,$alert_txt)
{
	//$txt=iconv('utf-8', 'big5', $alert_txt);
   echo "<script>";
   echo "location.replace('".$location_path."');"; //網頁跳轉

   if (!empty($alert_txt)) {
    echo "alert('" . $alert_txt . "');";
   }
   echo "</script>";
}
?>