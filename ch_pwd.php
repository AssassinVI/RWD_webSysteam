<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

  if ($_SESSION['competence']!='admin') {
    header('Location: http://rx.znet.tw/rwd_system/Static_Seed_Project/500.html');
    exit;
  }

  $User_id=addslashes($_GET['User_id']);
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>修改密碼</title>
	<!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>
    <style type="text/css">
    body{
    	height: auto;
    	background-color: rgb(243,243,244);
       font-family: 微軟正黑體;
    }

    </style>

    <script type="text/javascript">
      $(document).ready(function() {
         
         $("#pwd_btn").click(function(event) {

            var err_txt='';
        err_txt=err_txt+check_input("#new_pwd","新密碼, ");
        err_txt=err_txt+check_input("#admin_num","管理者帳號, ");
        err_txt=err_txt+check_input("#admin_pwd","管理者密碼, ");

            if (err_txt!='') {

              alert('請輸入'+err_txt+'!!');
            }
            else{

              $.ajax({
               url: 'rwd_php_sys.php',
               type: 'POST',
               data: {
                       page: "change_pwd",
                       User_id: "<?php echo $User_id;?>",
                       new_pwd: $("#new_pwd").val(),
                       admin_num: $("#admin_num").val(),
                       admin_pwd: $("#admin_pwd").val()
                     },
                success:function (data) {
            
                   if (data=="1") {
                      alert("更新完成");
                      $("input").val('');
                      
                   }
                   else{
                      alert("管理者帳號或密碼錯誤!!");
                    }
               }
             }); //ajax end
            }
         });

      }); //jquery END

         // =============================== 檢查input ====================================
  function check_input(id,txt) {

           if ($(id).val()=='') {
              $(id).css('borderColor', 'red');
              return txt;
           }else{
              $(id).css('borderColor', 'rgba(0,0,0,0.1)');
              return "";
           }
  }
    </script>
</head>
<body>
	<div id="wrapper" style="background-color:#F0F0F0; padding-top:0px; " >
	 
	 	<div class="wrapper wrapper-content animated fadeInRight">
	 		<div  class="row">

              <div  class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-content">
                         <div class="row">
                            <form method="POST" action="rwd_php_sys.php" class="form-horizontal">

                                <div class="form-group">
                                 <label class="col-sm-2 control-label">新密碼*:</label>
                                  <div id="con_box" class="col-sm-10">
                                   <input type="password" id="new_pwd" name="new_pwd" class="form-control">
                                  </div>
                                </div>

                                <div class="form-group">
                                 <label class="col-sm-2 control-label">管理者帳號*:</label>
                                  <div id="con_box" class="col-sm-10">
                                   <input type="text" id="admin_num" name="admin_num" class="form-control">
                                  </div>
                                </div>

                                <div class="form-group">
                                 <label class="col-sm-2 control-label">管理者密碼密碼*:</label>
                                  <div id="con_box" class="col-sm-10">
                                   <input type="password" id="admin_pwd" name="admin_pwd" class="form-control">
                                   <span class="help-block m-b-none"></span>
                                  </div>
                                </div>

                                <div class="form-group">
                                 <label class="col-sm-2 control-label"></label>
                                  <div id="con_box" class="col-sm-10">
                                   <button id="pwd_btn" class="btn btn-primary dim" type="button" >送出</button>
                                  </div>
                                </div>
                                
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