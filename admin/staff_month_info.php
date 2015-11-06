<?php
include("layout/header.php");
$day = $_REQUEST['month_accept'];
$user_id =  $_REQUEST['user_id'];
$month_confirm_id = $_REQUEST['month_confirm_id'];
$output = "";
$total_time  = 0;
$total_ot  = 0;
$time_inmonth  = 0;
$endday =  date("t", strtotime($day));
$sql1 = "select * from user where id=".$user_id;
$get_user = mysql_query($sql1);
$row2 = mysql_fetch_array($get_user);
if(@$_REQUEST['Update'])
{
	$time_accept = date('Y-m-d H:i:s');	
	$month_confirm_id = $_REQUEST['month_confirm_id'];
	$sql = "update month_confirm set status=0,is_view=1,time_accept='".$time_accept."' where id='".$month_confirm_id."'";
	echo $sql;
	$results = mysql_query($sql);
	if($results == true)
	{
		echo "<script>alert('Update Thành Công');window.location.href='staff_manager.php';</script>";
	}
	else
	{
		echo "<script>alert('Update Thất Bại');window.location.href='staff_manager.php';</script>";
	}
}
if(@$_REQUEST['Cancel'])
{
	$time_accept = date('Y-m-d H:i:s');	
	$month_confirm_id = $_REQUEST['month_confirm_id'];
	$results = mysql_query("update month_confirm set status=2,is_view=1,time_accept='".$time_accept."' where id='".$month_confirm_id."'");
	if($results == true)
	{
		echo "<script>alert('Cancel Thành Công');window.location.href='staff_manager.php';</script>";
	}
	else
	{
		echo "<script>alert('Cancel Thất Bại');window.location.href='staff_manager.php';</script>";
	}
}
?>
<div class="content-wrapper" style="min-height: 916px;">
	<section class="content-header">
	<h1>Thông Tin </h1>
	</section>
	<div class="content">
		
		<div class="box">
			<form id="statistical" >
			<?php
			//$month_confirm1 = date("Y-m-d", strtotime("01-".$day));
			$output .= '<table class="date_info_table table table-bordered">
					<tr>
						<input type="hidden" name="month_confirm_id" value="'.$month_confirm_id.'">
						<th>Ngày Làm Viêc</th>
						<th>Bắt Đầu</th>
						<th>Kết Thúc</th>
						<th>Giờ OT</th>
					</tr>';
			for($i = 1; $i <$endday; $i++)
			{
					
				$startday  =  date("Y-m-d", strtotime($i."-".$day));
				$dayname =  date("N", strtotime($i."-".$day));
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
							<td>'.$thu." , ".$i."-".$day.'</td>
							<td><input disabled="disabled" type="text" placeholder="08:00" ></td>
							<td><input disabled="disabled" type="text" placeholder="17:00" ></td>
							<td><input type="text" value="'.date("H:i",strtotime($row['time_OT'])).'" ></td>
							
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
							<td>'.$thu." , ".$i."-".$day.'</td>
							<td><input type="text" value="'.date("H:i",strtotime($row['time_start'])).'" ></td>
							<td><input type="text" value="'.date("H:i",strtotime($row['time_end'])).'" ></td>
							<td><input type="text" value="'.date("H:i",strtotime($row['time_OT'])).'" ></td>
							
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
					
					if($dayname == 6 || $dayname == 7)
					{
						$output .='
						<tr>
							<td>'.$thu." , ".$i."-".$day.'</td>
							<td><input disabled="disabled" type="text" placeholder="08:00" ></td>
							<td><input disabled="disabled" type="text" placeholder="17:00" ></td>
							<td><input type="text" placeholder="1:00" ></td>
						
						</tr>';		
					}
					else
					{
						$output .='
						<tr>
							<td>'.$thu." , ".$i."-".$day.'</td>
							<td><input type="text" placeholder="08:00" ></td>
							<td><input type="text" placeholder="17:00" ></td>
							<td><input type="text" placeholder="1:00" ></td>
							
						</tr>';		
						$time_inmonth += 8;
					}
						
				}
			}
			$total_time = $total_time/60;
			$total_ot = $total_ot/60;
			$confirm_month = date("Y-m", strtotime(date("Y-m-d")));
			$sql3 = "select * from month_confirm where month_accept like '%".$confirm_month."%' and user_id=".$user_id." and status = 1";
			$check_confirm = mysql_query($sql3);
			$row3 = mysql_fetch_array($check_confirm);	
			$output .='<tr>	
				<td>Tổng Thời Gian Làm : '.sprintf("%02dh %02dm", floor($total_time/60), $total_time%60).'/'.$time_inmonth.'h</td>
				<td>Tổng Thời Gian OT : '.sprintf("%02dh %02dm", floor($total_ot/60), $total_ot%60).'</td>
				<td>Lương Cơ Bản : '.$row2['luong'].'</td>
				<td>Lương Nhận Được : '.$row3['luong_inmonth'].'</td>
				
			</tr></table>';
			
			
			echo $output;
			?>
			<div class="box-footer" >
				<td style="text-align:center" colspan="2"><input type="submit" class="btn btn-primary" name="Update" value="Update"></td>
				<td style="text-align:center" colspan="2"><input type="submit" class="btn btn-primary" name="Cancel" value="Cancel"></td>
			</div>
			</form>
<?php
include("layout/footer.php");

?>