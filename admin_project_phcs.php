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
     #case_tr1{ font-size: 18px; }
     #case_td1, #case_td2{ padding-top: 38px; }

     #case_tital{ font-size: 15px; }
     #case_tr1>td>span{ font-size: 12px; }

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
   
    
 /* if (($_SESSION['competence']=='admin') OR ($_SESSION['competence']=='user') ) { //判斷管理者、使用者
     
       $result=db_conn("SELECT * FROM company WHERE User_id='$user_id'");//撈取公司 USER_id

      if (mysql_num_rows($result)<1) {

          $com_id=addslashes($_GET['com_id']);
         $result=db_conn("SELECT * FROM company WHERE com_id='$com_id'");//撈取公司
      }
  }
  else{ //判斷公司
       $com_id=$_SESSION['com_id'];
      $result=db_conn("SELECT * FROM company WHERE com_id='$com_id'");//撈取公司
   }

    if (mysql_num_rows($result)>0) {

      while ($row=mysql_fetch_array($result)) {
      $com_id=$row['com_id'];
      $com_name=$row['com_name'];
      
      $com_option="<option value=".$com_id.">".$com_name."</option>";
        echo '$("#sel_com").find("select").append("'.$com_option.'");';
    }
  }  */
      

     /* if ($_SESSION['competence']!='case') {
         echo 'var comID=$(":selected").val();';
         echo 'select_com(comID);';
      }
      else{
         echo 'select_case("'.$_SESSION['case_id'].'")';

      }*/
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

                      var info='<tr id="case_tr1">';
                      if (this['case_logo']=='') {
                        info=info+'<td><a class="logo_div" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'">專案LOGO</a><span>'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><a class="logo_img" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'"><img src="'+small_img+'"></a><span>'+this['case_name']+'</span></td>';
                      }
                     
                     //info=info+'<td id="case_td1">'+this['week_user']+'<span>人</span></td>';
                     info=info+'<td id="case_td1">'+this['month_user']+'<span>人</span></td>';  //每日人數
                     info=info+'<td id="case_td2">'+this['total_user']+'<span>人</span></td>'; //總人數
                     info=info+'</tr>';

                     


                    $("#all_project").append(info);
                    //<td>'+this['build_com']+'</td><td>'+this['Consignment']+'</td><td>'+this['format']+'</td><td>'+this['floor']+'</td><td>'+this['build_adds']+'</td><td>'+this['google_an']+'</td>
                }); 
          });
     } //fun END


     /* ==================== 抓取建案(個案) ======================= */
     function select_case(case_id) {
          $.getJSON('rwd_php_sys.php?admin=project_ph&case_id='+case_id, function(json) {
                $.each(json.pro_ph_array, function() {

                     var small_img='shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/case_logo/'+this['case_logo']+'&h=80&w=90&zc=1';
 
                      var info='<tr id="case_tr1">';

                     if (this['case_logo']=='') {
                        info=info+'<td><a class="logo_div" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'">專案LOGO</a><span>'+this['case_name']+'</span></td>';
                      }
                      else{
                        info=info+'<td><a class="logo_img" href="admin_analytics.php?case_id='+this['case_id']+'&case_name='+this['case_name']+'"><img src="'+small_img+'"></a><span>'+this['case_name']+'</span></td>';
                      }
                     //info=info+'<td id="case_td1">'+this['week_user']+'<span>人</span></td>';
                     info=info+'<td id="case_td1">'+this['month_user']+'<span>人</span></td>';  //每日人數
                     info=info+'<td id="case_td2">'+this['total_user']+'<span>人</span></td>'; //總人數
                     info=info+'</tr>';

                    $("#all_project").append(info);
                    //<td>'+this['build_com']+'</td><td>'+this['Consignment']+'</td><td>'+this['format']+'</td><td>'+this['floor']+'</td><td>'+this['build_adds']+'</td><td>'+this['google_an']+'</td>
                    
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
                            <h5>專案</h5>
                        </div>
                        <div class="ibox-content">

                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                                <thead>
                                <tr id="case_tital">
                                    <th>專案LOGO</th>
                                    <th>當日</th>
                                    
                                    <th>總</th>
                                    
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
