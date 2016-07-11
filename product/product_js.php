 <script type="text/javascript">   
    $(function() {
        window.scrollReveal = new scrollReveal();　
        $(window).load(function() {　　
            $(window).bind('scroll resize', function() {　　


                var $this = $(this);　　
                var $this_Top = $this.scrollTop();
                var $document_bottom = $(document).height() - $(window).height() - 100;

                //當高度小於100時 隱藏區塊

                if ($this_Top < 100) {
                    $(".scor_top").stop().animate({
                        right: 50
                    }, 200).fadeOut('100');
                }　

                //當高度大於400時，顯示區塊

                if ($this_Top > 400) {
                    $(".scor_top").stop().fadeIn('100').animate({
                        right: 20
                    }, 200);　　　
                }
            }).scroll();　
        });





        /* ==================================== 手機功能棒調整 ================================= */

        $(window).load(function() {
            $(window).bind('scroll resize', function() {　　

                var $this = $(this);　　
                var $this_Top = $this.scrollTop();
                var $document_bottom = $(document).height() - $(window).height() - 100;
                if ($this_Top > $document_bottom) {

                    $(".tool_box").stop().animate({
                        bottom: 190
                    }, 500);
                }

                if ($this_Top < $document_bottom) {
                    $(".tool_box").stop().animate({
                        bottom: 0
                    }, 500);
                }　
            }).scroll();　
        });





        /* ============================ Top 按鈕 ================================= */

        var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');

        //指定視窗物件

       $(".scor_top").click(function() {
            $body.animate({
                scrollTop: 0
            }, 1000);
        });


       <?php 

          $result=db_conn("SELECT fun_id FROM anchor_tb WHERE case_id='$case_id'");
          while ($row=mysql_fetch_array($result)) {

             $funId=$row['fun_id'];
             $top_txt='$("#'.$funId.'_btn").click(function() {';
             $top_txt.='$body.animate({ scrollTop: $("#'.$funId.'").offset().top - 50  }, 1000);';
             $top_txt.='$("#nav_ul").find("span").removeClass("nav_active");';
             $top_txt.='$(this).find("span").addClass("nav_active");';
             $top_txt.='});';

             echo $top_txt;

          }

           //close_nav
            $close_top='<li id="close_top" class="dropdown"><span  style="color: #fff;font-size: 30px;margin-top:15px;" class="glyphicon glyphicon-remove-sign"></span></li>';


          echo "$('#nav_ul').append('".$close_top."')";

       ?>


        /* ================================ 背景音樂開關 =========================================== */


        $(".song_btn").click(function() {
            var myaudio = document.getElementById("myaudio");
            if (myaudio.paused) {
                myaudio.play();
                $(".song_btn").find("span").removeClass('glyphicon-volume-up');
                $(".song_btn").find("span").addClass('glyphicon-volume-off');

            } else {
                myaudio.pause();
                $(".song_btn").find("span").removeClass('glyphicon-volume-off');
                $(".song_btn").find("span").addClass('glyphicon-volume-up');
            }
        });



        /* ====================================== p文字放大鏡 ========================================= */

        var amgn_index = 1;
        $("#magn_txt").click(function() {
            var p_size = $(".p_txt").css('fontSize');
            var p_size = parseInt(p_size.substr(0, 2));

            if (amgn_index % 3 == 1) {

                var p_big = p_size + 5;
                $(".p_txt").css('fontSize', p_big + 'px');
                $("#magn_txt").find('p').html('120%');

            } else if (amgn_index % 3 == 2) {

                var p_big = p_size + 5;
                $(".p_txt").css('fontSize', p_big + 'px');
                $("#magn_txt").find('span').removeClass('glyphicon-zoom-in');
                $("#magn_txt").find('span').addClass('glyphicon-zoom-out');
                $("#magn_txt").find('p').html('150%');

            } else if (amgn_index % 3 == 0) {

                var p_big = p_size - 10;
                $(".p_txt").css('fontSize', p_big + 'px');
                $("#magn_txt").find('span').removeClass('glyphicon-zoom-out');
                $("#magn_txt").find('span').addClass('glyphicon-zoom-in');
                $("#magn_txt").find('p').html('100%');

            }

            amgn_index = amgn_index + 1;

        });



        /* ======================= 幻燈片初始化 ============================== */

        var myswiper = new Swiper('.swiper-container', {
            speed: 1200,

        <?php 

         if (!empty($show_all['play_speed'])) {
              echo 'autoplay: '.$show_all['play_speed'].' ,';
          }
        ?>
            loop: true,

            /* 分頁器 */
            pagination: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
        });







        /* ============================== 燈箱(fancyBox) ============================== */

        var act_img='<?php echo $case["activity_img"];?>';

        if (act_img!="") {
        $.fancybox({

            href: "assets/images/activ_img.jpg",
             'padding':'0',
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none'
        });

        $.fancybox.open();
        }

/* ================================= 環景燈箱 ======================================= */
          $(".img_div").find('a').fancybox({
               'padding'               :'0',
               'width'                 : '100%',
               'height'               : '100%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });


/* ================================= 功能按鈕燈箱 ======================================= */
          $(".nw_btn").fancybox({
               'padding'               :'0',
               'width'                 : '350px',
               'height'               : '100%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });



        /* ============================== 手機網頁自動播歌 ============================== */

        var audioEl = document.getElementById('myaudio');

        // 可以自动播放时正确的事件顺序是
        // loadstart
        // loadedmetadata
        // loadeddata
        // canplay
        // play
        // playing
        // 
        // 不能自动播放时触发的事件是
        // iPhone5  iOS 7.0.6 loadstart
        // iPhone6s iOS 9.1   loadstart -> loadedmetadata -> loadeddata -> canplay

        audioEl.addEventListener('loadstart', function() {
            log('loadstart');
        }, false);

        audioEl.addEventListener('loadeddata', function() {
            log('loadeddata');
        }, false);

        audioEl.addEventListener('loadedmetadata', function() {
            log('loadedmetadata');
        }, false);

        audioEl.addEventListener('canplay', function() {
            log('canplay');
        }, false);

        audioEl.addEventListener('play', function() {
            log('play');
            // 当 audio 能够播放后, 移除这个事件
            window.removeEventListener('touchstart', forceSafariPlayAudio, false);
        }, false);

        audioEl.addEventListener('playing', function() {
            log('playing');
        }, false);

        audioEl.addEventListener('pause', function() {
            log('pause');
        }, false);

        // 由于 iOS Safari 限制不允许 audio autoplay, 必须用户主动交互(例如 click)后才能播放 audio,
        // 因此我们通过一个用户交互事件来主动 play 一下 audio.

        window.addEventListener('touchstart', forceSafariPlayAudio, false);

        <?php 
          if (!empty($case['activity_song'])) {
            echo "audioEl.src = 'music/activity_song.mp3';";
          }
        ?>

        function log(info) {
            console.log(info);
        }

        function forceSafariPlayAudio() {

            audioEl.load(); // iOS 9   还需要额外的 load 一下, 否则直接 play 无效
            audioEl.play(); // iOS 7/8 仅需要 play 一下
        }



        /* ============================== Google Map ============================== */


        var mapoption = {
            mapTypeControl: false,
            streetViewControl: false,
            zoomcontrol: true,
            scaleControl: true,
            center: new google.maps.LatLng(25.02348, 121.2952),
            zoom: 17
        };

        //google 經緯度轉地址物件
        var geocoder = new google.maps.Geocoder();

        // google.maps.LatLng 物件
        var coord = new google.maps.LatLng(25.02348, 121.2952);

        geocoder.geocode({
            'latLng': coord
        }, function(result, status) {

            if (status === google.maps.GeocoderStatus.OK) {

                var adds = result[0].formatted_address;

                /* MAP物件 */
                var map = new google.maps.Map(document.getElementById('map'), mapoption);

                /* 標記物件 */
                var marker = new google.maps.Marker({

                    map: map,
                    position: map.getCenter()
                    // icon:'assets/images/RWD/icom/marker02.png'
                });


                var info_txt = "<b><?php echo $case['case_name'];?> <br> 地址: "+adds+"</b>";

                /* 說明視窗物件 */
                var info = new google.maps.InfoWindow();
                info.setContent(info_txt);
                info.open(map, marker);
                google.maps.event.addListener(marker, 'click', function() {
                    info.open(map, marker);
                });

            } else {
                alert('經緯度輸入錯誤');
            }
        });




      //顏色轉換(back_caseName)
       var color16="<?php echo $color['back_color'];?>"; 
       var case_HSL=color_hsl(color16);
       var case_S=new Number(case_HSL[1]*100);

       if (case_HSL[2]>0.7) {
        var case_L=new Number(case_HSL[2]-0.3);
            case_L=case_L*100;
       }
       else{
        var case_L=new Number(case_HSL[2]+0.3);
            case_L=case_L*100;
       }
       
           case_S=case_S.toFixed(0);
           case_L=case_L.toFixed(0);
       var newHSL="hsl("+case_HSL[0]+","+case_S+"%,"+case_L+"%)";
      // var newHSLA="hsla("+case_HSL[0]+","+case_S+"%,"+case_L+"%, 0.4)";

       $(".back_caseName").css('color', newHSL);
        $(".back_hr").css('borderColor', newHSL);
       // $(".tool_box").css('backgroundColor', newHSLA);

    }); //JQUERY END

 </script>
 <!--
    <script type="text/javascript">

    /* ======================================== 輪播跑馬燈 ================================================= */


    $(document).ready(function() {
        //timer_out();
    });

    var marquee = "桃園之心-超群絕倫，高速網路-縱橫交織，綠色能量-絕版密境";
    var txt = marquee.split("，");
    var i = 0;
    var t;

    function timer_out() {
        $(".marquee_lay").slideDown('1500').delay(5000).html(txt[i]).fadeOut('1500');
        var index = txt.length - 1;
        if (i >= index) {
            i = i - index;
        } else {
            i = i + 1;
        }
        t = setTimeout("timer_out()", 6000);
    }


    </script>
-->

    <script>
  /* ================================= GOOGLE分析(追蹤碼) ==================================== */
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $case["google_code"];?>', 'auto');
  ga('require', 'displayfeatures');  //客層分析
  ga('send', 'pageview');
    </script>