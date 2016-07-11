<?php include 'config.php'; ?>
<?php 
 
/* ============================ 建案收尋 ==================================== */
 function select_case($case_id)
 {
  $select_case=db_conn("SELECT case_name, format, floor, build_com, Consignment, marquee, other, build_adds, google_an, google_code, bu_phone, line_tool, bu_line, bu_fb, activity_img, activity_song FROM build_case WHERE case_id='$case_id'");
  while ($row=mysql_fetch_array($select_case)) {
  	     
       $case_array=array('case_name'=>$row['case_name'], 
       	                    'format'=>$row['format'], 
       	                     'floor'=>$row['floor'], 
       	               'Consignment'=>$row['Consignment'], 
                           'marquee'=>$row['marquee'], 
       	                     'other'=>$row['other'], 
       	                'build_adds'=>$row['build_adds'], 
       	                 'google_an'=>$row['google_an'], 
                       'google_code'=>$row['google_code'],
       	                  'bu_phone'=>$row['bu_phone'], 
       	                     'bu_fb'=>$row['bu_fb'],
                      'activity_img'=>$row['activity_img'],
                     'activity_song'=>$row['activity_song'],
                         'line_tool'=>$row['line_tool'],
                           'bu_line'=>$row['bu_line']
       	                     );
  }
  return $case_array;
 }



  /* ================================ 關連索引收尋 ========================================== */
  function select_rel($case_id)
  {
    $rel_array=array();

     $select_rel=db_conn("SELECT fun_name, fun_id FROM Related_tb WHERE case_id='$case_id' ORDER BY sort");
  while ($row=mysql_fetch_array($select_rel)) {
     
    array_push($rel_array, $row['fun_id']);

    }
    return $rel_array;
  }
 


/* ============================ 幻燈片收尋 ==================================== */
  function select_show($fun_id)
{
   $select_show=db_conn("SELECT * FROM slideshow_tb WHERE fun_id='$fun_id'");
   while ($row=mysql_fetch_array($select_show)) {
     $show_all=array('show_img'=>$row['show_img'], 
                     'play_speed'=>$row['play_speed']
                     );
   }
   return $show_all;
}
  

  /* ============================ YouTube收尋 ==================================== */
  function select_you($fun_id)
  {
     $select_you=db_conn("SELECT you_adds, you_title FROM youtube_tb WHERE fun_id='$fun_id'");
     while ($row=mysql_fetch_array($select_you)) {
       $you_all=array('you_adds'=>$row['you_adds'], 
                     'you_title'=>$row['you_title']
                     );
     }
      return $you_all;
  }
  

  /* ============================ 基本圖文收尋 ==================================== */
  function select_base($fun_id)
  {
    $select_base= db_conn("SELECT * FROM base_word WHERE fun_id='$fun_id'");
    while ($row=mysql_fetch_array($select_base)) {
       $base_all=array('title'=>$row['title'],
                   'title_two'=>$row['title_two'], 
                   'edit_word'=>$row['edit_word'], 
                    'base_img'=>$row['base_img'], 
                  'txt_fadein'=>$row['txt_fadein'], 
                  'img_fadein'=>$row['img_fadein'],
                   'line_show'=>$row['line_show'],
                     'big_img'=>$row['big_img']
                  );
    }
    return $base_all;
  }
 

   /* ============================ GoogleMap收尋 ==================================== */
   function select_map($fun_id)
   {
     $select_map=db_conn("SELECT mark_img, map_position, mark_txt, map_title FROM googlemap_tb WHERE fun_id='$fun_id'");
      while ($row=mysql_fetch_array($select_map)) {
         $map=array('mark_img'=>$row['mark_img'], 
                'map_position'=>$row['map_position'], 
                    'mark_txt'=>$row['mark_txt'],
                    'map_title'=>$row['map_title']
                    );
      }
      return $map;
   }
  


  /* =================================== 錨點加入 ============================================= */
   function select_anchor($fun_id)
   {
      $select_anchor=db_conn("SELECT anchor_name FROM anchor_tb WHERE fun_id='$fun_id'");
      while ($row=mysql_fetch_array($select_anchor)) {
         $anchor_name=$row['anchor_name'];
      }
      return $anchor_name;
   }


   /* ==================================== 720環景 ================================================== */
   function select_view720($fun_id)
   {
     $select_view720=db_conn("SELECT * FROM view720_tb WHERE fun_id='$fun_id'");
     while ($row=mysql_fetch_array($select_view720)) {
       $view720 = array('view720_title'=>$row['view720_title'], 
                             'view_img'=>$row['view_img'],
                               'fun_id'=>$row['fun_id'],
                              'x_point'=>$row['x_point'],
                              'y_point'=>$row['y_point'],
                            'point_txt'=>$row['point_txt'],
                           'point_link'=>$row['point_link']
                         );
     }
     return $view720;
   }

  
  /* ==================================== 顏色更改 ================================================== */
   function select_color($case_id)
   {
     $select_color=db_conn("SELECT * FROM color WHERE case_id='$case_id'");
     while ($row=mysql_fetch_array($select_color)) {
        $color=array('h1_color'=>$row['h1_color'],
                     'h2_color'=>$row['h2_color'],
                      'p_color'=>$row['p_color'],
                      'marquee'=>$row['marquee'],
                      'top_txt'=>$row['top_txt'],
                      'top_bar'=>$row['top_bar'],
                   'back_color'=>$row['back_color']
                  );
     }
     return $color;
   }


 /* ==================================== 地圖(食醫住行育樂) ================================================== */
   function select_map_btn($case_id)
   {
     $select_map_btn=db_conn("SELECT * FROM expand_record INNER JOIN google_map_btn ON expand_record.record_id=google_map_btn.record_id WHERE case_id='$case_id'");
     while ($row=mysql_fetch_array($select_map_btn)) {
        $map_btn=array(  'map_food'=>$row['map_food'],
                     'map_hospital'=>$row['map_hospital'],
                         'map_home'=>$row['map_home'],
                      'map_traffic'=>$row['map_traffic'],
                      'traffic_url'=>$row['traffic_url'],
                       'map_school'=>$row['map_school'],
                          'map_fun'=>$row['map_fun'],
                   'map_other_name'=>$row['map_other_name'],
                    'other_keyword'=>$row['other_keyword'],
                        'who_other'=>$row['who_other'],
                           'is_use'=>$row['is_use'],
                        'btn_style'=>$row['btn_style']
                  );
     }
     return $map_btn;
   }

  /* ============================ 聯絡我們新增 ==================================== */
 //  db_conn("INSERT INTO call_us_tb (call_name, call_ph, call_em, call_q, call_ti, call_con) VALUES ('$call_name', '$call_ph', '$call_em', '$call_q', '$call_ti', '$call_con')");
?>