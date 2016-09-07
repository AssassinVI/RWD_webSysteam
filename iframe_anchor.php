<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';
?>

<?php 
   if (empty($_GET['funId'])){
     
 /*################# 給錨點ID ##################*/    
  $result = db_conn("SELECT fun_id FROM anchor_tb WHERE fun_id LIKE 'an".date('Ymd')."%' ORDER BY fun_id DESC LIMIT 1" );
  if (mysql_num_rows($result)<1) {

      $fun_id='an'.date('Ymd').'001';
  }else{

   while ($row=mysql_fetch_array($result)) {
       
        $fun_id_down =(int)substr($row['fun_id'], 10);
              $sum=$fun_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $fun_id='an'.date('Ymd').$sum;
          }
      }
   }
   else{
      $fun_id=htmlspecialchars($_GET['funId']);
      $result = db_conn("SELECT anchor_name FROM anchor_tb WHERE fun_id='$fun_id' " );
      while ($row=mysql_fetch_array($result)) {
         $anchor_name=$row['anchor_name'];
      }

   } 

 ?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title>錨點編輯</title>
  <link rel="shortcut icon" href="favicon.ico" />
	<!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>
    <style type="text/css">
     body{
      height: auto;
      background-color: rgb(243,243,244);
    }
    </style>
</head>
<body>
	<div id="wrapper"style="background-color:#F0F0F0; padding-top:0px; " >
	 	<div class="wrapper wrapper-content animated fadeInRight">
	 		<div  class="row">
                  <div id="anchor_div" class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>錨點編輯區塊 </h5>
                        </div>
                        <div class="ibox-content">
                         <div class="row">
                            
                            <form  method="POST" action="rwd_php_sys.php" >
                            
                             <div class="form-group">
                                <label class="col-sm-2 control-label">錨點名稱</label>
                                  <div class="col-sm-5">
                                    <input type="text" name="anchor_name" class="form-control" value="<?php echo $anchor_name; ?>">
                                  </div>
                             </div>
                             <div class="form-group">
                             <label class="col-sm-10 control-label"></label>
                               <div class="col-sm-2">
                               	  <button type="submit" class="btn btn-primary dim">送出</button>
                               </div>
                             </div>
                            <input type="hidden" name="page" value="anchor">
                            <input type="hidden" name="case_id" value="<?php echo $_POST['case_id'];?>">
                            <input id="fun_id" type="hidden" name="fun_id" value="<?php echo $fun_id;?>">
                            <input type="hidden" name="rel_sort" value="<?php echo $_POST['rel_sort'];?>">

                             </form>

                          </div>
                        </div>
                    </div>
                </div>

	 		</div>
	 	</div>
</div>
</body>
</html>