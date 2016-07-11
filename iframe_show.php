<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';
    if (!empty($_POST['case_id'])) {
      $case_id=htmlspecialchars($_POST['case_id']);
    }else{
      $case_id=htmlspecialchars($_GET['caseId']);
    }
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>圖片輪播</title>
	<!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>


    <style type="text/css">
    body{
      height: auto;
      background-color: rgb(243,243,244);
    }
      .select_show_img{
        float: left;
        border:2px solid #007979;
        margin-right: 5px;
        border-radius: 5px 5px;

      }
      .select_show_img p{

        margin:0px;
        padding: 0px;
        background: #007979;
        
      }
      .select_show_img i{
        padding: 2px;
        background-color: #D1E9E9;
        font-size: 20px;
        color:#FF2D2D;

      }
      .select_show_img img{
        width: 150px;
      }
      .dz-default{
        display: none;
      }
      .dz-message{
        display: :none;
      }
    </style>

  <script type="text/javascript">  
  jQuery(document).ready(function($) {

   /* =========================================== 撈取多圖檔 ================================================ */
 <?php
  if (empty($_GET['funId'])) {
    
       /*################# 給幻燈片ID ##################*/    
  $result = db_conn("SELECT fun_id FROM slideshow_tb WHERE fun_id LIKE 'ss".date('Ymd')."%' ORDER BY fun_id DESC LIMIT 1" );
  while ($row=mysql_fetch_array($result)) { $row_fun=$row['fun_id']; }
   if (empty($row_fun)) {
              $fun_id='ss'.date('Ymd').'001';
            }else{
              $fun_id_down =(int)substr($row_fun, 10);
              $sum=$fun_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $fun_id='ss'.date('Ymd').$sum;
            }
  }

  else{

  $fun_id=htmlspecialchars($_GET['funId']);
  $result=db_conn("SELECT * FROM slideshow_tb WHERE fun_id='$fun_id'");
  if (mysql_num_rows($result)>0) {
      while ($row=mysql_fetch_array($result)) {
          $show_img=explode(',', $row['show_img']);
          $play_speed=$row['play_speed'];
      }
    
    for ($i=0; $i <count($show_img)-1 ; $i++) { 

      $small='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/product_html/'.$case_id.'/assets/images/'.$show_img[$i].'&h=100&w=150&zc=1';//縮圖
   
  $txt='<div class="del_show_img">';
  $txt.='<div class=" select_show_img dz-preview ">';
  $txt.='<p><i style="cursor:pointer" class="fa fa-times-circle"></i></p>';
  $txt.='<img src="'.$small.'" >';
  $txt.='<input type="hidden" name="noDelete_img'.$i.'" value="'.$show_img[$i].'" />';
  $txt.='</div>';
  $txt.='</div>';

echo "$('.dropzone-previews').append('".$txt."');";
 }

 echo "$('.select_show_img').find('i').click(function() {
 if(confirm('確定要刪除??')){ 
  $(this).parentsUntil('.del_show_img').remove(); 
  }  
});";

  } 
  }
  ?>

                Dropzone.options.myAwesomeDropzone = {
                paramName:'show',
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

                       alert('新增圖片輪播');
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
<body >
<div id="wrapper"style="background-color:#F0F0F0; padding-top:0px; " >
	 
	 	<div class="wrapper wrapper-content animated fadeInRight">
	 		<div  class="row">
	 			<!-- =========================================== 幻燈片編輯 ============================================= -->
                 <div id="show" class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>圖片輪播區塊編輯 </h5>
                        </div>
                        <div class="ibox-content">
                         <div class="row">
                            
                            <h2 class="col-sm-2 ">圖檔上傳  </h2>
                           
                            <form id="my-awesome-dropzone" method="POST" class="dropzone" action="rwd_php_sys.php" enctype='multipart/form-data'>
                            
                            <div class="form-group"><label class="col-sm-2 control-label">自動切換速度:</label>
                                    <div class="col-sm-3"><input type="text" id="play_speed" class="form-control" name="play_speed" value="<?php echo $play_speed;?>"></div>
                            </div>

                            <button type="button" id="update_img" class="btn btn-primary">上傳圖片</button>
                            <button type="submit" class="btn btn-primary ">圖檔儲存</button>
                            <br>
                            <div class="dropzone-previews showImg"></div>
                            <input type="hidden" name="page" value="slideshow">
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