<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';
      $case_id=htmlspecialchars($_GET['case_id']);
      $case_name=htmlspecialchars($_GET['case_name']);

?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯功能區塊</title>

    <!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>

    <style type="text/css">
      body{
        font-family: 微軟正黑體;
      }
      #funNew {
        color:#ECF5FF;
        background-color:#0080FF;
        padding: 7px;
        border-radius: 5px 5px;
       margin-top: 10px;
        margin-bottom: 10px;
        font-size: 17px;
      }

      .tra_shadow{
        transition: box-shadow 0.25s;
      }

      .tra_shadow:hover{
        box-shadow: 0px 3px 4px #7B7B7B;
      }

      #you_ifram iframe{
        width: 100%;
      }

      #if_show{
        width: 100%;
        /*height: 800px;*/
      }

      .sortBox_holder{
        background: rgba(255, 226, 82,0.6);
        border-radius: 8px 8px;
        margin-right: 10px;
        height: 40px;
        width: 150px;
        float: left;
      }

      #up_sort{
        display: none;
        margin-right: 100px;
      }

      #btn_row{
        max-width: 80%;
      }

      .del_box{
        width: 200px;
      }

      .hand_btn{
        width: 130px;
      }

      .del_box p{
        cursor: move;
      }

     .fun_btn{
        background-color:#0072E3;
        color: #fff;
        border-radius: 5px 5px;
        padding: 7px;
        font-size: 17px;
        margin-left: 15px;
        text-decoration: none;
     }

     .fun_btn:hover{
        color: #fff;
     }
     #show_website, #show_phone{
       color: #fff;
     }
     .howTo{
      font-size: 15px;
     }
    </style>
    <script type="text/javascript">
     $(document).ready(function() {

/* ===================================== 新增功能區塊按鈕 ======================================== */

        $("#funNew").click(function(event) {
            if ($("#fun_sel").val()=='show') {
             // ## 幻燈片 ## 
              funBox_in('btn_show','iframe_show.php','btn-warning','fa-film','圖片輪播','del_btn(this)','<?php echo $case_id?>');

            }else if($("#fun_sel").val()=='you'){
               // ## YouTube ## 

               funBox_in('btn_you','iframe_you.php','btn-danger','fa-youtube','YouTube影片','del_btn(this)','<?php echo $case_id?>');

            }else if($("#fun_sel").val()=='base'){
               // ## 基本圖文 ## 
               funBox_in('btn_base','iframe_base.php','btn-primary btn-outline','fa-picture-o','基本圖文','del_btn(this)','<?php echo $case_id?>');


            }else if($("#fun_sel").val()=='map'){
              // ## GoogleMap ## 
              funBox_in('btn_map','iframe_map.php','btn-primary','fa-map-marker','GoogleMap','del_btn(this)','<?php echo $case_id?>');


            }else if($("#fun_sel").val()=='call'){
              // ## 聯絡我們 ##
              funBox_in('btn_call','iframe_call.php','btn-info','fa-phone','聯絡我們','del_btn(this)','<?php echo $case_id?>');

            }
            else if ($("#fun_sel").val()=='view720') {
              // ## 720環景 ##
              funBox_in('btn_view720','iframe_720view.php','btn-info','fa-share','720環景','del_btn(this)','<?php echo $case_id?>');
            }
            else if ($("#fun_sel").val()=='house_math') {
              // ## 房貸試算 ##
              funBox_in('btn_house_math','iframe_house.php','btn-success','fa-calculator','房貸試算','del_btn(this)','<?php echo $case_id?>');
            }
            else if ($("#fun_sel").val()=='catch_DM') {
              // ## 索取DM ##
              funBox_in('btn_catch_DM','iframe_DM.php','btn-success','fa-edit','索取DM','del_btn(this)','<?php echo $case_id?>');
            }
            else if ($("#fun_sel").val()=='newsletter') {
              // ## 電子報 ##
              funBox_in('btn_newsletter','iframe_news.php','btn-success','fa-edit','電子報','del_btn(this)','<?php echo $case_id?>');
            }
            else if ($("#fun_sel").val()=='imgwall') {
              // ## 圖片牆 ##
              funBox_in('btn_imgwall','iframe_imgwall.php','btn-warning','fa-edit','圖片牆','del_btn(this)','<?php echo $case_id?>');
            }

        });

  

   /* =================================== 錨點加入 ============================================= */

     $("#anchor").click(function() {

      if ($(".btn_anchor").length>5) {
          alert('錨點最多不可超過六個');
      }
      else{
         funBox_in('btn_anchor', 'iframe_anchor.php', 'btn-default', 'fa-anchor', '錨點', 'del_btn(this)', '<?php echo $case_id?>');
      }
     });


    /* ================================= 顯示網頁 ================================= */

     $("#show_website").fancybox({

               'width'                 : '100%',
               'height'               : '80%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });

    /* =================================== 手機板網頁 ==================================== */

     $("#show_phone").fancybox({

               'width'                 : '25%',
               'height'               : '50%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });

   /* ================================= 顯示錨點說明 ================================= */

     $("#show_point").fancybox({

               'width'                 : '100%',
               'height'               : '80%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });

/* ===================================== 載入功能區塊按鈕 ======================================== */

 <?php

 $case_id=htmlspecialchars($_GET['case_id']);
 $result=db_conn("SELECT fun_name, fun_id, sort FROM Related_tb WHERE case_id='$case_id' ORDER BY sort ");
 if (mysql_num_rows($result)>0) {

  $rows_num=mysql_num_rows($result);
  while ($row=mysql_fetch_array($result)) {

    $fun_id=htmlspecialchars($row['fun_id']);

    if ($row['fun_name']=='slideshow_tb') {
      // ## 幻燈片 ## 
      echo "funBox_in('btn_show', 'iframe_show.php?funId=".$fun_id."', 'btn-warning', 'fa-film', '圖片輪播', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";

    }elseif ($row['fun_name']=='youtube_tb') {

      // ## YouTube ## 
      echo "funBox_in('btn_you', 'iframe_you.php?funId=".$fun_id."', 'btn-danger', 'fa-youtube', 'YouTube影片', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";

    }elseif ($row['fun_name']=='base_word') {

      // ## 基本圖文 ## 
      echo "funBox_in('btn_base', 'iframe_base.php?funId=".$fun_id."', 'btn-primary btn-outline', 'fa-picture-o', '基本圖文', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";

    }elseif ($row['fun_name']=='googlemap_tb'){

      // ## GoogleMap ## 
      echo "funBox_in('btn_map', 'iframe_map.php?funId=".$fun_id."', 'btn-primary', 'fa-map-marker', 'GoogleMap', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";


    }elseif ($row['fun_name']=='call_us_tb'){

      // ## 聯絡我們 ## 
      echo "funBox_in('btn_call', 'iframe_call.php?funId=".$fun_id."', 'btn-info', 'fa-phone', '聯絡我們', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";



    }elseif ($row['fun_name']=='anchor_tb') {

      // ## 錨點 ##
      echo "funBox_in('btn_anchor', 'iframe_anchor.php?funId=".$fun_id."', 'btn-default', 'fa-anchor', '錨點', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";

    }elseif ($row['fun_name']=='view720_tb') {

      // ## 720環景 ##
      echo "funBox_in('btn_view720', 'iframe_720view.php?funId=".$fun_id."', 'btn-info', 'fa-share', '720環景', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";

    }elseif ($row['fun_name']=='house_math') {
      
      // ## 房貸試算 ##
      echo "funBox_in('btn_house_math', 'iframe_house.php?funId=".$fun_id."', 'btn-success', 'fa-calculator', '房貸試算', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";

    }elseif ($row['fun_name']=='catch_DM') {
      
      // ## 索取DM ##
      echo "funBox_in('btn_catch_DM', 'iframe_DM.php?funId=".$fun_id."', 'btn-success', 'fa-edit', '索取DM', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";

    }elseif ($row['fun_name']=='newsletter') {
      
      // ## 電子報 ##
      echo "funBox_in('btn_newsletter', 'iframe_news.php?funId=".$fun_id."', 'btn-success', 'fa-edit', '電子報', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";

    }elseif ($row['fun_name']=='imgwall') {
      
      // ## 圖片牆 ##
      echo "funBox_in('btn_imgwall', 'iframe_imgwall.php?funId=".$fun_id."', 'btn-warning', 'fa-edit', '圖片牆', 'old_del_btn(this)', '".$case_id."', '".$fun_id."');";
    }
 }
}
?>

     /* 功能區塊拖曳 */

       $("#btn_row").sortable({

          placeholder:"sortBox_holder",
          update: function( event, ui ) {

                    var btn_row = $( "#btn_row" ).sortable( "toArray" );
                    //alert(btn_row.length);
                     var row_array="";
                     for (var i = 0; i < btn_row.length; i++) {
                         var row_array=row_array+btn_row[i]+",";
                     }

                     $("#sort_txt").attr('value', row_array);

                     var id_array="";
                     $("#btn_row").find('.del_box').each(function(index, val) {
                      id_array=id_array+$(this).attr('id')+",";
                     });

                     if (id_array.indexOf('undefined')==-1) {
                        $("#up_sort").css('display','block');
                     }
                     else{
                       alert("請儲存完功能區塊，才可更新排序");
                     }
                }

       }).disableSelection();


 /* ============================ 儲存排序 =============================== */

       $("#up_sort").click(function() {

          var sort_txt=$("#sort_txt").attr('value');
          var caseid="<?php echo $case_id;?>";
          location.replace('rwd_php_sys.php?sort='+sort_txt+'&case_id='+caseid);
       });

     });




/* ======================================= 功能區塊加入 ============================================= */

 /*=============== 排序 ===============*/

      var show_index= 1;

/*name:按鈕名*/
/*action:form執行網頁*/
/*btnClass:按鈕造型*/
/*faClass:功能圖案*/
/*funName:顯示名稱*/
/*height:iframe高度*/
/*disabled:是否按鈕失效*/
/*case_id:建案ID*/

             function funBox_in(name,action,btnClass,faClass,funName,del_btn,case_id,fun_id) {

              var txt=    '<div id="'+fun_id+'" class="del_box pull-left">';
              var txt=txt+'<button style="margin-right: 0px;" class="del_btn btn btn-danger dim pull-left" onclick="'+del_btn+'"><i class="fa fa-times"></i></button>'
              var txt=txt+'<form class="pull-left" method="POST" target="if_show" action="'+action+'">';
              var txt=txt+'<button  class=" hand_btn '+name+' btn '+btnClass+' dim" type="submit" >';
              var txt=txt+'<i class="fa '+faClass+'"></i> '+funName+'</button>';
              var txt=txt+'<input id="rel_sort" name="rel_sort" type="hidden" value="'+show_index+'" />';
              var txt=txt+'<input id="case_id" name="case_id" type="hidden" value="'+case_id+'" />';
              var txt=txt+'<i class="fa fa-arrow-right"></i>';
              var txt=txt+'<p>點我拖曳</p>';
              var txt=txt+'</form>';
              var txt=txt+'</div>';

              $("#btn_row").append(txt);

                show_index=show_index+1;
             }



/* ============================= 剛新增的刪除鈕 ================================= */ 

             function del_btn(sel){

                if (confirm('您確定要刪除??')) {
                 $(sel).parent('.del_box').remove(); 
              } 
          }


/* ============================= 以儲存的刪除鈕 ================================= */

          function old_del_btn(sel){
             
           if (confirm('確定要刪除??')) {

             var action=$(sel).next().attr('action');
             var funid=action.split("=");
             var caseid="<?php echo $case_id;?>";
             location.href="rwd_php_sys.php?delete=funBox&fun_id="+funid[1]+"&case_id="+caseid;

           }
          }
 </script>
</head>
<body>
<div id="wrapper" >

     <!-- ============================== 導航欄位 =================================== -->
    <?php include 'shared_php/navbar-default.php';?>

    <div id="page-wrapper" class="gray-bg">
    <!-- ============================== TOP欄位+ =================================== -->

        <?php include 'shared_php/top_bar.php';?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div id="fun_edit" class="row">

<!-- =============================== 功能區塊 ============================================ -->

              <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo $case_name?>-功能區塊編輯 </h5>
                            <div class="ibox-tools">
                                 <a class="fun_btn tra_shadow" id="show_website" href="../product_html/<?php echo $case_id;?>/Default.php" > 顯示網頁 </a>

                                 <a class="fun_btn tra_shadow" id="show_phone" href="../product_html/<?php echo $case_id;?>/Default.php" > 顯示手機板網頁 </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                         <div class="row">
                           <div class="form-group">
                            <div class="col-sm-3 ">
                            <select id="fun_sel" class="input-sm form-control input-s-sm inline">

                                    <option value="show">圖片輪播</option>
                                    <option value="you">YouTube影片</option>
                                    <option value="base">基本圖文</option>
                                    <option value="map">GoogleMap</option>
                                    <option value="call">聯絡我們</option>
                                    <option value="view720">720環景</option>
                                    <option value="imgwall">圖片牆</option>
                        <?php 

                         $result_ex=db_conn("SELECT * FROM expand_tb as tb INNER JOIN expand_record as re ON tb.tool_id=re.tool_id WHERE case_id='$case_id' AND re.is_use='1' AND tb.values!=''");

                         if (mysql_num_rows($result_ex)>0) {
                           
                           while ($row=mysql_fetch_array($result_ex)) {
                             
                              echo '<option value="'.$row['values'].'">'.$row['tool_name'].'</option>';
                           }
                         }

                        ?>


                                </select>

                                <span class="help-block m-b-none">( 請選擇一個功能區塊，按新增 )</span>
                            </div>
                            <div class="col-sm-8 ">
                                <a id="funNew" class="tra_shadow" >
                                    <i class="fa fa-users"></i> 新增
                                 </a>

                                 <a class="fun_btn tra_shadow" id="anchor"  href="#">加入錨點</a>
                                 <a id="show_point" class="howTo" href="howTo_point.html">(如何使用錨點)</a>
                                 <a class="fun_btn tra_shadow" id="color_btn" target="if_show"  href="color.php?case_id=<?php echo $case_id;?>">顏色修改</a>
                                 <span >可改主標、副標、內文、背景</span>

                            </div>
                            </div>
                     </div>
                     <div class="hr-line-dashed"> </div>
                     <!--產生區塊-->
                     <div id="sort_box">
                       <button id="up_sort" type="button" class="btn btn-success btn-lg pull-right">更新排序</button>

                       <!-- 儲存排序 -->
                       <input  id="sort_txt" type="hidden" value="" />
                     </div>
                     <div id="btn_row" class="row"></div>
                        </div>
                    </div>
                </div>
                <!-- 嵌入功能區塊 -->
                <iframe src=""  id="if_show" name="if_show" frameborder="0" class="autoHeight" scrolling="no"></iframe>
            </div>
        </div>
        <!-- ============================== footer =================================== -->
        <?php include 'shared_php/footer.php';?>
    </div>
</div>
</body>
</html>







