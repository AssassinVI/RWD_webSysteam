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
	<title>索取DM</title>
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
		width: 250px;

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

   	  if ($("#dm_name").val()=="") {
   	  	err_txt=err_txt+"名稱，";
   	  	$("#dm_name").css('borderColor', 'red');
   	  }
   	  else{ $("#dm_name").css('borderColor', '#D7C77E'); }


   	  if(($("#dm_mail").val()=="")){
         err_txt=err_txt+"電子郵件，";
         $("#dm_mail").css('borderColor', 'red');
   	  }
      else{ $("#dm_mail").css('borderColor', '#D7C77E'); }


   	  if(($("#dm_adds").val()=="")){
         err_txt=err_txt+"地址，";
         $("#dm_adds").css('borderColor', 'red');
   	  }
      else{ $("#dm_adds").css('borderColor', '#D7C77E'); }


   	  if (err_txt!="") {
   	  	alert("請輸入"+err_txt);
   	  	err_txt="";
   	  	return false;

   	  }else{

   	  	if ($("#YN_news_div").find(':checked').length>0) {
   	  		var dm_YN_news=$("#dm_YN_news").val();
   	  	}
   	  	else{
   	  		var dm_YN_news="N";
   	  	}
   	  	     	$.ajax({
     		url: '../../Static_Seed_Project/rwd_php_sys.php',
     		type: 'POST',
     		data: {page: 'catch_DM_data',
     		    case_id: '<?php echo $case_id;?>',
     		  case_name: '<?php echo $case_name;?>',
     		    dm_name: $("#dm_name").val(),
     		    dm_mail: $("#dm_mail").val(),
     		    dm_adds: $("#dm_adds").val(),
     		   dm_phone: $("#dm_phone").val(),
     		 dm_YN_news: dm_YN_news,
     		  dm_remark: $("#dm_remark").val(),
     	           },
     	     success: function () {
     	     	alert("資料已送出!!");
     	     	$("#form_div").find('input').val("");
     	     	$("#form_div").find('textarea').val("");
     	     }
     	});
   	  }
   }); //click_END

 }); //jquery_END

</script>
</head>
<body style="font-family:微軟正黑體">
	<div>
		<h2 class="h2_lay">索取DM</h2>
		<div id="form_div" class="container-fluid">
		   <form action="../../Static_Seed_Project/rwd_php_sys.php" method="POST" enctype="multipart/form-data">
		   <div class="rate col-sm-12">
			<label class="col-sm-2" for="dm_name">建案: </label>
			<div class="col-sm-10">
				<p><?php echo $case_name?></p>
			</div>
		   </div>
		   <div class="rate col-sm-12">
			<label class="col-sm-2" for="dm_name">名稱*: </label>
			<div class="col-sm-10">
				<input type="text" name="dm_name" id="dm_name">
			</div>
		   </div>
		   <div class="rate col-sm-12">	
			  <label class="col-sm-2" for="dm_mail">電子郵件*: </label>
			    <div class="col-sm-10">
				<input type="email" name="dm_mail" id="dm_mail">
			   </div>
		   </div>
             <div class="rate col-sm-12">
             	<label class="col-sm-2" for="dm_adds">地址*: </label>
             	<div class="col-sm-10">
			        <input type="text" name="dm_adds" id="dm_adds">

			    </div>
             </div>
			
			  <div class="rate col-sm-12">
             	<label class="col-sm-2" for="dm_phone">電話: </label>
             	  <div class="col-sm-10">
			         <input type="text" name="dm_phone" id="dm_phone">

			      </div>
             </div>

            <div class="rate col-sm-12">
             	<label class="col-sm-2" for="dm_YN_news">索取電子報: </label>
             	  <div id="YN_news_div" class="col-sm-2">
			         <input id="dm_YN_news" name="dm_YN_news"  type="checkbox" value="Y">
			      </div>
             </div>
            
              <div class="rate col-sm-12">
             	<label class="col-sm-2" for="dm_remark">備註: </label>
             	   <div class="col-sm-10">
			         <textarea style="width:250px;height:100px;" id="dm_remark" name="dm_remark"></textarea>
			       </div>
             </div>
             <div class="rate col-sm-3" style="text-align:right">
                <button id="enter_DM" class="btn" type="submit">送出</button>
             </div>
              <input type="hidden" name="page" value="catch_DM_data">
              <input type="hidden" name="case_id" value="<?php echo $case_id;?>">
              <input type="hidden" name="case_name" value="<?php echo $case_name;?>">
            </form>
		</div>
	</div>
</body>
</html>