<?php
 /* ================================= 連接資料庫 ======================================= */
require_once 'config.php';
require_once 'login_session.php';
session_start();

?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>顧客問卷</title>
    <link rel="stylesheet" type="text/css" href="../css/plugins/jquery_step/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/jquery_step/main.css">
	<link rel="stylesheet" type="text/css" href="../css/plugins/jquery_step/jquery.steps.css">
	<style type="text/css">
	    body{ font-family: Microsoft JhengHei; font-size: 18px; }
		#wid_steps{ padding-top: 30px; }
		.input_div{ padding:10px;  }
		.input_div label{  }
		input[type="text"]{ padding: 11px 20px; width: 90%; border-radius: 10px;  }
		input[type="text"]:focus{  border:1px solid #3C3C3C; }
		input[type="radio"]{ width: 20px; height: 20px; }
		input[type="checkbox"]{ width: 20px; height: 20px; }

		#twzipcode input{ width: 20%; }
		select{ padding:10px; margin-right: 5px; border-radius: 10px; }
		#twzipcode{ display: inline-block; }
		.check_div{ padding:5px;  }
		.check_div label{ width: 80px; }

		.check_div2{ padding:5px;  }
		.check_div2 label{ width: 145px; }
	</style>
</head>
<body>
	<div id="wid_steps">
    <h3>基本資料</h3>
    <section>
        <div class="input_div"><label>顧客姓名：</label><input type="text" name="name" placeholder="姓名"></div>
        <div class="input_div"><label>性別：</label><input type="radio" value="m" name="gender">先生　<input type="radio" value="f" name="gender">小姐</div>
        <div class="input_div"><label>電話(家)：</label><input type="text" name="tel_H" placeholder="電話(家)"></div>
        <div class="input_div"><label>電話(公)：</label><input type="text" name="tel_O" placeholder="電話(公)"></div>
        <div class="input_div"><label>手機：</label><input type="text" name="phone" placeholder="手機"></div>
        <div class="input_div"><label>E-mail：</label><input type="text" name="email" placeholder="E-mail"></div>
        <div class="input_div"><label>住址：</label><div id="twzipcode"></div></div>
        <div class="input_div"><input type="text" name="adds" placeholder="詳細地址"></div>
    </section>


    <h3>公司資料</h3>
    <section>
        <div class="input_div"><label>職業：</label><input type="text" name="job" placeholder="職業"></div>
        <div class="input_div"><label>職稱：</label><input type="text" name="job_title" placeholder="職稱"></div>
        <div class="input_div"><label>年齡：</label><input type="text" name="cust_old" placeholder="年齡"></div>
        <div class="input_div"><label>工作區域：</label><input type="text" name="job_area" placeholder="工作區域"></div>
        <div class="input_div"><label>公司名稱：</label><input type="text" name="job_comapny" placeholder="公司名稱"></div>
    </section>


    <h3>目前狀況</h3>
    <section>
       <div class="input_div">
           <label>婚姻狀況：</label><br>
            <input type="radio" value="已婚" name="mar_state" >已婚　
            <input type="radio" value="已婚無子" name="mar_state" >已婚無子　 
            <input type="radio" value="未婚" name="mar_state" >未婚　 
            <input type="radio" value="其他" name="mar_state" >其他　<br>
            <label></label> 
            <input type="text" name="mar_child" placeholder="幾個小孩">
       </div>
       <div class="input_div"><label>月收入：</label><input type="text" name="mon_income" placeholder="月收入"></div>
       <div class="input_div">
          <label>交通工具：</label>
          <select name="transportation">
             <option>請選擇</option>
       	     <option value="汽車">汽車</option>
       	     <option value="機車">機車</option>
       	     <option value="大眾運輸">大眾運輸</option>
       	     <option value="其他">其他</option>
          </select>
         </div>
       <div class="input_div"><label>居住人口：</label><input type="text" name="live_people" placeholder="居住人口"></div>
       <div class="input_div">
          <label>現住房屋：</label>
          <select name="homeowner">
             <option>請選擇</option>
       	     <option value="租賃">租賃</option>
       	     <option value="宿舍">宿舍</option>
       	     <option value="父母所有">父母所有</option>
       	     <option value="配偶所有">配偶所有</option>
       	     <option value="本人所有">本人所有</option>
       	     <option value="其他">其他</option>
          </select>
         </div>

        <div class="input_div">
           <label>現住房屋型態：</label><br>
            <input type="radio" value="公寓" name="house_type" >公寓　
            <input type="radio" value="大樓" name="house_type" >大樓　
            <input type="radio" value="套房" name="house_type" >套房　
            <input type="radio" value="透天" name="house_type" >透天　<br>
            <label>屋齡：</label><input type="text" name="house_old" placeholder="幾年"> 
       </div>

       <div class="input_div"><label>現住：</label><input type="text" name="house_pattern1" placeholder="幾房"><br>
                                   <label></label><input type="text" name="house_pattern2" placeholder="幾廳"><br>
                                   <label></label><input type="text" name="house_pattern2" placeholder="幾衛浴">
        </div>
    </section>


    <h3>需求</h3>
    <section>
        <div class="input_div">
          <label>媒體(可複選)：</label>
                              <div class="check_div">
                              	<input type="checkbox" id="media1" name="media[]" value="中時"><label for="media1">中時</label>
                                <input type="checkbox" id="media2" name="media[]" value="聯合"><label for="media2">聯合</label>
                                <input type="checkbox" id="media3" name="media[]" value="自由"><label for="media3">自由</label>
                              </div>
                              <div class="check_div">
                              	<input type="checkbox" id="media4" name="media[]" value="聯晚"><label for="media4">聯晚</label>
                                <input type="checkbox" id="media5" name="media[]" value="蘋果日報"><label for="media5">蘋果日報</label>
                                <input type="checkbox" id="media6" name="media[]" value="網路"><label for="media6">網路</label>
                              </div>
                              <div class="check_div">
                              	<input type="checkbox" id="media7" name="media[]" value="車箱"><label for="media7">車箱</label>
                                <input type="checkbox" id="media8" name="media[]" value="廣告"><label for="media8">廣告</label>
                                <input type="checkbox" id="media9" name="media[]" value="CF"><label for="media9">CF</label>
                              </div>  
                              <div class="check_div">
                              	<input type="checkbox" id="media10" name="media[]" value="RD"><label for="media10">RD</label>
                                <input type="checkbox" id="media11" name="media[]" value="POP"><label for="media11">POP</label>
                                <input type="checkbox" id="media12" name="media[]" value="雜誌"><label for="media12">雜誌</label>
                              </div>
                              <div class="check_div">
                              	<input type="checkbox" id="media13" name="media[]" value="派報"><label for="media13">派報</label>
                                <input type="checkbox" id="media14" name="media[]" value="夾報"><label for="media14">夾報</label>
                                <input type="checkbox" id="media15" name="media[]" value="介紹"><label for="media15">介紹</label>
                              </div>
                              <div class="check_div">
                              	<input type="checkbox" id="media16" name="media[]" value="其他"><label for="media16">其他</label>
                                <input type="text" name="media17" value="" placeholder="其他媒體">
                              </div>

        </div>

        <div class="input_div">
           <label>產品需求(可複選)：</label>
                              <div class="check_div">
                              	<input type="checkbox" id="dem_product1" name="dem_product[]" value="大樓"><label for="dem_product1">大樓</label>
                                <input type="checkbox" id="dem_product2" name="dem_product[]" value="透天"><label for="dem_product2">透天</label>
                                <input type="checkbox" id="dem_product3" name="dem_product[]" value="套房"><label for="dem_product3">套房</label>
                              </div>
                              <div class="check_div">
                              	<input type="checkbox" id="dem_product4" name="dem_product[]" value="店面"><label for="dem_product4">店面</label>
                                <input type="checkbox" id="dem_product5" name="dem_product[]" value="辦公室"><label for="dem_product5">辦公室</label>
                                <input type="checkbox" id="dem_product6" name="dem_product[]" value="其他"><label for="dem_product6">其他</label>
                              </div>
                              <div class="check_div">
                              	<input type="text" name="dem_product7" value="" placeholder="其他產品">
                              </div>
              
        </div>

        <div class="input_div">
            <label>坪數需求(可複選)：</label>
                               <div class="check_div">
                              	<input type="checkbox" id="dem_floor_num1" name="dem_floor_num[]" value="30坪以下"><label for="dem_floor_num1">30坪以下</label>
                                <input type="checkbox" id="dem_floor_num2" name="dem_floor_num[]" value="31~40坪"><label for="dem_floor_num2">31~40坪</label>
                                <input type="checkbox" id="dem_floor_num3" name="dem_floor_num[]" value="41~50坪"><label for="dem_floor_num3">41~50坪</label>
                              </div>
                              <div class="check_div">
                              	<input type="checkbox" id="dem_floor_num4" name="dem_floor_num[]" value="51~70坪"><label for="dem_floor_num4">51~70坪</label>
                                <input type="checkbox" id="dem_floor_num5" name="dem_floor_num[]" value="71~90坪"><label for="dem_floor_num5">71~90坪</label>
                                <input type="checkbox" id="dem_floor_num6" name="dem_floor_num[]" value="91坪以上"><label for="dem_floor_num6">91坪以上</label>
                              </div>
            
        </div>

        <div class="input_div">
                  <label>購屋預算(可複選)：</label>
                              <div class="check_div2">
                              	<input type="checkbox" id="dem_money1" name="dem_money[]" value="301~400萬"><label for="dem_money1">301~400萬</label>
                                <input type="checkbox" id="dem_money2" name="dem_money[]" value="401~600萬"><label for="dem_money2">401~600萬</label>
                              </div>
                              <div class="check_div2">
                                <input type="checkbox" id="dem_money3" name="dem_money[]" value="601~800萬"><label for="dem_money3">601~800萬</label>
                              	<input type="checkbox" id="dem_money4" name="dem_money[]" value="801~1200萬"><label for="dem_money4">801~1200萬</label>
                              </div>
                              <div class="check_div2">
                                <input type="checkbox" id="dem_money5" name="dem_money[]" value="1201~2000萬"><label for="dem_money5">1201~2000萬</label>
                                <input type="checkbox" id="dem_money6" name="dem_money[]" value="2001~3000萬"><label for="dem_money6">2001~3000萬</label>
                              </div>
                              <div class="check_div2">
                              	<input type="checkbox" id="dem_money7" name="dem_money[]" value="3001萬以上"><label for="dem_money7">3001萬以上</label>
                              </div>
                  
        </div>

        <div class="input_div">
                  <label>希望月付款(可複選)：</label>
                             <div class="check_div2">
                              	<input type="checkbox" id="dem_mon_pay1" name="dem_mon_pay[]" value="20,000以下"><label for="dem_mon_pay1">20,000以下</label>
                                <input type="checkbox" id="dem_mon_pay2" name="dem_mon_pay[]" value="20,001~27,000"><label for="dem_mon_pay2">20,001~27,000</label>
                              </div>
                              <div class="check_div2">
                                <input type="checkbox" id="dem_mon_pay3" name="dem_mon_pay[]" value="27,001~35,000"><label for="dem_mon_pay3">27,001~35,000</label>
                              	<input type="checkbox" id="dem_mon_pay4" name="dem_mon_pay[]" value="35,001~42,000"><label for="dem_mon_pay4">35,001~42,000</label>
                              </div>
                              <div class="check_div2">
                                <input type="checkbox" id="dem_mon_pay5" name="dem_mon_pay[]" value="42,001~50,000"><label for="dem_mon_pay5">42,001~50,000</label>
                                <input type="checkbox" id="dem_mon_pay6" name="dem_mon_pay[]" value="50,001~60,000"><label for="dem_mon_pay6">50,001~60,000</label>
                              </div>
                              <div class="check_div2">
                              	<input type="checkbox" id="dem_mon_pay7" name="dem_mon_pay[]" value="60,000以上"><label for="dem_mon_pay7">60,000以上</label>
                              </div>
        </div>


        <div class="input_div">
            <label>自備款(可複選)：</label>
                               <div class="check_div2">
                              	<input type="checkbox" id="dem_have1" name="dem_have[]" value="50萬以下"><label for="dem_have1">50萬以下</label>
                                <input type="checkbox" id="dem_have2" name="dem_have[]" value="51~100萬"><label for="dem_have2">51~100萬</label>
                              </div>
                              <div class="check_div2">
                                <input type="checkbox" id="dem_have3" name="dem_have[]" value="101~200萬"><label for="dem_have3">101~200萬</label>
                              	<input type="checkbox" id="dem_have4" name="dem_have[]" value="201~300萬"><label for="dem_have4">201~300萬</label>
                              </div>
                               <div class="check_div2">
                                <input type="checkbox" id="dem_have5" name="dem_have[]" value="300萬以上"><label for="dem_have5">300萬以上</label>
                              </div>

        </div>

        <div class="input_div">
            <label>購屋動機(可複選)：</label>
                               <div class="check_div">
                              	<input type="checkbox" id="pay_motive1" name="pay_motive[]" value="交通因素"><label for="pay_motive1">交通因素</label>
                                <input type="checkbox" id="pay_motive2" name="pay_motive[]" value="工作因素"><label for="pay_motive2">工作因素</label>
                                <input type="checkbox" id="pay_motive3" name="pay_motive[]" value="環境因素"><label for="pay_motive3">環境因素</label>
                              </div>
                              <div class="check_div">
                              	<input type="checkbox" id="pay_motive4" name="pay_motive[]" value="投資置產"><label for="pay_motive4">投資置產</label>
                                <input type="checkbox" id="pay_motive5" name="pay_motive[]" value="小換大"><label for="pay_motive5">小換大</label>
                                <input type="checkbox" id="pay_motive6" name="pay_motive[]" value="新婚用"><label for="pay_motive6">新婚用</label>
                              </div>
                              <div class="check_div">
                              	<input type="checkbox" id="pay_motive7" name="pay_motive[]" value="營業用"><label for="pay_motive7">營業用</label>
                                <input type="checkbox" id="pay_motive8" name="pay_motive[]" value="舊換新"><label for="pay_motive8">舊換新</label>
                                <input type="checkbox" id="pay_motive9" name="pay_motive[]" value="其他"><label for="pay_motive9">其他</label>
                              </div>
            
        </div>

        <div class="input_div">
           <label>欲購屋時間：</label><br>
            <input type="radio" value="立即購買" name="pay_time" >立即購買　
            <input type="radio" value="半年之內" name="pay_time" >半年之內　
            <input type="radio" value="半年~二年" name="pay_time" >半年~二年　
       </div>
    </section>

    <h3>需求2</h3>
    <section>
        <div class="input_div"><label>格局需求：</label><input type="text" name="dem_pattern1" placeholder="幾房"><br>
                                   <label></label><input type="text" name="dem_pattern2" placeholder="幾廳"><br>
                                   <label></label><input type="text" name="dem_pattern3" placeholder="幾衛浴">
        </div>

        <div class="input_div">
           <label>車位需求：</label><br>　 
            <input type="radio" value="n" name="dem_car" >不需要　 
            <input type="radio" value="y" name="dem_car" >需要　<br>
            <label></label> 
            <input type="text" name="mar_child" placeholder="幾位">
       </div>

       <div class="input_div">
            <label>樓層需求(可複選)：</label>
                               <div class="check_div">
                              	<input type="checkbox" id="dem_floor1" name="dem_floor[]" value="低樓層"><label for="dem_floor1">低樓層</label>
                                <input type="checkbox" id="dem_floor2" name="dem_floor[]" value="中樓層"><label for="dem_floor2">中樓層</label>
                                <input type="checkbox" id="dem_floor3" name="dem_floor[]" value="高樓層"><label for="dem_floor3">高樓層</label>
                              </div>
                              
            
        </div>

        <div class="input_div">
            <label>座向需求(可複選)：</label>
                               <div class="check_div">
                              	<input type="checkbox" id="dem_side1" name="dem_side[]" value="東"><label for="dem_side1">東</label>
                                <input type="checkbox" id="dem_side2" name="dem_side[]" value="南"><label for="dem_side2">南</label>
                                <input type="checkbox" id="dem_side3" name="dem_side[]" value="西"><label for="dem_side3">西</label>
                              </div>
                              <div class="check_div">
                              	<input type="checkbox" id="dem_side4" name="dem_side[]" value="北"><label for="dem_side4">北</label>
                              </div>
                              
            
        </div>

        <div class="input_div"><label>購屋次數：</label><input type="text" name="pay_num" placeholder="幾次"></div>

        <div class="input_div"><label>介紹戶別：</label><input type="text" name="Introduction" ></div>

        
    </section>
</div>

	<script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="../js/jquery.steps.js"></script>
	<script type="text/javascript" src="../js/plugins/twzipcode/jquery.twzipcode.js"></script>
    <script type="text/javascript">
$(document).ready(function() {
	
   $("#wid_steps").steps({
           headerTag: "h3",
           bodyTag: "section",
           transitionEffect: "slideLeft",
           stepsOrientation: "vertical"
});

   $("#twzipcode").twzipcode();

});//JQUERY END
    	
    </script>
</body>
</html>