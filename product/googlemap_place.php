<?php

 if ($_GET) {
   $place_loc=$_GET['place_loc'];
   $type=$_GET['type'];
   $radius=$_GET['radius'];
   $zoom=$_GET['zoom'];
 }

?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>附近景點</title>
	<style type="text/css">
  body{ font-family: Microsoft JhengHei; background-color: hsla(16,13%,25%,1); }
		#map{ width: 100%;height: 500px; }
    #detial{ width: 98%; margin: auto; }
		.del_div{ width: 32%; height: 380px; display: inline-block; text-align: center; margin: 10px 0px 0px 10px; background-color: #5f4f49; color: #fff; }

    .del_div a{ display: inline-block; padding: 12px 45px; margin: 8px 11px; background: #b39c94; text-decoration: none; color: #5f4f49; font-size: 20px; font-weight: 700; border-radius: 4px; }
    .no_photo{margin: 0px; width: 100%; height: 250px; background: #9E9E9E; }

    #back_btn{ position: fixed; bottom: 60px; right: 0px; text-decoration: none; background-color: rgba(255, 255, 255, 0.65); padding: 10px 21px; color: #483c37; font-size: 20px; border-radius: 30px 0px 0px 30px; font-weight: 600;  box-shadow: 1px 3px 4px rgb(0, 0, 0);}

@media only screen and (max-width:1024px){
   .del_div h3{ font-size: 16px; }
}

@media only screen and (max-width:768px){
  #detial{ width: 100%; }
   .del_div { width: 100%; margin: 10px 0px 0px 0px; }
   .del_div h3{ font-size: 16px; }
}

@media only screen and (max-width:420px){
   #map{ height: 350px; }
}
</style>
</head>
<body>

<div id="map" ></div>

<div id="detial"></div>

<a id="back_btn" href="javascript:history.back()">返回</a>


<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDV1hk5SfQxLdftm38V5_3l4lY70jMg6w4&libraries=places"></script>

<script type="text/javascript">
var map;
var infowindow;
var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');//指定視窗物件

var latLng='<?php echo $place_loc?>';
   latLng=latLng.split(',');
// ============================= 專案座標 ==============================
  var pyrmont = {lat: parseFloat(latLng[0]), lng: parseFloat(latLng[1])};

  map = new google.maps.Map(document.getElementById('map'), {
    center: pyrmont,
    zoom: <?php echo $zoom;?>
  });

  infowindow = new google.maps.InfoWindow();

    var cen_mark=new google.maps.Marker({
    position: pyrmont,
    map: map,
    icon:'https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=home|ffeb3b',
  });

    google.maps.event.addListener(cen_mark, 'click', function() {
    infowindow.setContent('合雄心情天');
    infowindow.open(map, this);
  });


// =========================== 地點搜尋 ==================================
var service = new google.maps.places.PlacesService(map); //地方資訊庫
  service.nearbySearch({
    location: pyrmont,
    radius: '<?php echo $radius;?>',
    types: ['<?php echo $type;?>'] //百貨商店    
  }, callback);


// =========================== 建立marker ==================================
function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
    	createMarker(results[i]);
    
    }
  }
}

var x=0;
function createMarker(place) {
  var placeLoc = place.geometry.location;
  var marker = new google.maps.Marker({
    map: map,
    animation: google.maps.Animation.DROP,
    position: placeLoc
  });
   
   if (place.photos!=undefined){
    var del_txt= '<div class="del_div">';
    del_txt=del_txt+'<h3>'+place.name+'</h3>';
    del_txt=del_txt+'<div style="width:100%; height:250px; background: url(\''+place.photos[0].getUrl({'maxWidth': 700, 'maxHeight': 700})+'\') no-repeat center;"></div>';
    del_txt=del_txt+'<a href="#" id="map_place'+x+'" >位置</a>';
    del_txt=del_txt+'<a href="https://www.google.com/maps/dir//'+placeLoc+'/@'+placeLoc+',17z/data=!4m5!1m4!3m3!1s0x0:0x0!2zMjXCsDAyJzE4LjkiTiAxMjHCsDE3JzM2LjEiRQ!3b1?hl=zh-TW">導航</a>';
    del_txt=del_txt+'</div>';

     $("#detial").append(del_txt);
   }
   else{

    var del_txt='<div class="del_div">';
    del_txt=del_txt+'<h3>'+place.name+'</h3>';
    del_txt=del_txt+'<p class=no_photo></p>';
    del_txt=del_txt+'<a href="#" id="map_place'+x+'" >位置</a>';
    del_txt=del_txt+'<a href="https://www.google.com/maps/dir//'+placeLoc+'/@'+placeLoc+',17z/data=!4m5!1m4!3m3!1s0x0:0x0!2zMjXCsDAyJzE4LjkiTiAxMjHCsDE3JzM2LjEiRQ!3b1?hl=zh-TW">導航</a>';
    del_txt=del_txt+'</div>';

     $("#detial").append(del_txt);
   }

  //=================================== marker點擊監聽事件 ===========================================
  		google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(place.name);
           infowindow.open(map, this);
     });


  $("#map_place"+x).click(function(event) {
     event.preventDefault();
     map.setCenter(placeLoc);
     map.setZoom(17);
     
     infowindow.setContent(place.name);
     infowindow.open(map,marker );
     marker.setAnimation(google.maps.Animation.BOUNCE);

     window.setTimeout(function () {
       marker.setAnimation(null);
     },3000);

     $body.animate({ scrollTop: 0 }, 1000);
  });
  x++;
}



</script>
</body>
</html>