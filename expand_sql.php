<?php

/* ================================= 連接資料庫 ======================================= */
require_once 'shared_php/config.php';
require_once 'shared_php/phpmailer/class.phpmailer.php';//PHPmailer
session_start();

if ($_POST) {
	
	/* ==================================== 擴充紀錄表 =========================================== */
	if ($_POST['page']=='expand_record') {
		
		$tool_id=addslashes($_POST['tool_id']);
		$case_id=addslashes($_POST['case_id']);
        
        $result=db_conn("SELECT * FROM expand_record WHERE case_id='$case_id' AND tool_id='$tool_id'");
        if (mysql_num_rows($result)<1) {
        	
            $rand=rand(0,999);
            if ($rand<10) {
               $rand='00'.$rand;

            }elseif ($rand<100) {
               $rand='0'.$rand;
            }

        	$record_id='rc'.date('YmdHis').$rand; 

            db_conn("INSERT INTO expand_record (record_id, case_id, tool_id, is_use) VALUES ('$record_id', '$case_id', '$tool_id', '1')");
            echo "1";
        }
        else{

        	while ($row=mysql_fetch_array($result)) {
        		
        		if ($row['is_use']==0) {
        			
        			db_conn("UPDATE expand_record SET is_use='1' WHERE case_id='$case_id' AND tool_id='$tool_id'");
        			echo "1";
        		}else{
                    db_conn("UPDATE expand_record SET is_use='0' WHERE case_id='$case_id' AND tool_id='$tool_id'");
                    echo "0";
        		} 
        	}
        }
	}

  /* =========================================== 地圖(食醫住行育樂) ============================================ */  
    elseif ($_POST['page']=='edit_map_btn') {
        
        $record_id=addslashes($_POST['record_id']);
        $map_food=addslashes($_POST['map_food']);
        $map_hospital=addslashes($_POST['map_hospital']);
        $map_home=addslashes($_POST['map_home']);
        $map_traffic=addslashes($_POST['map_traffic']);
        $traffic_url=addslashes($_POST['traffic_url']);
        $map_school=addslashes($_POST['map_school']);
        $map_fun=addslashes($_POST['map_fun']);
        $who_other=addslashes($_POST['who_other']);
        $map_other_name=addslashes($_POST['map_other_name']);
        $other_keyword=addslashes($_POST['other_keyword']);
        $btn_style=addslashes($_POST['btn_style']);

        $result_sel=db_conn("SELECT record_id FROM google_map_btn WHERE record_id='$record_id'");
        if(mysql_num_rows($result_sel)<1){

            db_conn("INSERT INTO google_map_btn ( 
                                                  record_id, 
                                                  map_food, 
                                                  map_hospital, 
                                                  map_home, 
                                                  map_traffic, 
                                                  traffic_url,
                                                  map_school,
                                                  map_fun,
                                                  who_other,
                                                  map_other_name,
                                                  other_keyword,
                                                  btn_style
                                                ) 
                                                VALUES (
                                                         '$record_id',
                                                         '$map_food',
                                                         '$map_hospital',
                                                         '$map_home',
                                                         '$map_traffic',
                                                         '$traffic_url',
                                                         '$map_school',
                                                         '$map_fun',
                                                         '$who_other',
                                                         '$map_other_name',
                                                         '$other_keyword',
                                                         '$btn_style'
                                                                         )");
        }
        else{

            db_conn("UPDATE google_map_btn SET    
                                                   map_food='$map_food',
                                               map_hospital='$map_hospital',
                                                   map_home='$map_home',
                                                map_traffic='$map_traffic',
                                                traffic_url='$traffic_url',
                                                 map_school='$map_school',
                                                    map_fun='$map_fun',
                                                  who_other='$who_other',
                                             map_other_name='$map_other_name',
                                              other_keyword='$other_keyword',
                                                  btn_style='$btn_style' 

                                                    WHERE  record_id='$record_id' ");
        }
    }
}

?>