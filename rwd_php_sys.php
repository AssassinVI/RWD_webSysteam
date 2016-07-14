<?php

/* ================================= 連接資料庫 ======================================= */
include 'shared_php/config.php';
include 'shared_php/create_file.php'; //產生資料夾方法
include 'shared_php/pclzip.lib.php'; //zip解壓縮
include 'shared_php/phpmailer/class.phpmailer.php';//PHPmailer
require_once 'shared_php/check_phone.php'; //判斷手機媒體
session_start();


if ($_POST) {
/* ===================================== 登入系統 =============================================== */
	if ($_POST['page'] == 'login') {
    
    
    //----------------GOOGLE recaptcha 驗證程式 --------------------
    if (!empty($_POST['g-recaptcha-response'])) {
      
      $ReCaptchaResponse=filter_input(INPUT_POST, 'g-recaptcha-response');
      $Response=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6Ldt2SETAAAAAM4-x875Zk7-EAwyW_Fyzn9KWT-w&response='.$ReCaptchaResponse);
      $re_code = json_decode($Response, true);

      if ($re_code['success']!='1') {
        
         $txt=iconv('utf-8', 'big5', '請確定您不是機器人');
         location_up('login.php',$txt);
         exit();
      }
    }
    else{
      
      $txt=iconv('utf-8', 'big5', '請確定您不是機器人');
         location_up('login.php',$txt);
         exit();
    }
    //----------------GOOGLE recaptcha 驗證程式 --------------------


		$user_id = addslashes($_POST['user_id']);
		$user_pwd = addslashes($_POST['user_pwd']);
		$result = db_conn("SELECT User_Name, User_id, competence, com_id, case_id FROM admin_user WHERE login_id='$user_id' and login_pwd='$user_pwd'");

		if (mysql_num_rows($result)>0) {
			while ($row = mysql_fetch_array($result)) {
				$userName = $row['User_Name'];
				$user_id=$row['User_id'];
        $competence=$row['competence'];
        $com_id=$row['com_id'];
        $case_id=$row['case_id'];
			}
      
       $_SESSION['login'] = 'ok';
      $_SESSION['competence'] = $competence;
      $_SESSION['name'] = $userName;
      $_SESSION['user_id']=$user_id;
      $_SESSION['com_id']=$com_id;
      $_SESSION['case_id']=$case_id;

      $txt=iconv('utf-8', 'big5', '歡迎'.$userName.'登入~~~');
      echo "<script >";
      echo "alert('".$txt."');";

      /* ============================ 權限判斷 ================================== */
      if (check_mobile()) {
        
         if ($competence=='admin') {
           echo "location.replace('admin_user.php');";
         }
         elseif($competence=='user'){
           echo "location.replace('admin_project_ph.php');";
         }
         elseif(($competence=='case') OR ($competence=='company')){
           echo "location.replace('admin_project_phcs.php');";
         }
      }
      else{

         if ($competence=='admin') {
           echo "location.replace('admin_user.php');";
         }
         elseif(($competence=='user') OR ($competence=='company')){
           echo "location.replace('admin_project.php');";
         }
         elseif($competence=='case'){
           echo "location.replace('admin_project.php');";
         }
      }
      
      
      echo "</script>";


		}else{

      $txt=iconv('utf-8', 'big5', '帳號或密碼錯誤!!');
      echo "<script >";
      echo "alert('".$txt."');";
      echo "window.history.back();";
      echo "</script>";

    }
	}


/* =================================== 使用者 =============================================== */
  elseif ($_POST['page'] == 'admin_user') {
     
     $User_Name=addslashes($_POST['User_name']);
     $User_phone=addslashes($_POST['User_phone']);
     $User_adds=addslashes($_POST['User_adds']);
     $login_id=addslashes($_POST['login_id']);
     $login_pwd=addslashes($_POST['login_pwd']);
     $competence=addslashes($_POST['sel_cpe']);
     if (empty($_POST['sel_com'])) {
       
       $com_id=addslashes($_POST['sel_com_case']);
     }else{

       $com_id=addslashes($_POST['sel_com']);
     }
     $case_id=addslashes($_POST['sel_case']);

     /* ##################### 給使用者ID ###################### */

      $result = db_conn("SELECT User_id FROM admin_user WHERE User_id LIKE 'us".date('Ymd')."%' ORDER BY User_id DESC LIMIT 1" );
          if (mysql_num_rows($result)<1) {

            $User_id='us'.date('Ymd').'001';
          }
          else{

            while ($row=mysql_fetch_array($result)) {

                $row_user=$row['User_id'];
             }

             $use_id_down =(int)substr($row_user, 10);
              $sum=$use_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $User_id='us'.date('Ymd').$sum;
          }


     if ( empty($_POST['User_id']) ) {

        $check_id=db_conn("SELECT * FROM admin_user WHERE login_id='$login_id'"); //判斷有無重複密碼
      if (mysql_num_rows($check_id)<1) {
        
         db_conn("INSERT INTO admin_user (User_id, User_Name, User_phone, User_adds, login_id, login_pwd, competence, com_id, case_id)VALUES ('$User_id', '$User_Name', '$User_phone', '$User_adds', '$login_id', '$login_pwd', '$competence', '$com_id', '$case_id')");

          $txt=iconv('utf-8', 'big5', '新增使用者');
          location_up('admin_user.php',$txt);
      }
      else{

          $txt=iconv('utf-8', 'big5', '此帳號已註冊!!');
          location_up('admin_user.php',$txt);
      }
            
    }
    else{

        $User_id=$_POST['User_id'];

       db_conn("UPDATE admin_user SET User_Name='$User_Name', User_phone='$User_phone', User_adds='$User_adds', login_id='$login_id',  competence='$competence', com_id='$com_id', case_id='$case_id' WHERE User_id='$User_id'");

        $txt=iconv('utf-8', 'big5', '更新使用者');
        location_up('admin_user.php',$txt);
    }     
      
  }

/* ====================================== 公司 ================================================= */ 
  elseif ($_POST['page'] == 'company') {

    $User_id=$_SESSION['user_id'];
    $com_name=addslashes($_POST['com_name']);
    $old_logo=addslashes($_POST['old_logo']);
    

    /* ##################### 給公司ID ###################### */

      $result = db_conn("SELECT com_id FROM company WHERE com_id LIKE 'cm".date('Ymd')."%' ORDER BY com_id DESC LIMIT 1" );
          if (mysql_num_rows($result)<1) {

            $com_id='cm'.date('Ymd').'001';
          }
          else{

            while ($row=mysql_fetch_array($result)) {

                $row_com=$row['com_id'];
             }

             $use_id_down =(int)substr($row_com, 10);
              $sum=$use_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $com_id='cm'.date('Ymd').$sum;
          }

   if (empty($_POST['com_id'])) {

      if (!empty($_FILES['com_LOGO']['name'])) { $com_logo=$com_id.".jpg"; }

        db_conn("INSERT INTO company (User_id, com_id, com_name, com_logo) VALUES ('$User_id', '$com_id', '$com_name', '$com_logo')");
          $txt=iconv('utf-8', 'big5', '新增公司');
          location_up('admin_com.php',$txt);
   }
   else{
       $com_id=addslashes($_POST['com_id']);

       if (!empty($_FILES['com_LOGO']['name'])) { $com_logo=$com_id.".jpg"; }
       elseif (!empty($old_logo)) { $com_logo=$com_id.".jpg"; }

       db_conn("UPDATE company SET com_name='$com_name', com_logo='$com_logo' WHERE com_id='$com_id'");
          $txt=iconv('utf-8', 'big5', '更新公司');
          location_up('admin_com.php',$txt);
   } 
  
  if (!empty($_FILES['com_LOGO']['name'])) {
     
     file_upload_single('com_LOGO',$com_id,$com_logo);
  }
   
  }


/* ====================================== 建案 ================================================= */	

	elseif ($_POST['page'] == 'build_case') {
		$User_id=$_SESSION['user_id'];
    $com_id=addslashes($_POST['sel_com']);
		$case_name=addslashes($_POST['case_name']);

		if (empty($_POST['google_an'])) {
			$google_an='n';
		}else{
			$google_an=addslashes($_POST['google_an']);
		}

    $google_code=addslashes($_POST['google_code']);
    $google_view_code=addslashes($_POST['google_view_code']);
		$build_com=addslashes($_POST['build_com']);
		$Consignment=addslashes($_POST['Consignment']);
    $marquee=addslashes($_POST['marquee']);
		$format=addslashes($_POST['format']);
		$floor=addslashes($_POST['floor']);
		$build_adds=addslashes($_POST['build_adds']);
		$bu_phone=addslashes($_POST['bu_phone']);
    $line_tool=addslashes($_POST['line_tool']);
		$bu_line=addslashes($_POST['bu_line']);
		//$bu_fb=addslashes($_POST['bu_fb']);
    $activity_img=addslashes($_POST['activity_img']);
    $activity_song=addslashes($_POST['activity_song']);
    $old_case_logo=addslashes($_POST['old_case_logo']);


        $other=addslashes($_POST['other']);
        $inOrup=addslashes($_POST['inOrup']);


/* ##################### 給建案ID ###################### */

        $result = db_conn("SELECT case_id FROM build_case WHERE case_id LIKE 'cs".date('Ymd')."%' ORDER BY case_id DESC LIMIT 1" );
        	while ($row=mysql_fetch_array($result)) {

        		$row_case=$row['case_id'];
        	}

        	if (empty($row_case)) {
        			$case_id='cs'.date('Ymd').'001';

        		}else{
        			$case_id_down =(int)substr($row_case, 10);

        			$sum=$case_id_down+1;
                    if ($sum<10) {
                    	$sum="00".$sum;
                    }elseif ($sum<100) {
                    	$sum="0".$sum;
                    }
                    $case_id='cs'.date('Ymd').$sum;
        		}


 /* ################### 新增建案 ################# */	       		


        if ($inOrup=='insert') {

          if (!empty($_FILES['case_logo']['name'])) { $case_logo=$case_id.".jpg"; }

        	$result = db_conn("INSERT INTO build_case (User_id, com_id, case_name, google_an, google_code, google_view_code, build_com, Consignment, marquee,format, floor, build_adds, bu_phone, line_tool, bu_line, activity_img, activity_song, case_logo, other, case_id) VALUES ('$User_id', '$com_id', '$case_name', '$google_an', '$google_view_code', '$google_code', '$build_com', '$Consignment', '$marquee','$format', '$floor', '$build_adds', '$bu_phone', '$line_tool', '$bu_line', '$activity_img', '$activity_song', '$case_logo', '$other', '$case_id') ");

           create_dir('../product_html/'.$case_id);

           $file=fopen('../product_html/'.$case_id.'/caseId.php', "w");
           $file_txt='<?php $case_id="'.$case_id.'" ?>';
           fwrite($file,$file_txt );
           copy('product/product_empty.php', '../product_html/'.$case_id.'/Default.php');

          $txt=iconv('utf-8', 'big5', '產生新建案');
        	location_up('admin_project.php',$txt);




 /* #################### 更新建案 ################## */


        }elseif ($inOrup=='update') {

          $case_id=addslashes($_POST['case_id']);

          if (!empty($_FILES['case_logo']['name'])) { $case_logo=$case_id.".jpg"; }
          elseif (!empty($old_case_logo)) { $case_logo=$case_id.".jpg"; }

        	

        	$result = db_conn("UPDATE build_case SET com_id='$com_id', case_name='$case_name', google_an='$google_an', google_code='$google_code', google_view_code='$google_view_code', build_com='$build_com', Consignment='$Consignment', marquee='$marquee', format='$format', floor='$floor', build_adds='$build_adds', bu_phone='$bu_phone', line_tool='$line_tool', bu_line='$bu_line', activity_img='$activity_img', activity_song='$activity_song', case_logo='$case_logo', other='$other' WHERE case_id='".$case_id."'");

            
           /* $file=fopen('../product_html/'.$case_id.'/caseId.php', "w");
           $file_txt='<?php $case_id="'.$case_id.'" ?>';
           fwrite($file,$file_txt );*/


           $txt=iconv('utf-8', 'big5', '更新建案');
        	location_up('admin_project.php', $txt);

        }  

           if (!empty($_FILES['case_logo']['name'])) {
              file_upload_single('case_logo',$case_id, $case_logo);//新增/更新LOGO動圖
            }
           if (!empty($activity_img)) {
              file_upload_single('activity_img',$case_id,'activ_img.jpg');//新增/更新活動圖
            }
            if (!empty($activity_song)) {
              file_upload_single('activity_song',$case_id,'activity_song.mp3');//新增/更新音樂檔
            }

	}









/* ========================================= 幻燈片 ================================================ */	



	elseif ($_POST['page'] == 'slideshow'){


		$case_id=addslashes($_POST['case_id']);//建案ID
		$sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID
    $play_speed=addslashes($_POST['play_speed']); //輪播速度
    $newFileIndex=new_showIndex('slideshow_tb','show_img');
    

 $select_funId=db_conn("SELECT show_img FROM slideshow_tb WHERE fun_id='$fun_id'");


 /*========================= 新增幻燈片 ===============================*/

 if (mysql_num_rows($select_funId)<1){
     for ($i=0; $i < count($_FILES['show']['name']); $i++) { 
      $newFileName=$fun_id."_".$newFileIndex.".jpg";
     	$show_img.=$newFileName.","; //多圖檔名
      file_upload('show',$newFileName,$i,$case_id);
     $newFileIndex=$newFileIndex+1;

     }


  	/*################# 新增索引資料 ##################*/


    rel_insert($case_id, 'slideshow_tb', $fun_id, $sort);
    db_conn("INSERT INTO slideshow_tb (case_id, fun_id, show_img, play_speed) VALUES ('$case_id', '$fun_id', '$show_img', '$play_speed')");

/*========================= 修改幻燈片 ===============================*/

 }else{

     while ($row=mysql_fetch_array($select_funId)) {
       $more_img=explode(',', $row['show_img']) ;
      for ($i=0; $i <count($more_img)-1 ; $i++) { 

/* ####### 判斷刪除圖檔 ######## */

         if (empty($_POST['noDelete_img'.$i]) ) {
           unlink('../product_html/'.$case_id.'/assets/images/'.iconv('utf-8', 'big5',  $more_img[$i]));
         }else{
            $show_img.=$_POST['noDelete_img'.$i].",";
         }
      }
     }

/* ############# 新增圖檔 ############ */     

for ($i=0; $i < count($_FILES['show']['name']); $i++) { 

      $newFileName=$fun_id."_".$newFileIndex.".jpg";
      $show_img.=$newFileName.","; //多圖檔名
      file_upload('show',$newFileName,$i,$case_id);
     $newFileIndex=$newFileIndex+1;

     }



    /*################# 更新幻燈片 ##################*/	


    db_conn("UPDATE slideshow_tb SET show_img='$show_img', play_speed='$play_speed'  WHERE fun_id='$fun_id'");
 }
     location_up('iframe_show.php?funId='.$fun_id.'&caseId='.$case_id , '更新圖檔');
	}






 /*====================================== YouTube ===================================================================*/ 



  elseif ($_POST['page'] == 'youtube') {


    $case_id=addslashes($_POST['case_id']);//建案ID
    $sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID
    $you_title1=addslashes($_POST['you_title1']);
    $you_title2=addslashes($_POST['you_title2']);
    $you_title3=addslashes($_POST['you_title3']);
    $you_adds=addslashes($_POST['you_adds']);
    
    $you_title=$you_title1."(*)".$you_title2."(*)".$you_title3; //使用"(*)"分斷


    $select_funId=db_conn("SELECT * FROM youtube_tb WHERE fun_id='$fun_id'");

    /* ================= 新增YouTube =================== */

    if (mysql_num_rows($select_funId)<1) {
        rel_insert($case_id, 'youtube_tb', $fun_id, $sort);
       db_conn("INSERT INTO youtube_tb (case_id, fun_id, you_adds, you_title) VALUES ('$case_id', '$fun_id', '$you_adds', '$you_title')");
      location_parent('edit_funBox.php?case_id='.$case_id,'新增YouTube');
    }



    /* ================= 更新YouTube =================== */

    else{

      db_conn("UPDATE youtube_tb SET you_adds='$you_adds', you_title='$you_title' WHERE fun_id='$fun_id'");
      location_up('iframe_you.php?funId='.$fun_id, '更新網址');
    }
  }



  /* =============================================== 基本圖文 ====================================================== */


  elseif ($_POST['page'] == 'base') {


    $case_id=addslashes($_POST['case_id']);//建案ID
    $sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID
    $title1=addslashes($_POST['title1']);
    $title2=addslashes($_POST['title2']);
    $title3=addslashes($_POST['title3']);
    $title_two=addslashes($_POST['title_two']);
    $edit_word=addslashes($_POST['edit_word']);
    $base_img=addslashes($_POST['base_img']);
    $txt_fadein=addslashes($_POST['txt_fadein']);
    $img_fadein=addslashes($_POST['img_fadein']);
    $img_fadein_type=addslashes($_POST['img_fadein_type']);
    $line_show=addslashes($_POST['line_show']);
    $big_img=addslashes($_POST['big_img']); //空拍放大連結
    
    
    if (!empty($img_fadein)) {  $img_fadein=$img_fadein.','.$img_fadein_type;  }
    

$title=$title1."(*)".$title2."(*)".$title3;//使用"(*)"做分斷

     if (empty($txt_fadein) ) {  $txt_fadein="n"; }
    if (empty($img_fadein) ) {  $img_fadein="n"; }
   if (empty($line_show) ) {  $line_show="n"; }

    $newFileIndex=new_showIndex('base_word','base_img'); //圖檔索引
   $select_funId=db_conn("SELECT base_img FROM base_word WHERE fun_id='$fun_id'");

   if (mysql_num_rows($select_funId)<1) {

    for ($i=0; $i < count($_FILES['base']['name']); $i++){

      $newFileName=$fun_id."_".$newFileIndex.".jpg";
      $base_img.=$newFileName.","; //多圖檔名
      file_upload('base',$newFileName,$i,$case_id);
     $newFileIndex=$newFileIndex+1;
    }

     /*################# 新增索引資料 ##################*/


     rel_insert($case_id, 'base_word', $fun_id, $sort);

     db_conn("INSERT INTO base_word (case_id, fun_id, title, title_two, edit_word, base_img, txt_fadein, img_fadein, line_show, big_img) VALUES ('$case_id', '$fun_id', '$title', '$title_two', '$edit_word', '$base_img', '$txt_fadein', '$img_fadein', '$line_show', '$big_img')");

     location_parent('edit_funBox.php?case_id='.$case_id,'新增基本圖文');
   }
   else{

      while ($row=mysql_fetch_array($select_funId)) {

        $more_img=explode(',', $row['base_img']);

        for ($i=0; $i <count($more_img)-1 ; $i++) { 

           /* ####### 判斷刪除圖檔 ######## */
         if (empty($_POST['noDelete_img'.$i]) ) {
           unlink('../product_html/'.$case_id.'/assets/images/'.iconv('utf-8', 'big5',  $more_img[$i]));

         }else{

            $base_img.=$_POST['noDelete_img'.$i].",";
         }
        }
      }

      for ($i=0; $i < count($_FILES['base']['name']); $i++){

           $newFileName=$fun_id."_".$newFileIndex.".jpg";
           $base_img.=$newFileName.","; //多圖檔名
           file_upload('base',$newFileName,$i,$case_id);
           $newFileIndex=$newFileIndex+1;

           }



   /*################# 更新基本圖文 ##################*/ 

    db_conn("UPDATE base_word SET title='$title', title_two='$title_two', edit_word='$edit_word', base_img='$base_img', txt_fadein='$txt_fadein', line_show='$line_show', img_fadein='$img_fadein', big_img='$big_img' WHERE fun_id='$fun_id'");

    location_up('iframe_base.php?funId='.$fun_id.'&caseId='.$case_id, '更新基本圖文');

   }
  }




/* ======================================== GoogleMap ============================================ */



  elseif ($_POST['page'] == 'map') {

    $case_id=addslashes($_POST['case_id']);//建案ID
    $sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID
    $map_position=addslashes($_POST['map_position']);//經緯度
    $mark_txt=addslashes($_POST['mark_txt']);//座標文字
    $map_title1=addslashes($_POST['map_title1']);//地圖抬頭
    $map_title2=addslashes($_POST['map_title2']);//地圖抬頭
    $map_title3=addslashes($_POST['map_title3']);//地圖抬頭

    $map_title=$map_title1."(*)".$map_title2."(*)".$map_title3; //使用"(*)"分段
   $select_funId=db_conn("SELECT map_position FROM googlemap_tb WHERE fun_id='$fun_id'");

   if (mysql_num_rows($select_funId)<1) {

       /*################# 新增索引資料 ##################*/

       rel_insert($case_id, 'googlemap_tb', $fun_id, $sort);
       db_conn("INSERT INTO googlemap_tb (case_id, fun_id, map_position, map_title, mark_txt) VALUES ('$case_id', '$fun_id', '$map_position', '$map_title', '$mark_txt')");
       location_parent('edit_funBox.php?case_id='.$case_id,'新增GoogleMap');
   }

   else{

      db_conn("UPDATE googlemap_tb SET map_position='$map_position', map_title='$map_title', mark_txt='$mark_txt' WHERE fun_id='$fun_id'");

      location_up('iframe_map.php?funId='.$fun_id, '更新GoogleMap');
   }
  }


  /*====================================== 聯絡我們 ===========================================*/

  elseif ($_POST['page'] == 'call') {

    $case_id=addslashes($_POST['case_id']);//建案ID
    $sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID

    $re_name1=addslashes($_POST['re_name1']);
    $re_name2=addslashes($_POST['re_name2']);
    $re_name3=addslashes($_POST['re_name3']);
    $re_name4=addslashes($_POST['re_name4']);
    $re_name5=addslashes($_POST['re_name5']);

    $re_mail1=addslashes($_POST['re_mail1']);
    $re_mail2=addslashes($_POST['re_mail2']);
    $re_mail3=addslashes($_POST['re_mail3']);
    $re_mail4=addslashes($_POST['re_mail4']);
    $re_mail5=addslashes($_POST['re_mail5']);
    
    $re_name=$re_name1.",".$re_name2.",".$re_name3.",".$re_name4.",".$re_name5;
    $re_mail=$re_mail1.",".$re_mail2.",".$re_mail3.",".$re_mail4.",".$re_mail5;


   $select_funId=db_conn("SELECT * FROM Related_tb WHERE fun_id='$fun_id'");

    if (mysql_num_rows($select_funId)<1) {

      rel_insert($case_id, 'call_us_tb', $fun_id, $sort);
      db_conn("INSERT INTO call_us_tb (case_id, fun_id, re_name, re_mail) VALUES ('$case_id', '$fun_id', '$re_name', '$re_mail')");
      location_parent('edit_funBox.php?case_id='.$case_id,'新增聯絡我們');
    }
    else{
      
      db_conn("UPDATE call_us_tb SET re_name='$re_name', re_mail='$re_mail'");
      location_up('iframe_call.php?funId='.$fun_id,'更新聯絡我們');
    }
  }


  /* ==================================== 720環景 ================================================== */
  elseif ($_POST['page'] == 'view720') {
    
    $case_id=addslashes($_POST['case_id']);//建案ID
    $sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID
    $view720_title1=addslashes($_POST['view720_title1']);//720抬頭
    $view720_title2=addslashes($_POST['view720_title2']);
    $view720_title3=addslashes($_POST['view720_title3']);
    $x_point=addslashes($_POST['x_point']); //X座標
    $y_point=addslashes($_POST['y_point']); //Y座標
    $point_txt=addslashes($_POST['point_txt']); //名稱
    $point_link=addslashes($_POST['point_link']); //連結

    if (!empty($_FILES['view_img']['name'])) {
      $view_img=addslashes($fun_id.'.jpg'); //俯視圖
    }else{
      $view_img=addslashes($_POST['view_img']);
    }

     if (!empty($_FILES['view_file']['name'])) {
        $view_file=addslashes($_FILES['view_file']['name']);//環景檔案名
     }else{
        $view_file=addslashes($_POST['view_file']);//環景檔案名
     } 
     
     $view720_title=$view720_title1."(*)".$view720_title2."(*)".$view720_title3;
    
    $select_funId=db_conn("SELECT * FROM view720_tb WHERE fun_id='$fun_id'");
    if (mysql_num_rows($select_funId)<1) {

      rel_insert($case_id, 'view720_tb', $fun_id, $sort);
       db_conn("INSERT INTO view720_tb (case_id, fun_id, view720_title, view_img, view_file, x_point, y_point, point_txt, point_link) VALUES ('$case_id', '$fun_id', '$view720_title', '$view_img', '$view_file', '$x_point', '$y_point', '$point_txt', '$point_link')");

       if (!empty($_FILES['view_img']['name'])) {
         file_upload_single('view_img',$case_id,$view_img); //上傳俯視圖
       }
       
      if (!empty($_FILES['view_file']['name'])) {
        view_upload($case_id, $fun_id, $view_file); //上傳壓縮檔
      }
       
       location_parent('edit_funBox.php?case_id='.$case_id,'新增720環景');
    }
    
    else{

      db_conn("UPDATE view720_tb SET view720_title='$view720_title', view_img='$view_img', view_file='$view_file', x_point='$x_point', y_point='$y_point', point_txt='$point_txt', point_link='$point_link' WHERE fun_id='$fun_id'");

       if (!empty($_FILES['view_img']['name'])) {
         file_upload_single('view_img',$case_id,$view_img); //上傳俯視圖
       }

       if (!empty($_FILES['view_file']['name'])) {
        SureRemoveDir('../product_html/'.$case_id.'/zip/'.$fun_id , true);//刪除舊資料
        view_upload($case_id, $fun_id, $view_file); //上傳壓縮檔
        }
        
      location_up('iframe_720view.php?funId='.$fun_id.'&caseId='.$case_id,'更新720環景');

    }
 
  }


  /* ======================================== 錨點加入 ============================================== */

  elseif ($_POST['page'] == 'anchor') {

     

    $case_id=addslashes($_POST['case_id']);//建案ID
    $sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID
    $anchor_name=addslashes($_POST['anchor_name']);//錨點名稱

    $select_funId=db_conn("SELECT * FROM anchor_tb WHERE fun_id='$fun_id'");
    if (mysql_num_rows($select_funId)<1) {

       rel_insert($case_id, 'anchor_tb', $fun_id, $sort);
       db_conn("INSERT INTO anchor_tb (case_id, fun_id, anchor_name) VALUES ('$case_id', '$fun_id', '$anchor_name')");
      location_parent('edit_funBox.php?case_id='.$case_id,'新增錨點');

    }

    else{

      db_conn("UPDATE anchor_tb SET anchor_name='$anchor_name' WHERE fun_id='$fun_id'");
      location_up('iframe_anchor.php?funId='.$fun_id, '更新錨點');
    }
  }


/* ======================================== 房貸試算 ============================================== */
  elseif($_POST['page'] == 'house_math'){

    $case_id=addslashes($_POST['case_id']);//建案ID
    $sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID

    rel_insert($case_id, 'house_math', $fun_id, $sort);
    location_parent('edit_funBox.php?case_id='.$case_id,'新增房貸試算');
  }

/* ======================================== 索取DM ============================================== */
  elseif($_POST['page'] == 'catch_DM'){

    $case_id=addslashes($_POST['case_id']);//建案ID
    $sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID

    rel_insert($case_id, 'catch_DM', $fun_id, $sort);
    location_parent('edit_funBox.php?case_id='.$case_id,'新增索取DM');
  }

/* ======================================== 索取DM-客戶基本資料-AJAX ============================================== */
  elseif($_POST['page'] == 'catch_DM_data'){

     $case_id=addslashes($_POST['case_id']);//建案ID
     $dm_name=addslashes($_POST['dm_name']);
     $dm_mail=addslashes($_POST['dm_mail']);
     $dm_adds=addslashes($_POST['dm_adds']);
     $dm_phone=addslashes($_POST['dm_phone']);
     $dm_remark=addslashes($_POST['dm_remark']);
     $dm_YN_news=addslashes($_POST['dm_YN_news']);

     
     $phone_head=substr($dm_phone, 0,2); //手機
     $phone_head2=substr($dm_phone, 0,1); //市話
     if ($phone_head=="09") {
        $phone_top=substr($dm_phone, 0,4);
        $phone_down=substr($dm_phone, 4);
        $dm_phone=$phone_top."-".$phone_down;
     }
     elseif($phone_head2=="0"){
        $phone_top=substr($dm_phone, 0,2);
        $phone_down=substr($dm_phone, 2);
        $dm_phone=$phone_top."-".$phone_down;
     }

     db_conn("INSERT INTO catch_DM (case_id, dm_name, dm_mail, dm_adds, dm_phone, dm_YN_news, dm_remark) VALUES ('$case_id', '$dm_name', '$dm_mail', '$dm_adds', '$dm_phone', '$dm_YN_news', '$dm_remark')");
  }



  /* ======================================== 電子報 ============================================== */
  elseif($_POST['page'] == 'newsletter'){

    $case_id=addslashes($_POST['case_id']);//建案ID
    $sort=addslashes($_POST['rel_sort']);//排序
    $fun_id=addslashes($_POST['fun_id']);//功能區塊ID

    rel_insert($case_id, 'newsletter', $fun_id, $sort);
    location_parent('edit_funBox.php?case_id='.$case_id,'新增電子報');
  }


  /* ======================================== 電子報-data-AJAX ============================================== */
  elseif($_POST['page'] == 'newsletter_data'){

    $case_id=addslashes($_POST['case_id']);//建案ID
    $news_mail=addslashes($_POST['news_mail']);

    db_conn("INSERT INTO newsletter (case_id, news_mail) VALUES ('$case_id', '$news_mail')");
  }


  /* ======================================== 聯絡我們-AJAX-PHPmailer ============================================== */
  elseif($_POST['page'] == 'call_we'){
    $fun_id=$_POST['fun_id'];
    $case_name= $_POST['case_name'];
    $call_name= $_POST['call_name'];
    $call_mail= $_POST['call_mail'];
    $call_phone= $_POST['call_phone'];
    $q_And_a= $_POST['q_And_a'];
    $call_title= $_POST['call_title'];
    $call_contant= $_POST['call_contant'];

    $mail_body="<table>
    <tr>
      <td>姓名:</td>
      <td>".$call_name."</td>
    </tr>
    <tr>
      <td>電子郵件:</td>
      <td>".$call_mail."</td>
    </tr>
    <tr>
      <td>電話:</td>
      <td>".$call_phone."</td>
    </tr>
    <tr>
      <td>問題類別:</td>
      <td>".$q_And_a."</td>
    </tr>
    <tr>
      <td>主旨:</td>
      <td>".$call_title."</td>
    </tr>
    <tr>
      <td>內容:</td>
      <td>".$call_contant."</td>
    </tr>
  </table>";

   $mail = new PHPMailer();                        // 建立新物件        

    $mail->IsSMTP();                                // 設定使用SMTP方式寄信        
    $mail->SMTPAuth = true;                         // 設定SMTP需要驗證

   // $mail->SMTPSecure = "ssl";                      // Gmail的SMTP主機需要使用SSL連線   
    $mail->Host = "rx.znet.tw";                 // Gmail的SMTP主機        
    $mail->Port = 25;                              // Gmail的SMTP主機的port為465      
    $mail->CharSet = "utf-8";                       // 設定郵件編碼   
    $mail->Encoding = "base64";
    $mail->WordWrap = 50;                           // 每50個字元自動斷行
          
    $mail->Username = "work_test@rx.znet.tw";     // 設定驗證帳號        
    $mail->Password = "xm20926056565";              // 設定驗證密碼        
          
    $mail->From = "work_test@rx.znet.tw";         // 設定寄件者信箱        
    $mail->FromName = "系統寄出";                 // 設定寄件者姓名        
          
    $mail->Subject =$case_name."-聯絡我們" ;                  // 設定郵件標題        
      
    $mail->IsHTML(true);                            // 設定郵件內容為HTML  

    $result=db_conn("SELECT re_name, re_mail FROM call_us_tb WHERE fun_id='$fun_id'");
    while ($row=mysql_fetch_array($result)) {
      
      $re_name=explode(",", $row['re_name']);
      $re_mail=explode(",", $row['re_mail']);

      for ($i=0; $i <5 ; $i++) { 
        if (!empty($re_name[$i])) {
          $mail->AddAddress($re_mail[$i],$re_name[$i]);
        }
      }
    }

    $mail->Body = $mail_body;
  $mail->Send();
   
  }


/* ======================================== 顏色修改 ============================================== */
  elseif($_POST['page'] == 'color'){
 
     $case_id=addslashes($_POST['case_id']);//建案ID
     $h1_color=addslashes($_POST['h1_color']);
     $h2_color=addslashes($_POST['h2_color']);
     $p_color=addslashes($_POST['p_color']);
     $marquee=addslashes($_POST['marquee']);
     $top_txt=addslashes($_POST['top_txt']);
     $top_bar=addslashes($_POST['top_bar']);
     $back_color=addslashes($_POST['back_color']);

    $select_caseId=db_conn("SELECT * FROM color WHERE case_id='$case_id'");
    if (mysql_num_rows($select_caseId)<1) {
      
       db_conn("INSERT INTO color (case_id, h1_color, h2_color, p_color, marquee, top_txt, top_bar, back_color) VALUES ('$case_id', '$h1_color', '$h2_color', '$p_color', '$marquee', '$top_txt', '$top_bar', '$back_color')");

       location_up('color.php?case_id='.$case_id, '更新色彩');
    }
    else{
       
       db_conn("UPDATE color SET h1_color='$h1_color', h2_color='$h2_color', p_color='$p_color', marquee='$marquee', top_txt='$top_txt', top_bar='$top_bar', back_color='$back_color' WHERE case_id='$case_id'");

       location_up('color.php?case_id='.$case_id, '更新色彩');

    }
  }


/* =============================================== 更改密碼 ======================================================= */
  elseif ($_POST['page'] == 'change_pwd') {
    
    $User_id=addslashes($_POST['User_id']);//要更改密碼的使用者ID
    $new_pwd=addslashes($_POST['new_pwd']);
    $admin_num=addslashes($_POST['admin_num']);
    $admin_pwd=addslashes($_POST['admin_pwd']);

    $result=db_conn("SELECT User_id FROM admin_user WHERE login_id='$admin_num' AND login_pwd='$admin_pwd' AND competence='admin'");
    if (mysql_num_rows($result)>0) {
        while ($row=mysql_fetch_array($result)) {
      
           db_conn("UPDATE admin_user SET login_pwd='$new_pwd' WHERE User_id='$User_id'");
        }
        echo "1";
        exit();
    }
    else{
        echo "0";
        exit();
    }
    
  }


}//$_POST END


/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ GET @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ GET @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ GET @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */


if ($_GET) {

  /* =================================== 建案表格 ============================================== */ 
	if ($_GET['admin']=='project') {
    $com_id=addslashes($_GET['com_id']);
    $case_id=addslashes($_GET['case_id']);
		$pro_array=array();
    
    if (!empty($com_id)) {
      
       $result = db_conn("SELECT * FROM build_case WHERE com_id='$com_id'" );
    }
    else{

        $result = db_conn("SELECT * FROM build_case WHERE case_id='$case_id'" );
    }
		

          while ($row=mysql_fetch_array($result)) {
            
            $case_id=$row['case_id'];
            $result_expand = db_conn("SELECT record_id FROM expand_record WHERE case_id='$case_id' AND tool_id='tool20160624002' AND is_use='1'" );
            if (mysql_num_rows($result_expand)>0) {

              while ($row_quest=mysql_fetch_array($result_expand)) { $record_id=$row_quest['record_id']; }
            }

          	array_push($pro_array, array('case_id'=>$row['case_id'], 
          		                         'case_name'=>$row['case_name'], 
          		                         'bu_phone'=>$row['bu_phone'], 
          		                         'build_com'=>$row['build_com'], 
          		                         'Consignment'=>$row['Consignment'], 
          		                         'format'=>$row['format'], 
          		                         'floor'=>$row['floor'], 
          		                         'build_adds'=>$row['build_adds'], 
          		                         'google_an'=>$row['google_an'],
                                       'record_id'=>$record_id
          		                         ));
          }

          echo json_encode(array('pro_array'=>$pro_array));
	}


 /* =================================== 使用者表格 ============================================== */ 
  elseif ($_GET['admin']=='user'){
    $competence=addslashes($_GET['competence']);
    $user_array=array();
  $result=db_conn("SELECT User_id, User_Name, User_phone, User_adds, com_id, case_id FROM admin_user WHERE competence='$competence'");
  if (mysql_num_rows($result)>0) {
      while ($row=mysql_fetch_array($result)) {
           array_push($user_array, array('User_id'=>$row['User_id'], 
                                       'User_Name'=>$row['User_Name'],
                                      'User_phone'=>$row['User_phone'],
                                       'User_adds'=>$row['User_adds'],
                                          'com_id'=> $row['com_id'],
                                          'case_id'=>$row['case_id']
                                        ));
      }
      echo json_encode(array('user_array'=>$user_array));
    }
  }


   /* =================================== 公司表格 ============================================== */ 
  elseif ($_GET['admin']=='company'){

    $User_id=addslashes($_SESSION['user_id']);

    $com_array=array();
  $result=db_conn("SELECT com_id, com_name, com_logo FROM company WHERE User_id='$User_id'");
  if (mysql_num_rows($result)>0) {
      while ($row=mysql_fetch_array($result)) {
           array_push($com_array, array('com_id'=>$row['com_id'], 
                                      'com_name'=>$row['com_name'],
                                      'com_logo'=>$row['com_logo']
                                        ));
      }
      echo json_encode(array('com_array'=>$com_array));
    }
  }

  /* =================================== 選單公司 ============================================== */ 
  elseif ($_GET['admin']=='company_sel'){


    $com_array=array();
  $result=db_conn("SELECT com_id, com_name FROM company");
  if (mysql_num_rows($result)>0) {
      while ($row=mysql_fetch_array($result)) {
           array_push($com_array, array('com_id'=>$row['com_id'], 
                                      'com_name'=>$row['com_name'],
                                        ));
      }
      echo json_encode(array('com_array'=>$com_array));
    }
  }

  /* =================================== 選單專案 ============================================== */ 
  elseif ($_GET['admin']=='case_sel'){

 $com_id=$_GET['com_id'];

    $case_array=array();
  $result=db_conn("SELECT case_id, case_name FROM build_case WHERE com_id='$com_id'");
  if (mysql_num_rows($result)>0) {
      while ($row=mysql_fetch_array($result)) {
           array_push($case_array, array('case_id'=>$row['case_id'], 
                                      'case_name'=>$row['case_name'],
                                        ));
      }
      echo json_encode(array('case_array'=>$case_array));
    }
  }

  /* ======================================== 專案(手機板) ================================================ */
elseif($_GET['admin']=='project_ph'){

  $com_id=addslashes($_GET['com_id']);
    $case_id=addslashes($_GET['case_id']);
    $pro_ph_array=array();
    
    if (!empty($com_id)) {
      
       $result = db_conn("SELECT case_id, case_name, case_logo FROM build_case WHERE com_id='$com_id'" );
    }
    else{

        $result = db_conn("SELECT case_id, case_name, case_logo FROM build_case WHERE case_id='$case_id'" );
    }

    while ($row=mysql_fetch_array($result)) {
       
       $case_logo=$row['case_logo'];
       $case_id=$row['case_id'];
       $case_name=$row['case_name'];
        $result_analytics = db_conn("SELECT week_user, month_user, total_user FROM google_analytics WHERE case_no='$case_id'");
        while ($row_an=mysql_fetch_array($result_analytics)) {
         
           array_push($pro_ph_array, array(    'case_id'=> $case_id,
                                             'case_name'=> $case_name,
                                             'case_logo'=> $case_logo,
                                             'week_user'=> $row_an['week_user'],
                                            'month_user'=> $row_an['month_user'],
                                            'total_user'=> $row_an['total_user']
                                             ));
        }
        echo json_encode(array('pro_ph_array'=>$pro_ph_array));
    }

}

/* ========================================= all刪除 ============================================ */
   elseif ($_GET['delete'] == 'admin_user') {
    
    $User_id=addslashes($_GET['User_id']);
    db_conn("DELETE FROM admin_user WHERE User_id='$User_id'");

    $txt=iconv('utf-8', 'big5', '成功刪除使用者!!');
    location_up('admin_user.php', $txt);

   }


/* ====================================== 刪除公司 ============================================== */
    elseif ($_GET['delete'] == 'company') {
    
    $com_id=addslashes($_GET['com_id']);
    db_conn("DELETE FROM company WHERE com_id='$com_id'");

    $txt=iconv('utf-8', 'big5', '成功刪除公司!!');
    location_up('admin_com.php', $txt);

   }



 /* =================== 建案刪除 ===================== */
	elseif ($_GET['delete'] == 'build_case') {
		$case_id=addslashes($_GET['case']);
    $result=db_conn("SELECT fun_name, fun_id FROM Related_tb WHERE case_id='$case_id'" );
    while ($row=mysql_fetch_array($result)) {
      $fun_name=addslashes($row['fun_name']);
      $fun_id=addslashes($row['fun_id']);
       db_conn("DELETE FROM $fun_name WHERE fun_id='$fun_id'");
    }

    db_conn("DELETE FROM Related_tb WHERE case_id='$case_id'");
		db_conn("DELETE FROM build_case WHERE case_id='".$case_id."'");

     SureRemoveDir('../product_html/'.$case_id , true);

    $txt=iconv('utf-8', 'big5', '成功刪除!!');
        	location_up('admin_project.php', $txt);

	}





/* =========================================== 功能刪除 ================================================== */

  elseif ($_GET['delete'] == 'funBox') {

    $fun_id=addslashes($_GET['fun_id']);
    $case_id=addslashes($_GET['case_id']);
     $result=db_conn("SELECT fun_name FROM Related_tb WHERE fun_id='$fun_id'");

     while ($row=mysql_fetch_array($result)) {
        $fun_name=addslashes($row['fun_name']);

      /* ===================== 刪幻燈片圖 ======================== */

        if ($fun_name=='slideshow_tb') {

           $result=db_conn("SELECT show_img FROM slideshow_tb WHERE fun_id='$fun_id'");
           while ($row=mysql_fetch_array($result)) {

               $img_array=explode(',', $row['show_img']);

               for ($i=0; $i <count($img_array)-1 ; $i++) { 
                  unlink('../product_html/'.$case_id.'/assets/images/'.iconv('utf-8', 'big5',  $img_array[$i]));
               }
           }
        } 

        /* ===================== 刪基本圖 ======================== */

         elseif($fun_name=='base_word'){

          $result=db_conn("SELECT base_img FROM base_word WHERE fun_id='$fun_id'");
          while ($row=mysql_fetch_array($result)) {
             $img_array=explode(',', $row['base_img']);

             for ($i=0; $i <count($img_array)-1 ; $i++) { 
                unlink('../product_html/'.$case_id.'/assets/images/'.iconv('utf-8', 'big5',  $img_array[$i]));
             }
          }
        }

        // ====================== 刪環景-俯視圖 ==========================
        elseif ($fun_name=='view720_tb') {
          $result=db_conn("SELECT view_img FROM view720_tb WHERE fun_id='$fun_id'");
          while ($row=mysql_fetch_array($result)) {
            SureRemoveDir('../product_html/'.$case_id.'/zip/'.$fun_id , true);//刪除資料夾
             unlink('../product_html/'.$case_id.'/assets/images/'.iconv('utf-8', 'big5',  $row['view_img']));
          }
        }

        /* ======================== 刪除 ============================= */
     }

     /* 刪除功能區塊 */
     if (($fun_name!='house_math') and ($fun_name!='catch_DM')) {

       db_conn("DELETE FROM $fun_name WHERE fun_id='$fun_id'");
     }
        
    /* 刪除關聯索引 */
    db_conn("DELETE FROM Related_tb WHERE fun_id='$fun_id'");

  /* 修正排序 */  

  $new_sort=1;

    $sel_num=db_conn("SELECT fun_id FROM Related_tb WHERE case_id='$case_id' ORDER BY sort");

    while ($row=mysql_fetch_array($sel_num)) {
       $fun_id=addslashes($row['fun_id']);
      db_conn("UPDATE Related_tb SET sort=$new_sort WHERE fun_id='$fun_id'");
      ++$new_sort;
    }

    $txt=iconv('utf-8', 'big5', '功能刪除!!');
    location_up('edit_funBox.php?case_id='.$case_id, $txt);

  }


 /* ================================================== 重新排序 ========================================================== */ 
  elseif (!empty($_GET['sort']) ) {

     $case_id=addslashes($_GET['case_id']);
     $sort=addslashes($_GET['sort']);
     $sort=explode(',', $sort);

     for ($i=0; $i <count($sort)-1 ; $i++) { 

      $j=$i+1;
       db_conn("UPDATE Related_tb SET sort=$j WHERE  fun_id='".$sort[$i]."'");

     }

    $txt=iconv('utf-8', 'big5', '更新排序');
    location_up('edit_funBox.php?case_id='.$case_id, $txt);

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


function location_parent($location_path,$alert_txt)

{
  //$txt=iconv('utf-8', 'big5', $alert_txt);
   echo "<script>";
   echo "window.parent.location.replace('".$location_path."');"; //網頁跳轉

   if (!empty($alert_txt)) {
    echo "alert('" . $alert_txt . "');";
   }
   echo "</script>";

}







function rel_insert($case_id, $fun_name, $fun_id, $sort)

{
/*################# 新增索引資料 ##################*/
$result = db_conn("INSERT INTO Related_tb (case_id, fun_name, fun_id, sort) VALUES ('$case_id', '$fun_name', '$fun_id', '$sort')");
}





/* =============================== 產生檔名索引 ======================================== */

function new_showIndex($Dt,$col )
{

   $fun_id=addslashes($_POST['fun_id']);//功能區塊ID

     $result=db_conn("SELECT $col FROM $Dt WHERE fun_id='$fun_id'");

       if (mysql_num_rows($result)>0){
      while ($row=mysql_fetch_array($result)) {
         $new_imgIndex=substr($row[$col], -6,1);
         $new_imgIndex=(int)$new_imgIndex;
         $new_imgIndex=$new_imgIndex+1;
     }
  }
  else{

    $new_imgIndex=1;
    //$new_imgName=$fun_id."_".$new_imgIndex.".jpg";

  }
  return $new_imgIndex;
}



/*################################## 單檔上傳 ##############################*/

function file_upload_single($Name,$case_id,$fName)
{
        if ($_FILES[$Name]['error']>0) {
            //location_up('iframe_show.php?funId='.$fun_id, '檔案上傳失敗'.$_FILES[$Name]["error"][$i]);
        }
        else{
          if ($Name=='activity_song') { //活動背景音樂
            move_uploaded_file($_FILES[$Name]['tmp_name'], '../product_html/'.$case_id.'/music/'.iconv("utf-8", "big5",$fName));
          }
          elseif ($Name=='com_LOGO') { //公司LOGO
            move_uploaded_file($_FILES[$Name]['tmp_name'], 'img/com_logo/'.iconv("utf-8", "big5",$fName));
          }
          elseif ($Name=='case_logo') { //專案LOGO
            move_uploaded_file($_FILES[$Name]['tmp_name'], 'img/case_logo/'.iconv("utf-8", "big5",$fName));
          }
          else{
           move_uploaded_file($_FILES[$Name]['tmp_name'], '../product_html/'.$case_id.'/assets/images/'.iconv("utf-8", "big5",$fName));
          }
        }
}


/* ############################### 環景檔案上傳 ####################################### */
function view_upload($case_id, $fun_id, $fName)
{
  move_uploaded_file($_FILES['view_file']['tmp_name'], '../product_html/'.$case_id.'/zip/'.iconv("utf-8", "big5",$fName));

            $file_dir=explode('.', $fName) ;
            $file_dir=$file_dir[0];

            $archive = new PclZip('../product_html/'.$case_id.'/zip/'.iconv("utf-8", "big5",$fName));
            if ($archive->extract(PCLZIP_OPT_PATH,"../product_html/".$case_id."/zip/", //解壓縮路徑
                                  PCLZIP_OPT_REMOVE_PATH, $file_dir,  //移除指定資料夾
                                  PCLZIP_OPT_ADD_PATH, $fun_id ) == 0) {  //建立指定資料夾
              die("Error : ".$archive->errorInfo(true)); 
            } 
            unlink('../product_html/'.$case_id.'/zip/'.iconv("utf-8", "big5",$fName)); //再刪除壓縮檔
}


/* ############################# 多檔上傳 ############################### */

function file_upload($Name,$fileName,$i,$case_id)
{
        if ($_FILES[$Name]['error'][$i]>0) {
            //location_up('iframe_show.php?funId='.$fun_id, '檔案上傳失敗'.$_FILES[$Name]["error"][$i]);
        }
        else{
           move_uploaded_file($_FILES[$Name]['tmp_name'][$i], '../product_html/'.$case_id.'/assets/images/'.iconv("utf-8", "big5",$fileName ));
        }
}



/* ################################# 刪除資料夾連檔案 ############################# */

 // 第二個參數: true 連 2011 目錄也刪除


function SureRemoveDir($dir, $DeleteMe) {
if(!$dh = @opendir($dir)) return;
while (false !== ($obj = readdir($dh))) {
if($obj=='.' || $obj=='..') continue;
if (!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
}

if ($DeleteMe){
closedir($dh);
@rmdir($dir);
}

}

?>







