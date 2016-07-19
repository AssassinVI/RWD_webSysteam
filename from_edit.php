<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';
?>


<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>顧客問卷-編輯</title>
		<!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>
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
                            <form method="POST" action="shared_php/from_sql.php" class="form-horizontal" enctype="multipart/form-data">
                               <div class="form-group">
                                   <label class="col-sm-2 control-label">表單序號：</label>
                                    <div class="col-sm-2"><input type="text" class="form-control" readonly="readonly" value="ABC123456"></div>

                                    <label class="col-sm-2 control-label">填表日期：</label>
                                    <div class="col-sm-2"><input name="set_time" type="date" class="form-control" value=""></div>

                                    <label class="col-sm-2 control-label">專案名稱：</label>
                                    <div class="col-sm-2">
                                       <select name="case_name" class="form-control">
                                         <option>專案1</option>
                                         <option>專案2</option>
                                         <option>專案3</option>
                                         <option>專案4</option>
                                       </select>
                                    </div>
                                </div>

                             <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">顧客姓名：</label>
                                    <div class="col-sm-2">
                                       <input name="name" type="text" class="form-control" value="">
                                        <input type="radio" name="gender" value="m">先生
                                        <input type="radio" name="gender" value="f">小姐
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
                                       <input type="radio" value="已婚" name="mar_state">已婚
                                       <input name="mar_child" type="text"  value="">個小孩<br>
                                       <input type="radio" value="已婚無子" name="mar_state">已婚無子<br>
                                       <input type="radio" value="未婚" name="mar_state">未婚<br>
                                       <input type="radio" value="其他" name="mar_state">其他
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">月收入：</label>
                                    <div class="col-sm-2"><input name="mon_income" type="text" class="form-control" value=""></div>

                                     <label class="col-sm-2 control-label">交通工具：</label>
                                    <div class="col-sm-2">
                                       <select name="transportation" class="form-control">
                                         <option>汽車</option>
                                         <option>機車</option>
                                         <option>大眾運輸</option>
                                         <option>其他</option>
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
                                          <option>租賃</option>
                                          <option>宿舍</option>
                                          <option>父母所有</option>
                                          <option>配偶所有</option>
                                          <option>本人所有</option>
                                          <option>其他</option>
                                       </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">現住房屋型態：</label>
                                    <div class="col-sm-2">
                                       <input type="radio" value="公寓" name="house_type">公寓<br>
                                       <input type="radio" value="大樓" name="house_type">大樓<br>
                                       <input type="radio" value="套房" name="house_type">套房<br>
                                       <input type="radio" value="透天" name="house_type">透天<br>
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
                                       <input type="checkbox" value="中時" name="media[]">中時　
                                       <input type="checkbox" value="聯合" name="media[]">聯合　
                                       <input type="checkbox" value="自由" name="media[]">自由　
                                       <input type="checkbox" value="聯晚" name="media[]">聯晚　
                                       <input type="checkbox" value="蘋果日報" name="media[]">蘋果日報　
                                       <input type="checkbox" value="網路" name="media[]">網路　
                                       <input type="checkbox" value="車箱" name="media[]">車箱　
                                       <input type="checkbox" value="廣告" name="media[]">廣告　
                                       <input type="checkbox" value="CF" name="media[]">CF　
                                       <input type="checkbox" value="RD" name="media[]">RD　
                                       <input type="checkbox" value="POP" name="media[]">POP　
                                       <input type="checkbox" value="雜誌" name="media[]">雜誌　
                                       <input type="checkbox" value="派報" name="media[]">派報　
                                       <input type="checkbox" value="夾報" name="media[]">夾報　
                                       <input type="checkbox" value="介紹" name="media[]">介紹　
                                       <input type="checkbox" value="其他" name="media[]">其他 <input type="text" name="media17">
                                    </div>
                                </div>


                             <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">產品需求(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" value="大樓" name="dem_product[]">大樓　
                                       <input type="checkbox" value="透天" name="dem_product[]">透天　
                                       <input type="checkbox" value="套房" name="dem_product[]">套房　
                                       <input type="checkbox" value="店面" name="dem_product[]">店面　
                                       <input type="checkbox" value="辦公室" name="dem_product[]">辦公室　
                                       <input type="checkbox" value="其他" name="dem_product[]">其它 <input type="text" name="dem_product7">
                                    </div>
                                </div>
                                
                              <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">坪數需求(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" value="30坪以下" name="dem_floor_num[]">30坪以下　
                                       <input type="checkbox" value="31~40坪" name="dem_floor_num[]">31~40坪　
                                       <input type="checkbox" value="41~50坪" name="dem_floor_num[]">41~50坪　
                                       <input type="checkbox" value="51~70坪" name="dem_floor_num[]">51~70坪　
                                       <input type="checkbox" value="71~90坪" name="dem_floor_num[]">71~90坪　
                                       <input type="checkbox" value="91坪以上" name="dem_floor_num[]">91坪以上
                                    </div>
                                </div>
                              

                              <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">購屋預算(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" value="301~400萬" name="dem_money[]">301~400萬　
                                       <input type="checkbox" value="401~600萬" name="dem_money[]">401~600萬　
                                       <input type="checkbox" value="601~800萬" name="dem_money[]">601~800萬　
                                       <input type="checkbox" value="801~1200萬" name="dem_money[]">801~1200萬　
                                       <input type="checkbox" value="1201~2000萬" name="dem_money[]">1201~2000萬　
                                       <input type="checkbox" value="2001~3000萬" name="dem_money[]">2001~3000萬　
                                       <input type="checkbox" value="3001萬以上" name="dem_money[]">3001萬以上
                                    </div>
                                </div>

                             <div class="hr-line-dashed"></div>   


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">希望月付款(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" value="20,000以下" name="dem_mon_pay[]">20,000以下　
                                       <input type="checkbox" value="20,001~27,000" name="dem_mon_pay[]">20,001~27,000　
                                       <input type="checkbox" value="27,001~35,000" name="dem_mon_pay[]">27,001~35,000　
                                       <input type="checkbox" value="35,001~42,000" name="dem_mon_pay[]">35,001~42,000　
                                       <input type="checkbox" value="42,001~50,000" name="dem_mon_pay[]">42,001~50,000　
                                       <input type="checkbox" value="50,001~60,000" name="dem_mon_pay[]">50,001~60,000　
                                       <input type="checkbox" value="60,001以上" name="dem_mon_pay[]">60,001以上
                                    </div>
                                </div>


                              <div class="hr-line-dashed"></div>  

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">自備款(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" value="50萬以下" name="dem_have[]">50萬以下　
                                       <input type="checkbox" value="50~100萬" name="dem_have[]">50~100萬　
                                       <input type="checkbox" value="101~200萬" name="dem_have[]">101~200萬　
                                       <input type="checkbox" value="201~300萬" name="dem_have[]">201~300萬　
                                       <input type="checkbox" value="300萬以上" name="dem_have[]">300萬以上　
                                    </div>
                                </div>

                               <div class="hr-line-dashed"></div>  


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">購屋動機(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" value="交通因素" name="pay_motive[]">交通因素　
                                       <input type="checkbox" value="工作因素" name="pay_motive[]">工作因素　
                                       <input type="checkbox" value="環境因素" name="pay_motive[]">環境因素　
                                       <input type="checkbox" value="投資置產" name="pay_motive[]">投資置產　
                                       <input type="checkbox" value="小換大" name="pay_motive[]">小換大　
                                       <input type="checkbox" value="新婚用" name="pay_motive[]">新婚用　
                                       <input type="checkbox" value="營業用" name="pay_motive[]">營業用　
                                       <input type="checkbox" value="舊換新" name="pay_motive[]">舊換新　
                                       <input type="checkbox" value="其它" name="pay_motive[]">其它　
                                    </div>
                                </div>

                               <div class="hr-line-dashed"></div>  


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">欲購屋時間：</label>
                                    <div class="col-sm-10">
                                       <input type="radio" value="立即購買" name="pay_time">立即購買　
                                       <input type="radio" value="半年之內" name="pay_time">半年之內　
                                       <input type="radio" value="半年~二年" name="pay_time">半年~二年
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
                                       <input type="radio" value="n" name="dem_car">不需要　
                                       <input type="radio" value="y" name="dem_car">需要　
                                       <input type="text" name="dem_car_txt">位　
                                    </div>
                                </div>


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">樓層需求(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" value="低樓層" name="dem_floor[]">低樓層　
                                       <input type="checkbox" value="中樓層" name="dem_floor[]">中樓層　
                                       <input type="checkbox" value="高樓層" name="dem_floor[]">高樓層　
                                    </div>
                                </div>


                                <div class="form-group">
                                   <label class="col-sm-2 control-label">座向需求(可複選)：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" value="東" name="dem_side[]">東　
                                       <input type="checkbox" value="南" name="dem_side[]">南　
                                       <input type="checkbox" value="西" name="dem_side[]">西　
                                       <input type="checkbox" value="北" name="dem_side[]">北　
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
                                       <input type="radio" value="已購" name="is_buy">已購　
                                       <input type="radio" value="未購" name="is_buy">未購　
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