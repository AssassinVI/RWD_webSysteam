<?php require_once 'shared_php/login_session.php';
      require_once 'shared_php/config.php';
?>


<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>顧客問卷-編輯</title>
		<!-- ================================== 外掛and CSS ====================================== -->
    <?php require_once 'shared_php/script_style.php';?>
    <script type="text/javascript" src="js/plugins/twzipcode/jquery.twzipcode.js"></script> <!-- 台灣地址 -->

    <style type="text/css">
    body{font-family: 微軟正黑體; font-size: 15px; }
      .img_logo{ border: 1px solid #c3c1c1; padding: 12px; width: 300px; }
      .img_logo img{ width: 100%; }
      #logo_div, #old_logo_div{ float: left; margin-left: 7%; }
      #twzipcode select, #twzipcode input{ font-size: 15px; padding:3px;  }
      .view_p{ padding:5px 0px; }
      .view_span{ padding: 5px; background-color: #78dcc8; border: 1px solid #1ab394;}
      #inter_hr{ border-color: #1ab394; }
      #interview{ height: 150px; }
      @media only screen and (max-width:420px){
         .img_logo{ width: 100%; }
         #logo_div, #old_logo_div{ margin-left: 0%; }
      }
    </style>

    <script type="text/javascript">
    	 $(document).ready(function() {
      $("#build_back").click(function() {
         if (confirm("是否返回上一頁??")) {
            window.history.back();            
         }
        });

      $("#twzipcode").twzipcode();

    });

    </script>
</head>
<body >
	
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
                            <h5>顧客問卷-編輯 </h5>
                            <div class="ibox-tools">
                            </div>
                        </div>

                        <div class="ibox-content">
                            <form method="POST" action="from_all/from_sql.php" class="form-horizontal" enctype="multipart/form-data">
                               <div class="form-group">
                                   <label class="col-sm-2 control-label">表單序號：</label>
                                    <div class="col-sm-2"><input type="text" class="form-control" readonly="readonly" value="ABC123456"></div>

                                    <label class="col-sm-2 control-label">填表日期：</label>
                                    <div class="col-sm-2"><input name="set_time" type="date" class="form-control" value=""></div>

                                    <label class="col-sm-2 control-label">專案名稱：</label>
                                    <div class="col-sm-2">
                                       <select name="record_id" class="form-control">
                                         <option value="">專案1</option>
                                         <option value="">專案2</option>
                                         <option value="">專案3</option>
                                         <option value="">專案4</option>
                                       </select>
                                    </div>
                                </div>

                             <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">顧客姓名：</label>
                                    <div class="col-sm-2">
                                       <input name="name" type="text" class="form-control" value="">
                                        <input type="radio" id="gender1" name="gender" value="m"><label for="gender1">先生</label>
                                        <input type="radio" id="gender2" name="gender" value="f"><label for="gender2">小姐</label>
                                    </div>
                                </div>

                              <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">電話(家)：</label>
                                    <div class="col-sm-2"><input name="tel_H" type="text" class="form-control" value=""></div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">電話(公)：</label>
                                    <div class="col-sm-2"><input name="tel_O" type="text" class="form-control" value=""></div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">手機：</label>
                                    <div class="col-sm-2"><input name="phone" type="text" class="form-control" value=""></div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">E-mail：</label>
                                    <div class="col-sm-2"><input name="email" type="text" class="form-control" value=""></div>
                                </div>

                             <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">住址：</label>
                                    <div id="twzipcode" class="col-sm-10" ></div>
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-4"><input name="adds" type="text" class="form-control" value="" placeholder="詳細住址"></div>
                                </div>


                              <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">職業：</label>
                                    <div class="col-sm-2"><input name="job" type="text" class="form-control" value=""></div>

                                     <label class="col-sm-2 control-label">職稱：</label>
                                    <div class="col-sm-2"><input name="job_title" type="text" class="form-control" value=""></div>

                                     <label class="col-sm-2 control-label">年齡：</label>
                                    <div class="col-sm-2"><input name="cust_old" type="text" class="form-control" value=""></div>
                                </div>

                             <div class="hr-line-dashed"></div>   

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">工作區域：</label>
                                    <div class="col-sm-2"><input name="job_area" type="text" class="form-control" value=""></div>
                                    <label class="col-sm-2 control-label">公司名稱：</label>
                                    <div class="col-sm-2"><input name=" job_company" type="text" class="form-control" value=""></div>
                                </div>

                              <div class="hr-line-dashed"></div>  

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">婚姻狀況：</label>
                                    <div class="col-sm-4">
                                       <input type="radio" id="mar_state1" value="已婚" name="mar_state"><label for="mar_state1">已婚</label>
                                       <input name="mar_child" type="text"  value="">個小孩<br>
                                       <input type="radio" id="mar_state2" value="已婚無子" name="mar_state"><label for="mar_state2">已婚無子</label><br>
                                       <input type="radio" id="mar_state3" value="未婚" name="mar_state"><label for="mar_state3">未婚</label><br>
                                       <input type="radio" id="mar_state4" value="其他" name="mar_state"><label for="mar_state4">其他</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">月收入：</label>
                                    <div class="col-sm-2"><input name="mon_income" type="text" class="form-control" value=""></div>

                                     <label class="col-sm-2 control-label">交通工具：</label>
                                    <div class="col-sm-2">
                                       <select name="transportation" class="form-control">
                                         <option value="汽車">汽車</option>
                                         <option value="機車">機車</option>
                                         <option value="大眾運輸">大眾運輸</option>
                                         <option value="其他">其他</option>
                                       </select>
                                    </div>
                                </div>

                             <div class="hr-line-dashed"></div>   

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">居住人口：</label>
                                    <div class="col-sm-2"><input name="live_people" type="text" class="form-control" value="" placeholder="供幾人"></div>
                                    <label class="col-sm-2 control-label">現住房屋：</label>
                                    <div class="col-sm-2">
                                       <select name="homeowner" class="form-control">
                                          <option value="租賃">租賃</option>
                                          <option value="宿舍">宿舍</option>
                                          <option value="父母所有">父母所有</option>
                                          <option value="配偶所有">配偶所有</option>
                                          <option value="本人所有">本人所有</option>
                                          <option value="其他">其他</option>
                                       </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">現住房屋型態：</label>
                                    <div class="col-sm-2">
                                       <input type="radio" id="house_type1" value="公寓" name="house_type"><label for="house_type1">公寓</label><br>
                                       <input type="radio" id="house_type2" value="大樓" name="house_type"><label for="house_type2">大樓</label><br>
                                       <input type="radio" id="house_type3" value="套房" name="house_type"><label for="house_type3">套房</label><br>
                                       <input type="radio" id="house_type4" value="透天" name="house_type"><label for="house_type4">透天</label><br>
                                       屋齡<input type="text" name="house_old">年
                                    </div>
                                </div>

                             <div class="hr-line-dashed"></div>   


                              <div class="form-group">
                                   <label class="col-sm-2 control-label">現住：</label>
                                    <div class="col-sm-4">
                                       <input name="house_pattern1" type="text"  value="">房　
                                       <input name="house_pattern2" type="text"  value="">廳　
                                       <input name="house_pattern3" type="text"  value="">衛浴
                                    </div>
                                    <label class="col-sm-2 control-label">室內(坪)：</label>
                                    <div class="col-sm-2"><input name=" floor_num" type="text" class="form-control" value="" placeholder="坪數"></div>
                                </div>

                            <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">媒體(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="media1" value="中時" name="media[]"><label for="media1">中時</label>　
                                       <input type="checkbox" id="media2" value="聯合" name="media[]"><label for="media2">聯合</label>　
                                       <input type="checkbox" id="media3" value="自由" name="media[]"><label for="media3">自由</label>　
                                       <input type="checkbox" id="media4" value="聯晚" name="media[]"><label for="media4">聯晚</label>　
                                       <input type="checkbox" id="media5" value="蘋果日報" name="media[]"><label for="media5">蘋果日報</label>　
                                       <input type="checkbox" id="media6" value="網路" name="media[]"><label for="media6">網路</label>　
                                       <input type="checkbox" id="media7" value="車箱" name="media[]"><label for="media7">車箱</label>　
                                       <input type="checkbox" id="media8" value="廣告" name="media[]"><label for="media8">廣告</label>　
                                       <input type="checkbox" id="media9" value="CF" name="media[]"><label for="media9">CF</label>　
                                       <input type="checkbox" id="media10" value="RD" name="media[]"><label for="media10">RD</label>　
                                       <input type="checkbox" id="media11" value="POP" name="media[]"><label for="media11">POP</label>　
                                       <input type="checkbox" id="media12" value="雜誌" name="media[]"><label for="media12">雜誌</label>　
                                       <input type="checkbox" id="media13" value="派報" name="media[]"><label for="media13">派報</label>　
                                       <input type="checkbox" id="media14" value="夾報" name="media[]"><label for="media14">夾報</label>　
                                       <input type="checkbox" id="media15" value="介紹" name="media[]"><label for="media15">介紹</label>　
                                       <input type="checkbox" id="media16" value="其他" name="media[]"><label for="media16">其他</label> <input type="text" name="media_txt">
                                    </div>
                                </div>


                             <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">產品需求(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_product1" value="大樓" name="dem_product[]"><label for="dem_product1">大樓</label>　
                                       <input type="checkbox" id="dem_product2" value="透天" name="dem_product[]"><label for="dem_product2">透天</label>　
                                       <input type="checkbox" id="dem_product3" value="套房" name="dem_product[]"><label for="dem_product3">套房</label>　
                                       <input type="checkbox" id="dem_product4" value="店面" name="dem_product[]"><label for="dem_product4">店面</label>　
                                       <input type="checkbox" id="dem_product5" value="辦公室" name="dem_product[]"><label for="dem_product5">辦公室</label>　
                                       <input type="checkbox" id="dem_product6" value="其他" name="dem_product[]"><label for="dem_product6">其它</label> <input type="text" name="dem_product_txt">
                                    </div>
                                </div>
                                
                              <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">坪數需求(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_floor_num1" value="30坪以下" name="dem_floor_num[]"><label for="dem_floor_num1">30坪以下</label>　
                                       <input type="checkbox" id="dem_floor_num2" value="31~40坪" name="dem_floor_num[]"><label for="dem_floor_num2">31~40坪</label>　
                                       <input type="checkbox" id="dem_floor_num3" value="41~50坪" name="dem_floor_num[]"><label for="dem_floor_num3">41~50坪</label>　
                                       <input type="checkbox" id="dem_floor_num4" value="51~70坪" name="dem_floor_num[]"><label for="dem_floor_num4">51~70坪</label>　
                                       <input type="checkbox" id="dem_floor_num5" value="71~90坪" name="dem_floor_num[]"><label for="dem_floor_num5">71~90坪</label>　
                                       <input type="checkbox" id="dem_floor_num6" value="91坪以上" name="dem_floor_num[]"><label for="dem_floor_num6">91坪以上</label>
                                    </div>
                                </div>
                              

                              <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">購屋預算(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_money1" value="301~400萬" name="dem_money[]"><label for="dem_money1">301~400萬</label>　
                                       <input type="checkbox" id="dem_money2" value="401~600萬" name="dem_money[]"><label for="dem_money2">401~600萬</label>　
                                       <input type="checkbox" id="dem_money3" value="601~800萬" name="dem_money[]"><label for="dem_money3">601~800萬</label>　
                                       <input type="checkbox" id="dem_money4" value="801~1200萬" name="dem_money[]"><label for="dem_money4">801~1200萬</label>　
                                       <input type="checkbox" id="dem_money5" value="1201~2000萬" name="dem_money[]"><label for="dem_money5">1201~2000萬</label>　
                                       <input type="checkbox" id="dem_money6" value="2001~3000萬" name="dem_money[]"><label for="dem_money6">2001~3000萬</label>　
                                       <input type="checkbox" id="dem_money7" value="3001萬以上" name="dem_money[]"><label for="dem_money7">3001萬以上</label>
                                    </div>
                                </div>

                             <div class="hr-line-dashed"></div>   


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">希望月付款(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_mon_pay1" value="20,000以下" name="dem_mon_pay[]"><label for="dem_mon_pay1">20,000以下</label>　
                                       <input type="checkbox" id="dem_mon_pay2" value="20,001~27,000" name="dem_mon_pay[]"><label for="dem_mon_pay2">20,001~27,000</label>　
                                       <input type="checkbox" id="dem_mon_pay3" value="27,001~35,000" name="dem_mon_pay[]"><label for="dem_mon_pay3">27,001~35,000</label>　
                                       <input type="checkbox" id="dem_mon_pay4" value="35,001~42,000" name="dem_mon_pay[]"><label for="dem_mon_pay4">35,001~42,000</label>　
                                       <input type="checkbox" id="dem_mon_pay5" value="42,001~50,000" name="dem_mon_pay[]"><label for="dem_mon_pay5">42,001~50,000</label>　
                                       <input type="checkbox" id="dem_mon_pay6" value="50,001~60,000" name="dem_mon_pay[]"><label for="dem_mon_pay6">50,001~60,000</label>　
                                       <input type="checkbox" id="dem_mon_pay7" value="60,001以上" name="dem_mon_pay[]"><label for="dem_mon_pay7">60,001以上</label>
                                    </div>
                                </div>


                              <div class="hr-line-dashed"></div>  

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">自備款(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_have1" value="50萬以下" name="dem_have[]"><label for="dem_have1">50萬以下</label>　
                                       <input type="checkbox" id="dem_have2" value="50~100萬" name="dem_have[]"><label for="dem_have2">50~100萬</label>　
                                       <input type="checkbox" id="dem_have3" value="101~200萬" name="dem_have[]"><label for="dem_have3">101~200萬</label>　
                                       <input type="checkbox" id="dem_have4" value="201~300萬" name="dem_have[]"><label for="dem_have4">201~300萬</label>　
                                       <input type="checkbox" id="dem_have5" value="300萬以上" name="dem_have[]"><label for="dem_have5">300萬以上</label>　
                                    </div>
                                </div>

                               <div class="hr-line-dashed"></div>  


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">購屋動機(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="pay_motive1" value="交通因素" name="pay_motive[]"><label for="pay_motive1">交通因素</label>　
                                       <input type="checkbox" id="pay_motive2" value="工作因素" name="pay_motive[]"><label for="pay_motive2">工作因素</label>　
                                       <input type="checkbox" id="pay_motive3" value="環境因素" name="pay_motive[]"><label for="pay_motive3">環境因素</label>　
                                       <input type="checkbox" id="pay_motive4" value="投資置產" name="pay_motive[]"><label for="pay_motive4">投資置產</label>　
                                       <input type="checkbox" id="pay_motive5" value="小換大" name="pay_motive[]"><label for="pay_motive5">小換大</label>　
                                       <input type="checkbox" id="pay_motive6" value="新婚用" name="pay_motive[]"><label for="pay_motive6">新婚用</label>　
                                       <input type="checkbox" id="pay_motive7" value="營業用" name="pay_motive[]"><label for="pay_motive7">營業用</label>　
                                       <input type="checkbox" id="pay_motive8" value="舊換新" name="pay_motive[]"><label for="pay_motive8">舊換新</label>　
                                       <input type="checkbox" id="pay_motive9" value="其它" name="pay_motive[]"><label for="pay_motive9">其它</label>　
                                    </div>
                                </div>

                               <div class="hr-line-dashed"></div>  


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">欲購屋時間：</label>
                                    <div class="col-sm-10">
                                       <input type="radio" id="pay_time1" value="立即購買" name="pay_time"><label for="pay_time1">立即購買</label>　
                                       <input type="radio" id="pay_time2" value="半年之內" name="pay_time"><label for="pay_time2">半年之內</label>　
                                       <input type="radio" id="pay_time3" value="半年~二年" name="pay_time"><label for="pay_time3">半年~二年</label>
                                    </div>　
                                </div>


                               <div class="hr-line-dashed"></div>  


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">格局需求：</label>
                                    <div class="col-sm-10">
                                       <input type="text" name="dem_pattern1">房　
                                       <input type="text" name="dem_pattern2">廳　
                                       <input type="text" name="dem_pattern3">衛浴　
                                    </div>
                                </div>


                                 <div class="form-group">
                                   <label class="col-sm-2 control-label">車位需求：</label>
                                    <div class="col-sm-10">
                                       <input type="radio" id="dem_car1" value="n" name="dem_car"><label for="dem_car1">不需要</label>　
                                       <input type="radio" id="dem_car2" value="y" name="dem_car"><label for="dem_car2">需要</label>　
                                       <input type="text" name="dem_car_txt">位　
                                    </div>
                                </div>


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">樓層需求(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_floor1" value="低樓層" name="dem_floor[]"><label for="dem_floor1">低樓層</label>　
                                       <input type="checkbox" id="dem_floor2" value="中樓層" name="dem_floor[]"><label for="dem_floor2">中樓層</label>　
                                       <input type="checkbox" id="dem_floor3" value="高樓層" name="dem_floor[]"><label for="dem_floor3">高樓層</label>　
                                    </div>
                                </div>


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">座向需求(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_side1" value="東" name="dem_side[]"><label for="dem_side1">東</label>　
                                       <input type="checkbox" id="dem_side2" value="南" name="dem_side[]"><label for="dem_side2">南</label>　
                                       <input type="checkbox" id="dem_side3" value="西" name="dem_side[]"><label for="dem_side3">西</label>　
                                       <input type="checkbox" id="dem_side4" value="北" name="dem_side[]"><label for="dem_side4">北</label>　
                                    </div>
                                </div>


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">購屋次數：</label>
                                    <div class="col-sm-10">
                                       <input type="text" name="pay_num">次　
                                    </div>
                                </div>


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">介紹戶別：</label>
                                    <div class="col-sm-10">
                                       <input type="text" name="Introduction">　
                                    </div>
                                </div>
                               
                               <div class="hr-line-dashed"></div>  

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">代銷公司：</label>
                                    <div class="col-sm-4">
                                       <input type="text" name="com_name" readonly="readyonly" value="XXX公司">　
                                    </div>
                                    <div class="col-sm-2">
                                       <input type="radio" id="is_buy1" value="已購" name="is_buy"><label for="is_buy1">已購</label>　
                                       <input type="radio" id="is_buy2" value="未購" name="is_buy"><label for="is_buy2">未購</label>　
                                    </div>
                                    <div class="col-sm-2">

                                      購買戶別 <input type="text" name="buy_name">
                                       
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
                                <input type="hidden" name="page" value="from_edit" />
                                
                               <div id="inter_hr" class="hr-line-dashed"></div> 

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">訪談紀錄：</label>
                                    <div class="col-sm-7">
                                       　<textarea id="interview" name="interview" class="form-control"></textarea>
                                       <p class="view_p"><span class="view_span">2016-07-18</span>XXXXX看房子</p>
                                    </div>
                                    <div class="col-sm-3"><button id="insert_view" class="btn btn-primary" type="button">新增記錄</button></div>
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