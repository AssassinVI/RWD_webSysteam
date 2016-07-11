<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>公司管理介面</title>

    <!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>

    <!-- FooTable -->
    <link href="css/footable.core.css" rel="stylesheet">
   <!-- FooTable -->
   <script src="js/footable.all.min.js"></script>

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

    </style>
    <script type="text/javascript">
     $(document).ready(function() {
         $("#admin_com").addClass('active');
         $('.footable').footable();

       $.getJSON('rwd_php_sys.php?admin=company',  function(json) {
              
              $.each(json.com_array, function() {

                var competence="<?php echo $_SESSION['competence'];?>"; //權限

                   var info="<tr>";
                  info=info+"<td class='no_display768'>"+this['com_id']+"</td>";
                  info=info+"<td>"+this['com_name']+"</td>";
                  info=info+"<td><a href='edit_company.php?com_id="+this['com_id']+"'>修改</a></td>";

                  if (competence=="admin") {//權限判斷
                   info=info+"<td><a class='del_user_"+this['com_id']+"' href='#'>刪除</a></td>";
                  }

                  info=info+"</tr>";
                    $("#com_tb").append(info);
                    
                    var comId=this['com_id'];

                    $(".del_user_"+comId).click(function() {
                        if (confirm('確定要刪除??')) {
                            location.href="rwd_php_sys.php?delete=company&com_id="+comId;
                        }
                    });
              });
       });

     });
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
              <div class="col-lg-10 no_padding">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>公司資料表 </h5>
                           <div class="ibox-tools">
                           <span>(點新增產生新公司)</span>
                            <a href="edit_company.php" >
                                <i class="fa fa-plus-square"> 新增</i>
                            </a>
                        </div>
                        </div>
                        <div class="ibox-content">
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                                <thead>
                                <tr>
                                    <th class="no_display768">公司ID</th>
                                    <th>公司名稱</th>
                                    <th>修改</th>
                                    <th>刪除</th>
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
