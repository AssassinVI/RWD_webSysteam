<?php require_once 'shared_php/config.php';
      


 $case_id=addslashes($_GET['case_id']);

 $sql_query="SELECT * FROM expand_tb LEFT JOIN expand_record ON expand_tb.tool_id=expand_record.tool_id WHERE expand_record.case_id='$case_id' AND expand_record.is_use='1' AND expand_tb.edit_web!='' ";
 // 擴充功能
$result=db_conn($sql_query);

?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
	<meta charset="UTF-8">
	<title>擴充</title>
  <link rel="shortcut icon" href="favicon.ico" />
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
    a{
    float: right;
    border: none;
    padding: 2px 10px 2px 10px;
    border-radius: 5px;
    color: #fff;
    background-color: #1c84c6;
    transition: padding 0.5s;
  -moz-transition: padding 0.5s;  /* Firefox 4 */
  -webkit-transition: padding 0.5s; /* Safari 和 Chrome */
  -o-transition: padding 0.5s;  /* Opera */
    }
    a:hover{
      padding: 2px 12px 2px 12px;
      color: #fff;
    }

    .bor_line{ 
      border-bottom: 1px solid #d6d6d6;
    }
    </style>

    <script type="text/javascript">
    


    </script>
</head>
<body >
<div id="box" style="width:70%;margin: auto;">
   
   <h2>擴充功能表</h2>

 <?php

if (mysql_num_rows($result)<1) {

  echo "<h3>您無任何新功能</h3>";
}
else{

  while ($row=mysql_fetch_array($result)) {// 擴充功能
    
     $contant='<div class="bor_line"> '.$row['tool_name'].': <a href="'.$row['edit_web'].'?record_id='.$row['record_id'].'" id="'.$row['tool_id'].'"  >編輯</a> </div>';
    

    echo $contant;
  }
}

 ?>


</div>   
</body>
</html>