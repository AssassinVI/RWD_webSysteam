<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

if ($_SESSION['competence']!='admin') {
    header('Location: http://rx.znet.tw/rwd_system/Static_Seed_Project/500.html');
    exit;
  }
?>
<?php 
 if (!empty($_GET['User_id'])) {
 	$User_id=htmlspecialchars($_GET['User_id']);

 	$result=db_conn("SELECT * FROM admin_user WHERE User_id='$User_id'");
 	while ($row=mysql_fetch_array($result)) {
 		
 		$User_Name=$row['User_Name'];
 		$User_phone=$row['User_phone'];
 		$User_adds=$row['User_adds'];
 		$login_id=$row['login_id'];
 		//$login_pwd=$row['login_pwd'];
    $competence=$row['competence'];
    $com_id=$row['com_id'];
    $case_id=$row['case_id'];
        
 	}
 }

?>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>編輯使用者</title>
 <link rel="shortcut icon" href="favicon.ico" />
	<!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>
    <style type="text/css">
       .now_cpe{
        font-size: 20px;
       }
       #sel_com_div,#sel_case_div{
        display: none;
       }
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
      $("#build_back").click(function() {
         if (confirm("是否返回上一頁??")) {
            window.history.back();            
         }
        });

       /* ============================== 更改密碼 ===================================== */

          $(".ch_pwd").fancybox({

               'width'                 : '70%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });

       $("#sel_cpe").change(function(event) {
           var select=$(":selected").val();
           if (select=='company') {
              get_company();
              $("#sel_com_div").css('display', 'block');
              $("#sel_case_div").css('display', 'none');

           }
           else if(select=='case' || select=='employee'){
              get_case_com();
              $("#sel_com_div").css('display', 'none');
              $("#sel_case_div").css('display', 'block');
              $("#sel_com").empty();
           }
           else{
              $("#sel_com_div").css('display', 'none');
              $("#sel_case_div").css('display', 'none');
           }
       });

        $("#sel_com_case").change(function(event){
             var select=$("#sel_com_case :selected").val();
             get_case(select);
        });



      <?php

       echo '$("#sel_cpe [value=\''.$competence.'\']").attr("selected", "selected");'; //選取目前權限

       if ($competence=='company') {
          
          echo '$("#sel_com_div").css("display", "block");';
       }
       elseif ($competence=='case' OR $competence=='employee') {
         
          echo '$("#sel_case_div").css("display", "block");';
       }

      ?>


    }); //jquery END


    /* ============================== 附屬公司 =================================== */
    
    function get_company() {

      var com_txt='<option value="">選擇公司</option>';
       $.getJSON('rwd_php_sys.php?admin=company_sel', function(json) {
          $.each(json.com_array, function() {

           com_txt=com_txt+     '<option value="'+this['com_id']+'">'+this['com_name']+'</option>';
            
          });
          $("#sel_com").html(com_txt);
          $("#sel_com [value='<?php echo $com_id;?>']").attr('selected', 'selected');
       });
    }

   /* ============================== 附屬公司(專案) =================================== */
    function get_case_com() {

      var com_txt='<option value="">選擇公司</option>';
       $.getJSON('rwd_php_sys.php?admin=company_sel', function(json) {
          $.each(json.com_array, function() {

          com_txt=com_txt+     '<option value="'+this['com_id']+'">'+this['com_name']+'</option>';
            
          });
          $("#sel_com_case").html(com_txt);
          $("#sel_com_case [value='<?php echo $com_id;?>']").attr('selected', 'selected');
       });
    }
  
  /* ============================== 附屬專案 =================================== */
   function get_case(com_id) {

     
      var case_txt='';
       $.getJSON('rwd_php_sys.php?admin=case_sel&com_id='+com_id, function(json) {
          $.each(json.case_array, function() {

          case_txt=case_txt+     '<option value="'+this['case_id']+'">'+this['case_name']+'</option>';
            
          });
          $("#sel_case").html(case_txt);
          $("#sel_case [value='<?php echo $case_id;?>']").attr('selected', 'selected');
       });
   }

    </script>
</head>
<body style="font-family: 微軟正黑體">

<div id="wrapper">
	<!-- ============================== 導航欄位 =================================== -->

    <?php include 'shared_php/navbar-admin.php';?>
     <div id="page-wrapper" class="gray-bg">
     	  <!-- ============================== TOP欄位 =================================== -->

        <?php include 'shared_php/top_bar.php';?>
         <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                      <div class="ibox-title">
                            <h5>編輯使用者</h5>
                            <div class="ibox-tools">
                            </div>
                       </div>
                              <div class="ibox-content">
                                <form method="POST" action="rwd_php_sys.php" class="form-horizontal" enctype="multipart/form-data">

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">*使用者名稱</label>
                                    <div class="col-sm-4"><input name="User_name" type="text" class="form-control" value="<?php echo $User_Name;?>"></div>
                                    <label class="col-sm-1 control-label">電話</label>
                                    <div class="col-sm-4"><input name="User_phone" type="text" class="form-control" value="<?php echo $User_phone;?>"></div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">地址</label>
                                    <div class="col-sm-9"><input name="User_adds" type="text" class="form-control" value="<?php echo $User_adds;?>"></div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">*登入帳號</label>
                                    <div class="col-sm-4"><input name="login_id" type="text" class="form-control" value="<?php echo $login_id;?>"></div>

                                    <label class="col-sm-1 control-label">使用權限</label>
                                    <div class="col-sm-4">
                                      <select id="sel_cpe" name="sel_cpe" class="form-control">
                                          <option value="admin">管理者</option>
                                          <option value="user">最大使用者</option>
                                          <option value="company">公司權限</option>
                                          <option value="case">專案權限</option>
                                          <option value="employee">專員</option>
                                      </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">*登入密碼</label>

                          <?php

                           if (empty($login_id)) {
                            
                              echo '<div class="col-sm-4"><input name="login_pwd" type="text" class="form-control" value=""></div>';
                           }else{

                              echo '<div class="col-sm-4"><a href="ch_pwd.php?User_id='.$User_id.'" class="ch_pwd fun_btn tra_shadow">更改密碼</a></div>';
                           }

                          ?>
                                    
                                  
                                </div>


                           <!-- ==================================== 附屬的公司 ========================================== -->
                                <div id="sel_com_div" class="form-group">

                                   <label class="col-sm-2 control-label">公司</label>
                                    <div class="col-sm-4">
                                      <select id="sel_com" name="sel_com" class="form-control">
                                         
                                          <?php 
                                          if ($competence=='company') {
                                            
                                               $reslut_com=db_conn("SELECT com_id, com_name FROM company");
                                              while ($row=mysql_fetch_array($reslut_com)) {

                                               if ($com_id==$row['com_id']) {
                                                  echo '<option selected value="'.$row['com_id'].'">'.$row['com_name'].'</option>';
                                               }
                                               else{
                                                  echo '<option value="'.$row['com_id'].'">'.$row['com_name'].'</option>';
                                                }
                                              }
                                          }
                                          
                                          ?>
                                      </select>
                                    </div>
                                </div>
                           
                           <!-- ==================================== 附屬的專案 ========================================== -->
                                <div id="sel_case_div" class="form-group">

                                  <label class="col-sm-2 control-label">公司</label>
                                    <div class="col-sm-4">
                                      <select id="sel_com_case" name="sel_com_case" class="form-control">
                                          
                                      <?php 
                                         
                                         if ($competence=='case' OR $competence=='employee'){

                                            $reslut_com=db_conn("SELECT com_id, com_name FROM company");
                                            while ($row=mysql_fetch_array($reslut_com)) {

                                            if ($com_id==$row['com_id']) {
                                               echo '<option selected value="'.$row['com_id'].'">'.$row['com_name'].'</option>';
                                            }
                                            else{
                                               echo '<option value="'.$row['com_id'].'">'.$row['com_name'].'</option>';
                                            }
                                          }
                                         }
                                          

                                          ?>

                                      </select>
                                    </div>

                                   <label class="col-sm-2 control-label">專案</label>
                                    <div class="col-sm-4">
                                      <select id="sel_case" name="sel_case" class="form-control">
                                          
                                       <?php
                                      
                                      if ($competence=='case' OR $competence=='employee'){

                                         $result_case=db_conn("SELECT case_id, case_name FROM build_case WHERE com_id='$com_id'");
                                        if (mysql_num_rows($result_case)>0) {
                                          while ($row=mysql_fetch_array($result_case)) {
                                              
                                              if ($case_id==$row['case_id']) {
                                               echo '<option selected value="'.$row['case_id'].'">'.$row['case_name'].'</option>';
                                            }
                                            else{
                                               echo '<option value="'.$row['case_id'].'">'.$row['case_name'].'</option>';
                                            }
                                          }
                                        }
                                      }
  
                                      ?>
                                          
                                      </select>
                                    </div>
                                </div>

                                <!-- =========================== 分隔線 ============================ -->
                                 <div class="hr-line-dashed"></div>

                                 <div class="form-group">
                                    <label class="col-sm-4 control-label"></label>
                                    <div class="col-sm-4">
                                    	<button id="build_back" class="btn btn-white" type="button">取消</button>
                                        <button id="build_save" class="btn btn-primary" type="submit">儲存</button>

                                    </div>
                                </div>

                                <input type="hidden" name="page" value="admin_user" />
                                <input type="hidden" name="User_id" value="<?php echo $User_id;?>" />
                               </form>
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