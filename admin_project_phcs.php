<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

      $com_id=addslashes($_GET['com_id']); //USER 公司

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
     .logo_div{ display: block; width: 90px; height: 80px; padding: 5px; font-size: 24px; text-align: center; background-color: #bbbbbb; color: #dedede; }
     .logo_img{ display: block; width: 90px; height: 80px; }
     .logo_img img{ width: 100%; height: 100%; }
     .case_tr1{ font-size: 50px; }
     .case_td1, .case_td2{ padding-top: 15px; }
     #case_title{ font-size: 17px; }
     .case_tr1>td>span{ font-size: 12px; }
     .case_name{ padding-top: 8px; float: left; }
     .ibox-content button{ border: none; width: 50%; padding: 5px 0px; font-size: 20px; color: #fff; }
     .ibox-title h5 span{ color: rgb(26, 179, 148); }
     .active_btn{ background-color: rgb(28, 195, 162); }
     .dis_none{ display: none; }
    </style>

    <!-- FooTable -->

<script src="js/footable.all.min.js"></script>
 <script type="text/javascript">
     $(document).ready(function() {
         $("#admin_project").addClass('active');
         $('.footable').footable();
         $("#web_btn").click(function(event) {
             $("#web_btn").addClass('active_btn');
             $("#from_btn").removeClass('active_btn');
             $("#from_tb").addClass('dis_none');
             $("#web_tb").removeClass('dis_none');
             $(".ibox-title h5").html('專案-<span>網頁分析</span>');
         });

         $("#from_btn").click(function(event) {
             $("#from_btn").addClass('active_btn');
             $("#web_btn").removeClass('active_btn');
             $("#web_tb").addClass('dis_none');
             $("#from_tb").removeClass('dis_none');
             $(".ibox-title h5").html('專案-<span>問卷分析</span>');
         });
 <?php 

 /* if (empty($_GET['User_id'])) {
      $user_id=htmlspecialchars($_SESSION['user_id']);
  }

  else{ 
     $user_id=htmlspecialchars($_GET['User_id']);
     $_SESSION['user_id']=$user_id;
  }*/



  switch ($_SESSION['competence']) {
    case 'user':
       echo 'select_com("'.$com_id.'");';
       echo 'select_com_from("'.$com_id.'")';
      break;

    case 'company':
      echo 'select_com("'.$_SESSION['com_id'].'");';
      echo 'select_com_from("'.$_SESSION['com_id'].'")';
      break;

    case 'case':
      echo 'select_case("'.$_SESSION['case_id'].'")';
      break;
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

 

 /* ==================== 抓取建案(公司) ======================= */

     function select_com(com_id) {
          $.getJSON('rwd_php_sys.php?admin=project_ph&com_id='+com_id, function(json) {
                $.each(json.pro_ph_array, function() {

                  var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/case_logo/'+this['case_logo']+'&h=80&w=90&zc=1';

                      var info='<tr class="case_tr1">';

                      if (this['case_logo']=='') {
                        info=info+'<td><a class="logo_div" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'">專案LOGO</a><span>'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><a class="logo_img" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'"><img src="'+small_img+'"></a><span class="case_name">'+this['case_name']+'</span></td>';
                      }

                    
                     info=info+'<td class="case_td1">'+this['month_user']+'<span>人</span></td>';  //每日人數
                     info=info+'<td class="case_td2">'+this['total_user']+'<span>人</span></td>'; //總人數
                     info=info+'</tr>';

                    $("#all_project").append(info);
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
                        info=info+'<td><a class="logo_div" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'">專案LOGO</a><span>'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><a class="logo_img" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'"><img src="'+small_img+'"></a><span class="case_name">'+this['case_name']+'</span></td>';
                      }
                     info=info+'<td class="case_td1">'+this['month_user']+'<span>人</span></td>';  //每日人數
                     info=info+'<td class="case_td2">'+this['total_user']+'<span>人</span></td>'; //總人數
                     info=info+'</tr>';
                    $("#all_project").append(info);                    
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
                        info=info+'<td><a class="logo_div" href="">專案LOGO</a><span>'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><a class="logo_img" href=""><img src="'+small_img+'"></a><span class="case_name">'+this['case_name']+'</span></td>';
                      }

                     info=info+'<td class="case_td1"><span>人</span></td>';  //每日人數
                     info=info+'<td class="case_td2">'+this['total']+'<span>人</span></td>'; //總人數
                     info=info+'</tr>';

                    $("#all_from").append(info);
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
                            <h5>專案-<span>網頁分析</span></h5>
                            <p style="float:right;">點擊LOGO查看詳細分析</p>
                        </div>
                        <div class="ibox-content">
                          <button id="web_btn" class="active_btn">網頁分析</button><button id="from_btn">問卷分析</button>


                          <!-- ================================ 網頁分析 =================================== -->

                            <table id="web_tb" class="footable table table-stripped toggle-arrow-tiny" data-page-size="5">
                                <thead>
                                <tr id="case_title">
                                    <th>專案LOGO</th>
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
                                    <th>專案LOGO</th>
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

