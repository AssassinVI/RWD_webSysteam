<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';
    if (!empty($_POST['case_id'])) {
      $case_id=htmlspecialchars($_POST['case_id']);
    }else{
      $case_id=htmlspecialchars($_GET['caseId']);
    }
?>



<?php 

   if (empty($_GET['funId'])){
 /*################# 給YouTubeID ##################*/    

  $result = db_conn("SELECT fun_id FROM youtube_tb WHERE fun_id LIKE 'yu".date('Ymd')."%' ORDER BY fun_id DESC LIMIT 1" );

  if (mysql_num_rows($result)<1) {
      $fun_id='yu'.date('Ymd').'001';

  }else{

   while ($row=mysql_fetch_array($result)) {
        $fun_id_down =(int)substr($row['fun_id'], 10);
              $sum=$fun_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $fun_id='yu'.date('Ymd').$sum;
          }
      }
   }
   else{
      $fun_id=htmlspecialchars($_GET['funId']);
      $result = db_conn("SELECT you_adds, you_title FROM youtube_tb WHERE fun_id='$fun_id' " );
      while ($row=mysql_fetch_array($result)) {
         $you_adds=$row['you_adds'];
         $you_title=$row['you_title'];
         $you_title=explode("(*)", $you_title);
         if (!empty($you_title[0])) { $you_title1=$you_title[0]; }
         if (!empty($you_title[1])) { $you_title2=$you_title[1]; }
         if (!empty($you_title[2])) { $you_title3=$you_title[2]; }

      }
   } 
 ?>



<!DOCTYPE html>

<html >

<head>

	<meta charset="UTF-8">

	 <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>YouTube影片</title>

	<!-- ================================== 外掛and CSS ====================================== -->

    <?php include 'shared_php/script_style.php';?>

<style type="text/css">

body{

  height: 700px;

  background-color: rgb(243,243,244);

}

    #you_ifram iframe{

        width: 100%;

      }

</style>

<script type="text/javascript">

$(document).ready(function() {

     /* ===================================== YouTube顯示 ============================================= */

        $("#you_btn").click(function(event) {

            var str=$("#you_path").val();

             var array= str.split("=");

            if (str.indexOf("youtube")!=-1) {

                $("#you_ifram").html('<iframe width="560" height="350" src="https://www.youtube.com/embed/'+array[1]+'" frameborder="0" allowfullscreen></iframe>');

            }

            else {

                alert("請輸入正確YouTube影片網址!!");

            }

        });



      var youadds="<?php echo $you_adds;?>";

      if (youadds!="") {



             var array= youadds.split("=");

           $("#you_ifram").html('<iframe width="560" height="500" src="https://www.youtube.com/embed/'+array[1]+'" frameborder="0" allowfullscreen></iframe>');

      }



});

</script>

</head>

<body >

<div id="wrapper" style="background-color:#F0F0F0; padding-top:0px; " >

	 	<div class="wrapper wrapper-content animated fadeInRight">

	 		<div  class="row">

<!-- =========================================== YouTube編輯 ============================================= -->

                 <div id="you" class="col-lg-12">

                    <div class="ibox float-e-margins">

                        <div class="ibox-title">

                            <h5>YouTube影片區塊編輯 </h5>

                        </div>

                        <div class="ibox-content">

                         <div class="row">

                            <form action="rwd_php_sys.php" method="POST" class="form-horizontal">

                               
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">主標1</label>
                                    <div class="col-sm-3"><input type="text" maxlength="10" class="form-control" name="you_title1" value="<?php echo $you_title1;?>">
                                     
                                    </div>

                                    <label class="col-sm-1 control-label">主標2</label>
                                    <div class="col-sm-3"><input type="text" maxlength="10" class="form-control" name="you_title2" value="<?php echo $you_title2;?>"></div>

                                    <label class="col-sm-1 control-label">主標3</label>
                                    <div class="col-sm-3"><input type="text" maxlength="10" class="form-control" name="you_title3" value="<?php echo $you_title3;?>"></div>

                                    <label class="col-sm-1 control-label"></label>
                                    <div class="col-sm-10"><span class="help-block m-b-none">說明:主標可以一個或三個，最多三個，字數最大不可超過10個字</span></div>
                                   
                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">嵌入網址</label>

                                    <div class="col-sm-8"><input id="you_path" type="text" name="you_adds"  class="form-control" value="<?php echo $you_adds ;?>">
                                            <span class="help-block m-b-none">請輸入影片網址</span>
                                    </div>
                                    <div class="col-sm-2"><button id="you_btn" class="btn btn-default dim" type="button">顯示影片</button></div>
                                </div>

                                <div class="form-group">

                                <label class="col-sm-10 control-label"></label>

                                <div class="col-sm-2">

                                <button  class="btn btn-primary dim  " type="submit" > 送出</button>

                                </div>

                                </div>

                                <input type="hidden" name="page" value="youtube" />

                                <input type="hidden" name="case_id" value="<?php echo $case_id;?>">

                                <input type="hidden" name="fun_id" value="<?php echo $fun_id ; ?>" />

                                <input type="hidden" name="rel_sort" value="<?php echo $_POST['rel_sort'];?>">

                            </form>

                            <div class="col-sm-12" id="you_ifram"></div>

                           </div>

                        </div>

                    </div>

                </div>

	 		</div>

	 	</div>

	 

</div>

</body>

</html>