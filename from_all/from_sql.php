<?php
/* ================================= 連接資料庫 ======================================= */
require_once '../shared_php/config.php';
require_once '../shared_php/login_session.php';
session_start();

if ($_POST) {
  
	
	$set_time=$_POST['set_time'];
	$record_id=$_POST['record_id'];  //專案-紀錄ID


	$name=$_POST['name'];
	$gender=$_POST['gender'];
	$tel_H=$_POST['tel_H'];
	$tel_O=$_POST['tel_O'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];


	$adds=$_POST['zipcode'].$_POST['county'].$_POST['district'].$_POST['adds'];


	$job=$_POST['job'];
	$job_title=$_POST['job_title'];
	$cust_old=$_POST['cust_old'];


	$job_area=$_POST['job_area'];
	$job_company=$_POST['job_company'];


	$mar_state=$_POST['mar_state'];
	$mar_child=$_POST['mar_child'];
	$mon_income=$_POST['mon_income'];
    $transportation=$_POST['transportation'];


    $live_people=$_POST['live_people'];
    $homeowner=$_POST['homeowner'];
    $house_type=$_POST['house_type'];
    $house_old=$_POST['house_old'];


    $house_pattern=$_POST['house_pattern1'].",".$_POST['house_pattern2'].",".$_POST['house_pattern3'];

    $floor_num=$_POST['floor_num'];


    $media=$_POST['media'];
    $media=implode(',', $media);
    if (!empty($_POST['media_txt'])) { $media.=",".$_POST['media_txt']; }


    $dem_product=$_POST['dem_product'];
    $dem_product=implode(',', $dem_product);
    if (!empty($_POST['dem_product_txt'])) { $dem_product.=",".$_POST['dem_product_txt']; }


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


    $pay_time=$_POST['pay_time'];
    


    $dem_pattern1=$_POST['dem_pattern1'].",".$_POST['dem_pattern2'].",".$_POST['dem_pattern3'];
    $dem_car=$_POST['dem_car'];
    if (!empty($_POST['dem_car_txt'])) { $dem_car.=",".$_POST['dem_car_txt']; }



    $dem_floor=$_POST['dem_floor'];
    $dem_floor=implode(',', $dem_floor);

    $dem_side=$_POST['dem_side'];
    $dem_side=implode(',', $dem_side);


    $pay_num=$_POST['pay_num'];
    $Introduction=$_POST['Introduction'];


    $is_buy=$_POST['is_buy'];
    $buy_name=$_POST['buy_name'];




    $pdo=pdo_conn(); //資料庫連線
    $sql_q=$pdo->prepare("UPDATE from_question SET set_time=:set_time, 
                                                  record_id=:record_id, 
                                                       name=:name, 
                                                     gender=:gender, 
                                                      tel_H=:tel_H, 
                                                      tel_O=:tel_O, 
                                                      phone=:phone, 
                                                      email=:email, 
                                                       adds=:adds, 
                                                        job=:job, 
                                                  job_title=:job_title, 
                                                   cust_old=:cust_old,
                                                   job_area=:job_area, 
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
    $sql_q->bindparam(':set_time',$set_time);
    $sql_q->bindparam(':record_id',$record_id);
    $sql_q->bindparam(':name',$name);
    $sql_q->bindparam(':gender',$gender);
    $sql_q->bindparam(':tel_H',$tel_H);
    $sql_q->bindparam(':tel_O',$tel_O);
    $sql_q->bindparam(':phone',$phone);
    $sql_q->bindparam(':email',$email);
    $sql_q->bindparam(':adds',$adds);
    $sql_q->bindparam(':job',$job);
    $sql_q->bindparam(':job_title',$job_title);
    $sql_q->bindparam(':cust_old',$cust_old);
    $sql_q->bindparam(':job_area',$job_area);
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
    $sql_q->bindparam(':is_buy',$is_buy);
    $sql_q->bindparam(':buy_name',$buy_name);

    $sql_q->execute();

	$pdo=NULL; //關閉資料庫
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
   }
}



?>