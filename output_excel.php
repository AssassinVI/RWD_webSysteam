<?php include 'shared_php/login_session.php';
      include 'shared_php/config.php';
      $case_id=htmlspecialchars($_GET['case_id']);
      $fun_id=htmlspecialchars($_GET['fun_id']);


header("Content-type: application/vnd.ms-excel"); //檔案格式
header("Content-type:   application/x-msexcel; charset=utf-8");


$fun_id=substr($fun_id, 0,2);

/* ========================= 索取DM =============================== */
if ($fun_id=='dm') {

  $file_name=iconv("UTF-8", "Big5", "客戶資料").date('Y-m-d').".xls";
  header("Content-Disposition: attachment; filename='$file_name'"); //filename檔案名稱
  
$content  = '<html>';
$content .=   '<head> <meta charset="UTF-8"> </head>';
$content .=    '<body>';
$content .=      '<table>';
$content .=         '<tr>';
$content .=            '<th>客戶姓名</th>';
$content .=            '<th>電子信箱</th>';
$content .=            '<th>地址</th>';
$content .=            '<th>電話</th>';
$content .=            '<th>是否要電子報</th>';
$content .=            '<th>備註</th>';
$content .=         '</tr>';

 $result= db_conn("SELECT * FROM catch_DM WHERE case_id='$case_id'");
  if (mysql_num_rows($result)>0) {
  
    while ($row=mysql_fetch_array($result)) {
    
        $content .=         '<tr>';
        $content .=            '<td>'.$row['dm_name'].'</td>';
        $content .=            '<td style="background-color: #F0F0F0">'.$row['dm_mail'].'</td>';
        $content .=            '<td>'.$row['dm_adds'].'</td>';
        $content .=            '<td style="background-color: #F0F0F0">'.$row['dm_phone'].'</td>';
        $content .=            '<td style="text-align:center;">'.$row['dm_YN_news'].'</td>';
        $content .=            '<td style="background-color: #F0F0F0">'.$row['dm_remark'].'</td>';
        $content .=         '</tr>';
     }
   }

   $content .=      '</table>';
   $content .=    '</body>';
   $content .= '</html>';
}

/* ========================= 電子報 =============================== */
elseif ($fun_id=='nw') {

  $file_name=iconv("UTF-8", "Big5", "電子報索取資料").date('Y-m-d').".xls";
  header("Content-Disposition: attachment; filename='$file_name'"); //filename檔案名稱
  
  $content  = '<html>';
  $content .=   '<head> <meta charset="UTF-8"> </head>';
  $content .=    '<body>';
  $content .=      '<table>';
  $content .=         '<tr>';
  $content .=            '<th>客戶電子信箱</th>';
  $content .=         '</tr>';

   $result= db_conn("SELECT * FROM newsletter WHERE case_id='$case_id'");
    if (mysql_num_rows($result)>0) {
  
    while ($row=mysql_fetch_array($result)) {
    
        $content .=         '<tr>';
        $content .=            '<td>'.$row['news_mail'].'</td>';
        $content .=         '</tr>';
     }
   }

   $content .=      '</table>';
   $content .=    '</body>';
   $content .= '</html>';
}




$content_all =$content;
echo $content_all;
exit;
?>

