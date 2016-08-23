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
     .logo_img div, .logo_div div{ position: absolute; width: 40px; text-align: center;  padding: 5px 0px; color: rgba(255, 255, 255, 0.5); font-size: 20px; background-color: rgba(255, 255, 255, 0.35); border-radius: 50px; margin:27px; }
     .case_tr1{ font-size: 18px; text-align: center;}
     .case_tr1 a{ display: block; width: 51px; height: 64px; float: left; background-color: #1ab394; margin: 0px 4% 5px 0px; padding: 5px 0px; border-radius: 5px; color:#fff; 
        transition: box-shadow 0.5s;
        -moz-transition: box-shadow 0.5s;  /* Firefox 4 */
        -webkit-transition: box-shadow 0.5s; /* Safari 和 Chrome */
        -o-transition: box-shadow 0.5s;  /* Opera */
}
     .case_tr1 a i{ font-size: 30px; display: block;}
     .case_tr1 a:hover{ box-shadow: 2px 2px 4px #a6a6a6; }
     #case_title{ font-size: 17px; }
     .case_tr1>td>span{ font-size: 15px; }
     .case_name{ padding-top: 8px; float: left; }
     .active_btn{ background-color: rgb(28, 195, 162); }
     .dis_none{ display: none; }
    </style>

    <!-- FooTable -->

<script src="js/footable.all.min.js"></script>
 <script type="text/javascript">
     $(document).ready(function() {
         $("#admin_project").addClass('active');
         $('.footable').footable();

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
      break;

    case 'company':
      echo 'select_com("'.$_SESSION['com_id'].'");';
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

 
//var head_btn='<div><i class="fa fa-hand-o-up"></i></div>'; 
 /* ==================== 抓取建案(公司) ======================= */

     function select_com(com_id) {
          $.getJSON('rwd_php_sys.php?admin=phcs_list&com_id='+com_id, function(json) {
                $.each(json.pro_ph_array, function() {

                  var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/case_logo/'+this['case_logo']+'&h=80&w=90&zc=1';

                      var info='<tr class="case_tr1">';

                      if (this['case_logo']=='') {
                        info=info+'<td><div class="logo_div">專案LOGO</div><span>'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><div class="logo_img" ><img src="'+small_img+'"></div><span class="case_name">'+this['case_name']+'</span></td>';
                      }

                     info=info+'<td id="tool_td">'; //功能
                     info=info+     '<a id="an_btn_'+this['case_id']+'" href="admin_project_phcs.php?com_id='+com_id+'&type=web" style="background: #ff8e15;"><i class="fa fa-line-chart"></i>分析</a>';

                     //---------------- 聯絡我們 -------------------
                     info=info+     '<a id="call_btn_'+this['case_id']+'" href="call_ph_list.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'" style="background: #13b997;"><i class="fa fa-phone"></i>聯絡</a>';
                     info=info+'</td>';
                     info=info+'</tr>';

                    $("#all_project").append(info);

                    check_tool(this['case_id'],com_id);//功能判斷
                }); 
          });
     } //fun END



     /* ==================== 抓取建案(個案) ======================= */

     function select_case(case_id) {
          $.getJSON('rwd_php_sys.php?admin=phcs_list&case_id='+case_id, function(json) {
                $.each(json.pro_ph_array, function() {

                     var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/case_logo/'+this['case_logo']+'&h=80&w=90&zc=1';

                      var info='<tr class="case_tr1">';

                     if (this['case_logo']=='') {
                        info=info+'<td><div class="logo_div">專案LOGO</div><span>'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><div class="logo_img"><img src="'+small_img+'"></div><span class="case_name">'+this['case_name']+'</span></td>';
                      }
                     info=info+'<td >'; //功能
                     info=info+     '<a id="an_btn_'+this['case_id']+'" href="admin_project_phcs.php??com_id='+com_id+'&type=web" style="background: #ff8e15;"><i class="fa fa-line-chart"></i>分析</a>';

                     //---------------- 聯絡我們 -------------------
                     info=info+     '<a id="call_btn_'+this['case_id']+'" href="call_ph_list.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'" style="background: #13b997;"><i class="fa fa-phone"></i>聯絡</a>';
                     info=info+'</td>';
                     info=info+'</tr>';
                    $("#all_project").append(info);  

                    check_tool(this['case_id']);//功能判斷                  
                }); 
          });
     } //fun END



     /* ========================== 功能判斷 ============================= */
     function check_tool(case_id,com_id) {
        $.getJSON('rwd_php_sys.php?admin=check_tool&case_id='+case_id, function(json){
              
              $.each(json.tool_array, function() {
                  //------------------------------- 問卷 ---------------------------
                  if (this['tool_id']=='tool20160624002') {

                     var info='<a id="fq_btn_'+case_id+'" style="background:#248fc3;" href="admin_project_phcs.php?com_id='+com_id+'&type=form"><i class="fa fa-edit"></i>問卷</a>';
                     $("#tool_td").append(info);
                  }

                  //------------------------------- DM ---------------------------
                  if (this['tool_id']=='tool20160630002') {

                     var info='<a id="DM_btn_'+case_id+'" style="background:#a6a6a6;" href="DM_ph_list.php?case_id='+case_id+'"><i class="fa fa-newspaper-o"></i>DM</a>';
                     $("#tool_td").append(info);
                  }

              });
        });
     }




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
                            <h5>專案</h5>
                            <p style="float:right;">點擊LOGO查看詳細分析</p>
                        </div>
                        <div class="ibox-content">
                          


                          <!-- ================================ 網頁分析 =================================== -->

                            <table id="web_tb" class="footable table table-stripped toggle-arrow-tiny" data-page-size="5">
                                <thead>
                                <tr id="case_title">
                                    <th>LOGO</th>
                                    <th>功能</th>
                                  
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

