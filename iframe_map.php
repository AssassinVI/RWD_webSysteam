<?php include 'shared_php/login_session.php';

      include 'shared_php/config.php';

?>



<?php 

  if (empty($_GET['funId'])) {

    

       /*################# 給GoogleMap ID ##################*/    

          $result = db_conn("SELECT fun_id FROM googlemap_tb WHERE fun_id LIKE 'gm".date('Ymd')."%' ORDER BY fun_id DESC LIMIT 1" );

          if (mysql_num_rows($result)<1) {
              $fun_id='gm'.date('Ymd').'001';
           }else{

             while ($row=mysql_fetch_array($result)) {

              $fun_id_down =(int)substr($row['fun_id'], 10);
              $sum=$fun_id_down+1;
                    if ($sum<10) {
                      $sum="00".$sum;
                    }elseif ($sum<100) {
                      $sum="0".$sum;
                    }
                    $fun_id='gm'.date('Ymd').$sum;
          }
      }

      // ===================經度==========================
      $lon=24.9938617;
      // ===================緯度==========================
      $lat=121.30167989999995;
  }

  else{

      $case_id=htmlspecialchars($_POST['case_id']);
      $fun_id=htmlspecialchars($_GET['funId']);
      $result = db_conn("SELECT map_position, mark_txt, map_title FROM googlemap_tb WHERE fun_id='$fun_id' " );
      while ($row=mysql_fetch_array($result)) {

         $map_position=$row['map_position'];
         $mark_txt=$row['mark_txt'];
         $map_title=$row['map_title'];
 
         $map_title=explode("(*)", $map_title);
         if (!empty($map_title[0])) { $map_title1=$map_title[0]; }
         if (!empty($map_title[1])) { $map_title2=$map_title[1]; }
         if (!empty($map_title[2])) { $map_title3=$map_title[2]; }

         $Latlon=explode(',', $map_position);
         // ===================經度==========================
         $lon=(double)$Latlon[0];
         // ===================緯度==========================
         $lat=(double)$Latlon[1];
      }



      /* 抓取建案名稱 */

      $result = db_conn("SELECT case_name FROM build_case WHERE case_id='$case_id' " );

      while ($row=mysql_fetch_array($result)) {

        $case_name=$row['case_name'];

      }

  }
 ?>





<!DOCTYPE html>

<html >

<head>

	<meta charset="UTF-8">

	 <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title></title>

	<!-- ================================== 外掛and CSS ====================================== -->

    <?php include 'shared_php/script_style.php';?>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDV1hk5SfQxLdftm38V5_3l4lY70jMg6w4"></script>

    <style type="text/css">

     body{

  height: auto;

  background-color: rgb(243,243,244);

     }



     #map_box{

        width: 100%;

        height:350px;

    }

    </style>

<script type="text/javascript">

    $(document).ready(function() {




 /* ============================== 開啟查詢地址座標 ===================================== */

          $(".map_fancybox").fancybox({

               'width'                 : '80%',
               'height'               : '80%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });


         /* ============================== Google Map ============================== */

         var mapoption={

             mapTypeControl: false,

             streetViewControl: false,

            zoomcontrol:true,

            scaleControl: true,

            center:new google.maps.LatLng(<?php echo $lon;?>,<?php echo $lat;?>),

            zoom:15



         };

         //google 經緯度轉地址物件

         var geocoder=new google.maps.Geocoder();

         // google.maps.LatLng 物件

         var coord=new google.maps.LatLng(<?php echo $lon;?>,<?php echo $lat;?>);



         geocoder.geocode({'latLng': coord}, function (result ,status) {

             if (status === google.maps.GeocoderStatus.OK) {

                var adds=result[0].formatted_address;


                /* MAP物件 */
               var map=new google.maps.Map(document.getElementById('map_box'),mapoption);
                /* 標記物件 */
               var marker=new google.maps.Marker({
                   map:map,
                   position:map.getCenter()
                  // icon:'assets/images/RWD/icom/marker02.png'

             });

               var info_txt="<b><?php echo $case_name;?> <br> 地址: "+adds+"</b>";

               /* 說明視窗物件 */

              var info=new google.maps.InfoWindow();
              info.setContent(info_txt);
              info.open(map, marker);
                google.maps.event.addListener(marker, 'click', function() {
                  info.open(map, marker);

                });
           /* $("#map_position").change(function(event) {
            var location= $("#map_position").val().split(',');
             var lat=parseFloat(location[0]);
             var lng=parseFloat(location[1]);
             var new_lat=new google.maps.LatLng(lat,lng);
             map.setCenter(new_lat,15);
         });*/
             }
             else{
               alert('經緯度輸入錯誤');
             }

         });


    });










</script>

</head>

<body >

<div id="wrapper" style="background-color:#F0F0F0; padding-top:0px; " >
	 	<div class="wrapper wrapper-content animated fadeInRight">
	 		<div  class="row">
 <!-- =========================================== GoogleMap ============================================= -->
              <div id="map" class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>GoogleMap區塊編輯 </h5>
                        </div>
                        <div class="ibox-content">
                         <div class="row">
                            <form method="POST" action="rwd_php_sys.php" class="form-horizontal">
                              
                                <!--<div class="form-group"><label class="col-sm-2 control-label">Mark圖檔</label>
                                    <div class="col-sm-10"><input type="file" class="form-control" ></div>
                                </div>-->
                                <div class="form-group">
                                   <label class="col-sm-1 control-label">主標1</label>
                                    <div class="col-sm-3"><input type="text" class="form-control" name="map_title1" value="<?php echo $map_title1;?>"></div>

                                    <label class="col-sm-1 control-label">主標2</label>
                                    <div class="col-sm-3"><input type="text" class="form-control" name="map_title2" value="<?php echo $map_title2;?>"></div>

                                     <label class="col-sm-1 control-label">主標3</label>
                                    <div class="col-sm-3"><input type="text" class="form-control" name="map_title3" value="<?php echo $map_title3;?>"></div>

                                    <label class="col-sm-1 control-label"></label>
                                    <div class="col-sm-10"><span class="help-block m-b-none">說明:主標可以一個或三個，最多三個，字數最大不可超過10個字</span></div> 
                                </div>
                                <div class="form-group"><label class="col-sm-1 control-label">Map座標</label>
                                    <div class="col-sm-10"><input type="text" id="map_position" class="form-control" name="map_position" value="<?php echo  $map_position; ?>"><span class="help-block m-b-none"><a id="check_map_btn" class="map_fancybox" href="check_map.html" >查詢地址座標</a></span></div>
                                </div>

                                <div class="form-group"><label class="col-sm-1 control-label">座標文字</label>
                                    <div class="col-sm-10"><input type="text" id="mark_txt" class="form-control" name="mark_txt" value="<?php echo $mark_txt;?>"></div>
                                </div>
                              <!--  <div class="ibox-content no-padding">
                             <div class="ibox-title">
                            <h5>座標說明文</h5>
                             </div>
                                <div class="summernote">
                             </div>
                        </div>-->
                        <div class="form-group">
                                <label class="col-sm-10 control-label"></label>
                                <div class="col-sm-2">
                                <button  class="btn btn-primary dim  " type="submit" > 送出</button>
                                </div>
                                </div>
                                <input  type="hidden" name="page" value="map">
                                <input type="hidden" name="case_id" value="<?php echo $_POST['case_id'];?>">
                                <input type="hidden" name="fun_id" value="<?php echo $fun_id ; ?>" />
                                <input type="hidden" name="rel_sort" value="<?php echo $_POST['rel_sort'];?>">
                            </form>

                            <!-- 顯示地圖 -->

                            <div id="map_box" class="col-sm-10"></div>
                          </div>
                        </div>
                    </div>
                </div>
	 		</div>
	 	</div>
</div>
</body>
</html>