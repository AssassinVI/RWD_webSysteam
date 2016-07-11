<?php  
      include 'caseId.php';
      include'../../assets/php/data.php';

?>

<?php 

  // -- 抓取建案 --
   $case=select_case($case_id);  
  //-- 抓取功能ID -- 
   $fun_id=select_rel($case_id);
  //-- 更改顏色 --
   $color=select_color($case_id);

   //建案說明
   $other=html_entity_decode($case['other'], ENT_QUOTES, "UTF-8");
   //目前網址
   $URL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

   //-- 手機功能-地圖 --

   for ($i=0; $i <count($fun_id) ; $i++) { 
     $sel_fun=substr($fun_id[$i], 0,2);
       if ($sel_fun=='gm') {
          $map_ps=select_map($fun_id[$i]);
       }
   }


// -- LINE 分享 或 加LINE群組 --
   if ($case['line_tool']=="line_plus") {
     $bu_line=$case['bu_line'];
   }
   elseif($case['line_tool']=="line_share"){
     

    if (strpos($case['bu_line'], 'http')) {
      $bu_line="http://line.me/R/msg/text/?".$case['bu_line'];
    }
    else{
      $bu_line="http://line.me/R/msg/text/?".$case['bu_line'].$URL;
    }
   }

?>



<!DOCTYPE html>

<!--[if IE 8]>      <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>      <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<!--FACEBOOK Open Graph 標記語言-->

<html xmlns:og='http://ogp.me/ns#'>

<!--<![endif]-->

<head>

    <meta charset="utf-8" />
    <title><?php echo $case['case_name'];?></title>
    <!-- FACEBOOK 分享資訊 -->
    <meta property="og:title" content="<?php echo $case['case_name'];?>" />
    <meta property="og:description" content="<?php echo $other;?>" />
    <meta property="og:url" content="<?php echo $URL;?>" />

    <!-- 分享主圖 -->
    <meta property="og:image" content="assets/images/activ_img.jpg" />
    <meta property="og:type" content="website" />
    <meta name="description" content="<?php echo $other;?>" />
    <meta name="Author" content="Dorin Grigoras [www.stepofweb.com]" />
    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!-- CORE CSS -->
    <link href="../../assets/js/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/js/plugins/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/animate.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/superslides.css" rel="stylesheet" type="text/css" />
    <!-- REVOLUTION SLIDER -->
    <link href="../../assets/js/plugins/revolution-slider/css/settings.css" rel="stylesheet" type="text/css" />
    <!-- THEME CSS -->
    <link href="../../assets/css/essentials.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/layout-responsive.css" rel="stylesheet" type="text/css" />
    <!-- 黑色Layout -->
    <!--<link id="css_dark_skin" href="assets/css/layout-dark.css" rel="stylesheet" type="text/css" />-->
    <!-- 換色必要Layout -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/RWD_doc-layout1.css">
    <!-- 白色Layout -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/RWD_white_layout.css">
    <!-- 觸控式幻燈片 -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/swiper.min.css">
    <!-- 燈箱(fancyBox) -->
    <link rel="stylesheet" type="text/css" href="../../assets/js/source/jquery.fancybox.css">
    <!-- STYLESWITCHER - REMOVE ON PRODUCTION/DEVELOPMENT -->
    <link href="../../assets/js/plugins/styleswitcher/styleswitcher.css" rel="stylesheet" type="text/css" />
    <!-- Morenizr -->
    <script type="text/javascript" src="../../assets/js/plugins/modernizr.min.js"></script>

    <!-- 更改新顏色 -->
    <style type="text/css">
      .content h1{
        color: <?php echo $color['h1_color'];?>; /* 主標 */
       }
      .content h2{
        color: <?php echo $color['h2_color'];?>;/* 副標 */
       }
      .content p{
        color: <?php echo $color['p_color'];?>;/* 內文 */
       }
      .marquee_box{
        color: <?php echo $color['marquee'];?>;/* 跑馬燈 */
       }
       .big_txt b{
        color: <?php echo $color['top_txt'];?>;/* 錨點文字 */
       }
       .big_txt b:hover{
        color: <?php echo $color['h1_color'];?>;
       }
       header#topNav{
        background-color: <?php echo $color['top_bar'];?>;/* 導航欄 */
        border-color: <?php echo $color['top_bar'];?>;
        box-shadow: none;
       }
      body #wrapper{
        background-color: <?php echo $color['back_color'];?>;/* 背景 */
       }

      @media only screen and (max-width:800px) {
         .big_txt b{
            color: #fff;
          }
        }
    </style>

</head>

<body>

    <!-- Available classes for body: boxed , pattern1...pattern10 . Background Image - example add: data-background="assets/images/boxed_background/1.jpg"  -->

    <!-- TOP NAV -->
    <header id="topNav" class=" nopadd">
        <!-- remove class="topHead" if no topHead used! -->
        <div class="container ">
            <!-- 背景音樂 -->
            <audio id="myaudio" autoplay preload loop></audio>
            <!-- Mobile Menu Button -->
            <button class="btn-mobile pull-left  " data-toggle="collapse" data-target=".nav-main-collapse">
                <span style="color: #fff; font-size: 20px;" class="glyphicon glyphicon-align-justify"></span>
            </button>
            <!-- 跑馬燈 -->
            <!--<div class="marquee_lay"></div>-->
            <marquee class="ph_mar marquee_box"><?php echo $case['marquee']?></marquee>
            <!-- 背景音樂按鈕 -->
    <?php 
      if (!empty($case['activity_song'])) {
        echo '<button type="button" class="song_btn pull-right"><span class="glyphicon glyphicon-volume-off"></span></button>';
      }
    ?>
            <!-- Top Nav -->
            <div id="nav_btn" class=" navbar-collapse nav-main-collapse collapse pull-right">
            <!-- 跑馬燈 -->
            <!--<div class="marquee_lay"></div>-->
            <marquee class="pc_mar marquee_box"><?php echo $case['marquee']?></marquee>
                <nav class="nav-main mega-menu ">
                    <ul id="nav_ul" class="nav nav-pills nav-main scroll-menu" id="topMain">
                    </ul>
                </nav>
            </div>
            <!-- /Top Nav -->
        </div>
    </header>
    <span id="header_shadow"></span>
    <!-- /TOP NAV -->
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- ============================ 主文 ====================================-->
        <div id="all">
            <div class="content">
            </div>
        </div>
    </div>
    <!-- /WRAPPER -->
    <!-- FOOTER -->
    <footer class="dom_index">
        <!-- ===============================手機功能欄========================================= -->
        <div class="tool_box">

            <!-- 手機撥打 -->

            <a style="background:#00D6D6;display: block; width: 48px; height: 48px;font-size: 30px;border-radius: 30px 30px;text-align: center; " href="tel:<?php echo $case['bu_phone'];?>" onclick="ga('send', 'event', '手機撥打', 'click', 'tool_bar')"><span style="margin-top: 8px;" class="glyphicon glyphicon-earphone"></span><!--<img  src="assets/images/RWD/icom/04/icon1.png" alt="">--></a>

            <!-- 加LINE -->

            <a href="<?php echo $bu_line;?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')"><img style="width: 48px;height:48px;border-radius: 30px 30px" src="../../assets/images/RWD/icom/04/LINE.svg" alt=""></a>

            <!-- facebook分享 -->

            <a href="https://www.facebook.com/dialog/feed?app_id=563666290458260&display=popup&link=<?php echo $URL;?>&redirect_uri=https://www.facebook.com/" onclick="ga('send', 'event', 'facebook分享', 'click', 'tool_bar')"> <img style="background:#fff; width: 48px;height:48px;border-radius: 30px 30px" src="../../assets/images/RWD/icom/04/fb.svg" alt=""></a>

            <!-- GOOGLEMAP -->

            <a href="https://www.google.com/maps/dir//<?php echo $map_ps['map_position'];?>/@<?php echo $map_ps['map_position'];?>,17z/data=!4m5!1m4!3m3!1s0x0:0x0!2zMjXCsDAyJzE4LjkiTiAxMjHCsDE3JzM2LjEiRQ!3b1?hl=zh-TW" onclick="ga('send', 'event', 'GOOGLEMAP', 'click', 'tool_bar')"><img style="width: 48px;height:48px;border-radius: 30px 30px" src="../../assets/images/RWD/icom/04/map.svg" alt=""></a>

        </div>

        <!-- LINE按鈕 -->
        <a href="<?php echo $bu_line;?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')"><img  class="LINE_tool" src="../../assets/images/svg/line.svg" alt=""></a>
        
        <!-- FB按鈕 -->
        <a href="https://www.facebook.com/dialog/feed?app_id=563666290458260&display=popup&link=<?php echo $URL;?>&redirect_uri=https://www.facebook.com/" onclick="ga('send', 'event', 'facebook分享', 'click', 'tool_bar')"><img  class="FB_tool" src="../../assets/images/svg/FB.svg" alt=""></a>

        <!-- ====================== TOP按鈕 ======================= -->
        <div class="scor_top">
            <span class="glyphicon glyphicon-chevron-up " aria-hidden="true"></span>
        </div>

        <!-- ====================== 文字放大鏡 ======================= -->
        <button id="magn_txt" type="button"><span class="glyphicon glyphicon-zoom-in " aria-hidden="true"></span>
            <p>100%</p>
        </button>

        <!-- footer content -->
        <div class="footer-content">
            <div class="container">
                <div class="row">
                    <!-- FOOTER CONTACT INFO -->
                    <div class="column col-md-12">
                        <ul id="address_ul">
                            <li>

                                <?php echo $case['case_name']?>

                            </li>
                            <li>
                                <span class="glyphicon glyphicon-home"></span><?php echo $case['format']?>
                            </li>
                                <li>
                                    <span class="glyphicon glyphicon-home"></span> 接待會館：<?php echo $case['build_adds']?>
                                </li>
                                <li>
                                    <span class="glyphicon glyphicon-earphone"></span> 禮賓專線：<?php echo  $case['bu_phone']?>
                                </li>
                        </ul>
                    </div>
                    <!-- /FOOTER CONTACT INFO -->
                </div>
            </div>
        </div>

        <!-- footer content -->
    </footer>

    <!-- /FOOTER -->
    <!-- JAVASCRIPT FILES -->
    <script type="text/javascript" src="../../assets/js/plugins/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/jquery.cookie.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/jquery.appear.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/jquery.isotope.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/masonry.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/stellar/jquery.stellar.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/knob/js/jquery.knob.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/jquery.backstretch.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/superslides/dist/jquery.superslides.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/styleswitcher/styleswitcher.js"></script>
    <!-- STYLESWITCHER - REMOVE ON PRODUCTION/DEVELOPMENT -->
    <script type="text/javascript" src="../../assets/js/plugins/mediaelement/build/mediaelement-and-player.min.js"></script>
    <!-- REVOLUTION SLIDER -->
    <script type="text/javascript" src="../../assets/js/plugins/revolution-slider/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="../../assets/js/slider_revolution.js"></script>
    <script type="text/javascript" src="../../assets/js/scripts.js"></script>
    <!-- 觸控式幻燈片 -->
    <script type="text/javascript" src="../../assets/js/swiper.jquery.min.js"></script>
    <!-- 燈箱(fancyBox) -->
    <script type="text/javascript" src="../../assets/js/source/jquery.fancybox.js"></script>
    <!-- 滾輪動畫 -->
    <script type="text/javascript" src="../../assets/js/scrollReveal.js"></script>
    <!-- GOOGLE MAP 外掛 -->
    <script type="text/javascript" src="../../assets/js/jquery.googlemap.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDV1hk5SfQxLdftm38V5_3l4lY70jMg6w4"></script>

    <!-- 顏色十六進制轉HSL -->
    <script type="text/javascript" src="../../assets/js/color_exchange.js"></script>





<!-- ****************************** 讀取功能區塊 ************************************* --> 

   <script type="text/javascript">
       $(document).ready(function() {
   

<?php 



     //依序抓取功能區塊

   for ($i=0; $i <count($fun_id) ; $i++) { 
      $fun_name=substr($fun_id[$i], 0,2);

//============================================幻燈片==========================================
       if ($fun_name=='ss') { 

           $show_all=select_show($fun_id[$i]);
           $show_img=explode(',', $show_all['show_img']);
           $show_html='<div class="img_box">';
           $show_html.='<div class="swiper-container show_height">';
          $show_html.='<div class="swiper-wrapper">';
          
          for ($j=0; $j <count($show_img)-1 ; $j++) { 
             $show_html.='<div class="swiper-slide"><img src="assets/images/'.$show_img[$j].'" ></div>'; 
          }

          $show_html.='</div>';
          $show_html.='<div class="swiper-pagination"></div>'; //分頁器
          $show_html.='<div class="swiper-button-prev"></div>';//導航鈕(上)
          $show_html.='<div class="swiper-button-next"></div>';//導航鈕(下)
          $show_html.='</div>';
          $show_html.='';
          $show_html.='<h3 class="back_caseName"><hr class="back_hr"/>'.$case['case_name'].'<hr class="back_hr"/></h3>';//底色建案名稱
          $show_html.='';
          $show_html.='</div>';
        
        echo "$('.content').append('".$show_html."');";

       }



 //============================================  YouTube  ==========================================      

       elseif ($fun_name=='yu') { 
          $you_all=select_you($fun_id[$i]);
           $you_adds=explode("=", $you_all['you_adds']);
            $you_html="";
           if (!empty($you_all['you_title'])) {

              $you_title=explode("(*)", $you_all['you_title']);

              if (!empty($you_title[0])) { $you_html.='<h1 class="h1_txt">'.$you_title[0].'</h1>'; }
              if (!empty($you_title[1])) { $you_html.='<h1 class="h1_txt_2">'.$you_title[1].'</h1>'; }
              if (!empty($you_title[2])) { $you_html.='<h1 class="h1_txt_2">'.$you_title[2].'</h1>'; }
              
           }

           $you_html.='<div class="img_box">';
           $you_html.='<iframe src="https://www.youtube.com/embed/'.$you_adds[1].'" frameborder="0" allowfullscreen>';
           $you_html.='</iframe>';
           $you_html.='';
           $you_html.='<h3 class="back_caseName"><hr class="back_hr"/>'.$case['case_name'].'<hr class="back_hr"/></h3>';//底色建案名稱
           $you_html.='';
           $you_html.='</div>';
        echo "$('.content').append('".$you_html."');";
       }



 // =============================================== 基本圖文 ======================================     

       elseif ($fun_name=='bs') { 
           $base_all=select_base($fun_id[$i]);
           $ed_word=html_entity_decode($base_all['edit_word'], ENT_QUOTES, "UTF-8");
           if ($base_all['txt_fadein']=='y') {
               $fadein_h1='data-scroll-reveal="enter left move 100px over 1s"';
               $fadein_h2='data-scroll-reveal="enter right after 0.5s move 100px "';

           }else{
               $fadein_h1='';
               $fadein_h2='';
           }

          $base_html="";
           if (!empty($base_all['title'])) {

            $title=explode("(*)", $base_all['title']);

            if (!empty($title[0])) { $base_html.='<h1 '.$fadein_h1.' class="h1_txt">'.$title[0].'</h1>'; }
            if (!empty($title[1])) { $base_html.='<h1 '.$fadein_h1.' class="h1_txt_2">'.$title[1].'</h1>'; }
            if (!empty($title[2])) { $base_html.='<h1 '.$fadein_h1.' class="h1_txt_2">'.$title[2].'</h1>'; }
             
           }
           if (!empty($base_all['title_two'])) {
              $base_html.='<h2 '.$fadein_h2.' class="h2_txt">'.$base_all['title_two'].'</h2>';
           }
           if (!empty($ed_word)) {
            $base_html.='<p class="p_txt">'.$ed_word.'</p>';
           }
           elseif(empty($ed_word) AND !empty($base_all['title_two'])){
            $base_html.='<p class="p_txt"></p>';
           }


           $base_img=explode(',', $base_all['base_img']);
           for ($j=0; $j <count($base_img)-1 ; $j++) { 
            
            if (empty($base_all['big_img'])) {

              $base_html.='<img src="assets/images/'.$base_img[$j].'" alt="">';
            }
            else{
              $base_html.='<a id="zoom_a" href="'.$base_all['big_img'].'"><p id="big_zoom"><span class="glyphicon glyphicon-zoom-in " aria-hidden="true"></span> 點圖放大</p><img src="assets/images/'.$base_img[$j].'" alt=""></a>';
            }

             //$base_html.='<img src="assets/images/'.$base_img[$j].'" alt="">'; 

          }
          $base_html.='';
           $base_html.='<h3 class="back_caseName"><hr class="back_hr"/>'.$case['case_name'].'<hr class="back_hr"/></h3>';//底色建案名稱
           $base_html.='';
         echo "$('.content').append('".$base_html."');";
         //echo "$('.content').find('p').addClass('p_txt');";

       }



 // ======================================= GoogleMap ==========================================     

       elseif ($fun_name=='gm') { 

          
           $map_all=select_map($fun_id[$i]);
            $map_div="";
           if (!empty($map_all['map_title'])) {

            $map_title=explode("(*)", $map_all['map_title']);

              if (!empty($map_title[0])) { $map_div.='<h1 class="h1_txt">'.$map_title[0].'</h1>'; }
              if (!empty($map_title[1])) { $map_div.='<h1 class="h1_txt_2">'.$map_title[1].'</h1>'; }
              if (!empty($map_title[2])) { $map_div.='<h1 class="h1_txt_2">'.$map_title[2].'</h1>'; }
           }

           $map_div.='<div id="'.$fun_id[$i].'map" class="map"></div>';
           $map_div.='<a id="map_placeholder" href="https://www.google.com/maps/dir//'.$map_all['map_position'].'/@ '.$map_all['map_position'].',17z/data=!4m5!1m4!3m3!1s0x0:0x0!2zMjXCsDAyJzE4LjkiTiAxMjHCsDE3JzM2LjEiRQ!3b1?hl=zh-TW">';
           $map_div.='<img src="../../assets/images/RWD/icom/placeholder.svg" alt="">';
           $map_div.=' 導航-基地位置</a>';
           echo "$('.content').append('".$map_div."');";

        
          $map_html='var mapoption = {';
          $map_html.='mapTypeControl: false,';
          $map_html.='streetViewControl: false,';
          $map_html.= 'zoomcontrol: true,';
          $map_html.= 'scaleControl: true,';
          $map_html.= 'center: new google.maps.LatLng('.$map_all['map_position'].'),';
          $map_html.= 'zoom: 16'; 
          $map_html.=  '};';


           /* MAP物件 */
        $map_html.='var map = new google.maps.Map(document.getElementById("'.$fun_id[$i].'map"), mapoption);';

           
            /* 標記物件 */
         $map_html.='var marker = new google.maps.Marker({ map: map, position: map.getCenter() });';

            $map_html.='var info_txt = "<b>'.$case['case_name'].'</b><br><b> '.$map_all['mark_txt'].'</b>";';     

                /* 說明視窗物件 */
               $map_html.='var info = new google.maps.InfoWindow();';
               $map_html.='info.setContent(info_txt);';
               $map_html.='info.open(map, marker);';
               $map_html.='google.maps.event.addListener(marker, "click", function() { info.open(map, marker); });';   

                echo $map_html;
       }



 // =========================================== 聯絡我們 =================================================

       elseif ($fun_name=='ca') {  

           
       }


// =========================================== 720環景 =================================================

       elseif ($fun_name=='vi') {
          
          $view720=select_view720($fun_id[$i]);
           $view_fun_id=$view720['fun_id'];
          $x_point =explode(',', $view720['x_point']); //X座標
          $y_point=explode(',', $view720['y_point']);  //Y座標
          $point_txt=explode(',', $view720['point_txt']); //名稱
          $point_link=explode(',', $view720['point_link']); //連結

          $view_txt='';

          if (!empty($view720['view720_title'])) {

              $view720_title=explode("(*)", $view720['view720_title']);

              if (!empty($view720_title[0])) { $view_txt.='<h1 class="h1_txt">'.$view720_title[0].'</h1>'; }
              if (!empty($view720_title[1])) { $view_txt.='<h1 class="h1_txt_2">'.$view720_title[1].'</h1>'; }
              if (!empty($view720_title[2])) { $view_txt.='<h1 class="h1_txt_2">'.$view720_title[2].'</h1>'; }
          }
          $view_txt.='<div class="img_div">';

         for ($x=0; $x <count($x_point)-1 ; $x++) { 
            $new_x=explode('%', $x_point[$x]);

           $new_x=(int)$x_point[$x]-3;
           $new_y=(int)$y_point[$x]-5;

           $txt_x=(int)$x_point[$x]-3;
           $txt_y=(int)$y_point[$x]+3;

           $view_link="zip/".$view_fun_id."/".$point_link[$x]; //環景連結

            $view_txt.='<a class="img_txt" style="left:'.$txt_x.'%;top:'.$txt_y.'%"  href="'.$view_link.'">'.$point_txt[$x].'</a>';
            $view_txt.='<a class="light_box" style="left:'.$new_x.'%;top:'.$new_y.'%"  href="'.$view_link.'"><img src="../../assets/images/光.png" ></a>';
          }

          $view_txt.='<img src="assets/images/'.$view720['view_img'].'" alt="">';
          $view_txt.='';
          $view_txt.='<h3 class="back_caseName"><hr class="back_hr"/>'.$case['case_name'].'<hr class="back_hr"/></h3>'; //底色建案名稱
          $view_txt.='';
          $view_txt.='</div>';

          echo "$('.content').append('".$view_txt."');";
         
       }


 // ============================================= 錨點加入 =======================================================   

       elseif ($fun_name=='an') {

        $an_name=select_anchor($fun_id[$i]);
         $an_txt='<li class=" dropdown ">';
         $an_txt.='<a id="'.$fun_id[$i].'_btn" class="dropdown-toggle" href="#">';
         $an_txt.='<span class="big_txt "><b>'.$an_name.'</b> </span>';
         $an_txt.='</a>';
         $an_txt.='</li>';
         echo "$('#nav_ul').append('".$an_txt."');";

         $an_aiv='<div id="'.$fun_id[$i].'"></div>';
         echo "$('.content').append('".$an_aiv."');";
       }


    // ============================================= 房貸試算 ======================================================= 
         
        elseif ($fun_name=='hm') {
           $hm_txt='<a class="nw_btn tool_btn" href="../../assets/php/house_math.php">房貸試算</a>';
           echo "$('.content').append('".$hm_txt."');";
         } 

      // ============================================= 索取DM ======================================================= 
         
        elseif ($fun_name=='dm') {
           $dm_txt='<a class="nw_btn tool_btn" href="../../assets/php/catch_DM.php?case_id='.$case_id.'&case_name='.$case['case_name'].'">索取DM</a>';
           echo "$('.content').append('".$dm_txt."');";
         } 


      // ============================================= 電子報 ======================================================= 
         
        elseif ($fun_name=='nw') {
           $nw_txt='<a class="nw_btn tool_btn" href="../../assets/php/newsletter.php?case_id='.$case_id.'&case_name='.$case['case_name'].'">索取電子報</a>';
           echo "$('.content').append('".$nw_txt."');";
         } 


      // ============================================= 聯絡我們 ======================================================= 
         
        elseif ($fun_name=='ca') {
           $nw_txt='<a class="nw_btn tool_btn" href="../../assets/php/call_we.php?fun_id='.$fun_id[$i].'&case_name='.$case['case_name'].'">聯絡我們</a>';
           echo "$('.content').append('".$nw_txt."');";
         } 
   }//for-end
?>

       }); //jquery-end

   </script>

<!-- ======================== 所有Javascript ============================ -->
<?php require_once '../../assets/php/product_js.php'; ?>

</body>
</html>

