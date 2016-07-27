<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';
      if (empty($_GET['case_name'])) {
        $case_name=$_SESSION['case_name'];
      }else{
        $case_name=$_GET['case_name'];
        $_SESSION['case_name']=$case_name;
      }

      if (empty($_GET['record_id'])) {
        $record_id=$_SESSION['record_id'];
      }else{
        $record_id=$_GET['record_id'];
        $_SESSION['record_id']=$record_id;
      }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顧客問卷表單(假)</title>

    <!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>

    <!-- FooTable -->
    <link href="css/footable.core.css" rel="stylesheet">
   <!-- FooTable -->
   <script src="js/footable.all.min.js"></script>

    <style type="text/css">
      body{
        font-family: 微軟正黑體;
        font-size: 15px;
      }
     

    </style>
    <script type="text/javascript">
     $(document).ready(function() {

         $('.footable').footable();
       
       $.getJSON('from_all/from_sql.php?type=list&record_id=<?php echo $record_id;?>',  function(json) {
              
              $.each(json.from_array, function() {

              
                   var info="<tr>";
                  info=info+"<td class='no_display768'>"+this['from_id']+"</td>"; //表單ID
                  info=info+"<td >"+this['set_time']+"</td>";                    //填表日期
                  info=info+"<td><?php echo $case_name;?></td>";                     //專案名稱
                  info=info+"<td>"+this['name']+"</td>";                                    //顧客姓名
                  info=info+"<td class='no_display768'></td>";          //連絡電話
                  info=info+"<td class='no_display768'>"+this['phone']+"</td>";          //行動電話
                  info=info+"<td><a href='from_all/from_print.php?from_id="+this['from_id']+"' target='_blank' ><i class='fa fa-print'></i>列印</a></td>";
                  info=info+"<td class='no_display768'><a href='from_edit.php?from_id="+this['from_id']+"'><i class='fa fa-edit'></i>編輯</a></td>";
                  info=info+"<td class='no_display768'><a class='del_from_"+this['from_id']+"' href='#'><i class='fa fa-ban'></i>刪除</a></td>";
                  info=info+"</tr>";

                    $("#com_tb").append(info);

                    var from_id=this['from_id'];
                    
                    $(".del_from_"+this['from_id']).click(function() {
                        if (confirm('確定要刪除??')) {
                            location.href="from_all/from_sql.php?type=delete&from_id="+from_id;
                        }
                    });
              });
       });
     });

     // from_all/from_sql.php?type=list&record_id=<?php //echo $_GET['record_id'];?>&case_name=<?php //echo $_GET['case_name'];?>
 </script>
</head>
<body>

<div id="wrapper">

     <!-- ============================== 導航欄位 =================================== -->
    <?php include 'shared_php/navbar-default.php';?>

    <div id="page-wrapper" class="gray-bg">

    <!-- ============================== TOP欄位+ =================================== -->
        <?php include 'shared_php/top_bar.php';?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-12 no_padding">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>顧客問卷資料表 </h5>
                           <div class="ibox-tools">
                          
                        </div>
                        </div>
                        <div class="ibox-content">
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                                <thead>
                                <tr>
                                    <th class="no_display768">表單ID</th>
                                    <th>填表日期</th>
                                    <th>專案名稱</th>
                                    <th>顧客姓名</th>
                                    <th class="no_display768">連絡電話</th>
                                    <th class="no_display768">行動電話</th>
                                    <th>列印</th>
                                    <th class="no_display768">編輯</th>
                                    <th class="no_display768">刪除</th>
                                </tr>
                                </thead>
                                <tbody id="com_tb">
                                
                                </tbody>
                               <tfoot>
                                <tr>
                                    <td colspan="4">
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
