<!-- 產品新增,圖片無法配對 -->
<!-- 產品新增.更新,無法跳轉到產品頁面 -->
<?php include 'confige_conn.php'; session_start();
   if (empty($_SESSION['login'])) {
    echo iconv('utf-8', 'big5', "請使用正確管道進入!!");
    exit;
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>網頁維護後台</title>
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
   #tab_company,#tab_product,#tab_use {
      font-family: Microsoft JhengHei;
   }
   #editor{
    overflow:auto;
    width:100%;
    min-height:550px;
   }
   
   #text_enter{
    width:100px;
    height:50px;
    font-size:25px;
    border-radius:10px 10px ;
   }
   #text_enter:hover{
    background-color:#767E88;
    color:#ffffff;
    box-shadow:5px 5px 4px #555658;
   }
   .btn_pro{
   float:left;
    display:back;
    text-decoration:none;
    background-color:#EFA400;
    padding:6px;
    margin-right:50px;
    margin-top:10px;
    margin-bottom:10px;
    box-shadow:3px 3px 5px #5F5D5D;
   }
   #tabs ,#tab_product ,#tab_use{
    float:left;
     font-family: Microsoft JhengHei;
     width:90%;
   }
   .pro_box{
    float:left;
    width:100%;
   }
   .btn_new{

    display:back;
    text-decoration:none;
    background-color:#EFA400;
    padding:6px;
    box-shadow:3px 3px 5px #5F5D5D;
    margin-bottom:2px;
   }
   .btn_new:hover{
    box-shadow:1px 1px 15px #FFD900;
   }
   .flo_right{
    float:right;
   }
</style>
<script type="text/javascript">
function session_clear() {
  sessionStorage.clear();
}
$(document).ready(function() {
  getjson_app();
  getjson_pro();
    $("#tabs").tabs();
      $("#tabs").tabs("option","active",sessionStorage.tabs_index);

         
/* @@@@@@@@@@@@@@@@@@@@@@@ 撈取產品資料 @@@@@@@@@@@@@@@@@@@@@@@@@@ */
function getjson_pro() {
    $.getJSON("service_sql.php?select=get_pro&img=", function(json) {
        $.each(json.select_pro, function() {
                    var info="<p class='btn_pro'><a>"+this['product_name']+" </a> <br/> <img style='width:140px;height: 170px;' src='assets/images/demo/shop/"+this['img_txt']+"' ><br/> <a class='btn_tool' href='back_station_detail.php?get_pro="+this['rowid']+"'>更新 </a> <button id='"+this['rowid']+"' class='pro_delBtn btn_tool' type='submit' >刪除 </button></p>";
                    $("#pro_div").append(info);
                    $(".btn_tool").button();
                   del_btn("pro_delete",".pro_delBtn",1);
    });
  });
}

/* @@@@@@@@@@@@@@@@@@@@@@@ 撈取實例資料 @@@@@@@@@@@@@@@@@@@@@@@@@@ */
  function getjson_app() {
    $.getJSON("service_sql.php?select=get_app&img= ", function(json) {
        $.each(json.select_app, function() {
              var img_array=new Array();
              if (this['app_img']!=null) {
                 var img_array=this['app_img'].split(",");  //圖片名稱陣列
              }
                    var info="<p class='btn_pro'><a>"+this['subject']+" </a> <br/><img style='width:240px;height: 140px;' src='assets/images/demo/portfolio/"+img_array[0]+"' ><br/> <a class='btn_tool' href='back_station_appDetail.php?get_pro="+this['rowid']+"'>更新 </a><button id='"+this['rowid']+"' class='app_delBtn btn_tool' type='submit'  >刪除 </button></p>";
                    $("#app_div").append(info);
                    $(".btn_tool").button();
                   del_btn("app_detele",".app_delBtn",2);
    });
  });
}

/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 彈出視窗 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
function del_btn(updata_down,btn_id,del_index) {
   $(btn_id).click(function(event) {
   event.preventDefault();
   var app_id=$(this).attr('id');
            $("#dialog").dialog({
        buttons:{
          "確定":function () {
            $.ajax({
              url: 'service_sql.php',
              type: 'POST',
              data: {updata_down: updata_down,id:app_id},
              dataType:'json',
            });
            location.assign("service_sql.php?del_index="+del_index);

          },
          "取消":function () {
            $(this).dialog("close");
          }
        }
      });
    });//click
}
});//jquery_end
</script>
<script>
$ (function() {
    $("#text_enter").click(function() { //簡介更新按鈕
       var html_text=$("#editor").html();
       $("#company_text").attr('value', html_text); //替換暫存資料
    });
    /* ==================================HTML編輯器-Toolbar============================================= */
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
    $('#editor').wysiwyg({
        fileUploadError: showErrorAlert
    });
    window.prettyPrint && prettyPrint();
});
</script>
</head>
<body onbeforeunload="session_clear()">
<div id="tabs" >
<ul>
  <div class="flo_right"> 
  <span>使用者:<?php echo $_SESSION["name"]; ?></span>  
  <a href="service_sql.php?login_out=out">登出</a>
  </div>
   <li><a href="#tab_company">公司簡介</a></li>
   <li><a href="#tab_product">產品介紹</a></li>
   <li><a href="#tab_use">應用實例</a></li>
</ul>

<!-- ==============================================公司簡介============================================= -->
   <div id="tab_company">
   	<h2>公司簡介</h2>
   	<form action="service_sql.php" method="POST" accept-charset="utf-8">

   		<div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                <ul class="dropdown-menu">
                </ul>
            </div>
            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li>
                            <a data-edit="fontSize 8">
                                <font size="8">Big Huge</font>
                            </a>
                        </li>
                    <li>
                        <a data-edit="fontSize 5">
                            <font size="5">Huge</font>
                        </a>
                    </li>
                    <li>
                        <a data-edit="fontSize 3">
                            <font size="3">Normal</font>
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
                <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
                <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
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
                <a class="btn" title="Insert picture (or just drag and drop)" id="pictureBtn"><i class="icon-picture"></i></a>
                <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
            </div>
            <div class="btn-group">
                <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
            </div>
            <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
        </div>
        <div id="editor" >
            <?php
$query = db_conn_t1("SELECT cp_text FROM cpmpany_text WHERE id=1"); //連資料庫方法
while ($row = mysql_fetch_array($query)) {
	echo html_entity_decode($row["cp_text"], ENT_QUOTES, "UTF-8");
}
?>
        </div>
        <br/>
        <button id="text_enter" type="submit"><b>更新</b></button>


         <input id="company_text" type="hidden" name="company_text" value=""> <!-- 暫存公司介紹 -->
         <input type="hidden" name="updata_down" value="updata">
   	</form>
   </div>

  <!--  ===============================產品簡介=====================================================-->

   <div id="tab_product">
       <h2>更新產品
          <h4><a class="btn_tool btn_new" href="back_station_detail.php?get_pro=0">新增產品</a></h4>
       </h2>
      <!-- <form action="del_pro.php" method="POST" accept-charset="utf-8">   刪除用 -->
       <div id="pro_div" class="pro_box">

      </div>
     <!--  </form>-->
       <div id=dialog title="確定要刪除??"></div>
   </div>

   <!-- ==========================================應用簡介=========================================== -->

   <div id="tab_use">
    <h2>更新實例
       <h4><a class="btn_tool btn_new" href="back_station_appDetail.php?get_pro=0">新增實例</a></h4>
     </h2>
    <form action="service_sql.php" method="POST">
      <div id="app_div" class="pro_box">
      </div>
      </form>
   </div>
</div>
</body>
</html>