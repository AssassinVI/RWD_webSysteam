<?php
/* ================================= 連接資料庫 ======================================= */
require_once '../shared_php/config.php';
require_once '../shared_php/login_session.php';

if ($_POST) {
	
// ------------------------------------ 簡易查詢 ----------------------------------------	
  if ($_POST['type']=='bs_search') {  
  	$name='%'.$_POST['name'].'%';
    $phone='%'.$_POST['phone'].'%';
    $email='%'.$_POST['email'].'%';
    $is_buy='%'.$_POST['is_buy'].'%';
    $record_id=$_POST['record_id'];

    $search_array=array();

    $pdo=pdo_conn();

    if ($_POST['start_num']=='undefined' OR $_POST['many_num']=='all' OR empty($_POST['start_num'])) {
        
        $sql_q=$pdo->prepare("SELECT from_id, set_time, name, phone FROM from_question WHERE name LIKE :name AND phone LIKE :phone AND email LIKE :email AND is_buy LIKE :is_buy AND record_id=:record_id");
    }
    else{
        $start_num=(int)$_POST['start_num'];
        $many_num=(int)$_POST['many_num'];
        $sql_q=$pdo->prepare("SELECT from_id, set_time, name, phone FROM from_question WHERE name LIKE :name AND phone LIKE :phone AND email LIKE :email AND is_buy LIKE :is_buy AND record_id=:record_id LIMIT :start_num, :many_num");

        $sql_q->bindparam(':start_num',$start_num, PDO::PARAM_INT);
        $sql_q->bindparam(':many_num',$many_num, PDO::PARAM_INT);
    }
    
    $sql_q->bindparam(':name',$name);
    $sql_q->bindparam(':phone',$phone);
    $sql_q->bindparam(':email',$email);
    $sql_q->bindparam(':is_buy',$is_buy);
    $sql_q->bindparam(':record_id',$record_id);
    $sql_q->execute();

    while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
    	
       array_push($search_array, array('name'=>$row['name'], 'phone'=>$row['phone'], 'from_id'=>$row['from_id'], 'set_time'=>$row['set_time']));
    }
    echo json_encode(array('search_array'=>$search_array));
    $pdo=NULL;
  }


//-------------------------------------- 進階查詢 ----------------------------------------
  elseif ($_POST['type']=='adv_search') {  

  	$record_id=$_POST['record_id']; 
  	$name='%'.$_POST['name'].'%';
  	$set_time_start=$_POST['set_time_start'];
  	$set_time_end=$_POST['set_time_end'];
    $phone='%'.$_POST['phone'].'%';
    $adds='%'.$_POST['adds'].'%';
    $dem_money=explode(',', $_POST['dem_money']);
    $dem_product=explode(',', $_POST['dem_product']);

    $dem_car='%'.$_POST['dem_car'].'%';
    $dem_car_txt='%'.$_POST['dem_car_txt'].'%';
    
    $dem_floor_num=explode(',', $_POST['dem_floor_num']);
    $dem_floor=explode(',', $_POST['dem_floor']);
    $dem_mon_pay=explode(',', $_POST['dem_mon_pay']);
    $dem_side=explode(',', $_POST['dem_side']);
    $dem_have=explode(',', $_POST['dem_have']);
    $pay_motive=explode(',', $_POST['pay_motive']);
    $pay_time=explode(',', $_POST['pay_time']);
    $is_buy='%'.$_POST['is_buy'].'%';
    $media=explode(',', $_POST['media']);

    $sql_query="SELECT from_id, set_time, name, phone FROM from_question WHERE record_id=:record_id AND name LIKE :name ";

    if (!empty($_POST['set_time_start'])) {
    	$sql_query.=" AND set_time>='".$set_time_start."'";
    }
    if (!empty($_POST['set_time_end'])) {
    	$sql_query.=" AND set_time<='".$set_time_end."'";
    }

        $sql_query.=" AND phone LIKE :phone AND adds LIKE :adds";

    for ($i=0; $i < count($dem_money) ; $i++) { 
    	$sql_query.=" AND dem_money LIKE '%".$dem_money[$i]."%'";
    }

    for ($i=0; $i < count($dem_product); $i++) { 
    	$sql_query.=" AND dem_product LIKE '%".$dem_product[$i]."%'";
    }

        $sql_query.=" AND dem_car LIKE :dem_car";
        $sql_query.=" AND dem_car LIKE :dem_car_txt";

    for ($i=0; $i < count($dem_floor_num); $i++) { 
    	$sql_query.=" AND dem_floor_num LIKE '%".$dem_floor_num[$i]."%'";
    }
    for ($i=0; $i < count($dem_floor); $i++) { 
    	$sql_query.=" AND dem_floor LIKE '%".$dem_floor[$i]."%'";
    }
    for ($i=0; $i < count($dem_mon_pay); $i++) { 
    	$sql_query.=" AND dem_mon_pay LIKE '%".$dem_mon_pay[$i]."%'";
    }
    for ($i=0; $i < count($dem_side); $i++) { 
    	$sql_query.=" AND dem_side LIKE '%".$dem_side[$i]."%'";
    }
    for ($i=0; $i < count($dem_have); $i++) { 
    	$sql_query.=" AND dem_have LIKE '%".$dem_have[$i]."%'";
    }
    for ($i=0; $i < count($pay_motive); $i++) { 
    	$sql_query.=" AND pay_motive LIKE '%".$pay_motive[$i]."%'";
    }
    for ($i=0; $i < count($pay_time); $i++) { 
    	$sql_query.=" AND pay_time LIKE '%".$pay_time[$i]."%'";
    }

        $sql_query.=" AND is_buy LIKE :is_buy";

    for ($i=0; $i < count($media); $i++) { 
    	$sql_query.=" AND media LIKE '%".$media[$i]."%'";
    }

   //----------------------------- 取其他資料筆數 -----------------------------------
    if ($_POST['many_num']!='all' OR !empty($_POST['start_num'])) {

        $start_num=(int)$_POST['start_num'];
        $many_num=(int)$_POST['many_num'];
        $sql_query.=" LIMIT :start_num, :many_num";
    }
   
   $search_array=array();

    $pdo=pdo_conn();
    $sql_q=$pdo->prepare($sql_query);
    $sql_q->bindparam(':record_id', $record_id);
    $sql_q->bindparam(':name', $name);
    $sql_q->bindparam(':phone', $phone);
    $sql_q->bindparam(':adds', $adds);
    $sql_q->bindparam(':dem_car', $dem_car);
    $sql_q->bindparam(':dem_car_txt', $dem_car_txt);
    $sql_q->bindparam(':is_buy', $is_buy);
   
   //----------------------------- 取其他資料筆數 -----------------------------------
    if ($_POST['start_num']!='undefined' AND $_POST['many_num']!='all') {
        
     $sql_q->bindparam(':start_num', $start_num, PDO::PARAM_INT);
     $sql_q->bindparam(':many_num', $many_num, PDO::PARAM_INT);
    }
    $sql_q->execute();
    while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
    	
      array_push($search_array, array('name'=>$row['name'], 'phone'=>$row['phone'], 'from_id'=>$row['from_id'], 'set_time'=>$row['set_time']));
    }
    echo json_encode(array('search_array'=>$search_array));
    $pdo=NULL;
  }
	
}




?>