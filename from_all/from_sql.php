<?php
/* ================================= 連接資料庫 ======================================= */
require_once '../shared_php/config.php';
require_once '../shared_php/login_session.php';
session_start();

if ($_POST) {

  date_default_timezone_set('Asia/Taipei');
  
  $rand=rand(0,99);
  $rand=$rand<10 ? '0'.$rand : $rand;

  $from_id="qf".date("YmdHis").$rand;


	
	$set_time=date("Y-m-d H:i:s");
	$record_id=$_POST['record_id'];  //專案-紀錄ID


	$name=$_POST['name'];
	$gender=!empty($_POST['gender']) ? $_POST['gender'] : "";
	$phone=$_POST['phone'];
	$email=$_POST['email'];


	$adds=$_POST['zipcode'].$_POST['county'].$_POST['district'].$_POST['adds'];


	$job=$_POST['job'];
  $job_txt=$_POST['job_txt'];
	$job_title=$_POST['job_title'];
	$cust_old=$_POST['cust_old'];


	//$job_area=$_POST['job_area'];
	$job_company=$_POST['job_company'];


	$mar_state=!empty($_POST['mar_state']) ? $_POST['mar_state'] : "" ;
	$mar_child=$_POST['mar_child'];
	$mon_income=$_POST['mon_income'];
    $transportation=$_POST['transportation'];


    $live_people=$_POST['live_people'];
    $homeowner=$_POST['homeowner'];
    $house_type=!empty($_POST['house_type']) ? $_POST['house_type'] : "" ;
    $house_old=$_POST['house_old'];


    $house_pattern=$_POST['house_pattern1'];

    $floor_num=$_POST['floor_num'];

   if (!empty($_POST['media'])) {
    
     $media=implode(',', $_POST['media']);
    if (!empty($_POST['media_txt'])) { $media.=",".$_POST['media_txt']; }
   }
   else{ $media=""; }
    

   if (!empty($_POST['dem_product'])) {
    
     $dem_product=implode(',', $_POST['dem_product']);
    if (!empty($_POST['dem_product_txt'])) { $dem_product.=",".$_POST['dem_product_txt']; }
   }
   else{ $dem_product=""; }
   
 
    if (!empty($_POST['dem_floor_num'])){
       $dem_floor_num=implode(',', $_POST['dem_floor_num']);
    }
    else{ $dem_floor_num=""; }
    
    if (!empty($_POST['dem_money'])){
      $dem_money=implode(',', $_POST['dem_money']);
    }
    else{ $dem_money=""; }

    if (!empty($_POST['dem_mon_pay'])){
       $dem_mon_pay=implode(',', $_POST['dem_mon_pay']);
    }
    else{ $dem_mon_pay=""; }
   

   if (!empty($_POST['dem_have'])){
      $dem_have=implode(',', $_POST['dem_have']);
   }
   else{ $dem_have=""; }
   

    if (!empty($_POST['pay_motive'])){
       $pay_motive=implode(',', $_POST['pay_motive']);
    }
    else{ $pay_motive=""; }
    

    $pay_time=!empty($_POST['pay_time']) ? $_POST['pay_time'] : "";
    


    $dem_pattern=$_POST['dem_pattern1'];

    if (!empty($_POST['dem_car'])) {
     
      $dem_car=$_POST['dem_car'];
    if (!empty($_POST['dem_car_txt'])) { $dem_car.=",".$_POST['dem_car_txt']; }
    }
    else{ $dem_car=""; }
    


    if (!empty($_POST['dem_floor'])){
      $dem_floor=implode(',', $_POST['dem_floor']);
    }
    else{ $dem_floor=""; }
    
    
    if (!empty($_POST['dem_side'])){
      $dem_side=implode(',', $_POST['dem_side']);
    }
    else{ $dem_side=""; }
    
    $pay_num=$_POST['pay_num'];
    $Introduction=$_POST['Introduction'];


    $is_buy=$_POST['is_buy'];
    $buy_name=$_POST['buy_name'];


  $pdo=pdo_conn(); //資料庫連線

    if($_POST['sql_type']=="insert"){

     // $sql_q=$pdo->prepare("INSERT INTO from_question (from_id ,set_time) VALUES (:from_id, :set_time)");

         $sql_q=$pdo->prepare("INSERT INTO from_question (
                                                      from_id,
                                                      set_time,
                                                      record_id, 
                                                      name, 
                                                      gender, 
                                                      phone, 
                                                      email, 
                                                      adds, 
                                                      job, 
                                                      job_txt, 
                                                      job_title, 
                                                      cust_old, 
                                                      job_company, 
                                                      mar_state, 
                                                      mar_child, 
                                                      mon_income, 
                                                      transportation, 
                                                      live_people, 
                                                      homeowner, 
                                                      house_type, 
                                                      house_old, 
                                                      house_pattern, 
                                                      floor_num, 
                                                      media, 
                                                      dem_product, 
                                                      dem_floor_num, 
                                                      dem_money, 
                                                      dem_mon_pay, 
                                                      dem_have, 
                                                      pay_motive, 
                                                      pay_time, 
                                                      dem_pattern, 
                                                      dem_car, 
                                                      dem_floor, 
                                                      dem_side, 
                                                      pay_num, 
                                                      Introduction

                                                      ) VALUES ( 
                                                      
                                                      :from_id,
                                                      :set_time,
                                                      :record_id, 
                                                      :name, 
                                                      :gender, 
                                                      :phone, 
                                                      :email, 
                                                      :adds, 
                                                      :job, 
                                                      :job_txt, 
                                                      :job_title, 
                                                      :cust_old, 
                                                      :job_company, 
                                                      :mar_state, 
                                                      :mar_child, 
                                                      :mon_income, 
                                                      :transportation, 
                                                      :live_people, 
                                                      :homeowner, 
                                                      :house_type, 
                                                      :house_old, 
                                                      :house_pattern, 
                                                      :floor_num, 
                                                      :media, 
                                                      :dem_product, 
                                                      :dem_floor_num, 
                                                      :dem_money, 
                                                      :dem_mon_pay, 
                                                      :dem_have, 
                                                      :pay_motive, 
                                                      :pay_time, 
                                                      :dem_pattern, 
                                                      :dem_car, 
                                                      :dem_floor, 
                                                      :dem_side, 
                                                      :pay_num, 
                                                      :Introduction  )");

    }
    else if( $_POST['sql_type']=="update" ){

      $sql_q=$pdo->prepare("UPDATE from_question SET set_time=:set_time, 
                                                  record_id=:record_id, 
                                                       name=:name, 
                                                     gender=:gender, 
                                                      /*tel_H=:tel_H, 
                                                      tel_O=:tel_O,*/ 
                                                      phone=:phone, 
                                                      email=:email, 
                                                       adds=:adds, 
                                                        job=:job, 
                                                    job_txt=:job_txt, 
                                                  job_title=:job_title, 
                                                   cust_old=:cust_old,
                                                  /* job_area=:job_area, */
                                                job_company=:job_company, 
                                                  mar_state=:mar_state, 
                                                  mar_child=:mar_child, 
                                                 mon_income=:mon_income, 
                                             transportation=:transportation, 
                                                live_people=:live_people,
                                                  homeowner=:homeowner,
                                                 house_type=:house_type, 
                                                  house_old=:house_old, 
                                              house_pattern=:house_pattern, 
                                                  floor_num=:floor_num, 
                                                      media=:media, 
                                                dem_product=:dem_product, 
                                              dem_floor_num=:dem_floor_num, 
                                                  dem_money=:dem_money, 
                                                dem_mon_pay=:dem_mon_pay, 
                                                   dem_have=:dem_have, 
                                                 pay_motive=:pay_motive, 
                                                   pay_time=:pay_time, 
                                                dem_pattern=:dem_pattern, 
                                                    dem_car=:dem_car, 
                                                  dem_floor=:dem_floor, 
                                                   dem_side=:dem_side,
                                                    pay_num=:pay_num, 
                                               Introduction=:Introduction, 
                                                     is_buy=:is_buy, 
                                                   buy_name=:buy_name
                                                          ");
    }
        
    $sql_q->bindparam(':set_time',$set_time);
    $sql_q->bindparam(':record_id',$record_id);
    $sql_q->bindparam(':name',$name);
    $sql_q->bindparam(':gender',$gender);

    $sql_q->bindparam(':phone',$phone);
    $sql_q->bindparam(':email',$email);
    $sql_q->bindparam(':adds',$adds);
    $sql_q->bindparam(':job',$job);
    $sql_q->bindparam(':job_txt',$job_txt);
    $sql_q->bindparam(':job_title',$job_title);
    $sql_q->bindparam(':cust_old',$cust_old);

    $sql_q->bindparam(':job_company',$job_company);
    $sql_q->bindparam(':mar_state',$mar_state);
    $sql_q->bindparam(':mar_child',$mar_child);
    $sql_q->bindparam(':mon_income',$mon_income);
    $sql_q->bindparam(':transportation',$transportation);
    $sql_q->bindparam(':live_people',$live_people);
    $sql_q->bindparam(':homeowner',$homeowner);
    $sql_q->bindparam(':house_type',$house_type);
    $sql_q->bindparam(':house_old',$house_old);
    $sql_q->bindparam(':house_pattern',$house_pattern);
    $sql_q->bindparam(':floor_num',$floor_num);
    $sql_q->bindparam(':media',$media);
    $sql_q->bindparam(':dem_product',$dem_product);
    $sql_q->bindparam(':dem_floor_num',$dem_floor_num);
    $sql_q->bindparam(':dem_money',$dem_money);
    $sql_q->bindparam(':dem_mon_pay',$dem_mon_pay);
    $sql_q->bindparam(':dem_have',$dem_have);
    $sql_q->bindparam(':pay_motive',$pay_motive);
    $sql_q->bindparam(':pay_time',$pay_time);
    $sql_q->bindparam(':dem_pattern',$dem_pattern);
    $sql_q->bindparam(':dem_car',$dem_car);
    $sql_q->bindparam(':dem_floor',$dem_floor);
    $sql_q->bindparam(':dem_side',$dem_side);
    $sql_q->bindparam(':pay_num',$pay_num);
    $sql_q->bindparam(':Introduction',$Introduction);


    if ($_POST['sql_type']=="insert"){

       $sql_q->bindparam(':from_id',$from_id);
    }
    elseif ($_POST['sql_type']=="update") {
      
      $sql_q->bindparam(':is_buy',$is_buy);
     $sql_q->bindparam(':buy_name',$buy_name);
    }
    

    $sql_q->execute();

	$pdo=NULL; //關閉資料庫

  if ($_POST['sql_type']=="insert") {
    
     $txt=iconv('utf-8', 'big5', '感謝您耐心填寫');
     location_up('from_view.php?record_id='.$record_id,$txt);
  }
  elseif ($_POST['sql_type']=="update") {
     $txt=iconv('utf-8', 'big5', '更新資料');
     location_up('../from_edit.php?record_id='.$record_id,$txt);
  }
}


/* ============================================================ GET ============================================================= */

if ($_GET) {
   
   if ($_GET['type']=='list') {  //---------------- 顧客表單 ------------------
       
       $from_array=array();

       $pdo=pdo_conn();
       $sql_q=$pdo->prepare("SELECT from_id, set_time, name, tel_H, phone FROM from_question WHERE record_id=:record_id");
       $sql_q->bindparam(":record_id", $_GET['record_id']);
       $sql_q->execute();
       while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
           
            array_push($from_array, array('from_id'=>$row['from_id'], 
                                         'set_time'=>$row['set_time'], 
                                             'name'=>$rwo['name'], 
                                            'tel_H'=>$rwo['tel_H'], 
                                            'phone'=>$rwo['phone']));
       }

       echo json_encode(array('from_array'=>$from_array));

       $pdo=NULL;
   }
}


/* =============================== 網頁跳轉 ======================================== */
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