<?php include_once 'confige_conn.php'; session_start();
   if (empty($_SESSION['login'])) {
    echo iconv('utf-8', 'big5', "請使用正確管道進入!!");
    exit;
   }
?>
<?php
/* ===========================判斷新增或更新================================= */
if ($_GET["get_pro"] != 0) {
	$pro_det = db_conn_t1("SELECT * FROM product WHERE rowid=" . $_GET["get_pro"]); //快速連線方法
	while ($row = mysql_fetch_array($pro_det)) {
		$updata_id = $row["rowid"];
		$pro_id = $row["pro_id"];
		$pro_name = $row["product_name"];
		$pro_detail = $row["product_detail"];
		$remark = $row["remark"];
		$other_file = $row["other_file"];
		$updata_down = "pro_update";
	}
} else {
	$updata_down = "pro_insert";
	$updata_id = "0";
	$pro_id = "";
	$pro_name = "";
	$pro_detail = "";
	$remark = "";
	$other_file = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>網頁維護後台-<?php echo $pro_name ?></title>
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
      background-color:#DFECEE;
   }
   #editor,#editor_detail{
    overflow:auto;
    width:60%;
    min-height:200px;
    max-height:200px;
   }
   #editor_summary ,#editor_detail{
    overflow:auto;
    background-color:#ffffff;
    border:1px solid #CCCBCB;
   }
   #tab_product{
   	margin:30px;
    margin-top: 10px;
   	padding:20px;
    border-radius: 9px 9px ;
    border: 3px solid #8E8E8E;
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
   .app_imgDiv{
    float:left;
    width:200px;
        background-color:#D4A163;
        padding:0px;
        border:2px solid #583B18;
        margin-right:10px;
        margin-bottom: 8px;
        border-radius:5px 5px;
   }
   .newAndOld{
    background-color:#FFC30F;
    padding:4px;
    margin: 0px;
    border-radius:3px 3px;
    border-bottom:2px solid #583B18;;
   }
    .clear_lef{
        clear:left;
    }
    .padd{
        padding:4px;
    }
    .del_btn{
        display:inline-block;
        padding:3px;
        margin-right:10px;
        background-color:red;
        color:#fff;
        border-radius:3px 3px;
        cursor: pointer;
    }
    #old_del{
        padding:0px;
    }
</style>
<script type="text/javascript">
function file_viewer_load(controller) { //預覽圖片方法
            var file=controller.files[0];
            var fileReader= new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.onload = function(event){
                $("#img_div").html("<div class='app_imgDiv'><p class='newAndOld'>新圖檔</p><img id='img_box' src='"+this.result+"' alt='' style='width: 100%;height: 50%'></div>");
                //img_div.innerHTML ="<img id='img_box' src='"+this.result+"' alt='' style='width: 100px;height: 75px'>";
            };
    }
$(document).ready(function() {

    $("#updata_btn").click(function(){
        var summary_up=$("#editor_summary").html();
        var detail_up=$("#editor_detail").html();
        $("#updata_summary").attr('value', summary_up);
        $("#updata_detail").attr('value', detail_up);
    });
 /* ========================= 更新取圖 AND 附加檔案 ================================= */
               $.getJSON("service_sql.php?select=get_pro&img=one_img&img_id="+<?php echo $updata_id; ?>, function(json) {
              $.each(json.img_txt, function() {
              if (this['img_txt']!=null) {
                 var info="<div class='app_imgDiv'><p class='newAndOld'>舊圖檔</p><img style='width:100%;' src='assets/images/demo/shop/"+this['img_txt']+"'></div>";
                   $("#moreApp_div").append(info);
              }
              if ((this['other_file']!=="") && (this['other_file']!==null) ) {
                var info="<div class='othDivDiv'><div class='app_imgDiv'><p id=old_del class='newAndOld'><span class='del_btn' >Delete</span> 舊附加檔</p><p class='padd'>"+this['other_file']+"</p><input type='hidden' name='oth_del' value='"+this['other_file']+"' /></div></div>";
                   $("#oth_file").html(info);
              }
              $(".del_btn").click(function (){
        if(confirm("確定要刪除??")){
             $(this).parentsUntil(".othDivDiv").remove();
        }
    });
    });
  });//getjson_end
});
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
    $('#editor_detail').wysiwyg({
      fileUploadError: showErrorAlert
    });

    window.prettyPrint && prettyPrint();
});
</script>
</head>


<body style="font-family: Microsoft JhengHei">
<div>
	 <div id="tab_product">
       <h2>更新產品 <h4><a class="back_off" href="service_sql.php?del_index=back1">返回</a></h4></h2>
       <form action="service_sql.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
       <p>
      <label for="pro_id_up">型號：</label>
      <input type="text" name="pro_id" id="pro_id_up" placeholder="編號" value=<?php echo $pro_id; ?> >
      </p>
      <p>
      <label for="pro_name_up">產品名稱：</label>
      <input type="text" name="pro_name" id="pro_name_up" placeholder="產品名稱" value=<?php echo $pro_name; ?> >
      </p>
      <P id="pro_img_p">
      <label for="pro_file">產品主圖上傳 :</label>
        <input type="file" id="pro_file" name="pro_file" value="選檔案" onchange="file_viewer_load(this)"  >
        <div id="img_div" style="width: 200px"></div>
      </P>

      <p id="moreApp_div"> </p>  <!-- ############ 圖展示Div ############## -->
      <p style="clear: left">
      <label >摘要說明：</label>
            <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor_summary">
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
        <div id="editor_summary" style="width: 70%; min-height: 100px; max-height:200px;">
           <?php echo html_entity_decode(trim($pro_detail, " "), ENT_QUOTES, "UTF-8"); ?>
        </div>
      </p>
      <p>
      <label for="pro_detail_up">功能及特性：</label>
      <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor_detail">
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
        <div id="editor_detail">
           <?php echo html_entity_decode(trim($remark, " "), ENT_QUOTES, "UTF-8"); ?>
        </div>
      </p>
      <P>
      <label for="other_file">附加檔案上傳 :</label>
      <input type="file" id="other_file" name="other_file" value="選擇檔案" >
      <div id="oth_file"></div>
      </P>
      <p class="clear_lef">
       <input type="submit" id="updata_btn" value="更新" >
      <input type="reset" name="" value="重新輸入">
      <input type="hidden" name="updata_down" value=<?PHP ECHO $updata_down ?>>
      <input type="hidden" name="updata_id" value=<?php echo $updata_id; ?> >
      <input type="hidden" id="updata_summary" name="updata_summary" value="">  <!-- 暫存摘要說明 -->
      <input type="hidden" id="updata_detail" name="updata_detail" value="">  <!-- 暫存功能特性 -->
      </p>
       </form>
   </div>
</div>
</body>
</html>