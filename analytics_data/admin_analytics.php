<?php include 'shared_php/login_session.php';
      $case_id=htmlspecialchars($_GET['case_id']);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOOGLE分析</title>

    <!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>


        <style type="text/css">
      body{
        font-family: 微軟正黑體;
      }

     .p_txt{
        text-align: center;
        font-size: 40px;
     }
     .tootl_btn{
        color:#fff;
        background: #3C3C3C;
        padding: 5px;
     }
    .auth_lay{
      position: relative;
       color: #3C3C3C;
       padding: 7px;
       font-size: 15px;
     }
    .ex_txt{
      padding: 15px;
      font-size: 15px;
      background-color: rgb(247, 95, 95);
      color: #fff;
      border-radius: 7px 7px;
      text-align: center;
    }
 </style>
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
              <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>GOOGLE分析 </h5>
                           <div class="ibox-tools">
                         <!--<button id="getuser" type="button">test</button>-->

                        </div>
                        </div>
                        <div class="ibox-content ">
                           
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>今日瀏覽人數</h5>
                        </div>
                        <div class="ibox-content">
                           <p id="todays" class="p_txt"></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>一周瀏覽人數</h5>
                        </div>
                        <div class="ibox-content">
                            <p id="week" class="p_txt"></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>一個月瀏覽人數</h5>
                        </div>
                        <div class="ibox-content">
                            <p id="mouth" class="p_txt"></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>總瀏覽人數</h5>
                        </div>
                        <div class="ibox-content">
                            <p id="total" class="p_txt"></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>客層年齡</h5>
                           <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        </div>
                        <div class="ibox-content">
                          <div class="chart" id="chart-4-container"></div>
                        </div>
                    </div>
                </div>

                 <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>客層性別</h5>
                           <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        </div>
                        <div class="ibox-content">
                          <div class="chart" id="chart-5-container"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>使用裝置 </h5>
                           <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        </div>
                        <div class="ibox-content">
                          <div class="chart" id="chart-2-container"></div>
                           <div class="chart" id="chart-2_1-container"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>熱門按鈕點擊</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        </div>
                        <div class="ibox-content">
                            <div class="chart" id="chart-1-container"></div>
                           <div class="chart" id="chart-1_1-container"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>網頁停留時間</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        </div>
                        <div class="ibox-content">
                            <div class="chart" id="chart-7-container"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>流量來源</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        </div>
                        <div class="ibox-content">
                            <div class="chart" id="chart-6-container"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>地區</h5>
                           <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        </div>
                        <div class="ibox-content">
                          <div class="chart" id="chart-3-container"></div>
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
