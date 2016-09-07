<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

      $case_id=htmlspecialchars($_GET['case_id']);
    

    $result=db_conn("SELECT * FROM color WHERE case_id='$case_id'");
    if (mysql_num_rows($result)>0) {
      while ($row=mysql_fetch_array($result)) {
        $h1_color=$row['h1_color'];
        $h2_color=$row['h2_color'];
        $p_color=$row['p_color'];
        $marquee=$row['marquee'];
        $top_txt=$row['top_txt'];
        $top_bar=$row['top_bar'];
        $back_color=$row['back_color'];

      }
    }
?>


<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title>更改顏色</title>
  <link rel="shortcut icon" href="favicon.ico" />
  <!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>
    <style type="text/css">
    body{
    	height: 700px;
    	background-color: rgb(243,243,244);
       font-family: 微軟正黑體;
    }
    .img_box img{
        width: 100%;
    }

    </style>

    <script type="text/javascript">
       $(document).ready(function() {

          //----------------------- 主標 --------------------------
          $("#for_color").on('click', '.change_btn1', function(event) {

             if ($(this).parent().next().find('input').length>0) {  

              $(this).parent().next().html(""); 
              $(this).html("預設原色");

            }else{

              $(this).parent().next().html(' <input id="h1_color" class="form-control" type="color" name="h1_color" value="<?php echo $h1_color;?>" >');
              $(this).html("顏色修改");
            }
          });



            //----------------------- 副標 --------------------------
            $("#for_color").on('click', '.change_btn2', function(event) {
            if ($(this).parent().next().find('input').length>0) { 
             $(this).parent().next().html(""); 
             $(this).html("預設原色");
           }
            else{

              $(this).parent().next().html(' <input id="h2_color" class="form-control" type="color" name="h2_color" value="<?php echo $h2_color;?>" >');
              $(this).html("顏色修改");
            }
          });



            //----------------------- 內文 --------------------------
           $("#for_color").on('click', '.change_btn3', function(event) {
            if ($(this).parent().next().find('input').length>0) { 
             $(this).parent().next().html("");
             $(this).html("預設原色"); 
           }
            else{

              $(this).parent().next().html(' <input id="p_color" class="form-control" type="color" name="p_color" value="<?php echo $p_color;?>" >');
              $(this).html("顏色修改");
            }
          });


           //----------------------- 跑馬燈 --------------------------
           $("#for_color").on('click', '.change_btn5', function(event) {
            if ($(this).parent().next().find('input').length>0) { 
             $(this).parent().next().html("");
             $(this).html("預設原色"); 
           }
            else{

              $(this).parent().next().html(' <input id="marquee" class="form-control" type="color" name="marquee" value="<?php echo $marquee;?>" >');
              $(this).html("顏色修改");
            }
          });


          //----------------------- Top文字(錨點) --------------------------
           $("#for_color").on('click', '.change_btn6', function(event) {
            if ($(this).parent().next().find('input').length>0) { 
             $(this).parent().next().html("");
             $(this).html("預設原色"); 
           }
            else{

              $(this).parent().next().html(' <input id="top_txt" class="form-control" type="color" name="top_txt" value="<?php echo $top_txt;?>" >');
              $(this).html("顏色修改");
            }
          });


          //----------------------- top_bar --------------------------
           $("#for_color").on('click', '.change_btn7', function(event) {
            if ($(this).parent().next().find('input').length>0) { 
             $(this).parent().next().html("");
             $(this).html("預設原色"); 
           }
            else{

              $(this).parent().next().html(' <input id="top_bar" class="form-control" type="color" name="top_bar" value="<?php echo $top_bar;?>" >');
              $(this).html("顏色修改");
            }
          });



           //----------------------- 背景 --------------------------
           $("#for_color").on('click', '.change_btn4', function(event) {
            if ($(this).parent().next().find('input').length>0) { 
             $(this).parent().next().html("");
             $(this).html("預設原色");
             }
            else{

              $(this).parent().next().html(' <input id="back_color" class="form-control" type="color" name="back_color" value="<?php echo $back_color;?>" >');
              $(this).html("顏色修改");
            }
          });


   /* ================================= 顯示樣板 ================================= */

     $(".img_box").find('a').fancybox({

               'width'                 : '100%',
               'height'               : '80%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });

  // ================================== 白色樣板 =============================================
     $("#def_color").click(function(event) {

        for (var i = 1; i < 8; i++) {
        
          $(".change_btn"+i).parent().html('<button type="button" class="change_btn'+i+' btn btn-primary" >預設原色</button>');
          $(".show_color").html("");
        }
     });


  // ================================== 黑色樣板 =============================================
     $("#black_color").click(function(event) {
      
      for (var i = 1; i < 8; i++) {

        $(".change_btn"+i).parent().html('<button type="button" class="change_btn'+i+' btn btn-primary" >顏色修改</button>');
      }
     
     //主標顏色
     $(".change_btn1").parent().next().html('<input id="h1_color" class="form-control" type="color" name="h1_color" value="#FFEEA8" >');
     //副標顏色
     $(".change_btn2").parent().next().html('<input id="h2_color" class="form-control" type="color" name="h2_color" value="#FFF8D6" >');
     //內文顏色
     $(".change_btn3").parent().next().html('<input id="p_color" class="form-control" type="color" name="p_color" value="#FFFFFF" >');
     //跑馬燈文字
     $(".change_btn5").parent().next().html('<input id="marquee" class="form-control" type="color" name="marquee" value="#FFFFFF" >');
     //錨點文字
     $(".change_btn6").parent().next().html('<input id="top_txt" class="form-control" type="color" name="top_txt" value="#FFFFFF" >');
     //導航欄底色
     $(".change_btn7").parent().next().html('<input id="top_bar" class="form-control" type="color" name="top_bar" value="#1A1A1A" >');
     //背景顏色
     $(".change_btn4").parent().next().html('<input id="back_color" class="form-control" type="color" name="back_color" value="#262626" >');

       
     });


       });

    </script>
</head>
<body>
	<div id="wrapper"style="background-color:#F0F0F0; padding-top:0px; " >
	 
	 	<div class="wrapper wrapper-content animated fadeInRight">
	 		<div  class="row">

              <div  class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>基本樣板</h5>
                            <div class="ibox-tools">
                            </div>
                         </div>
                        <div class="ibox-content">
                         <div class="row">
                            <form class="form-horizontal">

                                <div class="form-group">
                                  <label for="def_color" class="col-sm-2 control-label">白色(預設):</label>
                                    <div class="col-sm-1">
                                      <input id="def_color" type="radio" name="def_color" >
                                    </div>
                                      <div class="col-sm-4 img_box">
                                        <a href="img/白色樣板.html">
                                           <img src="shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/白色樣板.jpg&h=151&w=308&zc=1">
                                        </a>
                                      </div>

                                </div>


                                <div class="form-group">
                                  <label for="black_color" class="col-sm-2 control-label">黑色:</label>
                                    <div class="col-sm-1">
                                      <input id="black_color" type="radio" name="def_color" >
                                    </div>
                                      <div class="col-sm-4 img_box">
                                        <a href="img/黑色樣板.html">
                                           <img src="shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/黑色樣板.jpg&h=151&w=308&zc=1">
                                        </a>
                                      </div>

                                </div>

                           </form>
                         </div>
                        </div>
                    </div>
              </div>


 <!-- =========================================== 更改顏色 ============================================= -->
              <div  class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>顏色修改</h5>
                            <div class="ibox-tools">
                            </div>
                         </div>
                        <div class="ibox-content">
                         <div class="row">
                            <form id="for_color" method="POST" action="rwd_php_sys.php" class="form-horizontal">

                            <?php 
                             
                             color('h1_color', $h1_color, '主標顏色:', 'change_btn1');
                             color('h2_color', $h2_color, '副標顏色:', 'change_btn2');
                             color('p_color', $p_color, '內文顏色:', 'change_btn3');
                             color('back_color', $back_color, '背景顏色:', 'change_btn4');
                             color('marquee', $marquee, '跑馬燈文字:', 'change_btn5');
                             color('top_txt', $top_txt, '錨點文字:', 'change_btn6');
                             color('top_bar', $top_bar, '導航欄底色:', 'change_btn7');
                             

                              function color($put_id,$sql_color,$lab_name,$btn_class)
                              {
                                if (empty($sql_color)) {
                                  $color_txt='<div class="form-group">';
                                 $color_txt.='<label class="col-sm-2 control-label">'.$lab_name.'</label>';
                                 $color_txt.='<div  class="col-sm-2">';
                                 $color_txt.='<button type="button" class="'.$btn_class.' btn btn-primary" >預設原色</button>';
                                 $color_txt.='</div>';
                                 $color_txt.='<div  class="col-sm-4 show_color">';
                                 $color_txt.='</div>';
                                 $color_txt.='</div>';
                                   echo $color_txt;
                                }
                                else{
                                  $color_txt='<div class="form-group">';
                                 $color_txt.='<label class="col-sm-2 control-label">'.$lab_name.'</label>';
                                 $color_txt.='<div  class="col-sm-2">';
                                 $color_txt.='<button type="button" class="'.$btn_class.' btn btn-primary" >顏色修改</button>';
                                 $color_txt.='</div>';
                                 $color_txt.='<div  class="col-sm-4 show_color">';
                                 $color_txt.='<input id="'.$put_id.'" class="form-control" type="color" name="'.$put_id.'" value="'.$sql_color.'" >';
                                 $color_txt.='</div>';
                                 $color_txt.='</div>';
                                   echo $color_txt;
                                }
                              }

                            ?>


                                <div class="form-group">
                                <label class="col-sm-7 control-label"></label>
                                <div class="col-sm-3">
                                  <button id="cr_color"  class="btn btn-primary dim " type="submit" >送出</button>
                                </div>
                                </div>

                                <input  type="hidden" name="page" value="color">
                                <input type="hidden" name="case_id" value="<?php echo $case_id;?>">
                                
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