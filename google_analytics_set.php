<?php

include 'shared_php/login_session.php';
include 'shared_php/config.php';

$sql_query="SELECT * FROM build_case LEFT JOIN google_analytics ON build_case.case_id=google_analytics.case_no ";
?>


<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>google 分析儲存</title>
    <!-- 外掛AND CSS -->
    <?php include 'shared_php/script_style.php';?>
    <!-- FooTable -->
    <link href="css/footable.core.css" rel="stylesheet">
        <style type="text/css">

      body{

        font-family: 微軟正黑體;
      }

      .ibox-tools a{
        color:#ECF5FF;
        background-color:#0080FF;
        padding: 5px;
        border-radius: 5px 5px;
       transition: box-shadow 0.25s;
      }

      .table >tbody>tr>td>a{
        color:#fff;
        background-color:#3DB8B8;
         padding: 3px;
         padding-left:10px;
         padding-right: 10px;
        border-radius: 5px 5px;
       transition: box-shadow 0.25s;
      }

      .table >tbody>tr>td>a:hover,.ibox-tools a:hover{
         box-shadow: 0px 2px 4px #7B7B7B;
      }

      #sel_user_div{
        float: left;
      margin-left: 30px;
      font-size: 12px;
      }
      #loading{
        display: none;
      width: 70px;
      position: absolute;
      left: 45%;
      top: 150px;
      }
    </style>

        <!-- FooTable -->
    <script src="js/footable.all.min.js"></script>
    <script>
    $(document).ready(function() {
      
      $("#admin_ga").addClass('active');
         $('.footable').footable();

/* ========================================= 全部更新 ================================================== */
      $("#set_all").click(function(event) {
        event.preventDefault();
        $("#loading").css('display', 'block');
         <?php 
           $re_set_all=db_conn($sql_query);
           $i=0;
           while ($row=mysql_fetch_array($re_set_all)) {
            
            if (!empty($row['google_view_code'])) {
                 $i+=500;
               echo 'var t'.$i.'=setTimeout("get_analytics(\''.$row['google_view_code'].'\', \''.$row['case_id'].'\')",'.$i.');';
                 $i+=1000;
               echo 'var t'.$i.'_1=setTimeout("ajax_analytics()",'.$i.');';
                 $i+=500;
               echo 'var t'.$i.'_2=setTimeout(\'$("input:hidden").val("")\','.$i.');';
            }
           } 
            $i+=500;
           echo 'var t'.$i.'=setTimeout("location_web(\'google_analytics_set.php\',\'全部更新完成\')",'.$i.');';
           echo 'var t'.$i.'=setTimeout("$(\'#loading\').css(\'display\', \'none\')",'.$i.');';
         ?>
         //alert("全部更新!!");
      });

    });

    // Replace with your client ID from the developer console.
    var CLIENT_ID = '385992667841-sh8hl37nh4j4fuc63n3dunml65t1hs0s.apps.googleusercontent.com';

    // Set authorized scope.
    var SCOPES = ['https://www.googleapis.com/auth/analytics.readonly'];

    //身分驗證
    function authorize(event) {
        // Handles the authorization flow.
        // `immediate` should be false when invoked from the button click.
        var useImmdiate = event ? false : true;
        var authData = {
            client_id: CLIENT_ID,
            scope: SCOPES,
            immediate: useImmdiate
        };
        gapi.auth.authorize(authData, function(response) {
            var authButton = document.getElementById('auth-button');
            if (response.error) {
                authButton.hidden = false;
            } else {
                authButton.hidden = true;
                queryAccounts();
            }
        });
    }

   //選擇分析版本
    function queryAccounts() {
        // Load the Google Analytics client library.
        gapi.client.load('analytics', 'v3').then(function() {
            // Get a list of all Google Analytics accounts for this user
        });
    }


//=============================================抓取分析資料=================================
    function queryCoreReportingApi(ids, start, end, metrics, dimensions, put_name, put_num) {

        if (dimensions=="null") {
            gapi.client.analytics.data.ga.get({
                'ids': 'ga:' + ids,
                'start-date':start ,
                'end-date':end ,
                'metrics':metrics
            })
            .then(function(response) {
                var data_src = response.result['rows'];
                $(put_num).attr('value', data_src[0][0]);
               // console.log(data_src);
            })
            .then(null, function(err) {
                // Log any errors.
                console.log(err);
            });
        }

        else{
            gapi.client.analytics.data.ga.get({
                'ids': 'ga:' + ids,
                'start-date':start ,
                'end-date':end ,
                'metrics':metrics ,
                'dimensions':dimensions 
            })
            .then(function(response) {
                var data_src = response.result['rows'];
                var data_name="";
                var data_num="";

                  for (var i = 0; i < data_src.length; i++) {

                     data_name=data_name+data_src[i][0]+",";
                     data_num=data_num+data_src[i][1]+",";
                  }
                 $(put_name).attr('value', data_name);
                  $(put_num).attr('value', data_num);
               // console.log(data_src);
            })
            .then(null, function(err) {
                // Log any errors.
                //console.log(err);
            });
        }
      }


//==================================== AJAX送出資料 ===========================================
     function ajax_analytics() {
       
       $.ajax({
         url: 'analytics_data/google_sql.php',
         type: 'POST',
         data: {
                      case_no: $("#case_no").val(),
                  report_week: $("#report_week").val(),
                 report_month: $("#report_month").val(),
                 report_total: $("#report_total").val(),

                   event_name: $("#event_name").val(),
                    event_num: $("#event_num").val(),

                  device_name: $("#device_name").val(),
                   device_num: $("#device_num").val(),

                    city_name: $("#city_name").val(),
                     city_num: $("#city_num").val(),

                   years_zone: $("#years_zone").val(),
                     year_num: $("#year_num").val(),

                     sex_name: $("#sex_name").val(),
                      sex_num: $("#sex_num").val(),

                     src_name: $("#src_name").val(),
                      src_num: $("#src_num").val(),

                    user_date: $("#user_date").val(),
                     user_num: $("#user_num").val(),
               }
       });
     }


/* ========================================= 送出更新資料 ============================================== */
      function get_analytics(ids, case_id, sub_yn) {
        
        $("#case_no").val(case_id);

         // ============================ 熱門點擊 ====================================
  queryCoreReportingApi(ids, '30daysAgo', 'today', 'ga:uniqueEvents', 'ga:eventCategory', '#event_name', '#event_num');
             
          // ============================ 連線裝置 ====================================
  queryCoreReportingApi(ids, '30daysAgo', 'today', 'ga:sessions', 'ga:deviceCategory', '#device_name', '#device_num');

          // ============================ 地區瀏覽 ====================================
  queryCoreReportingApi(ids, '30daysAgo', 'today', 'ga:sessions', 'ga:city', '#city_name', '#city_num');

          // ============================ 年齡 ====================================
  queryCoreReportingApi(ids, '30daysAgo', 'today', 'ga:sessions', 'ga:userAgeBracket', '#years_zone', '#year_num');


          // ============================ 性別 ====================================
             queryCoreReportingApi(ids, '30daysAgo', 'today', 'ga:sessions', 'ga:userGender', '#sex_name', '#sex_num');


          // ============================ 流量 ====================================
             queryCoreReportingApi(ids, '30daysAgo', 'today', 'ga:sessions', 'ga:sourceMedium', '#src_name', '#src_num');


          // ============================ 網頁停留時間 ====================================
             //queryCoreReportingApi(ids, '30daysAgo', 'today', 'ga:avgSessionDuration', 'ga:date');


          // ============================ 每日瀏覽人數 ====================================
             queryCoreReportingApi(ids, '30daysAgo', 'today', 'ga:sessions', 'ga:date', '#user_date', '#user_num');


         // ============================ 每月覽人數 ====================================
             queryCoreReportingApi(ids, '30daysAgo', 'today', 'ga:sessions', 'null', 'null', '#report_month');


         // ============================ 總瀏覽人數 ====================================
             queryCoreReportingApi(ids, '2016-04-01', 'today', 'ga:sessions', 'null', 'null', '#report_total');


         // ============================ 每週覽人數 ====================================
             queryCoreReportingApi(ids, '7daysAgo', 'today', 'ga:sessions', 'null', 'null', '#report_week');

             
         // ============================ 每日瀏覽人數 ====================================
             //queryCoreReportingApi('119826159', 'today', 'today', 'ga:users', 'null');
             
             if (sub_yn==1) {
                 $("#loading").css('display', 'block');
                var t=setTimeout('$("#analytics_form").submit()',1000); //更新
             }
      }

 // ============================== 跳轉網頁 ==================================== 
      function location_web(url,txt) {
       
          alert(txt);
          location.replace(url);
      }    

    </script>

    <style type="text/css">

    .box {
       width:45%;
        float: left;
        background-color: rgb(215, 215, 234);
        box-shadow: 5px 5px 7px rgb(80, 80, 80);
        padding: 10px;
        padding-bottom: 15px;
        margin: 5px;

    }
    .map_box{
        width:60%;
         float: left;
         box-shadow: 3px 3px 12px rgb(80, 80, 80);
          padding: 10px;
         margin: 10px;
    }

    .view {
        padding: 15px;
    }

    .view table{
        float: left;
    }

    .cl_img{
       border-radius: 20px 20px;
    }

    </style>
</head>

<body>

<div id="wrapper">

   <!-- ============================== 導航欄位 =================================== -->
    <?php include 'shared_php/navbar-admin.php';?>

    <div id="page-wrapper" class="gray-bg">

        <!-- ============================== TOP欄位 =================================== -->
        <?php include 'shared_php/top_bar.php';?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                                <div class="col-lg-12 no_padding">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>GOOGLE 分析儲存</h5>

                            <div class="ibox-tools">
                              <span class="no_display768">(點擊全部更新)</span>
                                <a id="set_all" href="#" >
                                <i class="fa fa-plus-square "> 全部更新</i>
                            </a>

                            </div>
                        </div>
                        <div class="ibox-content">
                          <img id="loading" src="img/ajax-loader.gif">
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                                <thead>
                                <tr>
                                    <th class="no_display768" data-toggle="true">建案ID</th>
                                    <th>建案名稱</th>
                                    <th>更新日期</th>
                                    <th>更新</th>

                                </tr>
                                </thead>
                                <tbody id="all_project">
                                    
<?php

$result=db_conn($sql_query);
while ($row=mysql_fetch_array($result)) {
  
  $contant='<tr >';
 $contant.='<td class="no_display768">'.$row['case_id'].'</td>';
 $contant.='<td>'.$row['case_name'].'</td>';
 $contant.='<td>'.$row['set_time'].'</td>';

  if (empty($row['google_view_code'])) {
    
   $contant.='<td>(無檢視編號)</td>';
  }
  else{

  $contant.='<td><a href="#" onclick="get_analytics(\''.$row['google_view_code'].'\', \''.$row['case_id'].'\', 1)"  >更新</a></td>';
  }
 
 $contant.='</tr>';

 echo $contant;


}

?>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                        
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                            <div id="update_btn"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================== footer =================================== -->
        <?php include 'shared_php/footer.php';?>
    </div>
</div>

    <button id="auth-button"  hidden>Authorize</button>
   <div id="apphtml">
    <div id="embed-api-auth-container" style="display: none"></div>
    <div class="view" id="view-selector-1-container"></div>
    <form id="analytics_form" action="analytics_data/google_sql.php" method="POST">


       <input type="hidden" id="case_no" name="case_no" value=""> 

            
       <input type="hidden" id="report_week" name="report_week">
       <input type="hidden" id="report_month" name="report_month">
       <input type="hidden" id="report_total" name="report_total">


       <input type="hidden" id="event_name" name="event_name">
       <input type="hidden" id="event_num" name="event_num">


       <input type="hidden" id="device_name" name="device_name">
       <input type="hidden" id="device_num" name="device_num">


       <input type="hidden" id="city_name" name="city_name">
       <input type="hidden" id="city_num" name="city_num">


       <input type="hidden" id="years_zone" name="years_zone">
       <input type="hidden" id="year_num" name="year_num">


       <input type="hidden" id="sex_name" name="sex_name">
       <input type="hidden" id="sex_num" name="sex_num">


       <input type="hidden" id="src_name" name="src_name">
       <input type="hidden" id="src_num" name="src_num">


       <input type="hidden" id="user_date" name="user_date">
       <input type="hidden" id="user_num" name="user_num">


    </form>

   </div>

<!-- ========================================= core Report庫 ====================================================== -->

    <script src="https://apis.google.com/js/client.js?onload=authorize"></script>

</body>



</html>

