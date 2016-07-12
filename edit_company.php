<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';
?>

<?php 
  if (!empty($_GET['com_id'])) {

  	$com_id=htmlspecialchars($_GET['com_id']);
  	$result=db_conn("SELECT * FROM company WHERE com_id='$com_id'");
  	if (mysql_num_rows($result)>0) {
  		while ($row=mysql_fetch_array($result)) {
  			$com_name=htmlspecialchars($row['com_name']);
        $com_logo=addslashes($row['com_logo']);
  		}
  	}
  }
?>


<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>編輯公司</title>
		<!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>

    <style type="text/css">
      .img_logo{ border: 1px solid #c3c1c1; padding: 12px; width: 300px; }
      .img_logo img{ width: 100%; }
      #logo_div, #old_logo_div{ float: left; margin-left: 7%; }
    </style>

    <script type="text/javascript">
    	 $(document).ready(function() {
      $("#build_back").click(function() {
         if (confirm("是否返回上一頁??")) {
            window.history.back();            
         }
        });


      <?php 

       if (!empty($com_logo)) { //目前公司LOGO

        echo "$('#old_logo_div').html('<div class=\"img_logo\"><p>目前公司LOGO</p><img  src=\"img/com_logo/".$com_logo."\"></div><input type=\"hidden\" name=\"old_logo\" value=\"y\">');";
       }

      ?>
    });

       function file_viewer_load(controller) { //預覽圖片方法

            var file=controller.files[0];
             if (file==null) {
                $('#logo_div').html('');
             }
             else{
                var fileReader= new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onload = function(event){

                $('#logo_div').html('<div class="img_logo"><p>新公司LOGO</p><img  src="'+this.result+'" alt=""></div>');
             }
            };
          }
    </script>
</head>
<body style="font-family: 微軟正黑體">
	
	<div id="wrapper">
	<!-- ============================== 導航欄位 =================================== -->

    <?php include 'shared_php/navbar-default.php';?>
     <div id="page-wrapper" class="gray-bg">
     	  <!-- ============================== TOP欄位 =================================== -->

        <?php include 'shared_php/top_bar.php';?>
         <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                      <div class="ibox-title">
                            <h5>編輯公司 </h5>
                            <div class="ibox-tools">
                            </div>
                        </div>

                        <div class="ibox-content">
                            <form method="POST" action="rwd_php_sys.php" class="form-horizontal" enctype="multipart/form-data">
                               <div class="form-group">
                                   <label class="col-sm-2 control-label">*公司名稱</label>
                                    <div class="col-sm-4"><input name="com_name" type="text" class="form-control" value="<?php echo $com_name;?>"></div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">*公司LOGO</label>
                                    <div class="col-sm-4"><input name="com_LOGO" type="file" class="form-control" accept="image/*" onchange="file_viewer_load(this)" ></div>
                                </div>
                                <div class="form-group">
                                  <div id="logo_div"></div>
                                  <div id="old_logo_div"></div>
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
                                <input type="hidden" name="page" value="company" />
                                <input type="hidden" name="com_id" value="<?php echo $com_id;?>" />
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