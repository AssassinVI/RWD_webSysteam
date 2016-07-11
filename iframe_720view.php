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
 /*################# 給720環景ID ##################*/    

  $result = db_conn("SELECT fun_id FROM view720_tb WHERE fun_id LIKE 'vi".date('Ymd')."%' ORDER BY fun_id DESC LIMIT 1" );

  if (mysql_num_rows($result)<1) {
      $fun_id='vi'.date('Ymd').'001';

  }else{

   while ($row=mysql_fetch_array($result)) {
        $fun_id_down =(int)substr($row['fun_id'], 10);
              $sum=$fun_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $fun_id='vi'.date('Ymd').$sum;
          }
      }
   }
   else{
      $fun_id=htmlspecialchars($_GET['funId']);
      $result = db_conn("SELECT * FROM view720_tb WHERE fun_id='$fun_id' " );
      while ($row=mysql_fetch_array($result)) {

         $view720_title=$row['view720_title'];
              $view_img=$row['view_img'];
             $view_file=$row['view_file'];
               $x_point=$row['x_point'];
               $y_point=$row['y_point'];
             $point_txt=$row['point_txt'];
            $point_link=$row['point_link'];

            $view720_title=explode("(*)", $view720_title);
            if (!empty($view720_title[0])) { $view720_title1=$view720_title[0]; }
            if (!empty($view720_title[1])) { $view720_title2=$view720_title[1]; }
            if (!empty($view720_title[2])) { $view720_title3=$view720_title[2]; }
      }
   } 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>720環景</title>
		<!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>

    <style type="text/css">
    body{
    	height: 1400px;
    	 background-color: rgb(243,243,244);
       font-family: 微軟正黑體;
    }
      #p720_box ,#p720_box img{
      	position: relative;
        margin:auto;
      	width: 700px;
      	height: 700px; 
      }
      #p720_box{
        display: none;
      }
      #p720_box div{
      	position: absolute;
      z-index: 100;
      }
      #p720_box div>a>img{
      	width: 40px;
      	height: 40px;
      }
     #p720_box .po_txt{
       border: 1px solid #BEBEBE;
       padding:15px;
       background-color: #fff;
       border-radius: 7px 7px;
       width: 300px;
       display: none;
     }
     .po_txt input{
      margin:5px;
     }
     .po_del{
      float: right;
      padding: 2px;
     }
     .po_del, .po_close{
       font-size: 15px;
     }
     .po_link, .po_name{
      width: 250px;
     }
     #view_file_p{
      padding: 8px;
      border-radius: 7px 7px ;
      background: #78EDED;
      font-size: 20px;
      color: #003838;
      width: 250px;
      text-align: center;
     }
    .dz-default ,.dz-message{
        display: none;
      }
    </style>
    <script type="text/javascript">
    	$(document).ready(function() {
            //---取得座標值---
            var x_point="";
            var y_point="";

          //---設定光點---
    		$("#p720_box").find('img').mousedown(function(e) {
    			var objleft=$(this).offset().left;
    			var objtop=$(this).offset().top;
    			var x=(e.pageX-objleft-20)/7;
    			var y=(e.pageY-objtop-20)/7;
                     var point_html='<div style="left:'+x+'%; top:'+y+'%">';
              point_html=point_html+'<a class="point_btn" href="#"><img src="img/光.png" ></a>';
              point_html=point_html+'<div style="left:'+x+'%; top:'+y+'%" class="po_txt">';
              point_html=point_html+'<label>名稱</label><input type="text" maxlength="4" class="po_name" /><br>';
              point_html=point_html+'<label>環景連結</label><input type="text" class="po_link" /><br>';
              point_html=point_html+'<a href="#" class="po_close">關閉</a>';
              point_html=point_html+'<a href="#" class="po_del">刪除</a>';
              point_html=point_html+'</div>';
              point_html=point_html+'</div>';
    			$("#p720_box").append(point_html);
    		});
       
       $("#p720_box").on('click', '.point_btn', function(event) { //顯示按鈕
         event.preventDefault();
           $(this).next().slideDown('400');
       });
      
       $("#p720_box").on('click', '.po_close', function(event) { //關閉按鈕
         event.preventDefault();
         $(this).parent().slideUp('400');
       });

       $("#p720_box").on('click', '.po_del', function(event) { //刪除按鈕
         event.preventDefault();
         if (confirm('確定要刪除??')) {
           $(this).parent().prev().remove();
          $(this).parent().remove();
         }
       });
      
      


      //判斷俯視圖
      var view_img="<?php echo $view_img;?>";
      if (view_img!="") {
         $('#p720_box').css('display', 'block');
      }


     //#################################################### 撈出光點 ##############################################
     var x_point="<?php echo $x_point;?>";
     var y_point="<?php echo $y_point;?>";
     var point_txt="<?php echo $point_txt;?>";
     var point_link="<?php echo $point_link;?>";

     if (x_point!='') {
        x_point=x_point.split(",");
        y_point=y_point.split(",");
        point_txt=point_txt.split(",");
        point_link=point_link.split(",");
        for (var i = 0; i < x_point.length-1; i++) {
           
            var point_html='<div style="left:'+x_point[i]+'%; top:'+y_point[i]+'%">';
              point_html=point_html+'<a class="point_btn" href="#"><img src="img/光.png" ></a>';
              point_html=point_html+'<div style="left:'+x_point[i]+'%; top:'+y_point[i]+'%" class="po_txt">';
              point_html=point_html+'<label>名稱</label><input type="text" maxlength="4" class="po_name" value="'+point_txt[i]+'" /><br>';
              point_html=point_html+'<label>環景連結</label><input type="text" class="po_link" value="'+point_link[i]+'" /><br>';
              point_html=point_html+'<a href="#" class="po_close">關閉</a>';
              point_html=point_html+'<a href="#" class="po_del">刪除</a>';
              point_html=point_html+'</div>';
              point_html=point_html+'</div>';
          $("#p720_box").append(point_html);
        }
     }



      // ## 送出 ##
      $(".view_btn").click(function(event) {
         var x=""; var y=""; var name=""; var link="";

        $(".point_btn").parent().each(function(index, el) {
           var x_po=$(this).css('left').split("px");
           var y_po=$(this).css('top').split("px");
           x_po=parseInt(x_po[0])/7;
           y_po=parseInt(y_po[0])/7;
           x=x+x_po+",";//座標x
           y=y+y_po+","; //座標y
           name=name+$(this).find('.po_name').val()+",";// 名稱
           link=link+$(this).find('.po_link').val()+",";// 連結
        });

         $("#x_point").attr('value', x);
         $("#y_point").attr('value', y);
         $("#point_txt").attr('value', name);
         $("#point_link").attr('value', link);
      });


    	});//jquery_END

    function file_viewer_load(controller) { //預覽圖片方法
            var file=controller.files[0];
             if (file==null) {
                $('#p720_box').find('img').attr('src', '');
             }
             else{
                var fileReader= new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onload = function(event){
                 $('#p720_box').find('img').attr('src', this.result);
                 $('#p720_box').css('display', 'block');
             }
            };
          }
    </script>

    <script type="text/javascript">
      $(document).ready(function() {

  /* =============================================== 檔案上傳 ========================================================= */

              Dropzone.options.myAwesomeDropzone = {
                paramName:'view_file',
                addRemoveLinks:true,
                autoProcessQueue: false,
                uploadMultiple: false,
                parallelUploads: 100,
                maxFiles: 100,
                acceptedFiles:'application/zip,application/x-zip,application/x-zip-compressed',
                clickable: "#clickable",
                previewsContainer:".baseImg",

                // Dropzone settings
                init: function() {
                    var myDropzone = this;
                    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {

                     // 判斷有無新檔案 

                      if (myDropzone.getAcceptedFiles()!="") {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                      }

                    });
                    this.on("sending", function() {
                    });

                    this.on("success", function(files, response) {

                       alert("更新720環景");
                        $(".view_btn").css('display', 'block');
                       var funId='<?php echo $_GET['funId'];?>';
                      if (funId=="") {
                         window.parent.location.replace('edit_funBox.php?case_id=<?php echo $_POST['case_id'];?>');
                      }
                      else{
                          
                          location.replace('iframe_720view.php?funId='+funId+'&caseId=<?php echo $case_id;?>');
                      }

                    });
                    
                    this.on("error", function(files, response) {

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
                  <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>720環景區塊編輯 </h5>

                        </div>
                        <div class="ibox-content">
                         <div class="row">
                            <form id="my-awesome-dropzone" method="POST" action="rwd_php_sys.php" class="dropzone form-horizontal" enctype='multipart/form-data'>
                              
                                <div class="form-group">
                                   <label class="col-sm-1 control-label">主標1</label>
                                    <div class="col-sm-3"><input type="text" maxlength="10" class="form-control" name="view720_title1" value="<?php echo $view720_title1;?>"></div>

                                   <label class="col-sm-1 control-label">主標2</label>
                                    <div class="col-sm-3"><input type="text" maxlength="10" class="form-control" name="view720_title2" value="<?php echo $view720_title2;?>"></div>

                                   <label class="col-sm-1 control-label">主標3</label>
                                    <div class="col-sm-3"><input type="text" maxlength="10" class="form-control" name="view720_title3" value="<?php echo $view720_title3;?>"></div>

                                    <label class="col-sm-1 control-label"></label>
                                    <div class="col-sm-10"><span class="help-block m-b-none">說明:主標可以一個或三個，最多三個，字數最大不可超過10個字</span></div>                              
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">俯視圖</label>
                                    <div class="col-sm-10">
                                    <input type="file" class="form-control" name="view_img" onchange="file_viewer_load(this)" accept="image/*">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">環景檔案</label>
                                    <div class="col-sm-10">
                                    <button id="clickable" class="btn btn-primary" type="button">選擇檔案</button>
                                    <div class="dropzone-previews baseImg"></div>
                                    <span class="help-block m-b-none">說明:請上傳.ZIP的壓縮檔，如要更換檔案請直接上傳新的壓縮檔即可</span>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-5">
                                      <p id="view_file_p">目前環景檔案: <?php echo $view_file;?></p>
                                    </div>
                                </div>


                        <div class="form-group">
                                <label class="col-sm-10 control-label"></label>
                                <div class="col-sm-2">
                                 <button  class="btn btn-primary dim view_btn " type="submit" > 送出</button>
                                </div>
                                </div>
                                <p style="font-size: 18px;text-align: center;"> 點擊圖片即產生一個光點 </p>
                                <p style="font-size: 18px;text-align: center;"> 點擊光點，即可輸入名稱、環景連結 </p>
                           <div id="p720_box">
		                    <img src="../product_html/<?php echo $case_id ;?>/assets/images/<?php echo $view_img;?>" alt="">
	                       </div>
                                <input type="hidden" name="page" value="view720">
                                <input type="hidden" id="x_point" name="x_point" value="<?php echo $x_point;?>">
                                 <!-- X座標 -->
                                <input type="hidden" id="y_point" name="y_point" value="<?php echo $y_point;?>"> 
                                <!-- Y座標 -->
                                <input type="hidden" id="point_txt" name="point_txt" value="<?php echo $point_txt;?>"> 
                                <!-- 名稱 -->
                                <input type="hidden" id="point_link" name="point_link" value="<?php echo $point_link;?>">
                                 <!-- 連結 -->
                                 <input type="hidden" name="view_img" value="<?php echo $view_img;?>">
                                 <input type="hidden" name="view_file" value="<?php echo $view_file;?>">
                                <input type="hidden" name="case_id" value="<?php echo $case_id;?>">
                                <input type="hidden" name="fun_id" value="<?php echo $fun_id ; ?>" />
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