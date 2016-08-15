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
            if (check_mobile()) {
              
              $show_html.='<div class="swiper-slide"><img src="../../assets/php/timthumb.php?src=http://rx.znet.tw/rwd_system/product_html/'.$case_id.'/assets/images/'.$show_img[$j].'&w=840&zc=0" ></div>'; 
            }else{

             $show_html.='<div class="swiper-slide"><img src="assets/images/'.$show_img[$j].'" ></div>'; 
            }
          }

          $show_html.='</div>';
         // $show_html.='<div class="swiper-pagination"></div>'; //分頁器
          $show_html.='<div class="swiper-button-prev"></div>';//導航鈕(上)
          $show_html.='<div class="swiper-button-next"></div>';//導航鈕(下)
          $show_html.='</div>';
          $show_html.='';
          $show_html.='<h3 class="back_caseName"><hr class="back_hr"/>'.$case['case_name'].'<hr class="back_hr"/></h3>';//底色建案名稱
          $show_html.='';
          $show_html.='</div>';
        
        echo $show_html;

       }



 //============================================  YouTube  ==========================================      

       elseif ($fun_name=='yu') { 
          $you_all=select_you($fun_id[$i]);
           $you_adds=explode("=", $you_all['you_adds']);
            $you_html="<div class='you_div'>";
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
           $you_html.='</div>';
        echo $you_html;
       }



 // =============================================== 基本圖文 ======================================     

       elseif ($fun_name=='bs') { 
           $base_all=select_base($fun_id[$i]);
           $ed_word=html_entity_decode($base_all['edit_word'], ENT_QUOTES, "UTF-8");
           $h2_word=html_entity_decode($base_all['title_two'], ENT_QUOTES, "UTF-8");
           if ($base_all['txt_fadein']=='y') {
               $fadein_h1='data-scroll-reveal="enter left move 100px over 1s"';
               $fadein_h2='data-scroll-reveal="enter right after 0.5s move 100px "';

           }else{
               $fadein_h1='';
               $fadein_h2='';
           }

           $img_move=explode(',', $base_all['img_fadein']);

           if ($img_move[0]=='y') {


             $fadein_img='class="wow '.$img_move[1].'" data-wow-delay="1s"';
           }
           else{
            
             $fadein_img='';
           }

          $base_html="";
          $base_html.='<div class="base_div">';
           if (!empty($base_all['title'])) {

            $title=explode("(*)", $base_all['title']);

            if (!empty($title[0])) { $base_html.='<h1 '.$fadein_h1.' class="h1_txt">'.$title[0].'</h1>'; }
            if (!empty($title[1])) { $base_html.='<h1 '.$fadein_h1.' class="h1_txt_2">'.$title[1].'</h1>'; }
            if (!empty($title[2])) { $base_html.='<h1 '.$fadein_h1.' class="h1_txt_2">'.$title[2].'</h1>'; }
             
           }
           if (!empty($base_all['title_two'])) {
              $base_html.='<h2 '.$fadein_h2.' class="h2_txt">'.$h2_word.'</h2>';
           }
           if (!empty($ed_word)) {
            $base_html.='<div class="p_txt">'.$ed_word.'</div>';
           }
           elseif(empty($ed_word) AND !empty($base_all['title_two'])){
            $base_html.='<div class="p_txt"></div>';
           }
          
          

           $base_img=explode(',', $base_all['base_img']);
           for ($j=0; $j <count($base_img)-1 ; $j++) { 
            
            if (empty($base_all['big_img'])) {


              if (check_mobile()) {

                 $base_html.='<img '.$fadein_img.' data-original="../../assets/php/timthumb.php?src=http://rx.znet.tw/rwd_system/product_html/'.$case_id.'/assets/images/'.$base_img[$j].'&w=840&zc=0" alt="">';
              }else{

                 $base_html.='<img '.$fadein_img.' data-original="assets/images/'.$base_img[$j].'" alt="">';
              }

            }
            else{
              $base_html.='<a id="zoom_a" href="'.$base_all['big_img'].'"><p id="big_zoom"><span class="glyphicon glyphicon-zoom-in " aria-hidden="true"></span><br> 點圖放大</p><img data-original="assets/images/'.$base_img[$j].'" alt=""></a>';
            }

             //$base_html.='<img src="assets/images/'.$base_img[$j].'" alt="">'; 

          }

           if ($base_all['line_show']=='y') {
              $base_html.='<h3 class="back_caseName"><hr class="back_hr"/>'.$case['case_name'].'<hr class="back_hr"/></h3>';//底色建案名稱
           }   
           $base_html.='</div>';       
         echo $base_html;
         //echo "$('.content').find('p').addClass('p_txt');";

       }



 // ======================================= GoogleMap ==========================================     

       elseif ($fun_name=='gm') { 

           $map_all=select_map($fun_id[$i]);
            $map_div="<div class='gmap_div'>";
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
           $map_div.='</div>';
           echo $map_div;

       }


// =========================================== 720環景 =================================================

       elseif ($fun_name=='vi') {
          
          $view720=select_view720($fun_id[$i]);
           $view_fun_id=$view720['fun_id'];
          $x_point =explode(',', $view720['x_point']); //X座標
          $y_point=explode(',', $view720['y_point']);  //Y座標
          $point_txt=explode(',', $view720['point_txt']); //名稱
          $point_link=explode(',', $view720['point_link']); //連結

          $view_txt='<div class="view_div">';

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

          if (check_mobile()) {

            $view_txt.='<img data-original="../../assets/php/timthumb.php?src=http://rx.znet.tw/rwd_system/product_html/'.$case_id.'/assets/images/'.$view720['view_img'].'&w=840&zc=0" alt="">';
          }else{

            $view_txt.='<img data-original="assets/images/'.$view720['view_img'].'" alt="">';
          }
          $view_txt.='';
          $view_txt.='<h3 class="back_caseName"><hr class="back_hr"/>'.$case['case_name'].'<hr class="back_hr"/></h3>'; //底色建案名稱
          $view_txt.='';
          $view_txt.='</div>';
          $view_txt.='</div>';

          echo $view_txt;
         
       }


 // ============================================= 錨點加入 =======================================================   

       elseif ($fun_name=='an') {

         $an_aiv='<div id="'.$fun_id[$i].'"></div>';
         echo $an_aiv;
       }


    // ============================================= 房貸試算 ======================================================= 
         
        elseif ($fun_name=='hm') {
           $hm_txt='<div class="tool_div"><a class="nw_btn tool_btn" href="../../assets/php/house_math.php">房貸試算</a></div>';
           echo $hm_txt;
         } 

      // ============================================= 索取DM ======================================================= 
         
        elseif ($fun_name=='dm') {
           $dm_txt='<div class="tool_div"><a class="nw_btn tool_btn" href="../../assets/php/catch_DM.php?case_id='.$case_id.'&case_name='.$case['case_name'].'">索取DM</a></div>';
           echo $dm_txt;
         } 


      // ============================================= 電子報 ======================================================= 
         
        elseif ($fun_name=='nw') {
           $nw_txt='<div class="tool_div"><a class="nw_btn tool_btn" href="../../assets/php/newsletter.php?case_id='.$case_id.'&case_name='.$case['case_name'].'">索取電子報</a></div>';
           echo $nw_txt;
         } 


      // ============================================= 聯絡我們 ======================================================= 
         
        elseif ($fun_name=='ca') {
           $nw_txt='<div class="tool_div"><a class="nw_btn tool_btn" href="../../assets/php/call_we.php?fun_id='.$fun_id[$i].'&case_name='.$case['case_name'].'">聯絡我們</a></div>';
           echo $nw_txt;
         } 


       // ============================================= 圖片牆 ======================================================= 
         
        elseif ($fun_name=='iw') {

        	$img_wall=select_imgwall($fun_id[$i]);
        	$images=explode(',', $img_wall['img_file']);
        	$wall_txt='<div class="grid">';

            for ($m=0; $m <count($images)-1 ; $m++) { 
            	
            	$wall_txt.='<div id="item'.($m+1).'" class="grid-item" style="background-image: url(\'assets/images/'.$images[$m].'\');">
                              <a class="imgwall" rel="wall" href="assets/images/'.$images[$m].'"></a>
                           </div>';
            }
            $wall_txt.='</div>';

            echo $wall_txt;
         } 

   }//for-end
?>