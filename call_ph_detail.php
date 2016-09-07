<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

      $cr_id=addslashes($_GET['cr_id']); //USER 專案
      $case_id=addslashes($_GET['case_id']);

      $pdo=pdo_conn();
      $sql_q=$pdo->prepare("SELECT * FROM call_record_tb WHERE cr_id=:cr_id ");
      $sql_q->bindparam(":cr_id", $cr_id);
      $sql_q->execute();
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
        
         $use_name=$row['use_name'];
         $use_mail=$row['use_mail'];
         $q_type=$row['q_type'];
         $call_title=$row['call_title'];
         $call_content=$row['call_content'];
         $is_process=$row['is_process'];

      }
?>



<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="shortcut icon" href="favicon.ico" />

   <!-- 外掛AND CSS -->
    <?php include 'shared_php/script_style.php';?>

    <!-- FooTable -->
    <link href="css/footable.core.css" rel="stylesheet">

    <style type="text/css">
      body{
        font-family: 微軟正黑體;
        font-size: 18px;
      }

     .con_lay{ padding: 15px; background: hsla(0,2%,95%,1); border-radius: 5px; }
    </style>

    <!-- FooTable -->

<script src="js/footable.all.min.js"></script>
 <script type="text/javascript">

     $(document).ready(function() {

         $("#admin_project").addClass('active');
         $('.footable').footable();
    

          $('.summernote').summernote({
                lang: 'zh-TW', // default: 'en-US'
                height:300,
                toolbar: [//定制工具栏，格式:['自定义分组名',['规定组内元素列表',]],

                            ['insert',['link']]

                       ],
                placeholder:'可使用HTML編輯'
                });
          
      // --------------- 判斷有無處理 ----------------------
          var is_process='<?php echo $is_process?>';
          if (is_process=='1') {
             $("#put_mail").css('display', 'none');
          }

 }); //jquery END



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
                            <h5>顧客意見</h5>
                            
                        </div>
                        <div class="ibox-content">
                          
                         <div class="form-group">
                                   <label class="col-sm-2 control-label">顧客姓名:</label>
                                   <span><?php echo $use_name?></span>
                                    
                         </div>

                          <div class="form-group">
                                   <label class="col-sm-2 control-label">E-mail:</label>
                                    <span ><?php echo $use_mail?></span>
                          </div>

                         <div class="form-group">
                                   <label class="col-sm-2 control-label">問題類型:</label>
                                    <span ><?php echo $q_type?></span>
                         </div>

                         <div class="form-group">
                                   <label class="col-sm-2 control-label">主旨:</label>
                                    <div class="col-sm-4"><?php echo $call_title?></div>
                         </div>

                         <div class="form-group">
                                   <label class="col-sm-2 control-label">內容:</label>
                                    <div class="col-sm-4 con_lay"><?php echo $call_content?></div>
                         </div>
                        

                        </div>
                    </div>
                </div>

                <div id="put_mail" class="col-lg-12 no_padding">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>快速回覆</h5>
                            
                        </div>
                        <div class="ibox-content">
                          
                        <!-- <div class="form-group">
                                   <label class="col-sm-2 control-label">專員姓名:</label>
                                   <span><?php echo $use_name?></span>
                         </div>-->

                         <form method="POST" action="rwd_php_sys.php" class="form-horizontal" enctype="multipart/form-data">

                               <div class="form-group">
                                   <label class="col-sm-2 control-label">回覆:</label>
                                    <textarea  name="call_us_content" class="summernote">感謝<?php echo $use_name?>您的來信:</textarea>
                                </div>
                               <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">送出</button>

                                    <input type="hidden" name="page" value="call_detail">
                                    <input type="hidden" name="case_name" value="<?php echo $_SESSION['call_ca_name']?>">
                                    <input type="hidden" name="case_id" value="<?php echo $case_id?>">
                                    <input type="hidden" name="cr_id" value="<?php echo $cr_id?>">
                                    <input type="hidden" name="use_mail" value="<?php echo $use_mail?>">
                                    <input type="hidden" name="use_name" value="<?php echo $use_name?>">
                                </div>
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

