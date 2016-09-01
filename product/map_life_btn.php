

<div class="tool_box">

            <!-- 手機撥打 -->

            <a id="phone_btn" class="tool_lay_base" href="tel:<?php echo $case['bu_phone'];?>" onclick="ga('send', 'event', 'phone_btn', 'click', 'tool_bar')"><span style="margin-top: 8px;" class="glyphicon glyphicon-earphone"></span><!--<img  src="assets/images/RWD/icom/04/icon1.png" alt="">--></a>

            <!-- 加LINE -->

            <a id="LINE_btn" class="tool_lay_base" href="<?php echo $bu_line;?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')"><img src="../../assets/images/RWD/icom/04/LINE.svg" alt=""></a>

            <!-- facebook分享 -->

            <a id="fb_btn" class="tool_lay_base" href="<?php echo $bu_fb;?>" onclick="ga('send', 'event', 'fb分享', 'click', 'tool_bar')"> <img src="../../assets/images/RWD/icom/04/fb.svg" alt=""></a>

            <!-- GOOGLEMAP -->

            <a id="gm_btn" class="tool_lay_base" href="https://www.google.com/maps/dir//<?php echo $map_ps['map_position'];?>/@<?php echo $map_ps['map_position'];?>,17z/data=!4m5!1m4!3m3!1s0x0:0x0!2zMjXCsDAyJzE4LjkiTiAxMjHCsDE3JzM2LjEiRQ!3b1?hl=zh-TW" onclick="ga('send', 'event', 'map_btn', 'click', 'tool_bar')"><img src="../../assets/images/RWD/icom/04/map.svg" alt=""></a>


        </div>

<button class="tool_box_btn" type="button">功能</button>

 <div id="tool_btn_div">

        <!-- GOOGLEMAP 食 -->

            <a id="gm_food_btn" class="tool_lay btn_lay" href="https://www.google.com.tw/maps/search/小吃/@<?php echo trim($map_ps['map_position']);?>,15z?hl=zh-TW" onclick="ga('send', 'event', '地圖(食)', 'click', 'tool_bar')">食</a>

        <!-- GOOGLEMAP 醫 -->

            <a id="gm_phl_btn" class="tool_lay btn_lay" href="https://www.google.com.tw/maps/search/醫院/@<?php echo trim($map_ps['map_position']);?>,15z?hl=zh-TW" onclick="ga('send', 'event', '地圖(醫)', 'click', 'tool_bar')">醫</a>

        <!-- GOOGLEMAP 住 -->

            <a id="gm_home_btn" class="tool_lay btn_lay" href="https://www.google.com/maps/dir//<?php echo $map_ps['map_position'];?>/@<?php echo $map_ps['map_position'];?>,17z/data=!4m5!1m4!3m3!1s0x0:0x0!2zMjXCsDAyJzE4LjkiTiAxMjHCsDE3JzM2LjEiRQ!3b1?hl=zh-TW" onclick="ga('send', 'event', '地圖(住)', 'click', 'tool_bar')">住</a>

        <!-- GOOGLEMAP 行 -->

            <a id="gm_work_btn" class="tool_lay btn_lay" href="<?php echo $map_life_btn['traffic_url'];?>" onclick="ga('send', 'event', '地圖(行)', 'click', 'tool_bar')">行</a>

        <!-- GOOGLEMAP 育 -->

            <a id="gm_school_btn" class="tool_lay btn_lay" href="https://www.google.com.tw/maps/search/學校/@<?php echo trim($map_ps['map_position']);?>,15z?hl=zh-TW" onclick="ga('send', 'event', '地圖(育)', 'click', 'tool_bar')">育</a>

        <!-- GOOGLEMAP 樂 -->

            <a id="gm_fun_btn" class="tool_lay btn_lay" href="https://www.google.com.tw/maps/search/百貨公司/@<?php echo trim($map_ps['map_position']);?>,14z?hl=zh-TW" onclick="ga('send', 'event', '地圖(樂)', 'click', 'tool_bar')">樂</a>

              
            <?php 

              if (!empty($map_life_btn['who_other'])) {
                  
                  $other_name=explode(',', $map_life_btn['map_other_name']);
                  $keyword=explode(',', $map_life_btn['other_keyword']);

                     $contant='<div id="'.$map_life_btn['who_other'].'" class="other_div">';

                  for ($i=0; $i < count($other_name) ; $i++) { 
                      
                      if (!empty($other_name[$i])) {
                        
                        $contant.='<div class="other_btn">';
                        $contant.='<a href="https://www.google.com.tw/maps/search/'.$keyword[$i].'/@'.trim($map_ps['map_position']).',16z?hl=zh-TW" onclick="ga(\'send\', \'event\', \'地圖('.$other_name[$i].')\', \'click\', \'tool_bar\')">'.$other_name[$i].'</a>'; 
                        $contant.='</div>';
                      }
                  }
                     $contant.='</div>';
                  echo $contant;
              }
            ?>

  </div>

 