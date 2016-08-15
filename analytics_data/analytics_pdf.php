<?php
  require_once '../shared_php/login_session.php';
  require_once '../shared_php/config.php';

  require_once '../tcpdf/tcpdf.php';

  $case_id=addslashes($_GET['case_id']);
  $case_name=addslashes($_GET['case_name']);

  $pdo=pdo_conn(); //開啟資料庫
  $sql_q=$pdo->prepare("SELECT * FROM google_analytics WHERE case_no=:case_id");
  $sql_q->bindparam(':case_id',$case_id);
  $sql_q->execute();
  while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
  	
  	 $week_user=$row['week_user'];
      // $month_user=$row['month_user'];
       $total_user=$row['total_user'];

       $male=$row['male'];
       $female=$row['female'];

       $years_zone=explode(',', $row['years_zone']);
       $year_num=explode(',', $row['year_num']);

       $desktop=$row['desktop'];
       $mobile=$row['mobile'];
       $tablet=$row['tablet'];

       $event_name=explode(',', $row['event_name']);
       $event_num=explode(',', $row['event_num']);

       $src_name=explode(',', $row['src_name']);
       $src_num=explode(',', $row['src_num']);

       $user_date=explode(',', $row['user_date']);
       $user_num=explode(',', $row['user_num']);

       $new_month_user=0;
       for ($i=0; $i <count($user_num) ; $i++) { 
         
         $new_month_user+=$user_num[$i];
       }

       $city_name=explode(',', $row['city_name']);
       $city_num=explode(',', $row['city_num']);
  }

/*  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false); //不要頁首
$pdf->setPrintFooter(false); //不要頁尾
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);  //設定自動分頁

$pdf->setFontSubsetting(true); //產生字型子集（有用到的字才放到文件中）
$pdf->SetFont('mingliu', '', 12, '', true); //設定字型 新細明體
$pdf->AddPage(); //新增頁面

$html='<h1>你好嗎??</h1>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('contact.pdf', 'I');*/
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title></title>

	<!-- ================================== 外掛and CSS ====================================== -->
    <?php include '../shared_php/script_style.php';?>
    
    <!-- d3 and c3 charts -->
    <link rel="stylesheet" type="text/css" href="../css/plugins/c3/c3.min.css">
    <script type="text/javascript" src="../js/plugins/c3/c3.min.js"></script>
    <script type="text/javascript" src="../js/plugins/c3/d3.min.js"></script>

    <!-- GOOGLE Chart  -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
   
    <script type="text/javascript">
   $(document).ready(function() {
     
     //使用者性別
      c3.generate({
                bindto: '#sex',
                data:{
                    columns: [
                        ['男性', <?php echo $male?>],
                        ['女性', <?php echo $female?>]
                    ],

                    type : 'pie'
                },
                pie: {
                label: {
                          format: function (value, ratio, id) {
                          return value+"人";
                         }
                       }
                  }
            });
      
      //使用者年齡
      c3.generate({
                bindto: '#old',
                data:{
                   x:'x',
                    columns: [

                      <?php 
                       
                       $zone_txt="['x',";
                       $num_txt="['使用人數',";

                      for ($i=0; $i < count($years_zone)-1 ; $i++) { 
         
                            $zone_txt.="'".$years_zone[$i]."歲',";
                            $num_txt.= $year_num[$i].",";
                         }
                         $zone_txt.="],";
                         $num_txt.= "],";
                        echo $zone_txt;
                        echo $num_txt;

                      ?>
                     
                    ],
                    colors:{
                        使用人數: '#1ab394',
                    },
                    type: 'bar',
                    labels: true
                },
           axis:{
                   x:{
                     type:'category'
                   }
                }
            });

       //使用媒體
      c3.generate({
                bindto: '#media',
                data:{
                   x:'x',
                    columns: [
                        ['x', '桌機', '手機','平板'],
                        ['使用人數', <?php echo $desktop.",".$mobile.",".$tablet;?>],
                    ],
                    colors:{
                        使用人數: '#1ab394',
                    },
                    type: 'bar',
                    labels: true
                },
                axis:{
                   x:{
                     type:'category'
                   }
                }
            });

      //使用功能鈕
      c3.generate({
                bindto: '#tool_btn',
                data:{
                    columns: [

                    <?php 
                      
                      for ($i=0; $i <count($event_name)-1 ; $i++) { 
                        
                        $name=$event_name[$i];
                        $num=$event_num[$i];
                        echo "['".$name."', ".$num."],";
                      }

                    ?>
                    
                    ],
                    type : 'pie'
                },
                pie: {
                label: {
                          format: function (value, ratio, id) {
                          return value+"人";
                         }
                       }
                  }
            });

      //流量來源
      c3.generate({
                bindto: '#src_num',
                data:{
                    columns: [

                         
                     <?php 
                      
                      for ($i=0; $i <count($src_name)-1 ; $i++) { 
                        
                        $name=$src_name[$i];
                        $num=$src_num[$i];
                        echo "['".$name."', ".$num."],";
                      }

                    ?>
                        
                    ],
                    type : 'pie'
                },
                pie: {
                label: {
                          format: function (value, ratio, id) {
                          return value+"人";
                         }
                       }
                  }
            });
      
      //每日使用人數
      c3.generate({
                bindto: '#date_use',
                data:{
                   x:'x',
                   xFormat: '%Y%m%d',
                    columns: [

                    <?php 
                       
                       $date_txt="['x',";
                       $num_txt="['使用人數',";

                      for ($i=0; $i < count($user_date)-1 ; $i++) { 
         
                            $date_txt.="'".$user_date[$i]."',";
                            $num_txt.= $user_num[$i].",";
                         }
                         $date_txt.="],";
                         $num_txt.= "],";
                        echo $date_txt;
                        echo $num_txt;

                      ?>
                       
                    ],
                    colors:{
                        data1: '#1ab394',
                        
                    },
                    type: 'line',
                },
                axis:{
                   x:{
                     type:'timeseries',
                      tick:{
                          
                          count:4,
                          format: '%m-%d'
                      }
                   }
                }
            });

   });

        

google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '地名');
        data.addColumn('number', '人數');
        
        data.addRows([

        <?php 
          for ($i=0; $i <count($city_name)-1 ; $i++) { 

            if ($city_num[$i]>5) {
              echo "['".$city_name[$i]."',    ".$city_num[$i]." ],";
            }
          }

        ?>

        ]);

        var table = new google.visualization.Table(document.getElementById('chart_div'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      }
 </script>

</head>
<body>
	
  <div id="wrapper">

     <!-- ============================== 導航欄位 =================================== -->
    <?php include '../shared_php/navbar-default.php';?>

    <div id="page-wrapper" class="gray-bg">

    <!-- ============================== TOP欄位+ =================================== -->
        <?php include '../shared_php/top_bar.php';?>


        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>分析結果 </h5>
                           <div class="ibox-tools">
                         <!--<button id="getuser" type="button">test</button>-->

                        </div>
                        </div>
                        <div class="ibox-content ">
                          <h2><?php echo $case_name?>-分析</h2>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>一周瀏覽人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                            <p id="week" class="p_txt"><?php echo $week_user?>人</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>一個月瀏覽人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                            <p id="mouth" class="p_txt"><?php echo $new_month_user?>人</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>總瀏覽人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                            <p id="total" class="p_txt"><?php echo $total_user?>人</p>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>使用者性別</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="sex"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>使用者年齡</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="old"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>使用的媒體</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="media"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>使用的功能鈕</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="tool_btn"></div>
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>流量來源</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="src_num"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>地區使用人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="chart_div"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>每日使用人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="date_use"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- ============================== footer =================================== -->
        <?php include '../shared_php/footer.php';?>

    </div>
</div>

</body>
</html>