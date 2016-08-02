<?php require_once '../shared_php/login_session.php';
      require_once '../shared_php/config.php';

      $from_id=$_GET['from_id'];

      $search_id=explode(',', $_POST['search_id']);
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title>列印</title>
<style type="text/css">
    
	.td_sty{ width: 11%; background-color: #dadada; text-align: center; }
	.view_td{ background-color: #e5c4b8; }
	.tb_title{ font-size: 25px; text-align: center; }
</style>
<script type="text/javascript">
	print(document);
</script>
</head>
<body>

<?php

if (!empty($from_id)) {
	
	print_from($from_id);
}
elseif(!empty($search_id)){

	for ($i=0; $i <count($search_id) ; $i++) { 
		
		print_from($search_id[$i]);
	}
}


function print_from($from_id)
{
	
    $pdo=pdo_conn(); //資料庫連線
      $sql_q=$pdo->prepare("SELECT * FROM from_question WHERE from_id=:from_id");
      $sql_q->bindparam(':from_id', $from_id);
      $sql_q->execute();
      while ($row=$sql_q->fetch(PDO::FETCH_ASSOC)) {
         
        // $from_id=$row['from_id'];
         $set_time=$row['set_time'];
         $name=$row['name'];
         $gender=$row['gender']=="m" ? "先生" : "小姐";
         $phone=$row['phone'];
         $email=$row['email'];
         $adds=$row['adds'];
         
         $job=$row['job'];
         $job_txt=$row['job_txt'];
         $job_title=$row['job_title'];
         $cust_old=$row['cust_old'];
         $job_company=$row['job_company'];


         $mar_state=$row['mar_state'];
         $mar_child=$row['mar_child']>0 ? $row['mar_child'].'子' : "";
         $mon_income=$row['mon_income'];
         $transportation=$row['transportation'];
         $live_people=$row['live_people'];
         $homeowner=$row['homeowner'];
         $house_type=$row['house_type'];
         $house_old=$row['house_old'];
         $house_pattern=$row['house_pattern'];
         $floor_num=$row['floor_num'];


         $media=$row['media'];

         $dem_product= $row['dem_product'];
         $dem_floor_num= $row['dem_floor_num'];
         $dem_money= $row['dem_money'];
         $dem_mon_pay= $row['dem_mon_pay'];
         $dem_have= $row['dem_have'];
         $pay_motive= $row['pay_motive'];
         $pay_time=$row['pay_time'];


         $dem_pattern=$row['dem_pattern'];
         $dem_car=explode(',', $row['dem_car']);
         $dem_car_txt=$dem_car[0]=="y" ? "需要" : "不需要";
         $dem_car_num=$dem_car[0]=="y" ? $dem_car[1]."位" : "";
         $dem_floor=$row['dem_floor'];
         $dem_side=$row['dem_side'];
         $pay_num=$row['pay_num'];
         $Introduction=$row['Introduction'];

         $is_buy=$row['is_buy'];
         $buy_name=$row['buy_name'];

         if ($job=="其他") { $job=$job_txt; }


         $table_txt=
         '<div>
	    <div class="tb_title">'.$_SESSION['case_name'].'</div>
		<table width="100%" border="1" cellpadding="5" cellspacing="0" style="font-size:12px;">
			<tbody>
				<tr>
					<td class="td_sty">表單序號</td>
					<td colspan="5">'.$from_id.'</td>
				</tr>
				<tr>
					<td class="td_sty">填表日期</td>
					<td colspan="5">'.$set_time.'</td>
				</tr>
				<tr>
					<td class="td_sty">專案名稱</td>
					<td colspan="5">'.$_SESSION['case_name'].'</td>
				</tr>
				<tr>
					<td class="td_sty">顧客姓名</td>
					<td colspan="5">'.$name.' '.$gender.'</td>
				</tr>
				<tr>
					<td class="td_sty">電話</td>
					<td colspan="5">
					  <p>手機：'.$phone.'</p>
					  <p>E-mail：'.$email.'</p>
					</td>
				</tr>
				<tr>
					<td class="td_sty">住址</td>
					<td colspan="5">'.$adds.'</td>
				</tr>
				<tr>
					<td class="td_sty">職業</td>
					<td>'.$job.'</td>

					<td class="td_sty">職稱</td>
					<td>'.$job_title.'</td>

					<td class="td_sty">年齡</td>
					<td>'.$cust_old.'</td>
				</tr>
				<tr>
					<td class="td_sty">公司名稱</td>
					<td colspan="5">'.$job_company.'</td>
				</tr>
				<tr>
					<td class="td_sty">婚姻狀況</td>
					<td>'.$mar_state.' '.$mar_child.'</td>

					<td class="td_sty">月收入</td>
					<td>'.$mon_income.'</td>

					<td class="td_sty">交通工具</td>
					<td>'.$transportation.'</td>
				</tr>
				<tr>
					<td class="td_sty">家庭成員數</td>
					<td>'.$live_people.'人</td>

					<td class="td_sty">現住房屋</td>
					<td>'.$homeowner.'</td>

					<td class="td_sty">現住房屋型態</td>
					<td>'.$house_type.'</td>

				</tr>
				<tr>
					<td class="td_sty">現住</td>
					<td>'.$house_pattern.'房</td>

					<td class="td_sty">室內</td>
					<td >'.$floor_num.'坪</td>

					<td class="td_sty">屋齡</td>
					<td>'.$house_old.'年</td>
				</tr>
				<tr>
					<td class="td_sty">媒體(複)</td>
					<td colspan="5">'.$media.'</td>
				</tr>
				<tr>
					<td class="td_sty">產品需求(複)</td>
					<td>'.$dem_product.'</td>

					<td >格局需求</td>
					<td colspan="3">'.$dem_pattern.'房</td>
				</tr>
				<tr>
					<td class="td_sty">坪數需求</td>
					<td >'.$dem_floor_num.'</td>

					<td>車位需求</td>
					<td colspan="3">'.$dem_car_txt.' '.$dem_car_num.'</td>
				</tr>
				<tr>
					<td class="td_sty">購物預算(複)</td>
					<td >'.$dem_money.'</td>

					<td>樓層需求(複)</td>
					<td colspan="3">'.$dem_floor.'</td>
				</tr>
				<tr>
					<td class="td_sty">希望月付款(複)</td>
					<td> '.$dem_mon_pay.'</td>

					<td>座向需求(複)</td>
					<td colspan="3">'.$dem_side.'</td>
				</tr>
				<tr>
					<td class="td_sty">自備款(複)</td>
					<td>'.$dem_have.'</td>

					<td>購屋次數</td>
					<td colspan="3">'.$pay_num次.'</td>
				</tr>
				<tr>
					<td class="td_sty">購屋動機(複)</td>
					<td>'.$pay_motive.'</td>

					<td>介紹戶別</td>
					<td colspan="3">'.$Introduction.'</td>
				</tr>
				<tr>
					<td class="td_sty">欲購屋時間</td>
					<td colspan="5"> '.$pay_time.'</td>
				</tr>

				<tr>
					<td width="10%" style="background-color: #7e5d52; color: #fff;" >訪談紀錄</td>
					<td ></td>
				</tr>';


             $sql_call=$pdo->prepare("SELECT * FROM from_callback WHERE from_id=:from_id");
           $sql_call->bindparam(":from_id", $from_id);
           $sql_call->execute();
           while ($row=$sql_call->fetch(PDO::FETCH_ASSOC)) {
              $back_content=$row['back_content'];
              $back_time=$row['back_time'];
              $table_txt.= '<tr>';
              $table_txt.= '<td width="10%" class="view_td" >'.$back_time.'</td>';
              $table_txt.= '<td colspan="5" style="white-space: pre-wrap;">'.$back_content.'</td>';
              $table_txt.= '</tr>';
              }

          $pdo=NULL;
	    

 $table_txt.='</tbody>
		</table>
	</div>
	<p style="page-break-after:always"></p>'; // 列印分頁
			
        echo $table_txt;
      }

} //FUN END
 
?>

	

    
	
</body>
</html>