<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

      if (!empty($_POST['case_id'])) {
      $case_id=htmlspecialchars($_POST['case_id']);
    }else{
      $case_id=htmlspecialchars($_GET['caseId']);
    }
?>
<?php

 $rel_sort=htmlspecialchars($_POST['rel_sort']);

   if (empty($_GET['funId'])) {
    
       /*################# 給電子報 ID ##################*/    
          $result = db_conn("SELECT fun_id FROM Related_tb WHERE fun_id LIKE 'nw".date('Ymd')."%' ORDER BY fun_id DESC LIMIT 1" );
          if (mysql_num_rows($result)<1) {

              $fun_id='nw'.date('Ymd').'001';
           }else{

             while ($row=mysql_fetch_array($result)) {
       
              $fun_id_down =(int)substr($row['fun_id'], 10);
              $sum=$fun_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $fun_id='nw'.date('Ymd').$sum;
          }
      }
  }
  else{
  	$fun_id=htmlspecialchars($_GET['funId']);

  }

?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title>電子報</title>
	<!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>
    <style type="text/css">
    body{
    	height: auto;
    	background-color: rgb(243,243,244);
      font-family: 微軟正黑體;
    }
   #con_box p{
      font-size: 20px;
    }
    #excel_btn{
      font-size: 20px;
      color: #fff;
      background-color: #009100;
      padding: 10px;
      display: block;
      text-align: center;
      transition: background-color 1s,color 0.5s;
     -moz-transition: background-color 1s,color 0.5s;  /* Firefox 4 */
     -webkit-transition: background-color 1s,color 0.5s; /* Safari 和 Chrome */
    }
    #excel_btn:hover{
      color: #009100;
      background-color:#F0FFF0;
    }
    </style>

    <script type="text/javascript">
       $(document).ready(function() {
           var fun_id="<?php echo $_GET['funId'];?>";
           if (fun_id!="") {
              $("#cr_btn").css('display', 'none');
              $("#con_box").html("<p>已產生電子報按鈕</p>");
           }
       });
    </script>
</head>
<body>
	<div id="wrapper"style="background-color:#F0F0F0; padding-top:0px; " >
	 
	 	<div class="wrapper wrapper-content animated fadeInRight">
	 		<div  class="row">
 <!-- =========================================== 房貸試算 ============================================= -->
              <div  class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-content">
                         <div class="row">
                            <form method="POST" action="rwd_php_sys.php" class="form-horizontal">
                              <div class="form-group">
                                <label class="col-sm-5 control-label"></label>
                                <div id="con_box" class="col-sm-2">
                                <button id="cr_btn"  class="btn btn-primary dim" type="submit" > 產生電子報按鈕</button>
                                </div>
                                </div>

<?php
   
  $result= db_conn("SELECT * FROM newsletter WHERE case_id='$case_id'");
  if (mysql_num_rows($result)>0) {
    
    $excel_txt='<div class="form-group">';
   $excel_txt.='<label class="col-sm-5 control-label"></label>';
   $excel_txt.='<div id="excel_box" class="col-sm-2">';
   $excel_txt.='<a id="excel_btn" href="output_excel.php?case_id='.$case_id.'&fun_id='.$fun_id.'" > 匯出Excel檔</a>';
   $excel_txt.='</div>';
   $excel_txt.='</div>';
   echo $excel_txt;
  }
 
?>

                                <input  type="hidden" name="page" value="newsletter">
                                <input type="hidden" name="case_id" value="<?php echo $case_id;?>">
                                <input type="hidden" name="fun_id" value="<?php echo $fun_id; ?>" />
                                <input type="hidden" name="rel_sort" value="<?php echo $rel_sort;?>">
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