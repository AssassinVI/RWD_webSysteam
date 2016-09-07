

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

       /*################# 給基本圖文ID ##################*/    
          $result = db_conn("SELECT fun_id FROM base_word WHERE fun_id LIKE 'bs".date('Ymd')."%' ORDER BY fun_id DESC LIMIT 1" );
          if (mysql_num_rows($result)<1) {
              $fun_id='bs'.date('Ymd').'001';
           }else{
             while ($row=mysql_fetch_array($result)) {
              $fun_id_down =(int)substr($row['fun_id'], 10);
              $sum=$fun_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $fun_id='bs'.date('Ymd').$sum;
          }
      }
   }

   else{

    $fun_id=htmlspecialchars($_GET['funId']);
    $result = db_conn("SELECT * FROM base_word WHERE fun_id='$fun_id' " );
      while ($row=mysql_fetch_array($result)) {
         $title=$row['title'];
         $title_two=$row['title_two'];
         $edit_word=html_entity_decode($row['edit_word'], ENT_QUOTES, "UTF-8");
         $base_img=$row['base_img'];
         $txt_fadein=$row['txt_fadein'];
         $img_fadein=$row['img_fadein'];
         $line_show=$row['line_show'];
         $big_img=$row['big_img'];

         $title=explode("(*)", $title);
         if (!empty($title[0])) {  $title1=$title[0];  }
         if (!empty($title[1])) {  $title2=$title[1];  }
         if (!empty($title[2])) {  $title3=$title[2];  }
      }
   }
?>


<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>基本圖文</title>
  <link rel="shortcut icon" href="favicon.ico" />

	<!-- ================================== 外掛and CSS ====================================== -->

    <?php include 'shared_php/script_style.php';?>
    <style type="text/css">
     body{
  height: auto;
  background-color: rgb(243,243,244);
  font-family: 微軟正黑體;
}

     .select_base_img{
        float: left;
        border:2px solid #007979;
        margin-right: 5px;
        border-radius: 5px 5px;
      }

      .select_base_img p{
        margin:0px;
        padding: 0px;
        background: #007979;
      }

      .select_base_img i{
        padding: 2px;
        background-color: #D1E9E9;
        font-size: 20px;
        color:#FF2D2D;
      }

      .select_base_img img{
        width: 100px;
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


/* =============================================== 檔案上傳 ========================================================= */

              Dropzone.options.myAwesomeDropzone = {
                paramName:'base',
                addRemoveLinks:true,
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,
                acceptedFiles:'image/*',
                clickable: "#clickable",
                previewsContainer:".baseImg",

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

                      alert('更新基本圖文');
                      var funId='<?php echo $_GET['funId'];?>';
                      if (funId=="") {
                         window.parent.location.replace('edit_funBox.php?case_id=<?php echo $_POST['case_id'];?>');
                      }
                      else{
                          var fun_id=$("#fun_id").attr('value');
                          location.replace('iframe_base.php?funId='+fun_id+'&caseId=<?php echo $case_id;?>');
                      }
                    });

                    this.on("errormultiple", function(files, response) {

                    });
                }
            }



 /* ============================== summernote ===================================== */

                $('.summernote').summernote({
                lang: 'zh-TW', // default: 'en-US'
                height:500,
                toolbar: [//定制工具栏，格式:['自定义分组名',['规定组内元素列表',]],
                           ['font-name',['fontname']],                        
                           ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['color',['color']],
                            ['para',['style','ul','ol','paragraph']],
                            ['insert',['link']],
                            ['height',['height']],
                           ['action',['undo','redo']],
                           ['help',['help']],
                           ['code-view',['codeview']]
                       ],
                fontNames: ['細明體', '標楷體', '微軟正黑體', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                placeholder:'可使用HTML編輯'
                });


              //  $('.summernote').code('<?php //echo $edit_word; ?>');//賦值給summernote
              /*  $("#base_submit").click(function() {
                  var edit_txt = $(".summernote").code(); //取得summernote的值
                   $("#edit_word").attr('value', edit_txt);

                });*/





 //          ## 文字飛入判斷 ##
                 var new_txt_fade=$("#txt_fadein_check").attr('value').substr(0,1);
                /* var txt_type=$("#txt_fadein_check").attr('value').substr(2);*/

                if (new_txt_fade=='y') {

                    document.getElementById("txt_fadein").checked=true;
                   /* $("#txt_fadein_type option[value='"+img_type+"']").attr('selected', 'selected');
                    $("#txt_fadein_type").css('display', 'inline');*/
                } 
                else{
                   /* $("#txt_fadein_type").css('display', 'none');*/
                }
                 
                 var new_img_fade=$("#img_fadein_check").attr('value').substr(0,1);
                 var img_type=$("#img_fadein_check").attr('value').substr(2);

                if (new_img_fade=='y') {

                    document.getElementById("img_fadein").checked=true;
                    $("#img_fadein_type option[value='"+img_type+"']").attr('selected', 'selected');
                    $("#img_fadein_type").css('display', 'inline');
                }
                else{
                    $("#img_fadein_type").css('display', 'none');
                }

                if ($("#line_show_check").attr('value')=='y') {

                    document.getElementById("line_show").checked=true;
                }
               
              /* 文字飛入 */

                /*$("#txt_fadein").change(function(event) {

                  if (document.getElementById("txt_fadein").checked==true) {
                    $("#txt_fadein_type").css('display', 'inline');
                   }
                  else{
                    $("#txt_fadein_type").css('display', 'none');
                  }
                });*/


           /* 圖片飛入特效 */

                $("#img_fadein").change(function(event) {

                  if (document.getElementById("img_fadein").checked==true) {
                    $("#img_fadein_type").css('display', 'inline');
                   }
                  else{
                    $("#img_fadein_type").css('display', 'none');
                  }
                });

 <?php 

  $base_img=explode(',', $base_img);

//------------------------------ 目前圖片 --------------------------------

   for ($i=0; $i <count($base_img)-1 ; $i++) { 

  $small='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/product_html/'.$case_id.'/assets/images/'.$base_img[$i].'&h=75&w=100&zc=1';//縮圖
     
  $txt='<div class="del_base_img">';
  $txt.='<div class=" select_base_img dz-preview ">';
  $txt.='<p><i style="cursor:pointer" class="fa fa-times-circle"></i></p>';
  $txt.='<img src="'.$small.'" >';
  $txt.='<input type="hidden" name="noDelete_img'.$i.'" value="'.$base_img[$i].'" />';
  $txt.='</div>';
  $txt.='</div>';

  echo "$('.dropzone-previews').append('".$txt."');";
   }

   echo "$('.select_base_img').find('i').click(function() {
 if(confirm('確定要刪除??')){ 
  $(this).parentsUntil('.del_base_img').remove(); 
  }  
});";

 ?>
        });

    </script>
</head>
<body >
<div id="wrapper"style="background-color:#F0F0F0; padding-top:0px; " >
	 	<div class="wrapper wrapper-content animated fadeInRight">
	 		<div  class="row">

 <!-- =========================================== 基本圖文編輯 ============================================= -->

                 <div id="base" class="col-lg-12">

                    <div class="ibox float-e-margins">

                        <div class="ibox-title">

                            <h5>基本圖文區塊編輯 </h5>

                        </div>

                        <div class="ibox-content">

                         <div class="row">

                            <form id="my-awesome-dropzone" method="POST" action="rwd_php_sys.php" class="dropzone form-horizontal" enctype='multipart/form-data'>

                                <div class="form-group"><label class="col-sm-1 control-label">主標1</label>
                                    <div class="col-sm-3"><input type="text" maxlength="10" name="title1" class="form-control" value="<?php echo $title1; ?>">
                                    </div>

                                    <label class="col-sm-1 control-label">主標2</label>
                                    <div class="col-sm-3"><input type="text" maxlength="10" name="title2" class="form-control" value="<?php echo $title2; ?>"></div>

                                     <label class="col-sm-1 control-label">主標3</label>
                                    <div class="col-sm-3"><input type="text" maxlength="10" name="title3" class="form-control" value="<?php echo $title3; ?>"></div>

                                    <label class="col-sm-1 control-label"></label>
                                    <div class="col-sm-10">
                                    <span class="help-block m-b-none">說明:主標可以一個或三個，最多三個，字數最大不可超過10個字</span>
                                    </div>

                                </div>
                                 

                                <div class="form-group"><label class="col-sm-1 control-label">副標</label>

                                    <div class="col-sm-10">

                                    <textarea name="title_two" class="summernote"><?php echo $title_two; ?></textarea>

                                    </div>

                                </div>

                                <div class="form-group"><label class="col-sm-1 control-label">圖片</label>

                                    <div class="col-sm-10">
                                    <button id="clickable"  class="btn btn-primary dim  " type="button" > 圖片上傳</button>
                                    <span class="help-block m-b-none">說明:將圖片尺寸寬度定為1680px，可呈現較好的視覺效果</span>
                                     <div class="dropzone-previews baseImg"></div>

                                    </div>

                                </div>

                                <div class="form-group"><label class="col-sm-1 control-label">空拍放大連結</label>

                                    <div class="col-sm-10">

                                    <input type="text" name="big_img" class="form-control" value="<?php echo $big_img; ?>">

                                    </div>

                                </div>

                                <div class="form-group">

                                <label class="col-sm-2 control-label">動畫效果</label>

                                <div class="col-sm-3 i-checks"><label> <input type="checkbox" id="txt_fadein" name="txt_fadein" value="y"> 文字飛入</label><br>
                                <!--<label>特效:</label>
                                <select id="txt_fadein_type" name="txt_fadein_type">
                                     <option value="bounce">bounce</option>
                                     <option value="flash">flash</option>
                                     <option value="pulse">pulse</option>
                                     <option value="rubberBand">rubberBand</option>
                                     <option value="bounceIn">bounceIn</option>
                                     <option value="bounceInLeft">bounceInLeft</option>
                                     <option value="bounceInRight">bounceInRight</option>
                                     <option value="flipInX">flipInX</option>
                                     <option value="flipInY">flipInY</option>
                                   </select>-->
                                 <span class="help-block m-b-none">說明:如不勾選即為靜態</span>
                                </div>
                      
                                <div class="col-sm-3 i-checks">
                                   <label> <input type="checkbox" id="img_fadein" name="img_fadein" value="y">  圖片飛入</label><br>
                                   <label>特效:</label>
                                   <select id="img_fadein_type" name="img_fadein_type">
                                     <option value="bounce">bounce</option>
                                     <option value="flash">flash</option>
                                     <option value="pulse">pulse</option>
                                     <option value="rubberBand">rubberBand</option>
                                     <option value="bounceIn">bounceIn</option>
                                     <option value="bounceInLeft">bounceInLeft</option>
                                     <option value="bounceInRight">bounceInRight</option>
                                     <option value="flipInX">flipInX</option>
                                     <option value="flipInY">flipInY</option>
                                   </select>
                                </div>

                                </div>


                                <div class="form-group">

                                <label class="col-sm-2 control-label">分隔線</label>

                                <div class="col-sm-3 i-checks"><label> <input type="checkbox" id="line_show" name="line_show" value="y"> <i></i> 是否顯示</label>
                                </div>

                                </div>



                                <div class="ibox-content no-padding">

                                  <div class="ibox-title">

                            <h4>內文</h4>

                             </div>

                                <textarea name="edit_word" class="summernote"><?php echo $edit_word; ?></textarea>

                        </div>

                        <div class="form-group">

                                <label class="col-sm-10 control-label"></label>

                                <div class="col-sm-2">

                                <button type="submit" id="base_submit"  class="btn btn-primary dim" > 送出</button>

                                </div>

                                </div>

                                <input  type="hidden" name="page" value="base">

                                <input type="hidden" name="case_id" value="<?php echo $case_id;?>">

                                <input id="fun_id" type="hidden" name="fun_id" value="<?php echo $fun_id ; ?>" />

                                <input type="hidden" name="rel_sort" value="<?php echo $_POST['rel_sort'];?>">

                                <input type="hidden" id="txt_fadein_check" value="<?php echo $txt_fadein;?>"><!-- 暫存文字飛入值 -->

                                <input type="hidden" id="img_fadein_check" value="<?php echo $img_fadein;?>"><!-- 暫存圖片飛入值 -->
                                <input type="hidden" id="line_show_check" value="<?php echo $line_show;?>"><!-- 暫存分隔線 -->

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