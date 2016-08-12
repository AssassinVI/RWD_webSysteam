<?php
 /* ================================= 連接資料庫 ======================================= */
require_once '../shared_php/config.php';
require_once '../shared_php/login_session.php';
session_start();

$record_id=$_GET['record_id'];

$pdo=pdo_conn();
  $sql_n=$pdo->prepare("SELECT case_name FROM build_case AS bs INNER JOIN expand_record AS er ON bs.case_id=er.case_id WHERE record_id=:record_id");
  $sql_n->bindparam(":record_id", $record_id);
  $sql_n->execute();
  $case_name=$sql_n->fetch(PDO::FETCH_ASSOC);
$pdo=NULL;
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>顧客問卷</title>
	<link rel="stylesheet" type="text/css" href="../css/plugins/mobile_themes/mobile.css">
	<link rel="stylesheet" type="text/css" href="../css/plugins/mobile_themes/jquery.mobile.icons.min.css">
	<link rel="stylesheet" type="text/css" href="../js/plugins/jquery_mobile/jquery.mobile.structure-1.4.5.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/jquery_step/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/jquery_step/main.css">
   
    	<!--<link rel="stylesheet" type="text/css" href="../css/plugins/jquery_step/jquery.steps.css">-->
	<style type="text/css">
	    body{ font-family: Microsoft JhengHei; font-size: 18px; }
	    #view_form{ padding: 10px 40px; }
		#wid_steps{  }
		.input_div{ padding:10px;  }
		/*input[type="text"]{ padding: 11px 20px; width: 90%; border-radius: 10px;  }
		input[type="text"]:focus{  border:1px solid #3C3C3C; }
		input[type="radio"]{ width: 20px; height: 20px; }
		input[type="checkbox"]{ width: 20px; height: 20px; }*/

		#twzipcode input{ width: 20%; }
		#twzipcode input[name="zipcode"]{ padding: 9px; border-radius: 10px; }
		select{ padding:10px; margin-right: 5px; border-radius: 10px; }
		#twzipcode{ display: inline-block; }
		.check_div{ padding:5px;  }
		.check_div label{ width: 80px; }

		.check_div2{ padding:5px;  }
		.check_div2 label{ width: 145px; }
    .big_select{ width: 100%; }
    #case_name{text-align: center; font-size: 30px; padding: 5px;}
	</style>
</head>
<body>
<form id="view_form" action="from_sql.php" method="POST" data-ajax="false">
 <div id="case_name" data-role="header" data-position="fixed" data-theme="a"><?php echo $case_name['case_name']?></div>
	<div data-role="collapsibleset" id="wid_steps">
	<div data-role="collapsible" data-collapsed="false">
    <h3 class="scor_top">基本資料</h3>
    <section>
        <div class="input_div"><label>顧客姓名：</label><input type="text" name="name" placeholder="姓名"></div>
        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
              <legend>性別：</legend><br>
               <input id="gender1" type="radio" value="m" name="gender"> <label for="gender1">先生</label>　
               <input id="gender2" type="radio" value="f" name="gender"> <label for="gender2">小姐</label> 
        </fieldset>
        <div><hr></div>
        <div class="input_div"><label>電話：</label><input type="text" name="phone" placeholder="電話"></div>
        <div class="input_div"><label>E-mail：</label><input type="text" name="email" placeholder="E-mail"></div>
        <div><hr></div>
        <div class="input_div"><label>住址：</label><div id="twzipcode"></div></div>
        <div class="input_div">
        <input id="inset-autocomplete-input" data-type="search" placeholder="詳細地址" name="adds">
<ul id="list_ul" data-role="listview" data-filter="true" data-filter-reveal="true" data-input="#inset-autocomplete-input">

</ul>
        </div>
    </section>
    </div>

    <div data-role="collapsible">
    <h3 class="scor_top">公司資料</h3>
    <section>
        <div class="input_div"><label>職業：</label>
          <select name="job" class="big_select">
            <option value="">請選擇</option>
            <option value="作業員">作業員</option>
            <option value="農林漁牧">農林漁牧</option>
            <option value="交通運輸業">交通運輸業</option>
            <option value="餐旅業">餐旅業</option>
            <option value="工程師">工程師</option>
            <option value="服務業">服務業</option>
            <option value="公職">公職</option>
            <option value="軍人">軍人</option>
            <option value="其他">其他</option>
          </select>
        </div>
        <div class="input_div"><input type="text" name="job_txt" placeholder="其他職業"></div>
        <div class="input_div"><label>職稱：</label><input type="text" name="job_title" placeholder="職稱"></div>
        <div class="input_div"><label>年齡：</label><input type="text" name="cust_old" placeholder="年齡"></div>
        <!--<div class="input_div"><label>工作區域：</label><input type="text" name="job_area" placeholder="工作區域"></div>-->
        <div class="input_div"><label>公司名稱：</label><input type="text" name="job_company" placeholder="公司名稱"></div>
    </section>
    </div>

    <div data-role="collapsible">
    <h3 class="scor_top">目前狀況</h3>
    <section>
       <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
           <legend>婚姻狀況：</legend><br>
            <input id="mar_state1" type="radio" value="已婚" name="mar_state" > <label for="mar_state1">已婚</label>　
            <input id="mar_state2" type="radio" value="已婚無子" name="mar_state" > <label for="mar_state2">已婚無子</label>　 
            <input id="mar_state3" type="radio" value="未婚" name="mar_state" > <label for="mar_state3">未婚</label>　 
       </fieldset>
       <input type="text" name="mar_child" placeholder="幾個小孩">
       <div class="input_div">
          <label>月收入：</label>
          <select name="mon_income" class="big_select">
             <option value="">請選擇</option>
             <option value="2萬~3萬">2萬~3萬</option>
             <option value="3萬~5萬">3萬~5萬</option>
             <option value="5萬~8萬">5萬~8萬</option>
             <option value="8萬~12萬">8萬~12萬</option>
             <option value="12萬~20萬">12萬~20萬</option>
             <option value="20萬以上">20萬以上</option>
          </select>
       </div>
       <div class="input_div">
          <label>交通工具：</label>
          <select name="transportation" class="big_select">
             <option value="">請選擇</option>
       	     <option value="汽車">汽車</option>
       	     <option value="機車">機車</option>
       	     <option value="大眾運輸">大眾運輸</option>
       	     <option value="其他">其他</option>
          </select>
         </div>
       <div class="input_div">
          <label>家庭成員人數：</label>
            <select name="live_people" class="big_select">
               <option value="">請選擇</option>
               <option value="1">1人</option>
               <option value="2">2人</option>
               <option value="3">3人</option>
               <option value="4">4人</option>
               <option value="5">5人以上</option>
            </select>
       </div>
       <div class="input_div">
          <label>現住房屋：</label>
          <select name="homeowner" class="big_select">
             <option value="">請選擇</option>
       	     <option value="租賃">租賃</option>
       	     <option value="宿舍">宿舍</option>
       	     <option value="父母所有">父母所有</option>
       	     <option value="配偶所有">配偶所有</option>
       	     <option value="本人所有">本人所有</option>
       	     <option value="其他">其他</option>
          </select>
         </div>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
           <legend>現住房屋型態：</legend><br>
           
              <input id="house_type1" type="radio" value="公寓" name="house_type" > <label for="house_type1">公寓</label>　
              <input id="house_type2" type="radio" value="大樓" name="house_type" > <label for="house_type2">大樓</label>　
              <input id="house_type3" type="radio" value="套房" name="house_type" > <label for="house_type3">套房</label>　
           
           
             <input id="house_type4" type="radio" value="租屋" name="house_type" > <label for="house_type4">租屋</label>　
             <input id="house_type5" type="radio" value="華廈" name="house_type" > <label for="house_type5">華廈</label>　
             <input id="house_type6" type="radio" value="透天" name="house_type" > <label for="house_type6">透天</label>　
           
       </fieldset>
         <div class="input_div"><label>屋齡：</label><input type="text" name="house_old" placeholder="幾年"></div> 

       <div class="input_div"><label>現住：</label><input type="text" name="house_pattern" placeholder="幾房">
                                  <!-- <label></label><input type="text" name="house_pattern2" placeholder="幾廳"><br>
                                   <label></label><input type="text" name="house_pattern2" placeholder="幾衛浴">-->
        </div>
        <div class="input_div"><label>坪數：</label><input type="text" name="floor_num"></div>


    </section>
    </div>

    
    <div data-role="collapsible">
    <h3 class="scor_top">需求</h3>
    <section>
        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
          <legend>您如何知道(可複選)：</legend>
                              
                              	<input type="checkbox" id="media1" name="media[]" value="中時"> <label for="media1"> 中時</label>
                                <input type="checkbox" id="media2" name="media[]" value="聯合"> <label for="media2"> 聯合</label>
                                <input type="checkbox" id="media3" name="media[]" value="自由"> <label for="media3"> 自由</label>
                              
                              
                              	<input type="checkbox" id="media4" name="media[]" value="聯晚"> <label for="media4"> 聯晚</label>
                                <input type="checkbox" id="media5" name="media[]" value="蘋果日報"> <label for="media5"> 蘋果日報</label>
                                <input type="checkbox" id="media6" name="media[]" value="網路"> <label for="media6"> 網路</label>
                              
                              
                              	<input type="checkbox" id="media7" name="media[]" value="車箱"> <label for="media7"> 車箱</label>
                                <input type="checkbox" id="media8" name="media[]" value="廣告"> <label for="media8"> 廣告</label>
                                <input type="checkbox" id="media9" name="media[]" value="CF"> <label for="media9"> CF</label>
                                
                              
                              	<input type="checkbox" id="media10" name="media[]" value="RD"> <label for="media10">  RD</label>
                                <input type="checkbox" id="media11" name="media[]" value="POP"> <label for="media11">  POP</label>
                                <input type="checkbox" id="media12" name="media[]" value="雜誌"> <label for="media12">  雜誌</label>
                              
                              
                              	<input type="checkbox" id="media13" name="media[]" value="派報"> <label for="media13"> 派報</label>
                                <input type="checkbox" id="media14" name="media[]" value="夾報"> <label for="media14"> 夾報</label>
                                <input type="checkbox" id="media15" name="media[]" value="介紹"> <label for="media15"> 介紹</label>
                              
                              
                              	<input type="checkbox" id="media16" name="media[]" value="其他"> 
        </fieldset>
                                <label for="media16"> 其他</label>
                                <input type="text" name="media_txt" value="" placeholder="其他媒體">

        <div><hr></div>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
           <legend>產品需求(可複選)：</legend>
                              
                              	<input type="checkbox" id="dem_product1" name="dem_product[]" value="大樓"> <label for="dem_product1"> 大樓</label>
                                <input type="checkbox" id="dem_product2" name="dem_product[]" value="透天"> <label for="dem_product2"> 透天</label>
                                <input type="checkbox" id="dem_product3" name="dem_product[]" value="套房"> <label for="dem_product3"> 套房</label>
                              
                              
                              	<input type="checkbox" id="dem_product4" name="dem_product[]" value="店面"> <label for="dem_product4"> 店面</label>
                                <input type="checkbox" id="dem_product5" name="dem_product[]" value="辦公室"> <label for="dem_product5"> 辦公室</label>
                                <input type="checkbox" id="dem_product6" name="dem_product[]" value="其他"> <label for="dem_product6"> 其他</label>
                              
        </fieldset>
                              <input type="text" name="dem_product_txt" value="" placeholder="其他產品">

        <div><hr></div>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
            <legend>坪數需求(可複選)：</legend>
                               
                              	<input type="checkbox" id="dem_floor_num1" name="dem_floor_num[]" value="30坪以下"> <label for="dem_floor_num1"> 30坪以下</label>
                                <input type="checkbox" id="dem_floor_num2" name="dem_floor_num[]" value="31~40坪"> <label for="dem_floor_num2"> 31~40坪</label>
                                <input type="checkbox" id="dem_floor_num3" name="dem_floor_num[]" value="41~50坪"> <label for="dem_floor_num3"> 41~50坪</label>
                              
                              
                              	<input type="checkbox" id="dem_floor_num4" name="dem_floor_num[]" value="51~70坪"> <label for="dem_floor_num4"> 51~70坪</label>
                                <input type="checkbox" id="dem_floor_num5" name="dem_floor_num[]" value="71~90坪"> <label for="dem_floor_num5"> 71~90坪</label>
                                <input type="checkbox" id="dem_floor_num6" name="dem_floor_num[]" value="91坪以上"> <label for="dem_floor_num6"> 91坪以上</label>
            
        </fieldset>

        <div><hr></div>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal"> 
                  <legend>購屋預算(可複選)：</legend>
                              
                              	<input type="checkbox" id="dem_money1" name="dem_money[]" value="301~400萬"> <label for="dem_money1"> 301~400萬</label>
                                <input type="checkbox" id="dem_money2" name="dem_money[]" value="401~600萬"> <label for="dem_money2"> 401~600萬</label>
                              
                              
                                <input type="checkbox" id="dem_money3" name="dem_money[]" value="601~800萬"> <label for="dem_money3"> 601~800萬</label>
                              	<input type="checkbox" id="dem_money4" name="dem_money[]" value="801~1200萬"> <label for="dem_money4"> 801~1200萬</label>
                              
                              
                                <input type="checkbox" id="dem_money5" name="dem_money[]" value="1201~2000萬"> <label for="dem_money5"> 1201~2000萬</label>
                                <input type="checkbox" id="dem_money6" name="dem_money[]" value="2001~3000萬"> <label for="dem_money6"> 2001~3000萬</label>
                              
                              
                              	<input type="checkbox" id="dem_money7" name="dem_money[]" value="3001萬以上"> <label for="dem_money7"> 3001萬以上</label>                  
        </fieldset>

        <div><hr></div>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
                  <legend>希望月付款(可複選)：</legend>
                             
                              	<input type="checkbox" id="dem_mon_pay1" name="dem_mon_pay[]" value="20000以下"> <label for="dem_mon_pay1"> 20,000以下</label>
                                <input type="checkbox" id="dem_mon_pay2" name="dem_mon_pay[]" value="20001~27000"> <label for="dem_mon_pay2"> 20,001~27,000</label>
                              
                              
                                <input type="checkbox" id="dem_mon_pay3" name="dem_mon_pay[]" value="27001~35000"> <label for="dem_mon_pay3"> 27,001~35,000</label>
                              	<input type="checkbox" id="dem_mon_pay4" name="dem_mon_pay[]" value="35001~42000"> <label for="dem_mon_pay4"> 35,001~42,000</label>
                              
                              
                                <input type="checkbox" id="dem_mon_pay5" name="dem_mon_pay[]" value="42001~50000"> <label for="dem_mon_pay5"> 42,001~50,000</label>
                                <input type="checkbox" id="dem_mon_pay6" name="dem_mon_pay[]" value="50001~60000"> <label for="dem_mon_pay6"> 50,001~60,000</label>
                              
                              
                              	<input type="checkbox" id="dem_mon_pay7" name="dem_mon_pay[]" value="60000以上"> <label for="dem_mon_pay7"> 60,000以上</label>
                              
        </fieldset>

          <div><hr></div>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
            <legend>自備款(可複選)：</legend>
                               
                              	<input type="checkbox" id="dem_have1" name="dem_have[]" value="50萬以下"> <label for="dem_have1"> 50萬以下</label>
                                <input type="checkbox" id="dem_have2" name="dem_have[]" value="51~100萬"> <label for="dem_have2"> 51~100萬</label>
                              
                              
                                <input type="checkbox" id="dem_have3" name="dem_have[]" value="101~200萬"> <label for="dem_have3"> 101~200萬</label>
                              	<input type="checkbox" id="dem_have4" name="dem_have[]" value="201~300萬"> <label for="dem_have4"> 201~300萬</label>
                              
                               
                                <input type="checkbox" id="dem_have5" name="dem_have[]" value="300萬以上"> <label for="dem_have5"> 300萬以上</label>
                              

        </fieldset>

         <div><hr></div>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
            <legend>購屋動機(可複選)：</legend>
                               
                              	<input type="checkbox" id="pay_motive1" name="pay_motive[]" value="交通因素"> <label for="pay_motive1"> 交通因素</label>
                                <input type="checkbox" id="pay_motive2" name="pay_motive[]" value="工作因素"> <label for="pay_motive2"> 工作因素</label>
                                <input type="checkbox" id="pay_motive3" name="pay_motive[]" value="環境因素"> <label for="pay_motive3"> 環境因素</label>
                              
                              
                              	<input type="checkbox" id="pay_motive4" name="pay_motive[]" value="投資置產"> <label for="pay_motive4"> 投資置產</label>
                                <input type="checkbox" id="pay_motive5" name="pay_motive[]" value="小換大"> <label for="pay_motive5"> 小換大</label>
                                <input type="checkbox" id="pay_motive6" name="pay_motive[]" value="新婚用"> <label for="pay_motive6"> 新婚用</label>
                              
                              
                              	<input type="checkbox" id="pay_motive7" name="pay_motive[]" value="營業用"> <label for="pay_motive7"> 營業用</label>
                                <input type="checkbox" id="pay_motive8" name="pay_motive[]" value="舊換新"> <label for="pay_motive8"> 舊換新</label>
                                <input type="checkbox" id="pay_motive9" name="pay_motive[]" value="其他"> <label for="pay_motive9"> 其他</label>
                              
            
        </fieldset>

         <div><hr></div>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
           <legend>欲購屋時間：</legend><br>
            <input id="pay_time1" type="radio" value="立即購買" name="pay_time" > <label for="pay_time1">立即購買</label>　
            <input id="pay_time2" type="radio" value="半年之內" name="pay_time" > <label for="pay_time2">半年之內</label>　
            <input id="pay_time3" type="radio" value="半年~二年" name="pay_time" > <label for="pay_time3">半年~二年</label>　
       </fieldset>
    </section>
    </div>


    <div data-role="collapsible">
    <h3 class="scor_top">需求2</h3>
    <section>
        <div class="input_div"><label>格局需求：</label><input type="text" name="dem_pattern" placeholder="幾房">
                                   <!--<label></label><input type="text" name="dem_pattern2" placeholder="幾廳"><br>
                                   <label></label><input type="text" name="dem_pattern3" placeholder="幾衛浴">-->
        </div>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
           <legend>車位需求：</legend>　 
            <input type="radio" value="n" id="dem_car1" name="dem_car" > <label for="dem_car1">不需要</label>
            <input type="radio" value="y" id="dem_car2" name="dem_car" ><label for="dem_car2">需要</label>
       </fieldset>
            <input type="text" name="dem_car_txt" placeholder="幾位">

       <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
            <legend>樓層需求(可複選)：</legend>
                               
                              	<input type="checkbox" id="dem_floor1" name="dem_floor[]" value="低樓層"><label for="dem_floor1"> 低樓層</label>
                                <input type="checkbox" id="dem_floor2" name="dem_floor[]" value="中樓層"><label for="dem_floor2"> 中樓層</label>
                                <input type="checkbox" id="dem_floor3" name="dem_floor[]" value="高樓層"><label for="dem_floor3"> 高樓層</label>
                              
        </fieldset>

        <fieldset class="input_div" data-role="controlgroup" data-type="horizontal">
            <legend>座向需求(可複選)：</legend>
                               
                              	<input type="checkbox" id="dem_side1" name="dem_side[]" value="東"><label for="dem_side1"> 東</label>
                                <input type="checkbox" id="dem_side2" name="dem_side[]" value="南"><label for="dem_side2"> 南</label>
                                <input type="checkbox" id="dem_side3" name="dem_side[]" value="西"><label for="dem_side3" >西</label>
                              	<input type="checkbox" id="dem_side4" name="dem_side[]" value="北"><label for="dem_side4">北</label>
                              
                              
        </fieldset>
        <div><hr></div>
        <div class="input_div"><label>購屋次數：</label><input type="text" name="pay_num" placeholder="幾次"></div>
        <div class="input_div"><label>介紹人、戶別：</label><input type="text" name="Introduction" ></div>

    </section>
    </div>

      <div data-role="footer" data-position="fixed" style="text-align: center;">
        <button id="sub_from" type="submit" class="ui-btn" style="font-size: 15px;">送出表單</button>
      </div>
    <input type="hidden" name="sql_type" value="insert">
    <input type="hidden" name="record_id" value="<?php echo $record_id?>">
  </div>
</form>

	<script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
	<!--<script type="text/javascript" src="../js/jquery.steps.js"></script>-->
	<script type="text/javascript" src="../js/plugins/jquery_mobile/jquery.mobile-1.4.5.min.js"></script>
  <script type="text/javascript" src="../js/plugins/twzipcode/jquery.twzipcode.js"></script>
    <script type="text/javascript">
$(document).ready(function() {

  <?php 
    if (empty($record_id)) {
      echo 'location.replace("../500.html");';
    }
  ?>
	
 /*  $("#wid_steps").steps({
           headerTag: "h3",
           bodyTag: "section",
           transitionEffect: "slideLeft",
           stepsOrientation: "vertical"
});*/

   $("#sub_from").click(function(event) {
          if (confirm("確定要送出表單??")) {
          	$("#view_form").submit();
          }
   });

   $("#twzipcode").twzipcode();

  

   var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
        //指定視窗物件

    $(".scor_top").click(function() {
            $body.animate({
                scrollTop: 0
            }, 500);
        });

   //搜尋方框

   $("#list_ul").on('click', '.search_txt', function(event) {
   	event.preventDefault();
   	$("#inset-autocomplete-input").val($(this).text());
      $("#list_ul li").addClass('ui-screen-hidden');
   });


   $("#twzipcode [name='county']").change(function(event) {
   	    adds_detial();
   });

   $("#twzipcode [name='district']").change(function(event) {
   	    adds_detial();
   });

});//JQUERY END

function adds_detial() {

	$.ajax({
   	  	url: 'from_sql.php',
   	  	type: 'GET',
   	  	dataType: 'json',
   	  	data: {
   	  		    type: 'adds_detial',
   	  		    zipcode: $("#twzipcode [name='zipcode']").val()
   	  		  },
   	    success:function (json) {

   	    	$("#list_ul").html('');
   	    	 
   	    	$.each(json.adds_array, function() {
   	    		 $("#list_ul").append('<li class="ui-screen-hidden"><a class="search_txt" href="#">'+this['road']+'</a></li>');
   	    	});
   	    }
   	  });
}
    	
    </script>
</body>
</html>