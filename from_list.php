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

    <script type="text/javascript" src="js/plugins/twzipcode/jquery.twzipcode.js"></script> <!-- 台灣地址 -->

    <!-- FooTable -->
    <link href="css/footable.core.css" rel="stylesheet">
   <!-- FooTable -->
   <script src="js/footable.all.min.js"></script>

    <style type="text/css">
      body{
        font-family: 微軟正黑體;
        font-size: 17px;
      }
      .ibox-title h5{ font-size: 16px; }
      #bs_search, #adv_search, #search_print{ color: #337ab7; font-size: 18px; margin-left: 15px; }
      #bs_search:hover, #adv_search:hover ,#search_print:hover{ color: #204a6e; }
      #twzipcode select, #twzipcode input{ font-size: 15px; padding:3px;  }
      .dis_none{ display: none; }
      .check_print{ width: 55px; height: 20px; }
      #all_check{ width: 28px; height: 18px; }
      #many_div{ padding: 0px 20px; }
      #num_bar ul{ list-style:none ; }
      #num_bar ul li{ display: inline-block; width: 35px; height: 35px; text-align: center; line-height: 33px; border-radius: 5px; border: 1px solid #1ab394; }
      #num_bar ul li a{ display: block; }
    </style>
    <script type="text/javascript">
     $(document).ready(function() {

         $('.footable').footable();

         $("#twzipcode").twzipcode();

         from_list(); //基本顯示
         many_fun('from_list'); //資料筆數


         $("#bs_search").click(function(event) {
            event.preventDefault();
             $("#bs_div").slideToggle('500');
             $("#adv_div").slideUp('500');
         });

         $("#adv_search").click(function(event) {
            event.preventDefault();
             $("#adv_div").slideToggle('500');
             $("#bs_div").slideUp('500');
         });


         $("#bs_search_btn").click(function(event) { //簡易查詢按鈕
             bs_search();
             many_fun('bs_search');//資料筆數
             bs_search_count();
             
         });

         $("#adv_search_btn").click(function(event) { //進階查詢按鈕
             adv_search();
             many_fun('adv_search');//資料筆數
         });


         //-------- 選取列印按鈕 ----------
        $("#search_print").click(function(event) {
            event.preventDefault();
           $("#search_id").val($(":checked[name='check_print']").map(function() { return $(this).val(); }).get().join(','));
           $("#search_pr_from").submit();
        });
      
      

       
     }); //JQUERY END

     function check_print() {  //選取列印按鈕顯示
            if ($(":checked[name='check_print']").length>0) {
               $("#search_print").css('display', 'inline');
            }
            else{
              $("#search_print").css('display', 'none');
            }
     }


  /* ================================= checkbox 全選 ======================================== */
    var p_num=1;
     function all_search(name) {
      var allvalue = document.getElementsByName(name);
      if (p_num%2!=0) {
        for (var i = 0; i < allvalue.length; i++) {        
           if (allvalue[i].type == "checkbox"){             
                allvalue[i].checked = true;             
             }  
          }  
       }else{

          for (var i = 0; i < allvalue.length; i++) {        
           if (allvalue[i].type == "checkbox"){             
                allvalue[i].checked = false;             
             }  
          } 
       }
       check_print();
       p_num+=1;
     }



     function bs_search_con() {
        $("#bs_div").slideToggle('500');
     }

     function adv_search_con() {
        $("#adv_div").slideToggle('500');
     }

     function from_list(start) {
     	 $("#com_tb").html('');

     	 var many=$('#many_div :selected').val();

     	 var href='from_all/from_sql.php?type=list&record_id=<?php echo $record_id;?>&start_num='+start+'&many_num='+many;
       
        $.getJSON( href ,  function(json) {
              
              $.each(json.from_array, function() {
              
                   var info="<tr>";
                  info=info+"<td ><input type='checkbox' class='check_print' name='check_print' onclick='check_print()' value="+this['from_id']+"></td>"; //選取列印
                  info=info+"<td class='no_display768'>"+this['from_id']+"</td>"; //表單ID
                  info=info+"<td >"+this['set_time']+"</td>";                    //填表日期
                  info=info+"<td><?php echo $case_name;?></td>";                     //專案名稱
                  info=info+"<td>"+this['name']+"</td>";                                    //顧客姓名
                  info=info+"<td class='no_display768'>"+this['phone']+"</td>";          //行動電話
                  info=info+"<td><a href='from_all/from_print.php?from_id="+this['from_id']+"' target='_blank' ><i class='fa fa-print'></i>列印</a></td>";
                  info=info+"<td class='no_display768'><a href='from_edit.php?from_id="+this['from_id']+"'><i class='fa fa-edit'></i>編輯</a></td>";
                  info=info+"<td class='no_display768'><a class='del_from_"+this['from_id']+"' href='javascript:del_from(\""+this['from_id']+"\");'><i class='fa fa-ban'></i>刪除</a></td>";
                  info=info+"</tr>";

                    $("#com_tb").append(info);
              });
       });
     }


    //----------------------------------------------------- List筆數 -------------------------------------------------------------
     function from_list_count() {
 
     	 var href='from_all/from_sql.php?type=list&record_id=<?php echo $record_id;?>';
       
        $.getJSON( href ,  function(json) {

        	var list_count=json.from_array.length;
       });
     }


    /* ============================================== 簡易查詢 ====================================================== */
     function bs_search(start) {

     	var many=$('#many_div :selected').val();
      
          $.ajax({
            url: 'from_all/search_sql.php',
            type: 'POST',
            dataType: 'json',
            data: {
                    type:'bs_search',
                    record_id: '<?php echo $record_id;?>',
                    name: $('[name="bs_name"]').val(), 
                    phone: $('[name="bs_phone"]').val(), 
                    email: $('[name="email"]').val(), 
                    is_buy: $(':checked[name="bs_is_buy"]').val(),
                    start_num: start,
                    many_num: many
                  },
            success:function (json) {

                 $("#com_tb").html('');
             
                $.each(json.search_array, function() {
              
                   var info="<tr>";
                  info=info+"<td ><input type='checkbox' class='check_print' name='check_print' onclick='check_print()' value="+this['from_id']+"></td>"; //選取列印
                  info=info+"<td class='no_display768'>"+this['from_id']+"</td>"; //表單ID
                  info=info+"<td >"+this['set_time']+"</td>";                    //填表日期
                  info=info+"<td><?php echo $case_name;?></td>";                     //專案名稱
                  info=info+"<td>"+this['name']+"</td>";                                    //顧客姓名
                  info=info+"<td class='no_display768'>"+this['phone']+"</td>";          //行動電話
                  info=info+"<td><a href='from_all/from_print.php?from_id="+this['from_id']+"' target='_blank' ><i class='fa fa-print'></i>列印</a></td>";
                  info=info+"<td class='no_display768'><a href='from_edit.php?from_id="+this['from_id']+"'><i class='fa fa-edit'></i>編輯</a></td>";
                  info=info+"<td class='no_display768'><a class='del_from_"+this['from_id']+"' href='javascript:del_from(\""+this['from_id']+"\");'><i class='fa fa-ban'></i>刪除</a></td>";
                  info=info+"</tr>";

                    $("#com_tb").append(info);
                    
              });
            }
          });
         
     }


    /* ============================================== 簡易查詢筆數 ====================================================== */
     function bs_search_count() {
         
         
          $.ajax({
            url: 'from_all/search_sql.php',
            type: 'POST',
            dataType: 'json',
            data: {
                    type:'bs_search',
                    record_id: '<?php echo $record_id;?>',
                    name: $('[name="bs_name"]').val(), 
                    phone: $('[name="bs_phone"]').val(), 
                    email: $('[name="email"]').val(), 
                    is_buy: $(':checked[name="bs_is_buy"]').val(),
                  },
            success:function (json) {

              
              //alert(json.search_array.length);
            }
          });
         
     }



   /* ============================================== 進階查詢 ====================================================== */
     function adv_search(start) {

     	var many=$('#many_div :selected').val();
       
          $.ajax({
            url: 'from_all/search_sql.php',
            type: 'POST',
            dataType: 'json',
            data: {
                     type: 'adv_search',
                record_id: '<?php echo $record_id;?>',
                     name: $('[name="name"]').val(), 
           set_time_start: $('[name="set_time_start"]').val(),
             set_time_end: $('[name="set_time_end"]').val(),
                    phone: $('[name="phone"]').val(),
                     adds: $('[name="zipcode"]').val()+$('[name="county"]').val()+$('[name="district"]').val()+$('[name="adds"]').val(),
                dem_money: $(':checked[name="dem_money"]').map(function() { return $(this).val(); }).get().join(','),
              dem_product: $(':checked[name="dem_product"]').map(function() { return $(this).val(); }).get().join(','),

                  dem_car: $(':checked[name="dem_car"]').val(),
              dem_car_txt: $('[name="dem_car_txt"]').val(),

            dem_floor_num: $(':checked[name="dem_floor_num"]').map(function() { return $(this).val(); }).get().join(','),
                dem_floor: $(':checked[name="dem_floor"]').map(function() { return $(this).val(); }).get().join(','),    
              dem_mon_pay: $(':checked[name="dem_mon_pay"]').map(function() { return $(this).val(); }).get().join(','), 
                 dem_side: $(':checked[name="dem_side"]').map(function() { return $(this).val(); }).get().join(','), 
                 dem_have: $(':checked[name="dem_have"]').map(function() { return $(this).val(); }).get().join(','), 
               pay_motive: $(':checked[name="pay_motive"]').map(function() { return $(this).val(); }).get().join(','), 
                 pay_time: $(':checked[name="pay_time"]').map(function() { return $(this).val(); }).get().join(','), 

                   is_buy: $(':checked[name="is_buy"]').val(),

                    media: $(':checked[name="media"]').map(function() { return $(this).val(); }).get().join(','), 

                start_num: start,
                 many_num: many

                  },
            success:function (json) {

                 $("#com_tb").html('');
             
                $.each(json.search_array, function() {
              
                   var info="<tr>";
                  info=info+"<td ><input type='checkbox' class='check_print' name='check_print' onclick='check_print()' value="+this['from_id']+"></td>"; //選取列印
                  info=info+"<td class='no_display768'>"+this['from_id']+"</td>"; //表單ID
                  info=info+"<td >"+this['set_time']+"</td>";                    //填表日期
                  info=info+"<td><?php echo $case_name;?></td>";                     //專案名稱
                  info=info+"<td>"+this['name']+"</td>";                                    //顧客姓名
                  info=info+"<td class='no_display768'>"+this['phone']+"</td>";          //行動電話
                  info=info+"<td><a href='from_all/from_print.php?from_id="+this['from_id']+"' target='_blank' ><i class='fa fa-print'></i>列印</a></td>";
                  info=info+"<td class='no_display768'><a href='from_edit.php?from_id="+this['from_id']+"'><i class='fa fa-edit'></i>編輯</a></td>";
                  info=info+"<td class='no_display768'><a class='del_from_"+this['from_id']+"' href='javascript:del_from(\""+this['from_id']+"\");'><i class='fa fa-ban'></i>刪除</a></td>";
                  info=info+"</tr>";

                    $("#com_tb").append(info);
                    
              });
            }
          });

     }



      /* ============================================== 進階查詢筆數 ====================================================== */
     function adv_search_count() {
       
          $.ajax({
            url: 'from_all/search_sql.php',
            type: 'POST',
            dataType: 'json',
            data: {
                     type: 'adv_search',
                record_id: '<?php echo $record_id;?>',
                     name: $('[name="name"]').val(), 
           set_time_start: $('[name="set_time_start"]').val(),
             set_time_end: $('[name="set_time_end"]').val(),
                    phone: $('[name="phone"]').val(),
                     adds: $('[name="zipcode"]').val()+$('[name="county"]').val()+$('[name="district"]').val()+$('[name="adds"]').val(),
                dem_money: $(':checked[name="dem_money"]').map(function() { return $(this).val(); }).get().join(','),
              dem_product: $(':checked[name="dem_product"]').map(function() { return $(this).val(); }).get().join(','),

                  dem_car: $(':checked[name="dem_car"]').val(),
              dem_car_txt: $('[name="dem_car_txt"]').val(),

            dem_floor_num: $(':checked[name="dem_floor_num"]').map(function() { return $(this).val(); }).get().join(','),
                dem_floor: $(':checked[name="dem_floor"]').map(function() { return $(this).val(); }).get().join(','),    
              dem_mon_pay: $(':checked[name="dem_mon_pay"]').map(function() { return $(this).val(); }).get().join(','), 
                 dem_side: $(':checked[name="dem_side"]').map(function() { return $(this).val(); }).get().join(','), 
                 dem_have: $(':checked[name="dem_have"]').map(function() { return $(this).val(); }).get().join(','), 
               pay_motive: $(':checked[name="pay_motive"]').map(function() { return $(this).val(); }).get().join(','), 
                 pay_time: $(':checked[name="pay_time"]').map(function() { return $(this).val(); }).get().join(','), 

                   is_buy: $(':checked[name="is_buy"]').val(),

                    media: $(':checked[name="media"]').map(function() { return $(this).val(); }).get().join(','), 

                  },
            success:function (json) {

                 
             
                $.each(json.search_array, function() {
              
                    
              });
            }
          });

     }



        /* ============================================== 分頁欄AJAX ====================================================== */
     function num_search(start,many) {
      
          $.ajax({
            url: 'from_all/search_sql.php',
            type: 'POST',
            dataType: 'json',
            data: {
                    type:'num_search',
                    record_id: '<?php echo $record_id;?>',
                    start_num: start,
                    many_num: many
                    
                  },
            success:function (json) {

                 $("#com_tb").html('');
             
                $.each(json.search_array, function() {
              
                   var info="<tr>";
                  info=info+"<td ><input type='checkbox' class='check_print' name='check_print' onclick='check_print()' value="+this['from_id']+"></td>"; //選取列印
                  info=info+"<td class='no_display768'>"+this['from_id']+"</td>"; //表單ID
                  info=info+"<td >"+this['set_time']+"</td>";                    //填表日期
                  info=info+"<td><?php echo $case_name;?></td>";                     //專案名稱
                  info=info+"<td>"+this['name']+"</td>";                                    //顧客姓名
                  info=info+"<td class='no_display768'>"+this['phone']+"</td>";          //行動電話
                  info=info+"<td><a href='from_all/from_print.php?from_id="+this['from_id']+"' target='_blank' ><i class='fa fa-print'></i>列印</a></td>";
                  info=info+"<td class='no_display768'><a href='from_edit.php?from_id="+this['from_id']+"'><i class='fa fa-edit'></i>編輯</a></td>";
                  info=info+"<td class='no_display768'><a class='del_from_"+this['from_id']+"' href='javascript:del_from(\""+this['from_id']+"\");'><i class='fa fa-ban'></i>刪除</a></td>";
                  info=info+"</tr>";

                    $("#com_tb").append(info);
                    
              });
            }
          });
         
     }


    /* ================================================= 資料筆數 ================================================ */
     function many_fun(type) {
     	
     	var info= '<label>資料筆數:</label>';
     	info=info+'<select id="many_num" name="many_num" onchange="'+type+'(\'0\');">';
     	info=info+'<option value="all">全部</option>';
     	info=info+'<option value="2">2</option>';
     	info=info+'<option value="4">4</option>';
     	info=info+'<option value="100">100</option>';
     	info=info+'<option value="200">200</option>';
     	info=info+'<option value="400">400</option>';
     	info=info+'</select>';

        $("#many_div").html(info);               
                               
     }


     function del_from(from_id) {
       
        if (confirm('確定要刪除??')) {
            location.href="from_all/from_sql.php?type=delete&from_id="+from_id;
        }
     }



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

            <!-- ================================================= 簡易查詢 ========================================= -->
            <div id="bs_div" class="col-lg-12 no_padding dis_none">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>基本查尋 </h5>
                           <div class="ibox-tools">
                           <button  type="button" class="btn btn-default" onclick="bs_search_con();">關閉查詢</button>
                        </div>
                        </div>
                        <div class="ibox-content">
                          <form method="POST" action="#" class="form-horizontal">
                            <div class="form-group">
                                   <label class="col-sm-2 control-label">顧客姓名：</label>
                                    <div class="col-sm-2">
                                       <input name="bs_name" type="text" class="form-control" value="">
                                    </div>
                                    <label class="col-sm-1 control-label">手機：</label>
                                    <div class="col-sm-2">
                                       <input name="bs_phone" type="text" class="form-control" value="">
                                    </div>
                                    <label class="col-sm-1 control-label">E-mail：</label>
                                    <div class="col-sm-2">
                                       <input name="email" type="text" class="form-control" value="">
                                    </div>
                                    <input id="buy_yes" type="radio" value="已購" name="bs_is_buy"> <label for="buy_yes">已購</label>　
                                    <input id="buy_no" type="radio" value="未購" name="bs_is_buy"> <label for="buy_no">未購</label>　
                                    <input id="buy" type="radio" value="" name="bs_is_buy"> <label for="buy">無</label>
                                </div>
                              <div class="form-group">
                                <label class="col-sm-10" ></label>
                                <button id="bs_search_btn" class="btn btn-primary" type="button">查詢</button>
                              </div>
                            </form>
                        </div>
                    </div>
                </div>


               <!-- =========================================== 進階查詢 =========================================== -->
                <div id="adv_div" class="col-lg-12 no_padding dis_none">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>進階查尋 </h5>
                           <div class="ibox-tools">
                          <button  type="button" class="btn btn-default" onclick="adv_search_con();">關閉查詢</button>
                        </div>
                        </div>
                        <div class="ibox-content">
                          <form method="POST" action="from_all/search_sql.php" class="form-horizontal">
                            <div class="form-group">
                                   <label class="col-sm-2 control-label">顧客姓名：</label>
                                    <div class="col-sm-2">
                                       <input name="name" type="text" class="form-control" value="">
                                    </div>
                                </div>
                            <div class="form-group">
                                   <label class="col-sm-2 control-label">填表日期：</label>
                                    <div class="col-sm-10">
                                       <input name="set_time_start" type="date" value="">至
                                       <input name="set_time_end" type="date"  value="">
                                    </div>
                                </div>
                            <div class="form-group">
                                   <label class="col-sm-2 control-label">手機：</label>
                                    <div class="col-sm-2">
                                       <input name="phone" type="text" class="form-control" value="">
                                    </div>
                                </div>
                            <div class="form-group">
                                   <label class="col-sm-2 control-label">地址：</label>
                                    <div class="col-sm-5">
                                      <div id="twzipcode" class="col-sm-12" ></div>
                                       <input name="adds" type="text" class="form-control" value="">
                                    </div>
                                </div>
                            <div class="form-group">
                                   <label class="col-sm-2 control-label">購屋預算：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_money1" name="dem_money" value="301~400萬"> <label for="dem_money1">301~400萬</label>　
                                       <input type="checkbox" id="dem_money2" name="dem_money" value="401~600萬"> <label for="dem_money2">401~600萬</label>　
                                       <input type="checkbox" id="dem_money3" name="dem_money" value="601~800萬"> <label for="dem_money3">601~800萬</label>　
                                       <input type="checkbox" id="dem_money4" name="dem_money" value="801~1200萬"> <label for="dem_money4">801~1200萬</label>　
                                       <input type="checkbox" id="dem_money5" name="dem_money" value="1201~2000萬"> <label for="dem_money5">1201~2000萬</label>　
                                       <input type="checkbox" id="dem_money6" name="dem_money" value="2001~3000萬"> <label for="dem_money6">2001~3000萬</label>　
                                       <input type="checkbox" id="dem_money7" name="dem_money" value="3001萬以上"> <label for="dem_money7">3001萬</label>　
                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">產品需求：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_product1" name="dem_product" value="大樓"> <label for="dem_product1">大樓</label>　
                                       <input type="checkbox" id="dem_product2" name="dem_product" value="透天"> <label for="dem_product2">透天</label>　
                                       <input type="checkbox" id="dem_product3" name="dem_product" value="套房"> <label for="dem_product3">套房</label>　
                                       <input type="checkbox" id="dem_product4" name="dem_product" value="店面"> <label for="dem_product4">店面</label>　
                                       <input type="checkbox" id="dem_product5" name="dem_product" value="辦公室"> <label for="dem_product5">辦公室</label>
                                      
                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">車位需求：</label>
                                    <div class="col-sm-10">
                                       <input type="radio" id="dem_car1" name="dem_car" value="n"> <label for="dem_car1">不需要</label>　
                                       <input type="radio" id="dem_car2" name="dem_car" value="y"> <label for="dem_car2">需要</label>
                                       <input type="text" name="dem_car_txt">位
                                      
                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">坪數需求：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_floor_num1" name="dem_floor_num" value="30坪以下"> <label for="dem_floor_num1">30坪以下</label>　
                                       <input type="checkbox" id="dem_floor_num2" name="dem_floor_num" value="31~40坪"> <label for="dem_floor_num2">31~40坪</label>　
                                       <input type="checkbox" id="dem_floor_num3" name="dem_floor_num" value="41~50坪"> <label for="dem_floor_num3">41~50坪</label>　
                                       <input type="checkbox" id="dem_floor_num4" name="dem_floor_num" value="51~70坪"> <label for="dem_floor_num4">51~70坪</label>　
                                       <input type="checkbox" id="dem_floor_num5" name="dem_floor_num" value="71~90坪"> <label for="dem_floor_num5">71~90坪</label>　
                                       <input type="checkbox" id="dem_floor_num6" name="dem_floor_num" value="91坪以上"> <label for="dem_floor_num6">91坪以上</label>
                                       
                                      
                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">樓層需求：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_floor1" name="dem_floor" value="低樓層"> <label for="dem_floor1">低樓層</label>　
                                       <input type="checkbox" id="dem_floor2" name="dem_floor" value="中樓層"> <label for="dem_floor2">中樓層</label>　
                                       <input type="checkbox" id="dem_floor3" name="dem_floor" value="高樓層"> <label for="dem_floor3">高樓層</label>
                                       
                                      
                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">希望月付款：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_mon_pay1" name="dem_mon_pay" value="20000以下"> <label for="dem_mon_pay1">20,000以下</label>　
                                       <input type="checkbox" id="dem_mon_pay2" name="dem_mon_pay" value="20001~27000"> <label for="dem_mon_pay2">20,001~27,000</label>　
                                       <input type="checkbox" id="dem_mon_pay3" name="dem_mon_pay" value="27001~35000"> <label for="dem_mon_pay3">27,001~35,000</label>　
                                       <input type="checkbox" id="dem_mon_pay4" name="dem_mon_pay" value="35001~42000"> <label for="dem_mon_pay4">35,001~42,000</label>　
                                       <input type="checkbox" id="dem_mon_pay5" name="dem_mon_pay" value="42001~50000"> <label for="dem_mon_pay5">42,001~50,000</label>　
                                       <input type="checkbox" id="dem_mon_pay6" name="dem_mon_pay" value="50001~60000"> <label for="dem_mon_pay6">50,001~60,000</label>　
                                       <input type="checkbox" id="dem_mon_pay7" name="dem_mon_pay" value="60001以上"> <label for="dem_mon_pay7">60,001以上</label>

                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">座向需求：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_side1" name="dem_side" value="東"> <label for="dem_side1">東</label>　
                                       <input type="checkbox" id="dem_side2" name="dem_side" value="南"> <label for="dem_side2">南</label>　
                                       <input type="checkbox" id="dem_side3" name="dem_side" value="西"> <label for="dem_side3">西</label>　
                                       <input type="checkbox" id="dem_side4" name="dem_side" value="北"> <label for="dem_side4">北</label>　
                                       
                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">自備款：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="dem_have1" name="dem_have" value="50萬以下"> <label for="dem_have1">50萬以下</label>　
                                       <input type="checkbox" id="dem_have2" name="dem_have" value="50~100萬"> <label for="dem_have2">50~100萬</label>　
                                       <input type="checkbox" id="dem_have3" name="dem_have" value="101~200萬"> <label for="dem_have3">101~200萬</label>　
                                       <input type="checkbox" id="dem_have4" name="dem_have" value="201~300萬"> <label for="dem_have4">201~300萬</label>　
                                       <input type="checkbox" id="dem_have5" name="dem_have" value="300萬以上"> <label for="dem_have5">300萬以上</label>　
                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">購屋動機：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="pay_motive1" name="pay_motive" value="交通因素"> <label for="pay_motive1">交通因素</label>　
                                       <input type="checkbox" id="pay_motive2" name="pay_motive" value="工作因素"> <label for="pay_motive2">工作因素</label>　
                                       <input type="checkbox" id="pay_motive3" name="pay_motive" value="環境因素"> <label for="pay_motive3">環境因素</label>　
                                       <input type="checkbox" id="pay_motive4" name="pay_motive" value="小換大"> <label for="pay_motive4">小換大</label>　
                                       <input type="checkbox" id="pay_motive5" name="pay_motive" value="新婚用"> <label for="pay_motive5">新婚用</label>　
                                       <input type="checkbox" id="pay_motive6" name="pay_motive" value="營業用"> <label for="pay_motive6">營業用</label>　
                                       <input type="checkbox" id="pay_motive7" name="pay_motive" value="舊換新"> <label for="pay_motive7">舊換新</label>

                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">欲購屋時間：</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" id="pay_time1" name="pay_time" value="立即購買"> <label for="pay_time1">立即購買</label>　
                                       <input type="checkbox" id="pay_time2" name="pay_time" value="半年之內"> <label for="pay_time2">半年之內</label>　
                                       <input type="checkbox" id="pay_time3" name="pay_time" value="半年~二年"> <label for="pay_time3">半年~二年</label>　
                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">已未購：</label>
                                    <div class="col-sm-10">
                                       <input type="radio" id="is_buy1" name="is_buy" value="已購"> <label for="is_buy1">已購</label>　
                                       <input type="radio" id="is_buy2" name="is_buy" value="未購"> <label for="is_buy2">未購</label>　
                                       <input type="radio" id="is_buy3" name="is_buy" value=""> <label for="is_buy3">無</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-sm-2 control-label">媒體：</label>
                                    <div class="col-sm-10">
                                      <input type="checkbox" id="media1" value="中時" name="media"><label for="media1">中時</label>　
                                       <input type="checkbox" id="media2" value="聯合" name="media"><label for="media2">聯合</label>　
                                       <input type="checkbox" id="media3" value="自由" name="media"><label for="media3">自由</label>　
                                       <input type="checkbox" id="media4" value="聯晚" name="media"><label for="media4">聯晚</label>　
                                       <input type="checkbox" id="media5" value="蘋果日報" name="media"><label for="media5">蘋果日報</label>　
                                       <input type="checkbox" id="media6" value="網路" name="media"><label for="media6">網路</label>　
                                       <input type="checkbox" id="media7" value="車箱" name="media"><label for="media7">車箱</label>　
                                       <input type="checkbox" id="media8" value="廣告" name="media"><label for="media8">廣告</label>　
                                       <input type="checkbox" id="media9" value="CF" name="media"><label for="media9">CF</label>　
                                       <input type="checkbox" id="media10" value="RD" name="media"><label for="media10">RD</label>　
                                       <input type="checkbox" id="media11" value="POP" name="media"><label for="media11">POP</label>　
                                       <input type="checkbox" id="media12" value="雜誌" name="media"><label for="media12">雜誌</label>　
                                       <input type="checkbox" id="media13" value="派報" name="media"><label for="media13">派報</label>　
                                       <input type="checkbox" id="media14" value="夾報" name="media"><label for="media14">夾報</label>　
                                       <input type="checkbox" id="media15" value="介紹" name="media"><label for="media15">介紹</label>　
                                       <input type="checkbox" id="media16" value="其他" name="media"><label for="media16">其他</label> <input type="text" class="new_text" name="media_txt">
                                    </div>
                                </div>

                               <hr>

                              <div class="form-group">
                                <label class="col-sm-10" ></label>
                                <button id="adv_search_btn" class="btn btn-primary" type="button">查詢</button>
                              </div>

                              <input type="hidden" name="type" value="adv_search"> <!-- 進階查詢 -->
                            </form>
                        </div>
                    </div>
                </div>


              <div class="col-lg-12 no_padding">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>顧客問卷資料表 </h5>
                           <div class="ibox-tools">

                           <form id="search_pr_from" method="POST" action="from_all/from_print.php" target="_blank" style="display:inline;">
                             <a id="search_print" class="dis_none" href="#"><i class='fa fa-print'></i>選取列印</a>
                             <input type="hidden" id="search_id" name="search_id">
                           </form>
                           
                           <a id="bs_search" href="#"><i class='fa fa-search'></i>簡易查詢</a>
                           <a id="adv_search" href="#"><i class='fa fa-search'></i>進階查詢</a>
                        </div>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                  <label for="all_check">全選</label><input id="all_check" type="checkbox" onclick="all_search('check_print')">

                                   <span id="many_div"></span> <!-- 資料筆數 -->
                               
                                    <th>選取列印</th>
                                    <th class="no_display768">表單ID</th>
                                    <th>填表日期</th>
                                    <th>專案名稱</th>
                                    <th>顧客姓名</th>
                                    <th class="no_display768">行動電話</th>
                                    <th>列印</th>
                                    <th class="no_display768">編輯</th>
                                    <th class="no_display768">刪除</th>
                                </tr>
                                </thead>
                                <tbody id="com_tb">
                                
                                </tbody>
                            </table>

                          <div id="num_bar">
                          	 <ul>
                          	 	<li><a href="#"><<</a></li>
                          	 	<li><a href="#">1</a></li>
                          	 	<li><a href="#">2</a></li>
                          	 	<li><a href="#">3</a></li>
                          	 	<li><a href="#">4</a></li>
                          	 	<li><a href="#">5</a></li>
                          	 	<li><a href="#">6</a></li>
                          	 	<li><a href="#">7</a></li>
                          	 	<li><a href="#">8</a></li>
                          	 	<li><a href="#">9</a></li>
                          	 	<li><a href="#">10</a></li>
                          	 	<li><a href="#">>></a></li>
                          	 </ul>
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
