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
    <title>顧客問卷表單</title>

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
                            <h5>顧客問卷收尋 </h5>
                           <div class="ibox-tools">
                          
                        </div>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
                                   <label class="col-sm-2 control-label">顧客姓名：</label>
                                    <div class="col-sm-2">
                                       <input name="name" type="text" class="form-control" value="">
                                    </div>
                                    <label class="col-sm-1 control-label">手機：</label>
                                    <div class="col-sm-2">
                                       <input name="name" type="text" class="form-control" value="">
                                    </div>
                                    <label class="col-sm-1 control-label">E-mail：</label>
                                    <div class="col-sm-2">
                                       <input name="name" type="text" class="form-control" value="">
                                    </div>
                                    <input type="radio" value="已購" name="is_buy"> 已購
                                    <input type="radio" value="未購" name="is_buy"> 未購
                                </div>

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
