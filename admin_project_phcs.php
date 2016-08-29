<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

      $com_id=addslashes($_GET['com_id']); //USER 公司
      $type=addslashes($_GET['type']); //網頁或問卷

?>



<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>專案管理</title>

   <!-- 外掛AND CSS -->
    <?php include 'shared_php/script_style.php';?>

    <!-- FooTable -->
    <link href="css/footable.core.css" rel="stylesheet">

    <style type="text/css">
      body{
        font-family: 微軟正黑體;
      }
      .ibox-tools a{
        color:#ECF5FF;
        background-color:#0080FF;
        padding: 5px;
        border-radius: 5px 5px;
       transition: box-shadow 0.25s;
       margin-right: 5px;
      }
     .ibox-tools span{
      font-size: 15px;
     }

     #sel_com{
      float: left;
      margin-left: 30px;
      font-size: 12px;
     }
     .logo_div{ display: block; width: 90px; height: 80px; padding-top: 5px; font-size: 24px; text-align: center; background-color: #bbbbbb; color: #dedede; }
     .logo_img{ display: block; width: 90px; height: 80px; }
     .logo_img img{ width: 100%; height: 100%; }
     .logo_img div, .logo_div div{ position: absolute; width: 40px; text-align: center;  padding: 5px 0px; color: rgba(255, 255, 255, 0.5); font-size: 20px; background-color: rgba(255, 255, 255, 0.35); border-radius: 50px; margin:27px; }
     .logo_img div:hover, .logo_div div:hover{ color: rgb(43, 243, 203); }
     .case_tr1{ font-size: 50px; text-align: right; }
     #case_title{ font-size: 17px; }
     .case_tr1>td>span{ font-size: 12px; }
     .case_name{ padding-top: 8px; float: left; }
     .ibox-title h5 span{ color: rgb(26, 179, 148); }
     .active_btn{ background-color: rgb(28, 195, 162); }
     .dis_none{ display: none; }
     
    </style>

    <!-- FooTable -->

<script src="js/footable.all.min.js"></script>
 <script type="text/javascript">
     $(document).ready(function() {
        // $("#admin_project").addClass('active');
         $('.footable').footable();
         
 <?php 

 /* if (empty($_GET['User_id'])) {
      $user_id=htmlspecialchars($_SESSION['user_id']);
  }

  else{ 
     $user_id=htmlspecialchars($_GET['User_id']);
     $_SESSION['user_id']=$user_id;
  }*/


/* =========================== 網頁 ============================== */
if ($type=='web') {

    switch ($_SESSION['competence']) {
    case 'user':
       echo 'select_com("'.$com_id.'");';
      break;

    case 'company':
      echo 'select_com("'.$_SESSION['com_id'].'");';
      break;

    case 'case':
      echo 'select_case("'.$_SESSION['case_id'].'")';
      break;
  }
}
elseif($type=='form'){

  switch ($_SESSION['competence']) {
    case 'user':
       echo 'select_com_from("'.$com_id.'")';
      break;

    case 'company':
      echo 'select_com_from("'.$_SESSION['com_id'].'")';
      break;

    case 'case':
      echo 'select_case_from("'.$_SESSION['case_id'].'")';
      break;
  }
}

 ?>



 /* ============================== 燈箱 ===================================== */

          $(".iframe_box").fancybox({

               'width'                 : '50%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });

 }); //jquery END

 
var head_btn='<div><i class="fa fa-hand-o-up"></i></div>'; 
 /* ==================== 抓取建案(公司) ======================= */

     function select_com(com_id) {
          $.getJSON('rwd_php_sys.php?admin=project_ph&com_id='+com_id, function(json) {
                $.each(json.pro_ph_array, function() {

                  var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/case_logo/'+this['case_logo']+'&h=80&w=90&zc=1';

                      var info='<tr class="case_tr1">';

                      if (this['case_logo']=='') {
                        info=info+'<td><a class="logo_div" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'">'+head_btn+'專案LOGO</a><span class="case_name">'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><a class="logo_img" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'">'+head_btn+'<img src="'+small_img+'"></a><span class="case_name">'+this['case_name']+'</span></td>';
                      }
                    
                    var total_num=parseInt(this['total_user']);
                    var day_num=parseInt(this['month_user']);
                      if (day_num>99) { info=info+'<td  style="padding-top: 35px; font-size:40px;">'+this['month_user']+'<span>人</span></td>';  }//每日人數
                      else{  info=info+'<td  style="padding-top: 25px;">'+this['month_user']+'<span>人</span></td>'; }

                      if (total_num>999) { info=info+'<td  style="padding-top: 35px; font-size:40px;">'+this['total_user']+'<span>人</span></td>';  }//總人數
                      else{ info=info+'<td  style="padding-top: 25px; ">'+this['total_user']+'<span>人</span></td>'; }

                     info=info+'</tr>';

                     

                    $("#all_project").append(info);
                    $("#web_tb").removeClass('dis_none');
                }); 
          });
     } //fun END



     /* ==================== 抓取建案(個案) ======================= */

     function select_case(case_id) {
          $.getJSON('rwd_php_sys.php?admin=project_ph&case_id='+case_id, function(json) {
                $.each(json.pro_ph_array, function() {

                     var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/case_logo/'+this['case_logo']+'&h=80&w=90&zc=1';

                      var info='<tr class="case_tr1">';

                     if (this['case_logo']=='') {
                        info=info+'<td><a class="logo_div" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'">'+head_btn+'專案LOGO</a><span class="case_name">'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><a class="logo_img" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'">'+head_btn+'<img src="'+small_img+'"></a><span class="case_name">'+this['case_name']+'</span></td>';
                      }
                     
                     var total_num=parseInt(this['total_user']);
                     var day_num=parseInt(this['month_user']);
                      if (day_num>99) { info=info+'<td  style="padding-top: 35px; font-size:40px;">'+this['month_user']+'<span>人</span></td>';  }//每日人數
                      else{  info=info+'<td  style="padding-top: 25px;">'+this['month_user']+'<span>人</span></td>'; }

                      if (total_num>999) { info=info+'<td  style="padding-top: 35px; font-size:40px;">'+this['total_user']+'<span>人</span></td>';  }//總人數
                      else{ info=info+'<td  style="padding-top: 25px; ">'+this['total_user']+'<span>人</span></td>'; }

                     info=info+'</tr>';

                     

                    $("#all_project").append(info);      
                    $("#web_tb").removeClass('dis_none');              
                }); 
          });
     } //fun END


     /* ==================== 抓取建案(公司)-問卷 ======================= */

     function select_com_from(com_id) {
          $.getJSON('from_all/from_sql.php?type=project_ph&com_id='+com_id, function(json) {
                $.each(json.from_array, function() {

                  var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/case_logo/'+this['case_logo']+'&h=80&w=90&zc=1';

                      var info='<tr class="case_tr1">';

                      if (this['case_logo']=='') {
                        info=info+'<td><a class="logo_div" href="">'+head_btn+'專案LOGO</a><span class="case_name">'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><a class="logo_img" href="">'+head_btn+'<img src="'+small_img+'"></a><span class="case_name">'+this['case_name']+'</span></td>';
                      }

                     
                     var total_num=parseInt(this['total_user']);
                    var day_num=parseInt(this['month_user']);
                      if (day_num>99) { info=info+'<td  style="padding-top: 35px; font-size:40px;">'+this['month_user']+'<span>人</span></td>';  }//每日人數
                      else{  info=info+'<td  style="padding-top: 25px;">'+this['month_user']+'<span>人</span></td>'; }

                      if (total_num>999) { info=info+'<td  style="padding-top: 35px; font-size:40px;">'+this['total_user']+'<span>人</span></td>';  }//總人數
                      else{ info=info+'<td  style="padding-top: 25px; ">'+this['total_user']+'<span>人</span></td>'; }

                     info=info+'</tr>';

                    

                    $("#all_from").append(info);
                    $("#from_tb").removeClass('dis_none');
                }); 
          });
     } //fun END


     /* ==================== 抓取建案(專案)-問卷 ======================= */

     function select_case_from(case_id) {
          $.getJSON('from_all/from_sql.php?type=project_ph&case_id='+case_id, function(json) {
                $.each(json.from_array, function() {

                  var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/case_logo/'+this['case_logo']+'&h=80&w=90&zc=1';

                      var info='<tr class="case_tr1">';

                      if (this['case_logo']=='') {
                        info=info+'<td><a class="logo_div" href="">'+head_btn+'專案LOGO</a><span class="case_name">'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><a class="logo_img" href="">'+head_btn+'<img src="'+small_img+'"></a><span class="case_name">'+this['case_name']+'</span></td>';
                      }

                     var total_num=parseInt(this['total_user']);
                    var day_num=parseInt(this['month_user']);
                      if (day_num>99) { info=info+'<td  style="padding-top: 35px; font-size:40px;">'+this['month_user']+'<span>人</span></td>';  }//每日人數
                      else{  info=info+'<td  style="padding-top: 25px;">'+this['month_user']+'<span>人</span></td>'; }

                      if (total_num>999) { info=info+'<td  style="padding-top: 35px; font-size:40px;">'+this['total_user']+'<span>人</span></td>';  }//總人數
                      else{ info=info+'<td  style="padding-top: 25px; ">'+this['total_user']+'<span>人</span></td>'; }


                     info=info+'</tr>';
                     

                    $("#all_from").append(info);
                    $("#from_tb").removeClass('dis_none');
                }); 
          });
     } //fun END
 </script>
</head>
<body>

<div id="wrapper">

   <!-- ============================== 導航欄位 =================================== -->
    <?php include 'shared_php/navbar-default.php';?>

    <div id="page-wrapper" class="gray-bg">

        <!-- ============================== TOP欄位 =================================== -->

        <?php include 'shared_php/top_bar.php';?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">

                                <div class="col-lg-12 no_padding">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>專案-<span><?php if ($type=='web') { echo "網頁分析"; } else{ echo "問卷分析"; } ?></span></h5>
                            <p style="float:right;">點擊LOGO查看詳細分析</p>
                        </div>
                        <div class="ibox-content">
                          

                          <!-- ================================ 網頁分析 =================================== -->

                            <table id="web_tb" class="dis_none footable table table-stripped toggle-arrow-tiny" data-page-size="5">
                                <thead>
                                <tr id="case_title">
                                    <th>LOGO</th>
                                    <th>當日</th>
                                    <th>總數</th>
                                </tr>
                                </thead>
                                <tbody id="all_project">
                                
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>


                            <!-- ================================ 問卷分析 =================================== -->


                            <table id="from_tb" class="dis_none footable table table-stripped toggle-arrow-tiny" data-page-size="5">
                                <thead>
                                <tr id="case_title">
                                    <th>LOGO</th>
                                    <th>當日</th>
                                    <th>總數</th>
                                    
                                </tr>

                                </thead>
                                <tbody id="all_from">
                                
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
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

