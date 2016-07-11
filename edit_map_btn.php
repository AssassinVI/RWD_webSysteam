<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';

      $record_id=addslashes($_GET['record_id']);

      $sql_query="SELECT * FROM google_map_btn WHERE record_id='$record_id'";
      $result=db_conn($sql_query);
      if (mysql_num_rows($result)>0) {
        
         while ($row=mysql_fetch_array($result)) {
        
           $map_food=addslashes($row['map_food']);
           $map_hospital=addslashes($row['map_hospital']);
           $map_home=addslashes($row['map_home']);
           $map_traffic=addslashes($row['map_traffic']);
           $traffic_url=addslashes($row['traffic_url']);
           $map_school=addslashes($row['map_school']);
           $map_fun=addslashes($row['map_fun']);
           $who_other=addslashes($row['who_other']);
           $map_other_name=addslashes($row['map_other_name']);
           $other_keyword=addslashes($row['other_keyword']);
           $map_other_name=explode(',', $map_other_name);
           $other_keyword=explode(',', $other_keyword);
           $btn_style=addslashes($row['btn_style']);
         }
      }
      
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title></title>
	<!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>
    <style type="text/css">
    body{
    	height: auto;
    	background-color: rgb(243,243,244);
      font-family: 微軟正黑體;
    }
    .text_right{
      text-align: right;
    }
    </style>

    <script type="text/javascript">
       $(document).ready(function() {

          $("#cr_btn").click(function(event) {
           
             $.ajax({
               url: 'expand_sql.php',
               type: 'POST',
               data: {
                                page: 'edit_map_btn',
                           record_id: '<?php echo $record_id;?>',
                            map_food: $("#map_food").val(), 
                        map_hospital: $("#map_hospital").val(),
                            map_home: $("#map_home").val(),
                         map_traffic: $("#map_traffic").val(),
                         traffic_url: $("#traffic_url").val(),
                          map_school: $("#map_school").val(),
                             map_fun: $("#map_fun").val(),
                             //額外地圖
                          who_other: $("#sel_who_other").val(),
                     map_other_name: $("#map_other_name1").val()+","+$("#map_other_name2").val()+","+$("#map_other_name3").val(),
                      other_keyword: $("#other_keyword1").val()+","+$("#other_keyword2").val()+","+$("#other_keyword3").val(),
                           //食醫住按鈕樣式
                          btn_style: $("input:radio:checked[name='btn_style']").val()

                     },
                success:function(data) {
                  
                   alert("資料已儲存");
                }
             });
          });

          $("#re_btn").click(function(event) {
            if (confirm('確定要還原顏色??')) {
              $("#map_food").val('#FF9457');
              $("#map_hospital").val('#7f7f7f');
              $("#map_home").val('#c33d3d');
              $("#map_traffic").val('#F1B604');
              $("#map_school").val('#2c6697');
              $("#map_fun").val('#adcf1d');
            }
          });

          <?php

           if (isset($btn_style)) {
             echo '$("#btn_style'.$btn_style.'").attr("checked", "checked");';
           }

          ?>
       }); //jquery END
    </script>
</head>
<body>
	<div id="wrapper" style="background-color:#F0F0F0; padding-top:0px; " >
	 
	 	<div class="wrapper wrapper-content animated fadeInRight">
	 		<div  class="row">
 <!-- =========================================== 編輯地圖(食醫住行育樂) ============================================= -->
              <div  class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-content">
                         <div class="row">
                            <form id="map_btn_form" method="POST" action="expand_sql.php" class="form-horizontal">

                              <div class="form-group">
                                <label class="col-sm-2 control-label">地圖(食):</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                     <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">背景色</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="color" id="map_food" name="map_food" class="form-control" value="<?php echo $map_food;?>">
                                  </div>


                                  <!--<div  class="col-sm-2 text_right">
                                     <input type="radio" name="map_food" value="1">
                                     <label class="control-label">背景圖</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="file" name="" class="form-control" value="">
                                  </div>-->
                              </div>


                              <div class="form-group">
                                <label class="col-sm-2 control-label">地圖(醫):</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                      <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">背景色</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="color" id="map_hospital" name="map_hospital" class="form-control" value="<?php echo $map_hospital;?>">
                                  </div>


                                  <!--<div  class="col-sm-2 text_right">
                                     <input type="radio" name="map_food" value="1">
                                     <label class="control-label">背景圖</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="file" name="" class="form-control" value="">
                                  </div>-->
                              </div>


                              <div class="form-group">
                                <label class="col-sm-2 control-label">地圖(住):</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                     <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">背景色</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="color" id="map_home" name="map_home" class="form-control" value="<?php echo $map_home;?>">
                                  </div>


                                  <!--<div  class="col-sm-2 text_right">
                                     <input type="radio" name="map_food" value="1">
                                     <label class="control-label">背景圖</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="file" name="" class="form-control" value="">
                                  </div>-->
                              </div>


                              <div class="form-group">
                                <label class="col-sm-2 control-label">地圖(行):</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                      <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">背景色</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="color" id="map_traffic" name="map_traffic" class="form-control" value="<?php echo $map_traffic;?>">
                                  </div>


                                  <div  class="col-sm-1 text_right">
                                     
                                     <label class="control-label">URL</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="text" id="traffic_url" name="traffic_url" class="form-control" value="<?php echo $traffic_url;?>">
                                  </div>
                              </div>


                              <div class="form-group">
                                <label class="col-sm-2 control-label">地圖(育):</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                      <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">背景色</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="color" id="map_school" name="map_school" class="form-control" value="<?php echo $map_school;?>">
                                  </div>


                                  <!--<div  class="col-sm-2 text_right">
                                     <input type="radio" name="map_food" value="1">
                                     <label class="control-label">背景圖</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="file" name="" class="form-control" value="">
                                  </div>-->
                              </div>


                              <div class="form-group">
                                <label class="col-sm-2 control-label">地圖(樂):</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                     <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">背景色</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="color" id="map_fun" name="map_fun" class="form-control" value="<?php echo $map_fun;?>">
                                  </div>


                                  <!--<div  class="col-sm-2 text_right">
                                     <input type="radio" name="map_food" value="1">
                                     <label class="control-label">背景圖</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="file" name="" class="form-control" value="">
                                  </div>-->
                              </div>

                              <div class="form-group">
                                <label class="col-sm-2 control-label">額外地圖屬於:</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                      <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">地圖類別</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <select id="sel_who_other" class="form-control">

                                   <?php

                              if (!empty($who_other)) {

                                switch ($who_other) {
                                  case 'other_food':
                                     $other_food='selected';
                                    break;
                                  case 'other_hospital':
                                     $other_hospital='selected';
                                    break;
                                  case 'other_home':
                                     $other_home='selected';
                                    break;
                                  case 'other_traffic':
                                     $other_traffic='selected';
                                    break;
                                  case 'other_school':
                                     $other_school='selected';
                                    break;
                                  case 'other_fun':
                                    $other_fun='selected';
                                    break;
                                }
                              }
                            ?>
                                       <option value="">無須額外地圖</option>
                                       <option value="other_food" <?php echo $other_food;?>>食</option>
                                       <option value="other_hospital" <?php echo $other_hospital;?>>醫</option>
                                       <option value="other_home" <?php echo $other_home;?>>住</option>
                                       <option value="other_traffic" <?php echo $other_traffic;?>>行</option>
                                       <option value="other_school" <?php echo $other_school;?>>育</option>
                                       <option value="other_fun"  <?php echo $other_fun;?>>樂</option>
                                     </select>
                                  </div>

                           
                                 

                              </div>

                              <div class="form-group">
                                <label class="col-sm-2 control-label">額外地圖:</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                      <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">地圖名稱</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="text" id="map_other_name1" name="map_other_name1" class="form-control" value="<?php echo $map_other_name[0];?>">
                                  </div>
                                  <div  class="col-sm-1 text_right">
                                     <label class="control-label">地圖關鍵字</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="text" id="other_keyword1" name="other_keyword1" class="form-control" value="<?php echo $other_keyword[0];?>">
                                  </div>
                              </div>


                              <div class="form-group">
                                <label class="col-sm-2 control-label">額外地圖2:</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                      <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">地圖名稱</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="text" id="map_other_name2" name="map_other_name2" class="form-control" value="<?php echo $map_other_name[1];?>">
                                  </div>
                                  <div  class="col-sm-1 text_right">
                                     <label class="control-label">地圖關鍵字</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="text" id="other_keyword2" name="other_keyword2" class="form-control" value="<?php echo $other_keyword[1];?>">
                                  </div>
                              </div>


                              <div class="form-group">
                                <label class="col-sm-2 control-label">額外地圖3:</label>
                                  
                                  <div  class="col-sm-2 text_right">
                                      <!--<input type="radio" name="map_food" value="0">-->
                                     <label class="control-label">地圖名稱</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="text" id="map_other_name3" name="map_other_name3" class="form-control" value="<?php echo $map_other_name[2];?>">
                                  </div>
                                  <div  class="col-sm-1 text_right">
                                     <label class="control-label">地圖關鍵字</label>
                                  </div>
                                  <div  class="col-sm-3">
                                     <input type="text" id="other_keyword3" name="other_keyword3" class="form-control" value="<?php echo $other_keyword[2];?>">
                                  </div>
                              </div>

                              <div class="form-group">
                                 <label class="col-sm-2 control-label">按鈕樣式:</label>

                                 <div  class="col-sm-5">
                                    <input id="btn_style0" type="radio" name="btn_style" value="0">
                                    <div><img src="shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/食醫住按鈕樣式1.PNG&w=300&zc=0"></div>
                                 </div>
                                 <div  class="col-sm-5">
                                    <input id="btn_style1" type="radio" name="btn_style" value="1">
                                    <div><img src="shared_php/timthumb.php?src=http://rx.znet.tw/rwd_system/Static_Seed_Project/img/食醫住按鈕樣式2.PNG&w=300&zc=0"></div>
                                 </div>

                              </div>


                                <div class="form-group">
                                <label class="col-sm-5 control-label"></label>
                                <div id="con_box" class="col-sm-2">
                                <button id="re_btn"  class="btn btn-primary dim" type="button" >還原預設顏色</button>
                                <button id="cr_btn"  class="btn btn-primary dim" type="button" >儲存</button>
                                </div>
                                </div>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
	 		</div>
	 	</div>
</div>
</body>
</html>