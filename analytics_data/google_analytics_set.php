<?php

include 'shared_php/login_session.php';
include 'shared_php/config.php';

$case_id=htmlspecialchars($_GET['case_id']);

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

    <script type="text/javascript" src="js/jquery-2.1.1.js"></script>
        <!-- FooTable -->
    <script src="js/footable.all.min.js"></script>
    <script>
    $(document).ready(function() {
      
      $("#admin_project").addClass('active');
         $('.footable').footable();
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
  $("#sel_case").change(function(event) {
      var sel_case=$(":selected").val();

         // ============================ 熱門點擊 ====================================
  queryCoreReportingApi(sel_case, '360daysAgo', 'today', 'ga:totalEvents', 'ga:eventCategory', '#event_name', '#event_num');

             
          // ============================ 連線裝置 ====================================
  queryCoreReportingApi(sel_case, '360daysAgo', 'today', 'ga:sessions', 'ga:deviceCategory', '#device_name', '#device_num');

          // ============================ 地區瀏覽 ====================================
  queryCoreReportingApi(sel_case, '360daysAgo', 'today', 'ga:sessions', 'ga:city', '#city_name', '#city_num');

          // ============================ 年齡 ====================================
  queryCoreReportingApi(sel_case, '360daysAgo', 'today', 'ga:sessions', 'ga:userAgeBracket', '#years_zone', '#year_num');


          // ============================ 性別 ====================================
             queryCoreReportingApi(sel_case, '360daysAgo', 'today', 'ga:sessions', 'ga:userGender', '#sex_name', '#sex_num');


          // ============================ 流量 ====================================
             queryCoreReportingApi(sel_case, '360daysAgo', 'today', 'ga:sessions', 'ga:sourceMedium', '#src_name', '#src_num');


          // ============================ 網頁停留時間 ====================================
             //queryCoreReportingApi(sel_case, '30daysAgo', 'today', 'ga:avgSessionDuration', 'ga:date');


          // ============================ 每日瀏覽人數 ====================================
             queryCoreReportingApi(sel_case, '30daysAgo', 'today', 'ga:sessions', 'ga:date', '#user_date', '#user_num');


         // ============================ 每月覽人數 ====================================
             queryCoreReportingApi(sel_case, '30daysAgo', 'today', 'ga:sessions', 'null', 'null', '#report_month');


         // ============================ 總瀏覽人數 ====================================
             queryCoreReportingApi(sel_case, '2016-04-01', 'today', 'ga:sessions', 'null', 'null', '#report_total');


         // ============================ 每週覽人數 ====================================
             queryCoreReportingApi(sel_case, '7daysAgo', 'today', 'ga:sessions', 'null', 'null', '#report_week');

             
         // ============================ 每日瀏覽人數 ====================================
             //queryCoreReportingApi('119826159', 'today', 'today', 'ga:users', 'null');

  });

        });
    }


    //抓取分析資料
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
                console.log(err);
            });
        }
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
    <?php include 'shared_php/navbar-default.php';?>

    <div id="page-wrapper" class="gray-bg">

        <!-- ============================== TOP欄位 =================================== -->
        <?php include 'shared_php/top_bar.php';?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>GOOGLE 分析儲存</h5>

                            <div class="ibox-tools">
                              <span>(點擊全部更新)</span>
                                <a href="edit_project.php?NewOrEdit=new" >
                                <i class="fa fa-plus-square"> 全部更新</i>
                            </a>

                            </div>
                        </div>
                        <div class="ibox-content">

                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                                <thead>
                                <tr>
                                    <th class="pro_case_id" data-toggle="true">建案ID</th>
                                    <th>建案名稱</th>
                                    <th>更新日期</th>
                                    <th>更新</th>

                                </tr>
                                </thead>
                                <tbody id="all_project">
                                    
<?php

$sql_query="SELECT * FROM build_case LEFT JOIN google_analytics ON build_case.case_id=google_analytics.case_id "
$result=db_conn($sql_query);
while ($row=mysql_fetch_array($result)) {
  
  $contant='<tr>';
 $contant.='<td>'.$row['case_id'].'</td>';
 $contant.='<td>'.$row['case_name'].'</td>';
 $contant.='<td>'.$row['set_time'].'</td>';
 $contant.='<td><a href="">更新</a></td>';
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

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================== footer =================================== -->
        <?php include 'shared_php/footer.php';?>
    </div>
</div>

    <button id="auth-button" hidden>Authorize</button>
   <div id="apphtml">
    <div id="embed-api-auth-container" style="display: none"></div>
    <div class="view" id="view-selector-1-container"></div>
    <form action="analytics_data/google_sql.php" method="POST">
    <select id="sel_case">
      <option value="119826159">星晴天</option>
      <option value="121100605">早安藝文</option>
    </select>

       <button type="submit">傳送</button>

       <input type="hidden" id="case_id" name="case_id" value="<?php echo $case_id;?>"> 

            
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

