<?php require_once 'shared_php/config.php';
      require_once 'shared_php/login_session.php';

      if ($_SESSION['competence']!='admin') {
    header('Location: http://rx.znet.tw/rwd_system/Static_Seed_Project/500.html');
    exit;
  }

 $case_id=addslashes($_GET['case_id']);

 $sql_query="SELECT * FROM expand_tb LEFT JOIN expand_record ON expand_tb.tool_id=expand_record.tool_id WHERE expand_record.case_id='$case_id'";

?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
	<meta charset="UTF-8">
	<title>擴充</title>
	<!-- 外掛AND CSS -->
    <?php include 'shared_php/script_style.php';?>
    <style type="text/css">
    	body{
    		background-color: #fff;
    		height: 650px;
        font-family: 微軟正黑體
    	}
    div{
      padding: 7px;
    font-size: 17px;
    }
    button{
    float: right;
    
    color: #fff;
    border: none;
    padding: 2px 10px 2px 10px;
    border-radius: 5px;

    transition: padding 0.5s;
  -moz-transition: padding 0.5s;  /* Firefox 4 */
  -webkit-transition: padding 0.5s; /* Safari 和 Chrome */
  -o-transition: padding 0.5s;  /* Opera */
    }
    .use_btn{
      background-color:green;
    }
    .not_use{
      background-color: #ed5565;
    }
    button:hover{
      padding: 2px 12px 2px 12px;
    }

    .bor_line{ 
      border-bottom: 1px solid #d6d6d6;
    }
    </style>

</head>
<body >
<div id="box" style="width:70%;margin: auto;">
   
   <h2>擴充功能表</h2>

 <?php



  $all_expand="SELECT * FROM expand_tb";
  $result_all=db_conn($all_expand);
  while ($row=mysql_fetch_array($result_all)) {
    
   $contant='<div class="bor_line"> '.$row['tool_name'].': <button id="'.$row['tool_id'].'" class="not_use" type="button" onclick="ajax_btn(\''.$row['tool_id'].'\',\''.$case_id.'\')">停用</button> </div>';

   echo $contant;
  }

 ?>


</div> 

<script type="text/javascript">
    $(document).ready(function() {
      

    <?php  
     // 擴充功能
     $result=db_conn($sql_query);
    while ($row=mysql_fetch_array($result)) {// 擴充功能
    
    if ($row['is_use']=='0') {
     
     $contant='$("#'.$row['tool_id'].'").text("停用");';
    $contant.='$("#'.$row['tool_id'].'").css("backgroundColor", "#ed5565");';
    }
    else if($row['is_use']=='1'){

      $contant='$("#'.$row['tool_id'].'").text("啟用");';
     $contant.='$("#'.$row['tool_id'].'").css("backgroundColor", "green");';
    }
    echo $contant;
    }

    ?>

    });

    function ajax_btn(tool_id,case_id) {
      
      $.ajax({
        url: 'expand_sql.php',
        type: 'POST',
        data: {
                page: 'expand_record',
                tool_id: tool_id,
                case_id: case_id
              },

        success:function (data) {
          
           if (data==0) { //停用
             $("#"+tool_id).text('停用');
             $("#"+tool_id).css('backgroundColor', '#ed5565');
           }
           else{ //啟用
             $("#"+tool_id).text('啟用');
             $("#"+tool_id).css('backgroundColor', 'green');
           }
        }
      });
    }
    </script>  
</body>
</html>