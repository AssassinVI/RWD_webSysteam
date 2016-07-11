<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

if ($_SESSION['competence']!='admin') {
    header('Location: http://rx.znet.tw/rwd_system/Static_Seed_Project/500.html');
    exit;
  }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者介面</title>

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

      #sel_user_div{
        float: left;
      margin-left: 30px;
      font-size: 12px;
      }



    </style>
    <script type="text/javascript">
     $(document).ready(function() {
         $("#admin_user").addClass('active');
         $('.footable').footable();
        select_user('admin'); //讀取管理者資料

        $("#sel_user").change(function(event) { //
            var now_user=$(":selected").val();
             $("#user_tb").html("");
            select_user(now_user);
        });

     });

     function select_user(competence) {
              $.getJSON('rwd_php_sys.php?admin=user&competence='+competence,  function(json) {
              $.each(json.user_array, function() {
                   var info="<tr>";
                  info=info+"<td class='no_display768'>"+this['User_id']+"</td>";
                  info=info+"<td>"+this['User_Name']+"</td>";
                  info=info+"<td class='no_display1024'>"+this['User_phone']+"</td>";
                  info=info+"<td class='no_display1024'>"+this['User_adds']+"</td>";
                  info=info+"<td class='no_display768'><a href='admin_expand.php?User_id="+this['User_id']+"'>擴充</a></td>";
                  info=info+"<td><a href='admin_project.php?User_id="+this['User_id']+"&com_id="+this['com_id']+"'>管理</a></td>";
                  info=info+"<td><a href='edit_admin.php?User_id="+this['User_id']+"'>修改</a></td>";
                  info=info+"<td class='no_display768'><a class='del_user_"+this['User_id']+"' href='#'>刪除</a></td>";
                  info=info+"</tr>";
                    $("#user_tb").append(info);

                    var userId=this['User_id'];

                    $(".del_user_"+userId).click(function() {
                        if (confirm('確定要刪除??')) {
                            location.href="rwd_php_sys.php?delete=admin_user&User_id="+userId;
                        }
                    });
              });
       });
     }

 </script>
</head>
<body>

<div id="wrapper">

     <!-- ============================== 導航欄位 =================================== -->
    <?php include 'shared_php/navbar-admin.php';?>
    <div id="page-wrapper" class="gray-bg">

    <!-- ============================== TOP欄位+ =================================== -->
        <?php include 'shared_php/top_bar.php';?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-10 no_padding">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>使用者資料表 </h5>
                           <div class="ibox-tools">
                            <a href="edit_admin.php" >
                                <i class="fa fa-users"> 新增</i>
                            </a>
                            <div id="sel_user_div">
                              <label for="sel_user">權限: </label>
                              <select id="sel_user">
                                <option value="admin">管理者</option>
                                <option value="user">最大使用者</option>
                                <option value="company">公司權限</option>
                                <option value="case">專案權限</option>
                              </select>
                             </div>
                        </div>
                        </div>
                        <div class="ibox-content">
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                                <thead>
                                <tr>
                                    <th class="no_display768">使用者ID</th>
                                    <th>使用者名稱</th>
                                    <th class='no_display1024'>電話</th>
                                    <th class='no_display1024'>地址</th>
                                    <th class='no_display768'>擴充功能</th>
                                    <th>專案管理</th>
                                    <th>修改</th>
                                    <th class='no_display768'>刪除</th>
                                </tr>
                                </thead>

                                <tbody id="user_tb">

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

