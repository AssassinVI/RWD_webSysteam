<?php include 'shared_php/login_session.php';

  // =====================資料庫連接 =================

      include 'shared_php/config.php';
?>



<?php

if ($_GET['NewOrEdit']=='edit') {

    $result = db_conn("SELECT * FROM build_case WHERE case_id='".$_GET['case']."'");

    while ($row=mysql_fetch_array($result)) {
    $com_id=$row['com_id'];
    $case_id=$row['case_id'];   
    $case_name=$row['case_name'];
    $google_an=$row['google_an'];
    $google_code=$row['google_code'];
    $google_view_code=$row['google_view_code'];
    $build_com=$row['build_com'];
    $Consignment=$row['Consignment'];
    $marquee=$row['marquee'];
    $format=$row['format'];
    $floor=$row['floor'];
    $build_adds=$row['build_adds'];
    $bu_phone=$row['bu_phone'];
    $line_tool=$row['line_tool'];
    $bu_line=$row['bu_line'];
    //$bu_fb=$row['bu_fb'];
    $activity_img=$row['activity_img'];
    $activity_song=$row['activity_song'];
    $case_logo=$row['case_logo'];
    $other=html_entity_decode($row['other'], ENT_QUOTES, "UTF-8"); 

    $inOrup='update';

    }

  
 } elseif ($_GET['NewOrEdit']=='new') {
    $User_id="";
    $case_id="";
    $case_name="";
    $build_com="";
    $Consignment="";
    $format="";
    $floor="";
    $build_adds="";
    $bu_phone="";
    $bu_line="";
    $other="";

    $inOrup='insert';

 }
?>


<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>專案網站編輯</title>
    <!-- 外掛AND CSS -->
	<?php include 'shared_php/script_style.php';?>
     <!-- ICheck -->
	 <link href="css/plugins/iCheck/custom.css" rel="stylesheet">

     <script src="js/plugins/iCheck/icheck.min.js"></script>

    <style type="text/css">

     #file_view, #logo_view {
        width: 150px;
        box-shadow: 0px 3px 5px #3C3C3C;
        border-radius: 5px 5px;
        overflow: hidden;
     }

     #file_music ,#old_file_music{
      width: 300px;
     }

     #file_view img, #old_file_view img ,#logo_view img ,#old_logo_view img{
      width: 100%;
       border-radius: 5px 5px;
     }

     #file_view p , #old_file_view p, #logo_view p, #old_logo_view p, #file_music p, #old_file_music p{
      padding:5px;
      font-size: 20px; 
      text-align: center;
      margin:0px;
      background-color: #4ECDC4;
      color: #fff;
      cursor:pointer;
     }

     #file_view p, #file_music p{
      cursor:default;
     }

     #old_file_view, #old_logo_view{
      float: right;
      width: 150px; 
      box-shadow: 0px 3px 5px #3C3C3C;
      border-radius: 5px 5px;
      overflow: hidden;
     }
     .now_com{
      font-size: 18px;
     }
     #summernote{
      width: 1000px;
      height: 300px;
     }


    </style>



	<script type="text/javascript">

		$(document).ready(function () {

			    $('.summernote').summernote({
                height:300,
                lang: 'zh-TW', // default: 'en-US'
                toolbar: [//定制工具栏，格式:['自定义分组名',['规定组内元素列表',]],
                           ['font-name',['fontname']],                        
                           ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['color',['color']],
                            ['para',['ul','ol']],
                            ['insert',['link']],
                            ['height',['height']],
                           ['action',['undo','redo']],
                           ['help',['help']],
                           ['code-view',['codeview']]
                       ],
                  fontNames: ['細明體', '標楷體', '微軟正黑體', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New']
                });

               /* $("#summernote").code('<?php //echo $other?>'); //賦值給summernote
                $("#build_save").click(function() {
                    var summernote_txt=$("#summernote").code(); //取得summernote的值
                  $("#other_in").attr('value', summernote_txt ); //轉移專案說明文到other_in裡
                });*/

              
                if ($("#checkbox_txt").attr('value')=='y') {
                    document.getElementById("google_an").checked=true;
                } 



   // ========================================燈箱===================================

                $("#cat_line").fancybox({
               'width'                 : '65%',
               'height'               : '80%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
                });



                $("#build_back").click(function() {
                    if (confirm('確定要取消??')) {
                         window.history.back();
                    }
                });    


                /* 顯示目前LOGO圖 */

                var active_img="<?php echo $case_logo;?>";

                if (active_img!="") {

                  var case_id="<?php echo $case_id;?>";

                  var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/case_logo/'+case_id+'.jpg&h=95&w=150&zc=1';//縮圖

                   $("#old_logo_view").html('<p><i class="fa fa-times-circle"></i>目前LOGO圖</p><img  src="'+small_img+'" alt=""><input name="old_case_logo" type="hidden" value="'+case_id+'.jpg" />');

                }    



               /* 顯示目前活動圖 */

                var active_img="<?php echo $activity_img;?>";

                if (active_img!="") {

                  var case_id="<?php echo $case_id;?>";

                  var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/product_html/'+case_id+'/assets/images/activ_img.jpg&h=95&w=150&zc=1';//縮圖

                   $("#old_file_view").html('<p><i class="fa fa-times-circle"></i>目前活動圖</p><img  src="'+small_img+'" alt=""><input name="activity_img" type="hidden" value="activ_img.jpg" />');

                }  

               

               /* 顯示目前音樂檔 */

               var activity_song="<?php echo $activity_song;?>";

               if (activity_song!="") {

                 var case_id="<?php echo $case_id;?>";

                 $("#old_file_music").html('<p><i class="fa fa-times-circle"></i>目前音樂檔</p><audio controls="controls"><source src="../product_html/'+case_id+'/music/activity_song.mp3" type="audio/mp3" /></audio><input name="activity_song" type="hidden" value="activity_song.mp3" /> ')

               }



               $('#file_box').find('p').click(function() {
                 if(confirm('確定要刪除??')){ 
                     $(this).parent('.del_file').remove(); 
                   }  
                });

                //更改公司
               $("#select_com").change(function(event) {
                  
                  var new_com=$("#select_com").find(":selected").val();
                  $("#sel_com").attr('value',new_com);
               });

               //LINE功能選擇
               $("#select_line").change(function(event) {

                 var select_line=$("#select_line").find(":selected").val();
                 $("#line_tool").attr('value',select_line);

                 if (select_line=="line_plus") {

                    var line_info='<label class="col-sm-2 control-label">加Line</label>';
          var line_info=line_info+'<div class="col-sm-4">';

          var line_info=line_info+'<input name="bu_line" type="text" placeholder="請輸入網址" class="form-control" value="">';

          var line_info=line_info+'<span class="help-block m-b-none"><a id="cat_line" href="catch_line.html" target="_blank">使用說明</a></span>';

          var line_info=line_info+'</div>';

                    $("#cha_line").html(line_info);
                 }
                 else if(select_line=="line_share"){

                  var line_info='<label class="col-sm-2 control-label">Line分享</label>';
          var line_info=line_info+'<div class="col-sm-4">';
          var line_info=line_info+'<input name="bu_line" type="text" placeholder="可同時輸入要分享的文字或網址" class="form-control" value="">';
          var line_info=line_info+'<span class="help-block m-b-none">輸入您要分享的文字、網址</span>';
          var line_info=line_info+'</div>';

                    $("#cha_line").html(line_info);
                 }
               });


               

            }); //jquery END



    function file_viewer_load(controller,html_id) { //預覽圖片方法

            var file=controller.files[0];
             if (file==null) {
                $('#file_view').html('');
             }
             else{
                var fileReader= new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onload = function(event){
                $(html_id).html('<p>圖片預覽</p><img  src="'+this.result+'" alt=""><input name="activity_img" type="hidden" value="activ_img.jpg" />');
             }
            };
          }

   function file_song_load(controller) { //預覽音樂方法

            var file=controller.files[0];

             if (file==null) {
                $('#file_music').html('');
              }
              else{
               var fileReader= new FileReader();
               fileReader.readAsDataURL(file);
               fileReader.onload = function(event){

               $('#file_music').html('<p>背景音樂</p><audio controls="controls"><source src="'+this.result+'" type="audio/mp3" /></audio><input name="activity_song" type="hidden" value="activity_song.mp3" />');
              }
            };
          }

	</script>

</head>

<body style="font-family: 微軟正黑體">

	<div id="wrapper">

		<!-- ============================== 導航欄位 =================================== -->

    <?php include 'shared_php/navbar-default.php';?>
     <div id="page-wrapper" class="gray-bg">
     	  <!-- ============================== TOP欄位 =================================== -->

        <?php include 'shared_php/top_bar.php';?>
         <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>編輯專案 </h5>
                            <div class="ibox-tools">
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method="POST" action="rwd_php_sys.php" class="form-horizontal" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">公司選擇 : </label>
                                    <div class="col-sm-3">
                                    <select id="select_com" class="form-control">
                                    <option value="<?php echo $com_id;?>">請選擇</option>
                                      <?php 
                                      //抓該建案使用者
                                        $User_id=htmlspecialchars($_SESSION['user_id']);
                                         $result=db_conn("SELECT * FROM company WHERE User_id='$User_id'");
                                         if (mysql_num_rows($result)>0) {
                                            while ($row=mysql_fetch_array($result)) {
                                               $comId=$row['com_id'];
                                               $comName=$row['com_name'];
                                               echo "<option value='".$comId."'>".$comName."</option>";
                                            }
                                         }
                                      ?>
                                    </select>
                                    </div>
                                    <div class=" col-sm-5">
                                       <?php
                                         $result=db_conn("SELECT * FROM company WHERE com_id='$com_id'");
                                         if (mysql_num_rows($result)) {
                                           while ($row=mysql_fetch_array($result)) {
                                             echo "<p class='now_com'>目前公司: ".$row['com_name']."</p>";
                                           }
                                         }
                                        
                                        ?>
                                    </div>
                                </div>     

                                <div class="form-group"><label class="col-sm-2 control-label">建案LOGO :</label>
                                    <div class="col-sm-4">
                                       <input name="case_logo" type="file" accept="image/*" class="form-control" onchange="file_viewer_load(this,'#logo_view')" >
                                       <div id="old_logo_view" class="del_file"></div>
                                       <div id="logo_view" class="del_file"></div>
                                    </div>
                                </div>                       

                                <div class="form-group"><label class="col-sm-2 control-label">建案名稱 :</label>

                                    <div class="col-sm-8">
 <?php 
      if (($_SESSION['competence']!="admin") and (!empty($case_name))) {
                              
          echo '<input readonly name="case_name" type="text" class="form-control" value="'.$case_name.'">';      
      }
      else{
         
         echo '<input name="case_name" type="text" class="form-control" value="'.$case_name.'">';
      }
 ?>
                                    </div>

                                    <div class=""><label> <input id="google_an" name="google_an" type="checkbox" value="y"> <i></i> Google分析 </label></div>

                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">建設公司 :</label>

                                    <div class="col-sm-4"><input name="build_com" type="text" class="form-control" value="<?php echo $build_com;?>"></div>

                                    <label class="col-sm-1 control-label">代銷公司 :</label>

                                    <div class="col-sm-4"><input name="Consignment" type="text" class="form-control" value="<?php echo $Consignment;?>"></div>

                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">格局說明 :</label>

                                    <div class="col-sm-4"><input name="format" type="text" class="form-control" value="<?php echo $format;?>">

                                    <!--<span class="help-block m-b-none">房數，例如:2~4房</span>-->

                                    </div>

                                    <label class="col-sm-1 control-label">坪 數 :</label>

                                    <div class="col-sm-4"><input name="floor" type="text" class="form-control" value="<?php echo $floor;?>"></div>

                                </div>
                                <div class="form-group">

                                    <label class="col-sm-2 control-label">Line功能選擇 :</label>
                                    <div class="col-sm-4">
                                      <select id="select_line" class="form-control">
                                        <option value="line_share">請選擇</option>
                                        <option value="line_plus">加LINE群組</option>
                                        <option value="line_share">LINE分享</option>
                                      </select>
                                    </div>

                                    <div class="col-sm-5">
                                     <?php 
                                      if ($line_tool=="line_plus") {
                                        echo "<p class='now_com'>目前LINE功能: 加LINE群組</p>";
                                      }
                                      elseif ($line_tool=="line_share") {
                                        echo "<p class='now_com'>目前LINE功能: LINE分享</p>";
                                      }
                                     ?>
                                    </div>
                                 </div>

                               <!-- LINE分享或加LINE -->
                                <div id="cha_line" class="form-group">
      <?php 
      if ($line_tool=="line_plus") {
        echo '<label class="col-sm-2 control-label">加Line :</label>';
        echo '<div class="col-sm-4">';
        echo '<input name="bu_line" type="text" placeholder="請輸入網址" class="form-control" value="'.$bu_line.'">';
        echo '<span class="help-block m-b-none"><a id="cat_line" href="catch_line.html" target="_blank">使用說明</a></span>';
        echo '</div>';

        }
        elseif ($line_tool=="line_share") {
        echo '<label class="col-sm-2 control-label">LINE分享 :</label>';
        echo '<div class="col-sm-4">';
        echo '<input name="bu_line" type="text" placeholder="可同時輸入要分享的文字或網址" class="form-control" value="'.$bu_line.'">';
        echo '<span class="help-block m-b-none">輸入您要分享的文字、網址</span>';
        echo '</div>';
        }
        ?>
                                  </div>

                                  <div class="form-group">
                                    <label class="col-sm-2 control-label">電 話 :</label>

                                    <div class="col-sm-4"><input name="bu_phone" type="text" class="form-control" value="<?php echo $bu_phone;?>"></div>

                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">基地位置 :</label>

                                    <div class="col-sm-10"><input name="build_adds" type="text" class="form-control" value="<?php echo $build_adds;?>"></div>

                                </div>



                               <div class="form-group"><label class="col-sm-2 control-label">跑馬燈 :</label>

                                    <div class="col-sm-10"><input name="marquee" type="text" placeholder="請輸入文字" class="form-control" value="<?php echo $marquee;?>">

                                    </div>

                                </div>

                                <div id="file_box" class="form-group"><label class="col-sm-2 control-label">背景音樂 :</label>

                                    <div class="col-sm-4">

                                    <div id="song_div">

                                    <input id="activity_song" name="activity_song" type="file" accept="audio/*" class="form-control" onchange="file_song_load(this)" >
                                      <span class="help-block m-b-none">說明:如不需背景音樂，將"目前音樂檔"刪除後儲存即可</span>
                                    </div>

                                    <div id="old_file_music" class="del_file"></div>

                                    <div id="file_music" class="del_file"></div>

                                    </div>



                                    <label class="col-sm-1 control-label">活動圖 :</label>

                                    <div class="col-sm-4">

                                    <div id="img_div">

                                    <input id="activity_img" name="activity_img" type="file" accept="image/*" class="form-control" onchange="file_viewer_load(this,'#file_view')" >

                                    </div>

                                    <div id="old_file_view" class="del_file"></div>

                                    <div id="file_view" class="del_file"></div>

                                    </div>

                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">google分析追蹤編號 :</label>
                                    <div class="col-sm-8">
                                    <input name="google_code" type="text" placeholder="請輸入追蹤編號" class="form-control" value="<?php echo $google_code?>">
                                    <span class="help-block m-b-none">例如:UA-12345678-1</span>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">google分析檢視編號 :</label>
                                    <div class="col-sm-8">
                                    <input name="google_view_code" type="text" placeholder="請輸入檢視編號" class="form-control" value="<?php echo $google_view_code?>">
                                    <span class="help-block m-b-none">例如:123456789，9碼</span>
                                    </div>
                                </div>



 <!-- ========================================== 分隔線 ====================================================== -->

                                <div class="hr-line-dashed"></div>



                                  <div class="ibox-content no-padding">

                                  <div class="ibox-title">

                            <h5>專案說明文</h5>

                        </div>

                        <textarea name="other" id="summernote" ><?php echo $other?></textarea>

                    </div>

                     <div class="hr-line-dashed"></div>

                                <div class="form-group">

                                    <div class="col-sm-4 col-sm-offset-2">

                                        <button id="build_back" class="btn btn-white" type="button">取消</button>

                                        <button id="build_save" class="btn btn-primary" type="submit">儲存</button>

                                    </div>

                                </div>

                                <!--<input id="other_in" name="other" type="hidden" value="">-->  <!-- 存放見案說明文 -->
                                 <input name="page" type="hidden" value="build_case" /> <!-- 判斷頁面 -->
                                  <input id="checkbox_txt" type="hidden" value="<?php echo $google_an?>"> 
                                  <!-- 存放google分析值 -->
                                  <input id="case_id" name="case_id" type="hidden" value="<?php echo $case_id?>">
                                  <input id="inOrup" name="inOrup" type="hidden" value="<?php echo $inOrup?>">
                                  <input id="sel_com" name="sel_com" type="hidden" value="<?php echo $com_id;?>">
                                  <input id="line_tool" name="line_tool" type="hidden" value="<?php echo $line_tool;?>">

                            </form>

                        </div>

                    </div>

                </div>

            </div>

         </div>

         <!-- ============================== footer =================================== -->
        <?php include 'shared_php/footer.php';?>

     </div>

	</div>

</body>

</html>