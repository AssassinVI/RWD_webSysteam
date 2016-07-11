<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
	<title>房貸試算表</title>
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
		font-size: 20px;
	}
	.rate input{
		border-radius: 7px 7px;
		padding: 5px;
		border: 2px solid 	#E0E0E0;
	}
	.put_width{
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
	#enter_math{
		background-color: #0F9F84;
		color: #fff;
	}
	#reset_btn{
		background-color:	#BEBEBE;
		color: #fff;
	}
	#form_div{
		background-color: #fff;
		padding-top: 30px;
		padding-bottom: 30px;
	}
	#result_box{
		display: none;
	}
	#result_div{
		background-color: #fff;
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
	.smal_txt{
		text-align: center;
	}
</style>
<script type="text/javascript">
   $(document).ready(function() {
   	  for (var i = 1; i < 31; i++) {
   	  	if (i==20) {  $(".math_years").append('<option value="'+i+'" SELECTED>'+i+'年</option>');  }

   	  	else{
             $(".math_years").append('<option value="'+i+'">'+i+'年</option>');
   	  	 }
   	  }

   	var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
   	//指定視窗物件
   
   $("#enter_math").click(function(event) {
   	 
   	   $("#result_box").css('display', 'block');;
      //年利率
      var one=parseFloat($("#one_math").val())/100;
      var two=parseFloat($("#two_math").val())/100;
      var three=parseFloat($("#three_math").val())/100;
      

      /* =========== 月利率 ============ */
      var avg_month1=one/12;
      var avg_month2=two/12;
      var avg_month3=three/12;


      /* ======================== 每月應付本息金額之平均攤還率 =========================== */
       var months=parseInt($(":selected").val())*12 ;
       var avg1=avg_fun(avg_month1, months);
       
       var avg2=avg_fun(avg_month2, months);
       
       var avg3=avg_fun(avg_month3, months);

     /* ============================== 每期平均本息金額 ================================== */
     var total=parseInt($("#total").val());

     var avg_total_pay1=avg_total_pay(avg1,total);
     var avg_total_pay2=avg_total_pay(avg2,total);
     var avg_total_pay3=avg_total_pay(avg3,total);

     $("#avg_total_pay1").html(moneyFormat(avg_total_pay1.toString())+"<small>元/月</small>");
     $("#avg_total_pay2").html(moneyFormat(avg_total_pay2.toString())+"<small>元/月</small>");
     $("#avg_total_pay3").html(moneyFormat(avg_total_pay3.toString())+"<small>元/月</small>");


           

      /* =================================== 總還款金額 ====================================== */
      var pay1_total=avg_total_pay1*12;
      var pay2_total=avg_total_pay2*12;
      var pay3_total=avg_total_pay3*(months-24);
      var in_total=pay1_total+pay2_total+pay3_total;
      $("#total_pay").html(moneyFormat(in_total.toString())+"<small>元</small>");

      /* =================================== 總利息 ====================================== */
      var total=parseInt($("#total").val());
      var interest=in_total-total;
      $("#interest").html(moneyFormat(interest.toString())+"<small>元</small>");

      /* =========================== 平均利息 ==================================== */
      var avg_interest=parseInt(interest/months);
      $("#avg_interest").html(moneyFormat(avg_interest.toString())+"<small>元/月</small>");
      
      /*========================== 平均本金 ====================================*/
      var avg_principal=parseInt(total/months);
      $("#avg_principal").html(moneyFormat(avg_principal.toString())+"<small>元/月</small>");


        //滑到試算結果
         $body.animate({
            scrollTop: $("#result_box").offset().top
         }, 1000);
   });
   

   });

/*  每月應付本息金額之平均攤還率  */
   function avg_fun(avg_month, months) {
   	 /* ========== 月數 ================ */
      
      var avg1=Math.pow(1+avg_month, months)*avg_month;
     var avg2=Math.pow(1+avg_month, months)-1;
     var avg=avg1/avg2; 
     return avg;  
   }
 /* 每期平均本息金額 */  
   function avg_total_pay(avg,total) {
   	var avg_total_pay=total*avg;
          avg_total_pay=parseInt(avg_total_pay);
         return avg_total_pay;
   }

/* 金錢格式 */
   	function moneyFormat(str){
		if(str.length<=3)	return str;
		else	return moneyFormat(str.substr(0,str.length-3))+","+(str.substr(str.length-3));
	}
</script>
</head>
<body style="font-family:微軟正黑體">
	<div>
		<h2 class="h2_lay">房貸試算表</h2>
		<div id="form_div" class="container-fluid">
		   <form>
		   <div class="rate col-sm-12">
			<label class="col-sm-2" for="total">貸款總額: </label>
			<div class="col-sm-10">
				<input type="text" name="total" id="total" class="put_width">
			</div>
		   </div>
		   <div class="rate col-sm-12">	
			  <label class="col-sm-2" for="math_years">貸款年限: </label>
			    <div class="col-sm-10">
			      <select name="math_years" id="math_years" class="math_years">
			    	
			        </select>
			    </div>
		   </div>
             <div class="rate col-sm-12">
             	<label class="col-sm-2" for="one_math">第一年房貸利率: </label>
             	<div class="col-sm-10">
			        <input type="text" name="one_math" id="one_math" class="put_width">%

			    </div>
             </div>
			
			  <div class="rate col-sm-12">
             	<label class="col-sm-2" for="two_math">第二年房貸利率: </label>
             	  <div class="col-sm-10">
			         <input type="text" name="two_math" id="two_math" class="put_width">%

			      </div>
             </div>
            
              <div class="rate col-sm-12">
             	<label class="col-sm-2" for="three_math">第三年後房貸利率: </label>
             	   <div class="col-sm-10">
			         <input type="text" name="three_math" id="three_math" class="put_width">%

			       </div>
             </div>
             <div class="rate col-sm-3" style="text-align:right">
               <input id="reset_btn" class="btn" type="reset" name="" value="重新試算">
                <button id="enter_math" class="btn" type="button">試算</button>
             </div>
            </form>
		</div>
       
       <div id="result_box">
		<h2 id="result_h2" class="h2_lay">試算結果</h2>
		<div id="result_div" class="container-fluid">
		 
            <div class="rate col-sm-12">
			<label class="col-sm-2" for="total_pay">總還款金額: </label>
			<div class="col-sm-10">
				<p id="total_pay" class="col-sm-5"></p>
			</div>
		   </div>

		    <div class="rate col-sm-12">
			<label class="col-sm-2" for="interest">總還利息: </label>
			<div class="col-sm-10">
				<p id="interest" class="col-sm-5"></p>
			</div>
		   </div>
           
           <div class="rate col-sm-12">
			<label class="col-sm-2" for="avg_principal">每期平均本金: </label>
			<div class="col-sm-10">
				<p id="avg_principal" class="col-sm-5"></p>
			</div>
		   </div>

		   <div class="rate col-sm-12">
			<label class="col-sm-2" for="avg_interest">每期平均利息: </label>
			<div class="col-sm-10">
				<p id="avg_interest" class="col-sm-5"></p>
			</div>
		   </div>

		   <div class="rate col-sm-12">
			<label class="col-sm-2" for="avg_total_pay1">第一年平均本息金額: </label>
			<div class="col-sm-10">
				<p id="avg_total_pay1" class="col-sm-5"></p>
			</div>
		   </div>

		  <div class="rate col-sm-12">
			<label class="col-sm-2" for="avg_total_pay2">第二年平均本息金額: </label>
			<div class="col-sm-10">
				<p id="avg_total_pay2" class="col-sm-5"></p>
			</div>
		   </div>

		   <div class="rate col-sm-12">
			<label class="col-sm-2" for="avg_total_pay3">第三年後平均本息金額: </label>
			<div class="col-sm-10">
				<p id="avg_total_pay3" class="col-sm-5"></p>
			</div>
		   </div>
		   <div class="smal_txt col-sm-12">
		   	<span>*本表僅提供試算</span><br>
		   	<span>實際貸款數字仍需以申貸銀行為準</span>
		   </div>
		</div>
	  </div>
	</div>
</body>
</html>