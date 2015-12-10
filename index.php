<?php
include("layout/header.php");

$day = date("m-Y", strtotime(date("Y-m-d")));
$endday =  date("t", strtotime(date("Y-m-d")));
$startday =  date("Y-m-01", strtotime(date("Y-m-d")));
$user_id = @$_SESSION['id'];
$output = "";
$total_time  = 0;
$total_ot  = 0;
$time_inmonth  = 0;
$sql1 = "select * from user where id=".$user_id;
$get_user = mysql_query($sql1);
$row2 = mysql_fetch_array($get_user);
if(@$_REQUEST['send_confirm'])
{
	$user_id = $_REQUEST['user_id'];
	$month = $_REQUEST['month_confirm1'];
	$luong_inmonth = $_REQUEST['luong_inmonth'];
	$sql_check = mysql_query("select * from month_confirm where month_accept = '".$month."' and user_id=".$user_id." and (status = 1 or status = 0)");
	$num_check = @mysql_num_rows($sql_check);	
	if($num_check == 0)
	{
		$results = mysql_query("insert into month_confirm(month_accept,user_id,status,luong_inmonth) values('".$month."','".$user_id."',1,'".$luong_inmonth."')");
		if($results == TRUE)
		{
			echo "<script>alert('gửi báo cáo thành công');window.location.href='index.php';</script>";
		}
		else
		{
			echo "<script>alert('gửi báo cáo thất bại');window.location.href='index.php';</script>";
		}
	}
	
	
}
?>
<script>

function update_time(day,month,year,user_id)
{
	
	var info = day+"-"+month+"-"+year;
	if (document.getElementById(info+"_day_leave").checked) {
		var timestart_val = "8:00";
		var timeend_val = "17:00";
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if(xmlhttp.responseText== "OK")
				{
					alert("Update thành công");
					$("#"+info+"_timestart").attr("disabled","disabled");
					$("#"+info+"_timeend").attr("disabled","disabled");
					$("#"+info+"_timeOT").attr("disabled","disabled");
					return false;
				}
				else if(xmlhttp.responseText== "FAIL")
				{
						
					alert("Báo Cáo Đã Gửi Không Thể Update");
					return false;
				}
				else if(xmlhttp.responseText== "FAIL2")
				{
					alert("Số Ngày Nghỉ Phép Không Đủ");
					return false;
					
				}
				else
				{
					alert("Update Thất Bại");
					return false;
				}
			}
		}
		xmlhttp.open("GET","ajax.php?action=update_time1&day="+info+"&user_id="+user_id,true);
		xmlhttp.send();
	
	}
	else
	{
		var timestart_val = $("#"+info+"_timestart").val();
		var timeend_val = $("#"+info+"_timeend").val();
		var timeOT_val = $("#"+info+"_timeOT").val();
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if(xmlhttp.responseText== "OK")
				{
					alert("Update thành công");
					return false;
				}
				else if(xmlhttp.responseText== "OK1")
				{
					$("#"+info+"_timestart").attr("disabled",false);
					$("#"+info+"_timestart").val(""); 
					$("#"+info+"_timestart").attr("placeholder","08:00");
					$("#"+info+"_timeend").attr("disabled",false);
					$("#"+info+"_timeend").val(""); 
					$("#"+info+"_timeend").attr("placeholder","17:00");
					$("#"+info+"_timeOT").attr("disabled",false);
					$("#"+info+"_timeOT").val(""); 
					$("#"+info+"_timeOT").attr("placeholder","1:00");
					alert("Update thành công");
					return false;
				}
				else if(xmlhttp.responseText== "FAIL")
				{
						
					alert("Báo Cáo Đã Gửi Không Thể Update");
					return false;
				}
				else
				{
						
					alert("Update Thất Bại");
					return false;
				}
			}
		}
		xmlhttp.open("GET","ajax.php?action=update_time&day="+info+"&user_id="+user_id+"&timestart_val="+timestart_val+"&timeend_val="+timeend_val+"&timeOT_val="+timeOT_val,true);
		xmlhttp.send();
	}
	
}

</script>
<?php
if($user_id != "")
{	
?>
<div class="content-wrapper" style="min-height: 916px;">
	<section class="content-header">
	<h1>Đăng Ký Giờ Làm</h1>
	</section>
	<div class="content">
		
		<div class="box">
			<div class="box-header with-border">
				<form>
					<input type="hidden" value="<?php echo $_SESSION['id']; ?>" id="user_id" name="user_id">
					<form action="javascript:void(0)" method="post">
					<div style="text-align:center">Chọn Tháng <input name="dat" id="datepicker1" type="text" value="<?php echo $day;?>"></div>
					</form>
				</form>
			</div>
			<form id="statistical" >
			<?php
			$month_confirm1 = date("Y-m-d", strtotime("01-".$day));
			$output .= '<table class="date_info_table table table-bordered">
					<tr>
						<input type="hidden" value="'.$_SESSION['id'].'" id="user_id" name="user_id">
						<input type="hidden" value="'.$month_confirm1.'" id="month_confirm1" name="month_confirm1">
						<th>Ngày Làm Viêc</th>
						<th>Bắt Đầu</th>
						<th>Kết Thúc</th>
						<th>Giờ OT</th>
						<th>Nghỉ Phép</th>
						<th>Thao Tác</th>
					</tr>';
			for($i = 1; $i <$endday; $i++)
			{
				$startday  =  date("Y-m-d", strtotime($i."-".$day));
				$day_info = explode("-",$i."-".$day);
				$day_info1 = $day_info[0];
				$day_info2 = $day_info[1];
				$day_info3 = $day_info[2];
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
					$row = mysql_fetch_array($get_cal);
					if($dayname == 6 || $dayname == 7)
					{
						$output .='
						<tr>	
							<td>'.$thu." , ".$i."-".$day.'</td>
							<td><input class="timepicker2" disabled="disabled" type="text" placeholder="08:00" id="'.$i."-".$day.'_timestart"></td>
							<td><input class="timepicker2" disabled="disabled" type="text" placeholder="17:00" id="'.$i."-".$day.'_timeend"></td>
							<td><input class="timepicker2" type="text" value="'.date("H:i",strtotime($row['time_OT'])).'" id="'.$i."-".$day.'_timeOT"></td>
							<td><input type="checkbox" id="'.$i."-".$day.'_day_leave"></td>
							<td><input type="button" class="btn btn-primary" value="Update" onclick="return update_time('.$day_info1.",".$day_info2.','.$day_info3.','.$user_id.')"></td>
						</tr>';
						
						$time =  date("H",strtotime($row['time_OT'])) * 3600;
						$time1 =  date("i",strtotime($row['time_OT'])) * 60;
						$total_ot += $time + $time1;
					}
					else
					{
						
						if($row['is_day_leave'] == 1)
						{
							$output .='
							<tr>	
								<td>'.$thu." , ".$i."-".$day.'</td>
								<td><input class="timepicker2" disabled="disabled" type="text" value="'.date("H:i",strtotime($row['time_start'])).'" id="'.$i."-".$day.'_timestart"></td>
								<td><input class="timepicker2" disabled="disabled" type="text" value="'.date("H:i",strtotime($row['time_end'])).'" id="'.$i."-".$day.'_timeend"></td>
								<td><input class="timepicker2" disabled="disabled" type="text" value="'.date("H:i",strtotime($row['time_OT'])).'" id="'.$i."-".$day.'_timeOT"></td>
								<td><input type="checkbox" checked="checked" id="'.$i."-".$day.'_day_leave"></td>
								<td><input type="button" value="Update" class="btn btn-primary"  onclick="return update_time('.$day_info1.",".$day_info2.','.$day_info3.','.$user_id.')"></td>
							</tr>';
						}
						else
						{
							$output .='
							<tr>	
								<td>'.$thu." , ".$i."-".$day.'</td>
								<td><input class="timepicker2" type="text" value="'.date("H:i",strtotime($row['time_start'])).'" id="'.$i."-".$day.'_timestart"></td>
								<td><input class="timepicker2" type="text" value="'.date("H:i",strtotime($row['time_end'])).'" id="'.$i."-".$day.'_timeend"></td>
								<td><input class="timepicker2" type="text" value="'.date("H:i",strtotime($row['time_OT'])).'" id="'.$i."-".$day.'_timeOT"></td>
								<td><input type="checkbox" id="'.$i."-".$day.'_day_leave"></td>
								<td><input type="button" value="Update" class="btn btn-primary"  onclick="return update_time('.$day_info1.",".$day_info2.','.$day_info3.','.$user_id.')"></td>
							</tr>';
						}
						
						if(strtotime($row['time_end']) - strtotime($row['time_start']) - 3600 < 28800)
						{
							$total_time += strtotime($row['time_end']) - strtotime($row['time_start']) - 3600;
						}
						else
						{
							$total_time += 28800;
						}
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
							<td><input class="timepicker2" disabled="disabled" type="text" placeholder="08:00" id="'.$i."-".$day.'_timestart"></td>
							<td><input class="timepicker2" disabled="disabled" type="text" placeholder="17:00" id="'.$i."-".$day.'_timeend"></td>
							<td><input class="timepicker2" type="text" placeholder="1:00" id="'.$i."-".$day.'_timeOT"></td>
							<td><input type="checkbox" id="'.$i."-".$day.'_day_leave"></td>
							<td><input type="button" class="btn btn-primary"  value="Update" onclick="return update_time('.$day_info1.",".$day_info2.','.$day_info3.','.$user_id.')"></td>
						</tr>';		
					}
					else
					{
						$output .='
						<tr>
							<td>'.$thu." , ".$i."-".$day.'</td>
							<td><input class="timepicker2" type="text" placeholder="08:00" id="'.$i."-".$day.'_timestart"></td>
							<td><input class="timepicker2" type="text" placeholder="17:00" id="'.$i."-".$day.'_timeend"></td>
							<td><input class="timepicker2" type="text" placeholder="1:00" id="'.$i."-".$day.'_timeOT"></td>
							<td><input type="checkbox" id="'.$i."-".$day.'_day_leave"></td>
							<td><input type="button" class="btn btn-primary"  value="Update" onclick="return update_time('.$day_info1.",".$day_info2.','.$day_info3.','.$user_id.')"></td>
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
			$confirm_month = date("Y-m", strtotime(date("Y-m-d")));
			$sql3 = "select * from month_confirm where month_accept like '%".$confirm_month."%' and user_id=".$user_id." and (status = 1 or status = 0)";
			$check_confirm = mysql_query($sql3);
			$num_rows_check_confirm = mysql_num_rows($check_confirm);	
			
			if($num_rows_check_confirm > 0)
			{
				$row3 = mysql_fetch_array($check_confirm);
				$output .='<tr>	
					<th>Tổng Thời Gian Làm : '.sprintf("%02dh %02dm", floor($total_time/60), $total_time%60).'/'.$time_inmonth.'h</th>
					<th>Tổng Thời Gian OT : '.sprintf("%02dh %02dm", floor($total_ot/60), $total_ot%60).'</th>
					<th>Lương Cơ Bản : '.substr(number_format(ceil($row2['luong']),2),0,-3).'</th>
					<th><input type="hidden" value="'.$row3['luong_inmonth'].'" name="luong_inmonth">Lương Nhận Được : '.substr(number_format($row3['luong_inmonth'],2),0,-3).'</th>
					<th colspan="2"><input disabled="disabled" class="btn btn-danger" type="button" value="Gửi Báo Cáo"></th>
				</tr></table>';
			}	
			else
			{
				$output .='<tr>	
					<th>Tổng Thời Gian Làm : '.sprintf("%02dh %02dm", floor($total_time/60), $total_time%60).'/'.$time_inmonth.'h</th>
					<th>Tổng Thời Gian OT : '.sprintf("%02dh %02dm", floor($total_ot/60), $total_ot%60).'</th>
					<th>Lương Cơ Bản : '.substr(number_format(ceil($row2['luong']),2),0,-3).'</th>
					<th><input type="hidden" value="'.ceil($luong+$luongot).'" name="luong_inmonth">Lương Nhận Được : '.substr(number_format(ceil($luong+$luongot),2),0,-3).'</th>
					<th colspan="2"><input name="send_confirm" class="btn btn-danger" type="submit" value="Gửi Báo Cáo"></th>
				</tr></table>';
			}
			
			
			echo $output;
			?>
			</form>
		</div>
		
		
	</div>
</div>
<?php
}
include("layout/footer.php");
?>