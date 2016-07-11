<?php session_start();
if ($_POST) {
/* ======================================更新公司介紹============================================ */
	if ($_POST["updata_down"] == "updata") {
		$cp_text = htmlspecialchars($_POST["company_text"]);
		db_conn("UPDATE cpmpany_text SET cp_text='$cp_text' WHERE id=1"); //連資料庫方法
		location_up("更新完成!!",0); //網頁跳回方法
	}

/* ====================================新增產品介紹=============================================== */
	elseif ($_POST["updata_down"] == "pro_insert") {
		$pro_id = htmlspecialchars($_POST["pro_id"]);
		$pro_name = htmlspecialchars($_POST["pro_name"]);
		$pro_summary = htmlspecialchars($_POST["updata_summary"]);
		$pro_detail = htmlspecialchars($_POST["updata_detail"]);
		$pro_img = htmlspecialchars($_FILES["pro_file"]["name"]);
		$other_file=htmlspecialchars($_FILES['other_file']['name']) ;

		db_conn("INSERT INTO product (pro_id, product_name,product_detail,remark,img_txt,other_file) VALUES('$pro_id','$pro_name','$pro_summary','$pro_detail','$pro_img','$other_file')");

/*  ============圖檔上傳============ */
		up_file("");

		if (($_FILES["pro_file"]["name"] == "") && ($_FILES["other_file"]["name"] == "")) {
			location_up("新增產品成功",1); //網頁跳回方法
		}
	}

/* ====================================更新產品介紹=============================================== */
	elseif ($_POST["updata_down"] == "pro_update") {
		$pro_id = htmlspecialchars($_POST["pro_id"]);
		$pro_name = htmlspecialchars($_POST["pro_name"]);
		$pro_summary = htmlspecialchars($_POST["updata_summary"]);
		$pro_detail = htmlspecialchars($_POST["updata_detail"]);
		$updata_id = htmlspecialchars($_POST["updata_id"]);

		/* ========================= 判斷是否有檔案 ================================ */
		$imgAndOther = db_conn("SELECT img_txt,other_file FROM product WHERE rowid='$updata_id'");
		while ($row = mysql_fetch_array($imgAndOther)) {
			if (empty($row['img_txt'])) {  //圖片
				$pro_img = $_FILES['pro_file']['name'];
			} else {
				$pro_img = htmlspecialchars($row['img_txt']);
			}

			if (empty($row['other_file'])) {  //附加檔案
				$other_file=$_FILES['other_file']['name'];

			}elseif(empty($_POST["oth_del"])){
				unlink("assets/images/demo/other_file/".$row['other_file']);   
				$other_file="";
			}else{
				unlink("assets/images/demo/other_file/".$row['other_file']);
                $other_file=$_FILES['other_file']['name'];
			}
		}
		db_conn("UPDATE product SET pro_id='$pro_id', product_name='$pro_name',product_detail='$pro_summary',remark='$pro_detail' ,img_txt='$pro_img' ,other_file='$other_file' WHERE rowid=$updata_id");

		/*  ============圖檔上傳============ */
		up_file($pro_img);
		if (($_FILES["pro_file"]["name"] == "") && ($_FILES["other_file"]["name"] == "")) {
			location_up("更新成功",1);
		}
	}

/* ==================================== 刪除產品 =============================================== */
	elseif ($_POST["updata_down"] == "pro_delete") {
		$id = htmlspecialchars($_POST["id"]);
		$img_conn = db_conn("SELECT img_txt FROM product WHERE rowid=$id");
		while ($row = mysql_fetch_array($img_conn)) {
			$img_id = $row['img_txt'];
		}
		unlink('assets/images/demo/shop/' . iconv('utf-8', 'big5', $img_id)); //需轉碼才可刪中文檔
		db_conn("DELETE FROM product WHERE rowid=$id");
	}

/* ====================================新增實例應用=============================================== */
	elseif ($_POST["updata_down"] == "app_insert") {
		$subject = htmlspecialchars($_POST["app_subject"]);
		$summary = htmlspecialchars($_POST["app_txt"]);
		$more_img_id = htmlspecialchars($_POST["more_img_id"]);
		$app_img = "";
		for ($i = 0; $i < $more_img_id; $i++) {
			$app_img .= $_FILES["app_file" . $i]["name"] . ",";
		}
		db_conn("INSERT INTO app_use (subject, summary, app_img) VALUES('$subject','$summary','$app_img')");

/*  ============圖檔上傳============ */
		up_file("");

		if ($_FILES["app_file1"]["name"] == "") {
			location_up("新增成功",2);
		}
	}

/* ====================================更新實例應用=============================================== */
	elseif ($_POST["updata_down"] == "app_update") {
		$subject = htmlspecialchars($_POST["app_subject"]);
		$summary = htmlspecialchars($_POST["app_txt"]);
		$updata_id = htmlspecialchars($_POST["updata_id"]);
		$more_img_id = htmlspecialchars($_POST["more_img_id"]); /* 新增的多圖數量 */
		$update_img_id = htmlspecialchars($_POST["update_img_id"]); /* 更新後多圖數量 */
		$app_img = ""; //多圖檔名陣列
		$resault = db_conn("SELECT app_img FROM app_use WHERE rowid=$updata_id");
		while ($row = mysql_fetch_array($resault)) {
			$moreImg_ar = explode(",", $row["app_img"]);
		}

		/* ================= 更新多圖檔 ===================== */
		for ($i = 0; $i < $update_img_id; $i++) {
			if (!empty($_POST["imgArray" . $i])) {
				$app_img .= $_POST["imgArray" . $i] . ",";
			}
		}

		for ($i = 0; $i < $more_img_id; $i++) {
			if (!in_array($_FILES["app_file" . $i]["name"], $moreImg_ar)) {
				//判別是否重複傳檔
				if (!empty($_FILES["app_file" . $i]["name"])) {
					$app_img .= $_FILES["app_file" . $i]["name"] . ",";
				}
			}
		}
		db_conn("UPDATE app_use SET subject='$subject', summary='$summary', app_img='$app_img' WHERE rowid=$updata_id");

		/*  ============圖檔上傳============ */
		up_file("");

		/* =========== 刪除多圖檔 ============== */
		for ($i = 0; $i < count($moreImg_ar); $i++) {
			for ($j = 0; $j < $update_img_id; $j++) {
				if (!empty($_POST["imgArray" . $j])) {
					if ($moreImg_ar[$i] == $_POST["imgArray" . $j]) {
						$moreImg_ar[$i] = "";
						break;
					}
				}
			}
		}
		for ($i = 0; $i < count($moreImg_ar); $i++) {
			if (!empty($moreImg_ar[$i])) {
				unlink("assets/images/demo/portfolio/" . $moreImg_ar[$i]);
			}

			if ($_FILES["app_file0"]["name"] == "") {
				location_up("更新成功",2);
			}
		}
	}

	/* ====================================刪除實例應用=============================================== */
	elseif ($_POST["updata_down"] == "app_detele") {
		$id = htmlspecialchars($_POST["id"]);

		$app_img = db_conn("SELECT app_img FROM app_use WHERE rowid=$id");
		while ($row = mysql_fetch_array($app_img)) {
			$img_array = explode(',', $row['app_img']);
		}
		for ($i = 0; $i < count($img_array); $i++) {
			unlink("assets/images/demo/portfolio/" . iconv('utf-8', 'big5', $img_array[$i]));
		}
		db_conn("DELETE FROM app_use WHERE rowid=$id");

	}

	/* ==================================== 登入後台 =============================================== */
	elseif($_POST["updata_down"]=="login"){
        $user_name=htmlspecialchars($_POST["user_name"]);
        $password=htmlspecialchars($_POST["user_password"]);
        $contact_captcha= htmlspecialchars($_POST["contact_captcha"]);

        if ($contact_captcha!=$_SESSION['captcha']) { //驗證碼判斷
        	
            echo "<script>";
        		echo "location.replace('Default.html');"; //跳回登入頁面
        		echo "alert('".iconv('utf-8','big5','驗證碼輸入錯誤')."');";
        		echo "</script>";
        		exit;
        }
        $user_msg=db_conn("SELECT user_id,user_name,password FROM user WHERE user_id=$user_name and password=$password");
        if(!empty($user_msg)){
           while ($row=mysql_fetch_array($user_msg)) {
           $conn_name=$row["user_name"];
        	}
        }
        	if (!empty($conn_name)) {
        		$_SESSION["login"]="OK";
        		$_SESSION["name"]=$conn_name;
        		$txt=iconv('utf-8', 'big5', '歡迎'.$conn_name.'登入');
        		echo "<script>";
        		echo "location.replace('back_station.php');"; //網頁跳轉回後台
        		echo "alert('".$txt."');";
        		echo "</script>";
        		exit;
        	}
        	else{
                echo "<script>";
        		echo "location.replace('Default.html');"; //跳回登入頁面
        		echo "alert('".iconv('utf-8','big5','使用者名稱或密碼錯誤')."');";
        		echo "</script>";
        }
	}
}

if ($_GET) {
/* ========================== 產品資料 =============================== */
if(!empty($_GET["select"])){
	if ($_GET["select"] == "get_pro") {
     //撈取圖片資料 AND 附加檔案
		if($_GET["img"]=="one_img"){
			$img_id=$_GET["img_id"];
			$img_array=array();
			$select_img=db_conn("SELECT img_txt,other_file FROM product WHERE rowid='$img_id'");
			while ($row=mysql_fetch_array($select_img)) {
				array_push($img_array, array('img_txt'=>$row['img_txt'],'other_file'=>$row['other_file']));
			}
			echo json_encode(array('img_txt'=>$img_array));
		}
		//所有資料
		else{
			$sel_name = db_conn("SELECT rowid,product_name,img_txt FROM product");
		$select_pro = array();
		while ($row = mysql_fetch_array($sel_name)) {
			array_push($select_pro, array('rowid' => $row['rowid'], 'product_name' => $row['product_name'], 'img_txt' => $row['img_txt']));
		}
		echo json_encode(array('select_pro' => $select_pro));
		}
	}

/* ========================== 實例資料 =============================== */
	elseif ($_GET["select"] == "get_app") {
		//撈取多圖資料
		if ($_GET["img"] == "more_img") {
			$img_id = $_GET["img_id"];
			$img_array = array();
			$sel_name = db_conn("SELECT app_img FROM app_use WHERE rowid='$img_id'"); //快速連線方法
			while ($row = mysql_fetch_array($sel_name)) {
				array_push($img_array, array('app_img' => $row['app_img']));
			}
			echo json_encode(array('app_img' => $img_array));
		}
		//所有資料
		else {
			$sel_name = db_conn("SELECT rowid,subject,app_img FROM app_use"); //快速連線方法
			$select_app = array();
			while ($row = mysql_fetch_array($sel_name)) {
				array_push($select_app, array('rowid' => $row['rowid'], 'subject' => $row['subject'], 'app_img' => $row['app_img']));
			}
			echo json_encode(array('select_app' => $select_app));
		}
	}
}

/* ========================== 刪除跳轉 =============================== */
   if (!empty($_GET["del_index"])) {
   	if ($_GET["del_index"]==1) {
		location_up("產品成功刪除",1);
	}
	elseif($_GET["del_index"]==2){
		location_up("實例成功刪除",2);
	}
	elseif($_GET["del_index"]=="back1"){
        location_up("",1);
	}
	elseif($_GET["del_index"]=="back2"){
         location_up("",2);
	}
   }
/* ============================= 後台登出 ======================================== */
  if(!empty($_GET["login_out"])){
     if ($_GET["login_out"]=="out") {
     	 session_destroy();
     	        echo "<script>";
        		echo "location.replace('Default.html');"; //跳回登入頁面
        		echo "</script>";
     }
  }
}

/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 資料庫連線 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
function db_conn($query) {
	$conn = mysql_connect("localhost", "rxznet_work_test", "xm20926056565") OR die('無法連線'); //資料庫連結
	mysql_select_db("rxznet_work_test_db", $conn); //選定資料庫
	mysql_query("SET NAMES 'UTF8'");
	return mysql_query($query);
	mysql_close($conn);
}

/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 網頁跳轉回後台 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
function location_up($alert_text,$index) {
	$txt=iconv('utf-8', 'big5', $alert_text);
	echo "<script>";
	echo "location.replace('back_station.php');"; //網頁跳轉回後台
	if (!empty($alert_text)) {
		echo "alert('" . $txt . "');";
	}
	echo "sessionStorage.tabs_index=".$index;
	echo "</script>";
}
function location_detail($alert_text,$index) {
	$txt=iconv('utf-8', 'big5', $alert_text);
	echo "<script>";
	if($index==1){
		echo "history.back();"; //網頁跳轉回產品更新
	}
	else{
        echo "location.replace('back_station_detail.php');"; //網頁跳轉回實例更新
	}
	if (!empty($alert_text)) {
		echo "alert('" . $txt . "');";
	}
	echo "</script>";
}

/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 圖檔上傳 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
function up_file($img_txt) {
	/* =================產品主圖================= */
	if (!empty($_FILES["pro_file"]["name"])) {

		if (($_FILES["pro_file"]["type"] == "image/gif") ||
			($_FILES["pro_file"]["type"] == "image/jpeg") ||
			($_FILES["pro_file"]["type"] == "image/pjpeg")) {
			if ($_FILES["pro_file"]["error"] > 0) {
				echo "檔案上傳失敗" . $_FILES["pro_file"]["error"];
				echo $_FILES["pro_file"]["name"];
			} else {
				if (!empty($img_txt)) {
					//更新主圖
					move_uploaded_file($_FILES["pro_file"]["tmp_name"], "assets/images/demo/shop/" . iconv("utf-8", "big5", $img_txt));
					location_up("圖檔上傳成功",1);
				} else {
					//新增主圖
					move_uploaded_file($_FILES["pro_file"]["tmp_name"], "assets/images/demo/shop/" . iconv("utf-8", "big5", $_FILES["pro_file"]["name"]));
					location_up("圖檔上傳成功",1);
				}
			}
		} else {
			echo location_detail("檔案類型錯誤",1); //網頁跳回方法
		}
	}
/* ==============附加檔案================ */
	if (!empty($_FILES["other_file"]["name"])) {

		if ($_FILES["other_file"]["error"]) {
			echo "附加檔案上傳失敗";
		} else {
			move_uploaded_file($_FILES["other_file"]["tmp_name"], "assets/images/demo/other_file/" . iconv("utf-8", "big5",
				$_FILES["other_file"]["name"]));
			location_up("更新成功",1);
		}
	}
/* ================多實例圖上傳============== */
	if (!empty($_FILES["app_file0"]["name"])) {
		$more_img_id = htmlspecialchars($_POST["more_img_id"]);

		if ($_FILES["app_file0"]["error"]) {
			echo "實例圖上傳失敗" . $_FILES["app_file1"]["error"];
		} else {
			for ($i = 0; $i < $more_img_id; $i++) {
				if (!empty($_FILES["app_file" . $i]["name"])) {
					move_uploaded_file($_FILES["app_file" . $i]["tmp_name"], "assets/images/demo/portfolio/" . iconv("utf-8", "big5", $_FILES["app_file" . $i]["name"]));
				}
			}
			location_up("多圖更新成功",2);
		}
	} //if
} //function

?>