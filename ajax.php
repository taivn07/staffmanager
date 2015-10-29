<?php
header("Content-type: text/html;charset=UTF-8");
$host       = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'staff_manager';
$con = mysql_connect($host, $username, $password);
mysql_select_db($database, $con);
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
mysql_query("SET CHARACTER SET utf8");
$action = @$_REQUEST['action'];



if($action == "update_noti")
{
	$id = $_REQUEST['id'];
	$results = mysql_query("update month_confirm set is_view = 0 where id=".$id);
	if($results == true)
	{
		echo "OK";
	}
	else
	{
		echo "Fail";
	}
}
if($action == "update_time")
{
	$day = date("Y-m-d", strtotime(@$_REQUEST['day'])); 
	$user_id = @$_REQUEST['user_id']; 
	$timestart_val = date("Y-m-d H:i:s", strtotime(date($day." ".@$_REQUEST['timestart_val'])));
	$timeend_val = date("Y-m-d H:i:s", strtotime(date($day." ".@$_REQUEST['timeend_val'])));
	$timeOT_val = @$_REQUEST['timeOT_val']; 
	$check = mysql_query("select * from month_confirm where month_accept='".$day."' and user_id=".$user_id);
	$num_rows_check = @mysql_num_rows($check);	
	if($num_rows_check > 0)
	{
		echo "FAIL";
	}
	else
	{
		$sql = "select * from staff_time where time_start like '%".$day."%' and user_id='".$user_id."'";
		//$sql = "select * from staff_time where time_start like '%".$startday."%' and user_id='".$user_id."'";
		$get_cal = mysql_query($sql);
		$num_rows = @mysql_num_rows($get_cal);	
		if($num_rows > 0)
		{
			$row = mysql_fetch_array($get_cal);	
			$results = mysql_query("update staff_time set time_start='".$timestart_val."',time_end='".$timeend_val."',time_OT='".$timeOT_val."' where id=".$row['id']);
			if($results == true)
			{
				echo "OK";
			}
			else
			{
				echo "FAIL1";
			}
		}
		else
		{
			$results = mysql_query("insert into staff_time(user_id,time_start,time_end,time_OT) values('".$user_id."','".$timestart_val."','".$timeend_val."','".$timeOT_val."')");
			if($results == true)
			{
				echo "OK";
			}
			else
			{
				echo "FAIL1";
			}
		}
	}
	
}
if($action == "staffmonthchange")
{
	$data = @$_REQUEST['data']; 
	$user_id = @$_REQUEST['user_id']; 
	$end_loop = date("t", strtotime("01-".$data));
	$sql1 = "select * from user where id=".$user_id;
	$get_user = mysql_query($sql1);
	$row2 = mysql_fetch_array($get_user);
	$output = "";
	$total_time = 0;
	$total_ot = 0;
	$time_inmonth = 0;
	$month_confirm1 = date("Y-m-d", strtotime("01-".$data));
	$output .= '
			<table class="table date_info_table table-bordered">
					<input type="hidden" value="'.$_SESSION['id'].'" id="user_id" name="user_id">
					<input type="hidden" value="'.$month_confirm1.'" id="month_confirm1" name="month_confirm1">
					<tr>
						<td>Ngày Làm Viêc</td>
						<td>Bắt Đầu</td>
						<td>Kết Thúc</td>
						<td>Giờ OT</td>
						<td>Thao Tác</td>
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
		$sql = "select * from staff_time where time_start like '%".$startday."%' and user_id='".$user_id."'";
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
					<td><input disabled="disabled" type="text" placeholder="08:00" id="'.$i."-".$data.'_timestart"></td>
					<td><input disabled="disabled" type="text" placeholder="17:00" id="'.$i."-".$data.'_timeend"></td>
					<td><input type="text" value="'.date("H:i",strtotime($row['time_OT'])).'" id="'.$i."-".$data.'_timeOT"></td>
					<td><input type="button" value="update" class="btn btn-primary"  onclick="return update_time('.$day_info1.",".$day_info2.','.$day_info3.','.$user_id.')"></td>
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
					<td><input type="text" value="'.date("H:i",strtotime($row['time_start'])).'" id="'.$i."-".$data.'_timestart"></td>
					<td><input type="text" value="'.date("H:i",strtotime($row['time_end'])).'" id="'.$i."-".$data.'_timeend"></td>
					<td><input type="text" value="'.date("H:i",strtotime($row['time_OT'])).'" id="'.$i."-".$data.'_timeOT"></td>
					<td><input type="button" value="update" class="btn btn-primary"  onclick="return update_time('.$day_info1.",".$day_info2.','.$day_info3.','.$user_id.')"></td>
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
					<td><input disabled="disabled" type="text" placeholder="08:00" id="'.$i."-".$data.'_timestart"></td>
					<td><input disabled="disabled" type="text" placeholder="17:00" id="'.$i."-".$data.'_timeend"></td>
					<td><input type="text" placeholder="1:00" id="'.$i."-".$data.'_timeOT"></td>
					<td><input type="button" value="update" class="btn btn-primary"  onclick="return update_time('.$day_info1.",".$day_info2.','.$day_info3.','.$user_id.')"></td>
				</tr>';		
			}
			else
			{
				$output .='
				<tr>
					<td>'.$thu." , ".$i."-".$data.'</td>
					<td><input type="text" placeholder="08:00" id="'.$i."-".$data.'_timestart"></td>
					<td><input type="text" placeholder="17:00" id="'.$i."-".$data.'_timeend"></td>
					<td><input type="text" placeholder="1:00" id="'.$i."-".$data.'_timeOT"></td>
					<td><input type="button" value="update" class="btn btn-primary"  onclick="return update_time('.$day_info1.",".$day_info2.','.$day_info3.','.$user_id.')"></td>
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
	//$confirm_month = date("Y-m", strtotime(date("Y-m-d")));
	$sql3 = "select * from month_confirm where month_accept like '%".$month_confirm1."%' and user_id=".$user_id." and status = 1";
	$check_confirm = mysql_query($sql3);
	$num_rows_check_confirm = mysql_num_rows($check_confirm);	
	if($num_rows_check_confirm > 0)
	{
		$output .='<tr>	
		<td>Tổng Thời Gian Làm : '.sprintf("%02dh %02dm", floor($total_time/60), $total_time%60).'/'.$time_inmonth.'h</td>
		<td>Tổng Thời Gian OT : '.sprintf("%02dh %02dm", floor($total_ot/60), $total_ot%60).'</td>
		<td>Lương Cơ Bản : '.$row2['luong'].'</td>
		<td>Lương Nhận Được : '.ceil($luong+$luongot).'</td>
		<td><input name="send_confirm" disabled="disabled" class="btn btn-primary" type="submit" value="Gửi Báo Cáo"></td>
		</tr></table>';
	}
	else
	{
		$output .='<tr>	
		<td>Tổng Thời Gian Làm : '.sprintf("%02dh %02dm", floor($total_time/60), $total_time%60).'/'.$time_inmonth.'h</td>
		<td>Tổng Thời Gian OT : '.sprintf("%02dh %02dm", floor($total_ot/60), $total_ot%60).'</td>
		<td>Lương Cơ Bản : '.$row2['luong'].'</td>
		<td>Lương Nhận Được : '.ceil($luong+$luongot).'</td>
		<td><input name="send_confirm" class="btn btn-primary" type="submit" value="Gửi Báo Cáo"></td>
		</tr></table>';
	}
	
	echo $output;
}
