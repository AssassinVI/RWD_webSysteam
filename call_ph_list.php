<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

      $case_id=addslashes($_GET['case_id']); //USER 公司
      $_SESSION['call_ca_name']=$_GET['case_name'];
?>



<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

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

     .case_tr1{ font-size: 18px; }
     .case_tr1 a{ display: block; width: 51px; background-color: #1ab394; padding: 5px 0px; border-radius: 5px; text-align: center; color:#fff; 
        transition: box-shadow 0.5s;
        -moz-transition: box-shadow 0.5s;  /* Firefox 4 */
        -webkit-transition: box-shadow 0.5s; /* Safari 和 Chrome */
        -o-transition: box-shadow 0.5s;  /* Opera */
}
     .case_tr1 a i{ font-size: 30px; display: block;}
     .case_tr1 a:hover{ box-shadow: 2px 2px 4px #a6a6a6; }
     #case_title{ font-size: 17px; }
     .case_tr1>td>span{ font-size: 18px; }
     .case_name{ padding-top: 8px; float: left; }
    </style>

    <!-- FooTable -->

<script src="js/footable.all.min.js"></script>
 <script type="text/javascript">
     $(document).ready(function() {
         $("#admin_project").addClass('active');
         $('.footable').footable();
        
        var case_id='<?php echo $case_id;?>';
        select_case(case_id);

 }); //jquery END




     /* ==================== 抓取建案(個案) ======================= */

     function select_case(case_id) {
          $.getJSON('rwd_php_sys.php?admin=call_ph_list&case_id='+case_id, function(json) {
                $.each(json.pro_ph_array, function() {

                      var info='<tr class="case_tr1">';

                     info=info+'<td >'+this['use_name']+'</td>'; 
                     info=info+'<td class="no_display768">'+this['set_time']+'</td>';
                     info=info+'<td class="no_display768">'+this['q_type']+'</td>';

                     if (this['is_process']=='0') {
                       info=info+'<td ><span style="color:red;">未處理</span></td>';
                     }
                     else if(this['is_process']=='1'){
                       info=info+'<td ><span style="color:#4caf50;">已處理</span></td>';
                     }

                     info=info+'<td ><a href="call_ph_detail.php?cr_id='+this['cr_id']+'&case_id='+case_id+'">內容</a></td>';
                     
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
    <?php include 'shared_php/navbar-default.php';?>

    <div id="page-wrapper" class="gray-bg">

        <!-- ============================== TOP欄位 =================================== -->

        <?php include 'shared_php/top_bar.php';?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">

                                <div class="col-lg-12 no_padding">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>顧客意見表單</h5>
                            
                        </div>
                        <div class="ibox-content">
                          


                          <!-- ================================ 網頁分析 =================================== -->

                            <table id="web_tb" class="footable table table-stripped toggle-arrow-tiny" data-page-size="5">
                                <thead>
                                <tr id="case_title">
                                    <th>顧客姓名</th>
                                    <th class="no_display768">時間</th>
                                    <th class="no_display768">問題類型</th>
                                    <th>狀態</th>  
                                    <th>詳細</th>
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

