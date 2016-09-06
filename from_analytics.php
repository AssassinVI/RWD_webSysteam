<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

      $case_id=addslashes($_GET['case_id']);
      $case_name=addslashes($_GET['case_name']);
      $record_id=addslashes($_GET['record_id']);

      $pdo=pdo_conn();

      //-- 今天人數 --
      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND set_time=CURDATE()");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $today=$sql_q->fetch();


      //-- 一周人數 --
      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND set_time=DATE_SUB(CURDATE( ), INTERVAL 7 DAY )");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $week=$sql_q->fetch();


      //-- 一月人數 --
      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND set_time=DATE_SUB(CURDATE( ), INTERVAL 1 MONTH )");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $month=$sql_q->fetch();


       //-- 總人數 --
      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $all=$sql_q->fetch();


      //-- 性別 --
      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND gender='m' ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $male=$sql_q->fetch();

      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND gender='f' ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $female=$sql_q->fetch();


      //-- 年齡 --
      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND cust_old BETWEEN 20 AND 30 ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $y20_30=$sql_q->fetch();

      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND cust_old BETWEEN 31 AND 40 ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $y30_40=$sql_q->fetch();

      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND cust_old BETWEEN 41 AND 50 ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $y40_50=$sql_q->fetch();

      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND cust_old BETWEEN 51 AND 60 ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $y50_60=$sql_q->fetch();

      $sql_q=$pdo->prepare("SELECT COUNT(*) FROM from_question WHERE record_id=:record_id AND cust_old>60 ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $y60=$sql_q->fetch();


      //-- 月收入 --
      $sql_q=$pdo->prepare("SELECT mon_income FROM from_question WHERE record_id=:record_id ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      $mon_3_5=0; $mon_5_8=0; $mon_8_12=0; $mon_12_20=0; $mon_20=0;
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {

         switch ($row['mon_income']) {
           case '3萬~5萬':
              $mon_3_5++;
             break;
           case '5萬~8萬':
              $mon_5_8++;
             break;
           case '8萬~12萬':
             $mon_8_12++;
             break;
           case '12萬~20萬':
             $mon_12_20++;
             break;
           case '20萬以上':
             $mon_20++;
             break;
         }
      }


      //-- 媒體 --
      $sql_q=$pdo->prepare("SELECT media FROM from_question WHERE record_id=:record_id ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();

      $media1=0; $media2=0; $media3=0; $media4=0; $media5=0; $media6=0; $media7=0; $media8=0; 
      $media9=0; $media10=0; $media11=0; $media12=0; $media13=0; $media14=0; $media15=0; $media16=0; 
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
        
         $media=explode(',', $row['media']);
         for ($i=0; $i <count($media) ; $i++) { 
           
           switch ($media[$i]) {
             case '中時':
               $media1++;
               break;
               case '聯合':
               $media2++;
               break;
               case '自由':
               $media3++;
               break;
               case '聯晚':
               $media4++;
               break;
               case '蘋果日報':
               $media5++;
               break;
               case '網路':
               $media6++;
               break;
               case '車箱':
               $media7++;
               break;
               case '廣告':
               $media8++;
               break;
               case 'CF':
               $media9++;
               break;
               case 'RD':
               $media10++;
               break;
               case 'POP':
               $media11++;
               break;
               case '雜誌':
               $media2++;
               break;
               case '派報':
               $media13++;
               break;
               case '夾報':
               $media14++;
               break;
               case '介紹':
               $media15++;
               break;
               case '其他':
               $media16++;
               break;
             
           }
         }
      }


      //-- 產品需求 --
      $sql_q=$pdo->prepare("SELECT dem_product FROM from_question WHERE record_id=:record_id ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();

      $dem_product1=0; $dem_product2=0; $dem_product3=0; $dem_product4=0; $dem_product5=0; $dem_product6=0;
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
       
        $dem_product=explode(',', $row['dem_product']);
        for ($i=0; $i <count($dem_product) ; $i++) { 

          switch ($dem_product[$i]) {
            case '大樓':
              $dem_product1++;
              break;
            case '透天':
              $dem_product2++;
              break;
              case '套房':
              $dem_product3++;
              break;
              case '店面':
              $dem_product4++;
              break;
              case '辦公室':
              $dem_product5++;
              break;
              case '其他':
              $dem_product6++;
              break;
          }
        }
      }


     //-- 坪數需求 --
      $sql_q=$pdo->prepare("SELECT dem_floor_num FROM from_question WHERE record_id=:record_id ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();

      $dem_floor_num1=0; $dem_floor_num2=0; $dem_floor_num3=0; $dem_floor_num4=0; $dem_floor_num5=0; $dem_floor_num6=0;
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
       
        $dem_floor_num=explode(',', $row['dem_floor_num']);
        for ($i=0; $i <count($dem_floor_num) ; $i++) { 

          switch ($dem_floor_num[$i]) {
            case '30坪以下':
              $dem_floor_num1++;
              break;
            case '31~40坪':
              $dem_floor_num2++;
              break;
              case '41~50坪':
              $dem_floor_num3++;
              break;
              case '51~70坪':
              $dem_floor_num4++;
              break;
              case '71~90坪':
              $dem_floor_num5++;
              break;
              case '91坪以上':
              $dem_floor_num6++;
              break;
          }
        }
      }



     //-- 購屋預算 --
      $sql_q=$pdo->prepare("SELECT dem_money FROM from_question WHERE record_id=:record_id ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();

      $dem_money1=0; $dem_money2=0; $dem_money3=0; $dem_money4=0; $dem_money5=0; $dem_money6=0; $dem_money7=0;
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
       
        $dem_money=explode(',', $row['dem_money']);
        for ($i=0; $i <count($dem_money) ; $i++) { 

          switch ($dem_money[$i]) {
            case '301~400萬':
              $dem_money1++;
              break;
            case '401~600萬':
              $dem_money2++;
              break;
              case '601~800萬':
              $dem_money3++;
              break;
              case '801~1200萬':
              $dem_money4++;
              break;
              case '1201~2000萬':
              $dem_money5++;
              break;
              case '2001~3000萬':
              $dem_money6++;
              break;
              case '3001萬以上':
              $dem_money7++;
              break;
          }
        }
      }



      //-- 購屋動機 --
      $sql_q=$pdo->prepare("SELECT pay_motive FROM from_question WHERE record_id=:record_id ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();

      $pay_motive1=0; $pay_motive2=0; $pay_motive3=0; $pay_motive4=0; $pay_motive5=0; $pay_motive6=0; $pay_motive7=0;
      $pay_motive8=0; $pay_motive9=0;
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
       
        $pay_motive=explode(',', $row['pay_motive']);
        for ($i=0; $i <count($pay_motive) ; $i++) { 

          switch ($pay_motive[$i]) {
            case '交通因素':
              $pay_motive1++;
              break;
            case '工作因素':
              $pay_motive2++;
              break;
              case '環境因素':
              $pay_motive3++;
              break;
              case '投資置產':
              $pay_motive4++;
              break;
              case '小換大':
              $pay_motive5++;
              break;
              case '新婚用':
              $pay_motive6++;
              break;
              case '營業用':
              $pay_motive7++;
              break;
              case '舊換新':
              $pay_motive8++;
              break;
              case '其他':
              $pay_motive9++;
              break;
          }
        }
      }



      //-- 格局需求 --
      $sql_q=$pdo->prepare("SELECT dem_pattern FROM from_question WHERE record_id=:record_id ");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();

      $dem_pattern1=0; $dem_pattern2=0; $dem_pattern3=0; $dem_pattern4=0; $dem_pattern5=0; 
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
       
        $dem_pattern=explode(',', $row['dem_pattern']);
        for ($i=0; $i <count($dem_pattern) ; $i++) { 

          switch ($dem_pattern[$i]) {
            case '1':
              $dem_pattern1++;
              break;
            case '2':
              $dem_pattern2++;
              break;
              case '3':
              $dem_pattern3++;
              break;
              case '4':
              $dem_pattern4++;
              break;
              case '5':
              $dem_pattern5++;
              break;
          }
        }
      }


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>專案分析</title>

    <!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>
    
    <!-- d3 and c3 charts -->
    <link rel="stylesheet" type="text/css" href="css/plugins/c3/c3.min.css">
    <script type="text/javascript" src="js/plugins/c3/c3.min.js"></script>
    <script type="text/javascript" src="js/plugins/c3/d3.min.js"></script>

    <!-- GOOGLE Chart  -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    

        <style type="text/css">
      body{
        font-family: Microsoft JhengHei;
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
    .c3 svg{ font: 15px Microsoft JhengHei;  }
    .c3-legend-item{ font-size: 16px; }
    .ibox-title h5{ font-size: 18px; }

    #print_web{ color: #1ab394; font-size: 16px; padding: 7px; }

    .cp_btn{ background: #1bbb9b; padding: 5px 15px; border-radius: 4px; color: #fff; font-size: 17px; }

    #def_btn{ background: #c1c1c1; box-shadow: 1px 3px 3px rgba(33, 33, 33, 0.5); }
    #def_btn:hover{ box-shadow: 0px 0px 0px rgba(33, 33, 33, 0.5); color: #fff;}
    #com_tb, #title_tb{ font-size: 18px; }

    @media only screen and (max-width:1024px) {
       #print_web{ display: none; }
    }
    @media only screen and (max-width:420px){ 
       .ph_none{ display: none; }
       tspan{ font-size: 10px; }
     }
    
 </style>

 <script type="text/javascript">
   $(document).ready(function() {
     
     //使用者性別
      c3.generate({
                bindto: '#sex',
                data:{
                    columns: [
                        ['男性', <?php echo $male[0]?>],
                        ['女性', <?php echo $female[0]?>]
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
                         ['x', '20~30歲', '31~40歲', '41~50歲', '51~60歲', '60歲以上'],
                         
                      <?php 
                       
                       echo "['使用人數', ".$y20_30[0].", ".$y30_40[0].", ".$y40_50[0].", ".$y50_60[0].", ".$y60[0]."],";

                      ?>
                        //['x', '10~20歲', '20~30歲','30~40歲', '40~50歲', '50~60歲', '60~70歲'],
                        //['使用人數', 30,200,100,400,150,250],
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

       //月收入
      c3.generate({
                bindto: '#income',
                data:{
                   x:'x',
                    columns: [
                        ['x', '3萬~5萬', '5萬~8萬','8萬~12萬', '12萬~20萬', '20萬以上'],
                        ['人數', <?php echo $mon_3_5.",".$mon_5_8.",".$mon_8_12.",".$mon_12_20.",".$mon_20;?>],
                    ],
                    colors:{
                        人數: '#1ab394',
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

      //媒體
      c3.generate({
                bindto: '#media',
                data:{
                    columns: [

                         ['中時', <?php echo $media1;?>],
                         ['聯合', <?php echo $media2;?>],
                         ['自由', <?php echo $media3;?>],
                         ['聯晚', <?php echo $media4;?>],
                         ['蘋果日報', <?php echo $media5;?>],
                         ['網路', <?php echo $media6;?>],
                         ['車箱', <?php echo $media7;?>],
                         ['廣告', <?php echo $media8;?>],
                         ['CF', <?php echo $media9;?>],
                         ['RD', <?php echo $media10;?>],
                         ['POP', <?php echo $media11;?>],
                         ['雜誌', <?php echo $media12;?>],
                         ['派報', <?php echo $media13;?>],
                         ['夾報', <?php echo $media14;?>],
                         ['介紹', <?php echo $media15;?>],
                         ['其他', <?php echo $media16;?>],
                        
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


      //產品需求
      c3.generate({
                bindto: '#dem_product',
                data:{
                    columns: [

                         ['大樓', <?php echo $dem_product1;?>],
                         ['透天', <?php echo $dem_product2;?>],
                         ['套房', <?php echo $dem_product3;?>],
                         ['店面', <?php echo $dem_product4;?>],
                         ['辦公室', <?php echo $dem_product5;?>],
                         ['其他', <?php echo $dem_product6;?>],
                        
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



      //坪數需求
      c3.generate({
                bindto: '#dem_floor_num',
                data:{
                    columns: [

                         ['30坪以下', <?php echo $dem_floor_num1;?>],
                         ['31~40坪', <?php echo $dem_floor_num2;?>],
                         ['41~50坪', <?php echo $dem_floor_num3;?>],
                         ['51~70坪', <?php echo $dem_floor_num4;?>],
                         ['71~90坪', <?php echo $dem_floor_num5;?>],
                         ['91坪以上', <?php echo $dem_floor_num6;?>],
                        
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



      //購屋預算
      c3.generate({
                bindto: '#dem_money',
                data:{
                    columns: [

                         ['301~400萬', <?php echo $dem_money1;?>],
                         ['401~600萬', <?php echo $dem_money2;?>],
                         ['601~800萬', <?php echo $dem_money3;?>],
                         ['801~1200萬', <?php echo $dem_money4;?>],
                         ['1201~2000萬', <?php echo $dem_money5;?>],
                         ['2001~3000萬', <?php echo $dem_money6;?>],
                         ['3001萬以上', <?php echo $dem_money7;?>],
                        
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


       //購屋動機
      c3.generate({
                bindto: '#pay_motive',
                data:{
                   x:'x',
                    columns: [
                        ['x', '交通因素', '工作因素','環境因素', '投資置產', '小換大', '新婚用', '營業用', '舊換新', '其他'],
                        ['人數', <?php echo $pay_motive1.",".$pay_motive2.",".$pay_motive3.",".$pay_motive4.",".$pay_motive5.",".$pay_motive6.",".$pay_motive7.",".$pay_motive8.",".$pay_motive9;?>],
                    ],
                    colors:{
                        人數: '#1ab394',
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



      //格局需求
      c3.generate({
                bindto: '#dem_pattern',
                data:{
                   x:'x',
                    columns: [
                        ['x', '1房', '2房','3房', '4房', '5房'],
                        ['人數', <?php echo $dem_pattern1.",".$dem_pattern2.",".$dem_pattern3.",".$dem_pattern4.",".$dem_pattern5;?>],
                    ],
                    colors:{
                        人數: '#1ab394',
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

      
      //每日使用人數
      c3.generate({
                bindto: '#date_use',
                data:{
                   x:'x',
                   xFormat: '%Y-%m-%d',
                    columns: [

                    <?php 

                       $date_txt="['x',";
                       $num_txt="['使用人數',";

      //-- 每日人數 --
      $sql_q=$pdo->prepare("SELECT set_time,COUNT(set_time) as num FROM from_question WHERE record_id=:record_id GROUP BY set_time");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
         
                            $date_txt.="'".$row['set_time']."',";
                            $num_txt.= $row['num'].",";
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


      //每日回訪人數
      c3.generate({
                bindto: '#date_back',
                data:{
                   x:'x',
                   xFormat: '%Y-%m-%d',
                    columns: [

                    <?php 

                       $date_txt="['x',";
                       $num_txt="['使用人數',";

      //-- 每日人數 --
      $sql_q=$pdo->prepare("SELECT back_time,COUNT(back_time) as num FROM from_question as fq INNER JOIN from_callback as fc ON fq.from_id=fc.from_id WHERE record_id=:record_id GROUP BY back_time");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
         
                            $date_txt.="'".$row['back_time']."',";
                            $num_txt.= $row['num'].",";
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

   });//JQUERY END

        


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
              <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><span style="color:#1ec1a0">問卷分析</span>結果 </h5>
                           <div class="ibox-tools">

                         <a id="print_web" target="_blank" href="from_analytics_print.php?record_id=<?php echo $record_id;?>&case_id=<?php echo $case_id;?>&case_name=<?php echo $case_name;?>"><i class='fa fa-print'></i>列印報表</a>

                        </div>
                        </div>
                        <div class="ibox-content ">
                          <h2><?php echo $case_name?>-分析　</h2>
                          <span class="ph_none" style="font-size:15px;">切換分析：</span>
                          <span class="cp_btn ph_none" ><i class="fa fa-line-chart"></i>問卷分析</span>
                          <a id="def_btn" class="cp_btn ph_none" href="admin_analytics.php?case_id=<?php echo $case_id;?>&case_name=<?php echo $case_name;?>"><i class="fa fa-area-chart"></i>網頁分析</a>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>今日人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                            <p id="week" class="p_txt"><?php echo $today[0]?>人</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>一周人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                            <p id="mouth" class="p_txt"><?php echo $week[0]?>人</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>一月人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                            <p id="total" class="p_txt"><?php echo $month[0]?>人</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>總人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                            <p id="total" class="p_txt"><?php echo $all[0]?>人</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>每日人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="date_use"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>每日回訪人數</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="date_back"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>媒體</h5>
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
                            <h5>性別</h5>
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
                            <h5>年齡</h5>
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
                            <h5>月收入</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="income"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>縣市地區</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content" style="height: 356px;">
                           <div id="adds">
                             <table class="table table-hover ">
                                <thead id="title_tb">
                                <tr>                               
                                    <th>地名</th>
                                    <th>人數</th>
                                    
                                </tr>
                                </thead>
                                <tbody id="com_tb">
                                   <?php

      //-- 縣市地區 --
      $sql_q=$pdo->prepare("SELECT SUBSTR(adds, 1, 3) as zip, COUNT(SUBSTR(adds, 1, 3)) as num FROM from_question WHERE record_id=:record_id GROUP BY SUBSTR(adds, 1, 3) ORDER BY num DESC LIMIT 0 , 6");
      $sql_q->bindparam(":record_id", $record_id);
      $sql_q->execute();
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {

        $sql_zip=$pdo->prepare("SELECT city, district FROM streetname WHERE zipcode=:zipcode GROUP BY zipcode");
        $sql_zip->bindparam(":zipcode", $row['zip']);
        $sql_zip->execute();
        $zip_name=$sql_zip->fetch();

        if (!empty($zip_name[0])) {
           echo '<tr><td>'.$zip_name[0].$zip_name[1].'</td><td>'.$row['num'].'</td></tr>';
        }
      }

                                   ?>
                                </tbody>
                            </table>
                           </div>
                        </div>
                    </div>
                </div>
                

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>產品需求</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="dem_product"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>坪數需求</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="dem_floor_num"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>購屋預算</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="dem_money"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>購屋動機</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="pay_motive"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>格局需求</h5>
                           <div class="ibox-tools">
                            
                        </div>
                        </div>
                        <div class="ibox-content">
                           <div id="dem_pattern"></div>
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
