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
    
       /*################# 給圖片牆 ID ##################*/    
          $result = db_conn("SELECT fun_id FROM Related_tb WHERE fun_id LIKE 'iw".date('Ymd')."%' ORDER BY fun_id DESC LIMIT 1" );
          if (mysql_num_rows($result)<1) {

              $fun_id='iw'.date('Ymd').'001';
           }else{

             while ($row=mysql_fetch_array($result)) {
       
              $fun_id_down =(int)substr($row['fun_id'], 10);
              $sum=$fun_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $fun_id='iw'.date('Ymd').$sum;
          }
      }
  }
  else{
  $fun_id=htmlspecialchars($_GET['funId']);
  $pdo=pdo_conn(); //開資料庫
  $sql_q=$pdo->prepare("SELECT * FROM img_wall_tb WHERE fun_id=:fun_id");
  $sql_q->bindparam(":fun_id", $fun_id);
  $sql_q->execute();
  while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
    
     $img_file=explode(',', $row['img_file']);
  }

    
    for ($i=0; $i <count($img_file)-1 ; $i++) { 

      $small='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/product_html/'.$case_id.'/assets/images/'.$img_file[$i].'&h=100&w=150&zc=1';//縮圖
   
  $txt='<div class="del_img_file">';
  $txt.='<div class="select_img_file dz-preview ">';
  $txt.='<p><i style="cursor:pointer" class="fa fa-times-circle"></i></p>';
  $txt.='<img src="'.$small.'" >';
  $txt.='<input type="hidden" name="noDelete_img'.$i.'" value="'.$img_file[$i].'" />';
  $txt.='</div>';
  $txt.='</div>';

echo "$('.dropzone-previews').append('".$txt."');";
 }

 echo "$('.select_img_file').find('i').click(function() {
 if(confirm('確定要刪除??')){ 
  $(this).parentsUntil('.del_img_file').remove(); 
  }  
});";

  }

  

?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title>圖片牆</title>
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
    .dz-default{
        display: none;
      }
      .dz-message{
        display: :none;
      }
    
    </style>

    <script type="text/javascript">
       $(document).ready(function() {

              Dropzone.options.myAwesomeDropzone = {
                paramName:'wall',
                addRemoveLinks:true,
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,
                acceptedFiles:'image/*',
                clickable: "#update_img",
                previewsContainer:".showImg",
                // Dropzone settings
                init: function() {
                    var myDropzone = this;

                    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                     /* 判斷有無新檔案 */
                      if (myDropzone.getAcceptedFiles()!="") {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();

                      }
                                               
                    });
                    this.on("sendingmultiple", function() {
                    });
                    this.on("successmultiple", function(files, response) {
                       var funId='<?php echo $_GET['funId'];?>';

                       alert('新增圖片牆');
                       if (funId=="") {
                          window.parent.location.replace('edit_funBox.php?case_id=<?php echo $_POST['case_id'];?>');
                       }
                       else{
                          
                          var fun_id=$("#fun_id").attr('value');
                         location.replace('iframe_show.php?funId='+fun_id+'&caseId=<?php echo $case_id;?>');
                       }
                      
                    });
                    this.on("errormultiple", function(files, response) {
                     
                    });
                }
            }
           
       });
    </script>
</head>
<body>
	<div id="wrapper"style="background-color:#F0F0F0; padding-top:0px; " >
	 
	 	<div class="wrapper wrapper-content animated fadeInRight">
	 		<div  class="row">
 <!-- =========================================== 圖片牆 ============================================= -->
              <div  class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-content">
                         <div class="row">
                             <form id="my-awesome-dropzone" method="POST" class="dropzone" action="rwd_php_sys.php" enctype='multipart/form-data'>

                            <button type="button" id="update_img" class="btn btn-primary">上傳圖片</button>
                            <button type="submit" class="btn btn-primary ">送出</button>
                            <br>
                            <div class="dropzone-previews showImg"></div>
                            <input type="hidden" name="page" value="imgwall">
                            <input type="hidden" name="case_id" value="<?php echo $case_id;?>">
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