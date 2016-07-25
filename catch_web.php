<?php require_once 'shared_php/config.php';

 $case_id=htmlspecialchars($_GET['case_id']);

  $pdo=pdo_conn(); //資料庫連線
  $sql_q=$pdo->prepare("SELECT record_id FROM expand_record WHERE case_id=:case_id AND tool_id='tool20160624002' AND is_use='1'");
  $sql_q->bindparam(":case_id", $case_id);
  $sql_q->execute();
  while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
    $record_id=$row['record_id'];
  }
  $pdo=NULL;
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
	<meta charset="UTF-8">
	<title>取網址</title>
	<!-- 外掛AND CSS -->
    <?php include 'shared_php/script_style.php';?>
    <style type="text/css">
    	body{
    		background-color: #fff;
    		height: 650px;
    	}
        #box{
            height: 250px;
        }
     .logo_qr{
      position: relative;
      width: 150px;
      height: 150px;
     }
     #logo_div{
       position: absolute;
       width: 50px;
       height:50px;
       margin:auto;
       top:0px;
       left: 0px;
       right: 0px;
       bottom: 0px;
     }
     #put_logo_div{
      
       padding-bottom: 10px;
     }
    #logo_div img{
      width: 50px;
      height: 50px;
    }
    .margin_div{
      margin-top:7px;
      margin-bottom: 7px; 
    }
    .size15{
      font-size: 15px;
    }
    </style>

    <script type="text/javascript">

    	$(document).ready(function() {

            var long_url="http://rx.znet.tw/rwd_system/product_html/<?php echo $case_id;?>/Default.php";

         // ====================== 短網址 ==========================
            	$.ajax({
    			url: 'https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyDV1hk5SfQxLdftm38V5_3l4lY70jMg6w4',
    			type: 'POST',
    			dataType: 'json',
    			data: JSON.stringify({longUrl:long_url}),
    			contentType : "application/json",
    			success:function (result,status,xhr) {
    				if (status=="success") {
                       $("#short_url").html(result.id);
                       $("#short_url").attr('href', result.id);
                       
    				}
    			}
    		  }); 

           // ========================= 簡訊短網址 ==================================  
           var qr_code_url=catch_url('簡訊','簡訊','一般'); 
           get_shortURL(qr_code_url,'#ph_short_url');

           // ====================== QR_Code報紙 ==========================
          var qr_code_url=qrcode_url("報紙","一般");
          get_qrcode(qr_code_url,'#qr_code','#qr_url');


          $("#sel_mar").change(function(event) {
            if ($(":selected").val()=="news") {

                 var qr_code_url=qrcode_url("報紙","一般");
                 get_qrcode(qr_code_url,'#qr_code','#qr_url');
            }
            else if($(":selected").val()=="mag"){
                 
                 var qr_code_url=qrcode_url("雜誌","一般");
                 get_qrcode(qr_code_url,'#qr_code','#qr_url');
            }
            else if($(":selected").val()=="dm"){

                 var qr_code_url=qrcode_url("DM","一般");
                 get_qrcode(qr_code_url,'#qr_code','#qr_url');
            }
          });

          
        //============================ 手動媒介 =============================
         $("#sel_txtBtn").click(function(event) {
            var source=$("#sor_txt").val();
            var medium=$("#sel_txt").val();
            var campaign=$("#com_txt").val();
              //短網址
              var qr_code_url=catch_url(source,medium,campaign); 
              get_shortURL(qr_code_url,'#new_short_url');
             //QR_Code
             var qr_code_url=qrcode_url(medium,campaign);
             get_qrcode(qr_code_url,'#qr_code','#qr_url');
         });
    	});//jquery_END

/* =================================== 產生短網址 ============================================= */
      function get_shortURL(get_url,show_id) {
        
         $.ajax({
          url: 'https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyDV1hk5SfQxLdftm38V5_3l4lY70jMg6w4',
          type: 'POST',
          dataType: 'json',
          data: JSON.stringify({longUrl:get_url}),
          contentType : "application/json",
          success:function (result,status,xhr) {
            if (status=="success") {
                       
               $(show_id).html(result.id);
               $(show_id).attr('href', result.id);
            }
          }
         });
      }

/* =================================== 產生QR code ============================================= */
      function get_qrcode(get_url,show_id,put_id) {
        
         $.ajax({
          url: 'https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyDV1hk5SfQxLdftm38V5_3l4lY70jMg6w4',
          type: 'POST',
          dataType: 'json',
          data: JSON.stringify({longUrl:get_url}),
          contentType : "application/json",
          success:function (result,status,xhr) {
            if (status=="success") {
                       //產生QR_code
              var qr_url='http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='+result.id+'&chld=H|0';
               $(show_id).attr('src', qr_url);
              $(put_id).attr('value', qr_url);
            }
          }
         });
      }

/* =================================== 追蹤網址 ============================================= */
      function catch_url(source,medium,campaign) {
         var qr_code_url="http://rx.znet.tw/rwd_system/product_html/<?php echo $case_id;?>/Default.php?utm_source="+source+"&utm_medium="+medium+"&utm_campaign="+campaign;
         return qr_code_url;
      }
/* =================================== QR code網址 ============================================= */
      function qrcode_url(medium,campaign) {
         var qr_code_url="http://rx.znet.tw/rwd_system/product_html/<?php echo $case_id;?>/Default.php?utm_source=QR_Code&utm_medium="+medium+"&utm_campaign="+campaign;
         return qr_code_url;
      }
   
    
  // ==========================預覽圖片方法======================================
    function file_viewer_load(controller) { 

            var file=controller.files[0];
             if (file==null) {
                $('#qr_logo').html('');
             }
             else{
                var fileReader= new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onload = function(event){

                $("#logo_div").find('img').attr('src', this.result);
             }
            };
          }

    </script>
</head>
<body style="font-family: 微軟正黑體">
<div id="box" style="width:70%;margin: auto;">
 <h3> 複製此網址:</h3>
	<a target="_blank" href="http://rx.znet.tw/rwd_system/product_html/<?php echo $case_id;?>/Default.php">http://rx.znet.tw/rwd_system/product_html/<?php echo $case_id;?>/Default.php</a>
   <h3>短網址:</h3>
   <p><a target="_blank" id="short_url"></a></p>
   <h3>簡訊短網址:</h3>
   <p><a target="_blank" id="ph_short_url"></a></p>

   <?php

    if (!empty($record_id)) {
      
      echo '<h3>顧客問卷網址:</h3>';
      echo '<p><a target="_blank" href="from_all/from_view.php?record_id='.$record_id.'" >http://rx.znet.tw/rwd_system/Static_Seed_Project/from_all/from_view.php?record_id='.$record_id.'</a></p>';
    }
   ?>
   
  <hr><!-- 分隔線 -->
<h3>QR Code:</h3>
<form method="POST" action="shared_php/qr_code_merger.php" enctype='multipart/form-data'>
   <div id="put_logo_div">
       <label for="qr_logo">LOGO:</label>
       <input type="file" accept="image/*" id="qr_logo" name="qr_logo" accept="image/*" onchange="file_viewer_load(this)">
       <p>*直接下載為QR_code原圖，也可以選擇一個LOGO做結合</p>
     </div>
     
     <label class="size15" for="sel_mar">預設媒介:</label>
     <select id="sel_mar" class="size15">
       <option value="news">報紙</option>
       <option value="mag">雜誌</option>
       <option value="dm">DM</option>
     </select>
     <br>
     <br>

     <label class="size15">來源:</label>
    <input id="sor_txt" type="text" value="QR_Code" name="">

    <label class="size15">媒介:</label>
    <input id="sel_txt" type="text" name="">

    <label class="size15">活動名稱:</label>
    <input id="com_txt" type="text" name="" value="一般">

    <button type="button" id="sel_txtBtn">產生QR Code與網址</button>

  <div class="margin_div">
       <button id="qr_btn" type="submit" class="btn btn-primary">下載QR Code</button><br><br>

       <h3>短網址:</h3>
       <p><a target="_blank" id="new_short_url"></a></p>

       <div class="logo_qr">
         <div id="logo_div"><img src="" alt=""></div><!--LOGO-->
         <img id="qr_code" src="" alt="">
       </div>
  </div>


   <input type="hidden" id="qr_url" name="qr_url" value="">

</form>
</body>
</html>