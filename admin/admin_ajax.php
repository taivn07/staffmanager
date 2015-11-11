<?php
header("Content-type: text/html;charset=UTF-8");
$host       = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'staff_manager';
include '../PHPMailer/class.phpmailer.php';
$con = mysql_connect($host, $username, $password);
mysql_select_db($database, $con);
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
mysql_query("SET CHARACTER SET utf8");
$action = @$_REQUEST['action'];

if($action == "send_mail")
{
	$reason = $_REQUEST['reason'];
	$user_id = $_REQUEST['user_id'];
	$user_info = mysql_query("select * from user where id=".$user_id);
	$row = mysql_fetch_array($user_info);
	
	$mail = new PHPMailer(); // defaults to using php "mail()"
	$mail->CharSet = 'UTF-8';
	$mail->SetFrom('baquevn17@gmail.com', 'First Last');
	$mail->addAddress($row['email']);
	$mail->Subject = "Thông Báo Từ Paditech";
	$mail->MsgHTML("Gửi ".$row['name']."<br>");
	$mail->MsgHTML($reason);
	if(!$mail->send()) {
		echo "Fail";
	} else {
		echo "OK";
	}
}
if($action == "update_staff")
{
	$time_accept = date('Y-m-d H:i:s');	
	$month_accept = $_REQUEST['date'];
	$user_id = $_REQUEST['user_id'];
	$results = mysql_query("update month_confirm set status=0,is_view=1,time_accept='".$time_accept."' where month_accept='".$month_accept."' and user_id=".$user_id);
	if($results == true)
	{
		echo "OK";
	}
	else
	{
		echo "Fail";
	}
}
if($action == "cancel_staff")
{
	$time_accept = date('Y-m-d H:i:s');	
	$month_accept = $_REQUEST['date'];
	$user_id = $_REQUEST['user_id'];
	$reason = $_REQUEST['reason'];
	$results = mysql_query("update month_confirm set status=2,is_view=1,time_accept='".$time_accept."',reason='".$reason."' where month_accept='".$month_accept."' and user_id=".$user_id);
	if($results == true)
	{
		echo "OK";
	}
	else
	{
		echo "Fail";
	}
}
if($action == "staffmonthchange")
{
	$data = @$_REQUEST['data']; 
	$staff_id = @$_REQUEST['staff_id']; 
	$end_loop = date("t", strtotime("01-".$data));
	$sql1 = "select * from user where id=".$staff_id;
	$get_user = mysql_query($sql1);
	$row2 = mysql_fetch_array($get_user);
	$output = "";
	$total_time = 0;
	$total_ot = 0;
	$time_inmonth = 0;
	$month_confirm1 = date("Y-m-d", strtotime("01-".$data));
	$output .= '
			<table class="table date_info_table table-bordered">
					<tr>
						<th>Ngày Làm Viêc</th>
						<th>Bắt Đầu</th>
						<th>Kết Thúc</th>
						<th>Giờ OT</th>
						<th>Nghỉ Phép</th>

					</tr>';
	for($i = 1;$i<=$end_loop;$i++)
	{
		$startday = $startday =  date("Y-m-d", strtotime($i."-".$data));
		$day_info = explode("-",$i."-".$data);
		$day_info1 = $day_info[0];
		$day_info2 = $day_info[1];
		$day_info3 = $day_info[2];
		$dayname =  date("N", strtotime($i."-".$data));
		if($dayname == 1)
		{
			$thu = "Thứ Hai";
		}
		if($dayname == 2)
		{
			$thu = "Thứ Ba";
		}
		if($dayname == 3)
		{
			$thu = "Thứ Tư";
		}
		if($dayname == 4)
		{
			$thu = "Thứ Năm";
		}
		if($dayname == 5)
		{
			$thu = "Thứ Sáu";
		}
		if($dayname == 6)
		{
			$thu = "Thứ Bảy";
		}
		if($dayname == 7)
		{
			$thu = "Chủ Nhật";
		}
		$sql = "select * from staff_time where time_start like '%".$startday."%' and user_id='".$staff_id."'";
		$get_cal = mysql_query($sql);
		$num_rows = @mysql_num_rows($get_cal);	
		if($num_rows > 0)
		{
			
			if($dayname == 6 || $dayname == 7)
			{
				$row = mysql_fetch_array($get_cal);
				$output .='
				<tr>	
					<td>'.$thu." , ".$i."-".$data.'</td>
					<td><input disabled="disabled" class="timepicker2" type="text" placeholder="08:00" id="'.$i."-".$data.'_timestart"></td>
					<td><input disabled="disabled" class="timepicker2" type="text" placeholder="17:00" id="'.$i."-".$data.'_timeend"></td>
					<td><input type="text" class="timepicker2" value="'.date("H:i",strtotime($row['time_OT'])).'" id="'.$i."-".$data.'_timeOT"></td>
					<td><input type="checkbox" id="'.$i."-".$data.'_day_leave"></td>
					
				</tr>';
				$total_time += strtotime($row['time_end']) - strtotime($row['time_start']) - 3600;
				$time =  date("H",strtotime($row['time_OT'])) * 3600;
				$time1 =  date("i",strtotime($row['time_OT'])) * 60;
				$total_ot += $time + $time1;
			}
			else
			{
				$row = mysql_fetch_array($get_cal);
				$output .='
				<tr>	
					<td>'.$thu." , ".$i."-".$data.'</td>
					<td><input type="text" class="timepicker2" value="'.date("H:i",strtotime($row['time_start'])).'" id="'.$i."-".$data.'_timestart"></td>
					<td><input type="text" class="timepicker2" value="'.date("H:i",strtotime($row['time_end'])).'" id="'.$i."-".$data.'_timeend"></td>
					<td><input type="text" class="timepicker2" value="'.date("H:i",strtotime($row['time_OT'])).'" id="'.$i."-".$data.'_timeOT"></td>
					<td><input type="checkbox" id="'.$i."-".$data.'_day_leave"></td>
					
				</tr>';
				$total_time += strtotime($row['time_end']) - strtotime($row['time_start']) - 3600;
				$time =  date("H",strtotime($row['time_OT'])) * 3600;
				$time1 =  date("i",strtotime($row['time_OT'])) * 60;
				$total_ot += $time + $time1;
				$time_inmonth += 8;
			}
			
		}
		else
		{
			$dayname =  date("N", strtotime($i."-".$data));
			if($dayname == 6 || $dayname == 7)
			{
				$output .='
				<tr>
					<td>'.$thu." , ".$i."-".$data.'</td>
					<td><input disabled="disabled" class="timepicker2" type="text" placeholder="08:00" id="'.$i."-".$data.'_timestart"></td>
					<td><input disabled="disabled" class="timepicker2" type="text" placeholder="17:00" id="'.$i."-".$data.'_timeend"></td>
					<td><input type="text" class="timepicker2" placeholder="1:00" id="'.$i."-".$data.'_timeOT"></td>
					<td><input type="checkbox" id="'.$i."-".$data.'_day_leave"></td>
					
				</tr>';		
			}
			else
			{
				$output .='
				<tr>
					<td>'.$thu." , ".$i."-".$data.'</td>
					<td><input type="text" class="timepicker2" placeholder="08:00" id="'.$i."-".$data.'_timestart"></td>
					<td><input type="text" class="timepicker2" placeholder="17:00" id="'.$i."-".$data.'_timeend"></td>
					<td><input type="text" class="timepicker2" placeholder="1:00" id="'.$i."-".$data.'_timeOT"></td>
					<td><input type="checkbox" id="'.$i."-".$data.'_day_leave"></td>
					
				</tr>';		
				$time_inmonth += 8;
			}
				
		}
	}
	
	$total_time = $total_time/60;
	$total_ot = $total_ot/60;
	$luongtb = $row2['luong']/$time_inmonth;
	$luongot = ($luongtb*1.5)*floor($total_ot/60)+($luongtb*1.5/60)*floor($total_ot%60);
	$luong = $luongtb*floor($total_time/60) + ($luongtb/60)*($total_time%60);
	
	$sql3 = "select * from month_confirm where month_accept like '%".$month_confirm1."%' and user_id=".$staff_id." and (status = 1 or status = 0)";
	$check_confirm = mysql_query($sql3);
	$num_rows_check_confirm = mysql_num_rows($check_confirm);	
	if($num_rows_check_confirm > 0)
	{
		$output .='<tr>	
			<th>Tổng Thời Gian Làm : '.sprintf("%02dh %02dm", floor($total_time/60), $total_time%60).'/'.$time_inmonth.'h</th>
			<th>Tổng Thời Gian OT : '.sprintf("%02dh %02dm", floor($total_ot/60), $total_ot%60).'</th>
			<th>Lương Cơ Bản : '.substr(number_format(ceil($row2['luong']),2),0,-3).'</th>
			<th><input type="hidden" value="'.ceil($luong+$luongot).'" name="luong_inmonth">Lương Nhận Được : '.substr(number_format(ceil($luong+$luongot),2),0,-3).'</th>
			
		</tr></table>';
	}	
	else
	{
		$output .='<tr>	
			<th>Tổng Thời Gian Làm : '.sprintf("%02dh %02dm", floor($total_time/60), $total_time%60).'/'.$time_inmonth.'h</th>
			<th>Tổng Thời Gian OT : '.sprintf("%02dh %02dm", floor($total_ot/60), $total_ot%60).'</th>
			<th>Lương Cơ Bản : '.substr(number_format(ceil($row2['luong']),2),0,-3).'</th>
			<th><input type="hidden" value="'.ceil($luong+$luongot).'" name="luong_inmonth">Lương Nhận Được : '.substr(number_format(ceil($luong+$luongot),2),0,-3).'</th>
			
		</tr></table>';
	}
	
	echo $output;
}
?>