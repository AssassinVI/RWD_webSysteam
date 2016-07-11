<?php include_once 'confige_conn.php'; session_start();
   if (empty($_SESSION['login'])) {
    echo iconv('utf-8', 'big5', "請使用正確管道進入!!");
    exit;
   }
?>
<?php
/* ===========================判斷新增或更新================================= */
if ($_GET["get_pro"] != 0) {
	$pro_det = db_conn_t1("SELECT * FROM app_use WHERE rowid=" . $_GET["get_pro"]); //快速連線方法
	while ($row = mysql_fetch_array($pro_det)) {
		$updata_id = $row["rowid"];
		$subject = $row["subject"];
		$summary = $row["summary"];
		$app_img = explode(",", $row["app_img"]); //圖片陣列
		$updata_down = "app_update";
	}
} else {
	$updata_down = "app_insert";
	$updata_id = "0";
	$subject = "";
	$summary = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>應用實例維護</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="opensource rich wysiwyg text editor jquery bootstrap execCommand html5" />
    <meta name="description" content="This tiny jQuery Bootstrap WYSIWYG plugin turns any DIV into a HTML5 rich text editor" />
    <link rel="apple-touch-icon" href="//mindmup.s3.amazonaws.com/lib/img/apple-touch-icon.png" />
    <link rel="shortcut icon" href="http://mindmup.s3.amazonaws.com/lib/img/favicon.ico">
    <link href="external/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="external/jquery.hotkeys.js"></script>
    <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
    <script src="external/google-code-prettify/prettify.js"></script>
    <link href="index.css" rel="stylesheet">
    <script src="bootstrap-wysiwyg.js"></script>
   <link rel="stylesheet" type="text/css" href="assets/js/jquery-ui.min.css">
   <script type="text/javascript" src="assets/js/jquery-ui.js"></script>
   <style type="text/css" media="screen">
      	#tab_product{

      		padding:25px;
      		background-color:#EDEECE;

      	}
      	#editor_summary{
           clear: left;
           overflow: auto;
      		background-color:#ffffff;
      		border:1px solid #CFCDCC;
      		 padding: 10px;
             border-radius:10px 10px;
      	}
       #toolbar{
        float: left;
         background-color:#AA6B44;
         border:2px solid #CFCDCC;
         padding:9px;
        border-radius:10px 10px;
       }
      label{
        background-color: #EFF755;
        width: 90px;
        padding: 5px;
        padding-left: 10px;
        border: 1px solid #B5B5B5;
        border-radius:5px 5px;
        font-size: 15px;

      }
      .app_imgDiv,#app_uploadDiv{
        float:left;
        background-color:#D4A163;
        padding:7px;
        border:2px solid #583B18;
        margin-right:4px;
        margin-bottom: 8px;
        border-radius:5px 5px;
      }
      .clear_left{
        clear:left;
      }
      .app_imgDiv span{
         background-color:red;
         padding:5px;
         color:#ffffff;
         cursor:pointer;
      }
      #summary_in{
        padding: 10px;
        margin-top: 10px;
        background-color: #CCC0A8;
        width: 80%;
        border-radius:5px 5px;
       border: 2px solid #8E8E8E;
      }
      .back_off{
    background-color:#00AEAE;
    color:#ffffff;
    display:inline-block;
    padding:8px;
    text-decoration:none;
    border-radius:4px 4px ;
    box-shadow:2px 2px 4px #4F4F4F;
   }
   .back_off:hover{
    text-decoration:none;
    box-shadow:0px 0px 1px #4F4F4F;
   }
   </style>
   <script >
   function file_viewer_load(controller,mig_id) { //預覽圖片方法
          if(controller.files[0]==null){
            $("#img_box"+(mig_id)).remove();
          }
          else{
            var file=controller.files[0];
            var fileReader= new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.onload = function(event){
              if ($("#img_box"+mig_id).length>0) {  //判斷HTML元素是否存在
                $("#img_box"+mig_id).attr('src', this.result);
              }
              else{
                $("#img_divDiv").append("<img id='img_box"+mig_id+"' src='"+this.result+"' alt='' style='width: 200px;height: 160px'>");
              }
            };
          }
    }
       $(document).ready(function() {

/* =================================== 多圖增加鈕 =============================================== */
        var patt1=new RegExp(/^[1-9]*$/); //取1以上的值
           var img_id=1;

           $("#img_up").click(function() {  //增加多圖上傳
            if(patt1.test(img_id)){
              var div_id="img_divDiv";
               $("#img_div").append("<div id='file_div"+img_id+"'>實例圖檔"+img_id+"<br><input type='file' id='app_file"+img_id+"' name='app_file"+img_id+"' onchange='file_viewer_load(this,"+img_id+")'></div>");
             }
             else{
            img_id=1;
            $("#img_div").append("<div id='file_div"+img_id+"'>實例圖檔"+img_id+"<br><input type='file' id='app_file"+img_id+"' name='app_file"+img_id+"' onchange='file_viewer_load(this,"+img_id+")></div>");
           }
             img_id++;
             $("#more_img_id").attr('value', img_id);

           }); //增加多圖上傳_end


           $("#img_re").click(function() {  //取消多圖上傳
            if(img_id>=2){
               $("#file_div"+(img_id-1)).remove();
               $("#img_box"+(img_id-1)).remove();
               img_id--;
           }
            $("#more_img_id").attr('value', img_id);
           }); //取消多圖上傳_end

           //內文說明轉存
               $("#app_save").click(function() {
               var appHtml_txt=$("#editor_summary").html();
               $("#app_txt").attr('value',appHtml_txt );
           });
           //內文說明轉存_end

/* ==================================== 多圖展示 ========================================= */
           $.getJSON("service_sql.php?select=get_app&img=more_img&img_id="+<?php echo $updata_id; ?>, function(json) {
              $.each(json.app_img, function() {
              var img_array=new Array();
              if (this['app_img']!=null) {
                 var img_array=this['app_img'].split(",");  //資料庫-圖片名稱陣列
                 $("#update_img_id").attr('value', img_array.length-1);
              }
              for (var i = 0; i < img_array.length-1; i++) {
                 var info="<div class='imgDivDiv'><div class='app_imgDiv'><p><span id='delBtn"+i+"'>刪除</span></p><img style='width:240px;height: 140px;' src='assets/images/demo/portfolio/"+img_array[i]+"'><input type='hidden' name='imgArray"+i+"' value='"+img_array[i]+"' /></div></div>";
                   $("#moreApp_div").append(info);

                $("#delBtn"+i).click(function () {
                  if(confirm("確定要刪除??")){
                   $(this).parentsUntil(".imgDivDiv").remove();
                  // var new_imgId=$("#update_img_id").attr('value');  //刪圖就減一
                  // $("#update_img_id").attr('value', new_imgId-1);
                }
             });

              }
    });
  });//getjson_end

       });//jguery_end
   </script>
   <!-- ==================================HTML編輯器-Toolbar============================================= -->
<script>
    $(function() {
    function initToolbarBootstrapBindings() {
        var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                'Times New Roman', 'Verdana','標楷體','新細明體'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
        $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
        });
        $('a[title]').tooltip({
            container: 'body'
        });
        $('.dropdown-menu input').click(function() {
                return false;
            })
            .change(function() {
                $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
                this.value = '';
                $(this).change();
            });

        $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
                target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
        });
        if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();
            $('#voiceBtn').css('position', 'absolute').offset({
                top: editorOffset.top,
                left: editorOffset.left + $('#editor').innerWidth() - 35
            });
        } else {
            $('#voiceBtn').hide();
        }
    };

    function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
        } else {
            console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
    };
    initToolbarBootstrapBindings();
    $('#editor_summary').wysiwyg({
      fileUploadError: showErrorAlert
    });

    window.prettyPrint && prettyPrint();
});
</script>
</head>
<body style="font-family: Microsoft JhengHei"> <!-- 微軟正黑體 -->
	 <div id="tab_product">
       <h2>更新應用實例 <h4><a class="back_off" href="service_sql.php?del_index=back2">返回</a></h4></h2>
       <form action="service_sql.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
       <p>
      <label for="app_subject_la">標題：</label>
      <input type="text" name="app_subject" id="app_subject_la" placeholder="標題" value=<?php echo $subject; ?> >
      </p>
      <P >
      <label for="pro_file">實例圖上傳 : </label>
      <div id=app_uploadDiv>
        <h5 style="color: red">(請勿取相同檔名)</h5>
        <div id='img_divDiv'></div> <!-- 多圖預覽 -->
        <input type="file" id="app_file" name="app_file0" value="選檔案" onchange="file_viewer_load(this,'0')" ><br>
        <div id="img_div" ></div>
        <button id="img_up" type="button" >增加圖檔</button>
        <button id="img_re" type="button" >取消圖檔</button>
      </div>
      <p id="moreApp_div"> </p>  <!-- ############ 多圖展示Div ############## -->
      </P>
      <div id="summary_in" class="clear_left" >
      <label class="clear_left" >內文說明：</label>
            <div id="toolbar" class="btn-toolbar" data-role="editor-toolbar" data-target="#editor_summary">
            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                <ul class="dropdown-menu">
                </ul>
            </div>
            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li>
                            <a data-edit="fontSize 6">
                                <font size="6">Big Huge</font>
                            </a>
                        </li>
                    <li>
                        <a data-edit="fontSize 5">
                            <font size="5">Huge</font>
                        </a>
                    </li>
                    <li>
                        <a data-edit="fontSize 4">
                            <font size="4">Normal-2</font>
                        </a>
                    </li>
                    <li>
                        <a data-edit="fontSize 3">
                            <font size="3">Normal-1</font>
                        </a>
                    </li>
                    <li>
                        <a data-edit="fontSize 1">
                            <font size="1">Small</font>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="btn-group">
                <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
            </div>
            <div class="btn-group">
                <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
                <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
                <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
            </div>
            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
                <div class="dropdown-menu input-append">
                    <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                    <button class="btn" type="button">Add</button>
                </div>
                <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>
            </div>

            <div class="btn-group">
                <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
            </div>
            <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
        </div>
        <div id="editor_summary" style="width: 80%; min-height: 200px; max-height:200px;">
           <?php echo html_entity_decode(trim($summary, " "), ENT_QUOTES, "UTF-8"); ?>
        </div>
        <br>
         <input type="submit" id="app_save" value="儲存"/>
         <input type="reset" value="重新輸入"/>
         <input type="hidden" value="" name="app_txt" id="app_txt"/>
         <input type="hidden" name="updata_down" value=<?php echo $updata_down; ?> />
          <input type="hidden" name="updata_id" value=<?php echo $updata_id; ?> /> <!--圖片索引-->
          <input type="hidden" id="more_img_id" name="more_img_id" value="1" />   <!--新增的多圖數量-->
          <input type="hidden" id="update_img_id" name="update_img_id" value="" />  <!--更新後多圖數量-->
          </div>
        </form>

</body>
</html>