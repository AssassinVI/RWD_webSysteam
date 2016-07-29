<div class="tool_box">

            <!-- 手機撥打 -->

            <a style="background:#00D6D6;display: block; width: 48px; height: 48px;font-size: 30px;border-radius: 30px 30px;text-align: center; " href="tel:<?php echo $case['bu_phone'];?>" onclick="ga('send', 'event', '手機撥打', 'click', 'tool_bar')"><span style="margin-top: 8px;" class="glyphicon glyphicon-earphone"></span><!--<img  src="assets/images/RWD/icom/04/icon1.png" alt="">--></a>

            <!-- 加LINE -->

            <a href="<?php echo $bu_line;?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')"><img style="width: 48px;height:48px;border-radius: 30px 30px" src="../../assets/images/RWD/icom/04/LINE.svg" alt=""></a>

            <!-- facebook分享 -->

            <a href="<?php echo $bu_fb;?>" onclick="ga('send', 'event', 'facebook分享', 'click', 'tool_bar')"> <img style="background:#fff; width: 48px;height:48px;border-radius: 30px 30px" src="../../assets/images/RWD/icom/04/fb.svg" alt=""></a>

            <!-- GOOGLEMAP -->

            <a href="https://www.google.com/maps/dir//<?php echo $map_ps['map_position'];?>/@<?php echo $map_ps['map_position'];?>,17z/data=!4m5!1m4!3m3!1s0x0:0x0!2zMjXCsDAyJzE4LjkiTiAxMjHCsDE3JzM2LjEiRQ!3b1?hl=zh-TW" onclick="ga('send', 'event', 'GOOGLEMAP', 'click', 'tool_bar')"><img style="width: 48px;height:48px;border-radius: 30px 30px" src="../../assets/images/RWD/icom/04/map.svg" alt=""></a>

        </div>