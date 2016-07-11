<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>功能擴充</title>
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
      .table >tbody>tr>td>a{
        color:#fff;
        background-color:#3DB8B8;
         padding: 3px;
         padding-left:10px;
         padding-right: 10px;
        border-radius: 5px 5px;
       transition: box-shadow 0.25s;
      }
      .table >tbody>tr>td>a:hover,.ibox-tools a:hover{
         box-shadow: 0px 2px 4px #7B7B7B;
      }
     .ibox-tools span{
      font-size: 15px;
     }
     #sel_com{
      float: left;
      margin-left: 30px;
      font-size: 12px;
     }
    </style>
    <!-- FooTable -->
<script src="js/footable.all.min.js"></script>
 <script type="text/javascript">
     $(document).ready(function() {
         $("#admin_user").addClass('active');
         $('.footable').footable();
 
 <?php 
  if (empty($_GET['User_id'])) {
      $user_id=htmlspecialchars($_SESSION['user_id']);
  }
  else{ 
     $user_id=htmlspecialchars($_GET['User_id']);
     $_SESSION['user_id']=$user_id;
  }
   
    //使用者帳密
    $result=db_conn("SELECT * FROM company WHERE User_id='$user_id'");//撈取公司
    if (mysql_num_rows($result)>0) {
       
      while ($row=mysql_fetch_array($result)) {
      $com_id=$row['com_id'];
      $com_name=$row['com_name'];
      
      $com_option="<option value=".$com_id.">".$com_name."</option>";
        echo '$("#sel_com").find("select").append("'.$com_option.'");';
    }
   }
   else{
    /* 專案帳密 */
   }
 ?>

 
 var comID=$(":selected").val();
 select_com(comID);

$("#sel_com").change(function(event) {
    var com_id=$(":selected").val();
     $("#all_project").html("");
     select_com(com_id);
});



 /* ============================== 擴充頁面 ===================================== */

          $("#cat_expand").fancybox({

               'width'                 : '50%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });
        
 }); //jquery END
 
 /* ==================== 抓取建案 ======================= */
     function select_com(com_id) {
          $.getJSON('rwd_php_sys.php?admin=project&com_id='+com_id, function(json) {
                $.each(json.pro_array, function() {

                  var competence="<?php echo $_SESSION['competence'];?>"; //權限

                      var info='<tr>';
                     info=info+'<td class="pro_case_id">'+this['case_id']+'</td>';
                     info=info+'<td>'+this['case_name']+'</td>';
                     
                     info=info+'<td><a id="cat_expand" href="case_expand.php?case_id='+this['case_id']+'">功能擴充</a></td>';
                     

                     info=info+'</tr>';

                    $("#all_project").append(info);
                   
                }); 
          });
     } //fun END
 </script>
</head>
<body>

<div id="wrapper">

   <!-- ============================== 導航欄位 =================================== -->
    <?php include 'shared_php/navbar-admin.php';?>

    <div id="page-wrapper" class="gray-bg">

        <!-- ============================== TOP欄位 =================================== -->
        <?php include 'shared_php/top_bar.php';?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                                <div class="col-lg-12 no_padding">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>功能擴充</h5>

                            <div class="ibox-tools">
                              
                            <div id="sel_com">
                            <label for="sel_com">公司: </label>
                            <select >

                            </select>

                            </div>
                            </div>
                        </div>
                        <div class="ibox-content">

                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                                <thead>
                                <tr>
                                    <th class="pro_case_id" data-toggle="true">建案ID</th>
                                    <th>建案名稱</th>
                                    <th>功能擴充</th>
                                    
                                   <!-- <th data-hide="all">建案公司</th>
                                    <th data-hide="all">代銷公司</th>
                                    <th data-hide="all">格 局</th>
                                    <th data-hide="all">坪 數</th>
                                    <th data-hide="all">基地地址</th>
                                     <th data-hide="all">GOOGLE分析</th>-->
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
