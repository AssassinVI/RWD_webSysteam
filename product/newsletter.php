<?php 
  $case_id=htmlspecialchars($_GET['case_id']);
  $case_name=htmlspecialchars($_GET['case_name']);
?>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
	<title>電子報</title>
<script type="text/javascript" src="../js/plugins/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="../js/plugins/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="../js/plugins/bootstrap/css/bootstrap.min.css">
<style type="text/css">
	#form_div label, #result_div label{
       text-align: right;
	}
	#result_box{
		/*display: none;*/
	}
	.rate{
		padding: 5px;
		font-size: 15px;
	}
	.rate input{
		border-radius: 7px 7px;
		padding: 5px;
		border: 2px solid #D7C77E;
		width: 90%;

	}
	.h2_lay{
		background-color: #003D79;
		color: #fff;
		display: block;
		margin: 0px;
		padding: 18px;
	}
	#result_h2{
		background-color: #14D2AF;
	}

	.btn{
		border: none;
		border-radius: 7px 7px;
		font-size: 25px;
		transition: box-shadow 0.5s;
        -moz-transition: box-shadow 0.5s;	/* Firefox 4 */
        -webkit-transition: box-shadow 0.5s;	/* Safari 和 Chrome */
        -o-transition: box-shadow 0.5s;	/* Opera */
	}
	.btn:hover{
        box-shadow: 0px 3px 5px #3C3C3C;
	}
	#enter_DM{
		background-color: #0F9F84;
		color: #fff;
	}
	#reset_btn{
		background-color:#CDCD9A;
		color: #fff;
	}
	#form_div{
		background-color: #FAF9EB;
		padding-top: 30px;
		padding-bottom: 30px;
	}
	#result_box{
		display: none;
	}
	#result_div{
		background-color: #FAF9EB;
		padding-top: 30px;
		padding-bottom: 30px;
	}
	#result_div p{
		border-bottom: 2px solid #D7C77E;
		color: red;
	}
	#result_div p small{
		color: #3C3C3C;
	}
	#dm_YN_news{
		width: 25px;
		height: 25px;
	}
</style>
<script type="text/javascript">
   $(document).ready(function() {

   var err_txt="";

   $("#enter_DM").click(function(event) {

   	  event.preventDefault();

   	  if(($("#news_mail").val()=="")){
         err_txt=err_txt+"電子郵件";
         $("#news_mail").css('borderColor', 'red');
   	  }
      else{ $("#news_mail").css('borderColor', '#D7C77E'); }


   	  if (err_txt!="") {
   	  	alert("請輸入"+err_txt);
   	  	err_txt="";
   	  	return false;

   	  }else{

   	  	     	$.ajax({
     		url: '../../Static_Seed_Project/rwd_php_sys.php',
     		type: 'POST',
     		data: {page: 'newsletter_data',
     		    case_id: '<?php echo $case_id;?>',
     		    news_mail: $("#news_mail").val(),
     	           },
     	     success: function () {
     	     	alert("資料已送出!!");
     	     	$("#form_div").find('input').val("");
     	     }
     	});
   	  }
   }); //click_END

 }); //jquery_END

</script>
</head>
<body style="font-family:微軟正黑體">
	<div>
		<h2 class="h2_lay">電子報</h2>
		<div id="form_div" class="container-fluid">
		   <form action="../../Static_Seed_Project/rwd_php_sys.php" method="POST" enctype="multipart/form-data">
		   <div class="rate col-sm-12">
			<label class="col-sm-2" for="dm_name">建案: </label>
			<div class="col-sm-10">
				<p><?php echo $case_name?></p>
			</div>
		   </div>

		   <div class="rate col-sm-12">	
			  <label class="col-sm-2" for="news_mail">電子郵件*: </label>
			    <div class="col-sm-10">
				<input type="email" name="news_mail" id="news_mail">
			   </div>
		   </div>

             <div class="rate col-sm-3" style="text-align:right">
                <button id="enter_DM" class="btn" type="submit">送出</button>
             </div>
            </form>
		</div>
	</div>
</body>
</html>