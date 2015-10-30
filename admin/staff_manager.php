<?php
include("layout/header.php");
$sql = "select *,month_confirm.id as month_confirm_id from month_confirm inner join user on user.id = month_confirm.user_id where  month_confirm.status = 1 order by month_confirm.month_accept DESC ";
$day = date("Y-d", strtotime(date("Y-m-d")));

?>
<script>
function update_staff(month,year,user_id)
{
	var date = year+"-"+month+"-01";
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
				alert("update thành công");
				window.location.href='staff_manager.php';
			}
			else
			{
				alert("update không thành công");
				window.location.href='staff_manager.php';
			}
		}
	}
	xmlhttp.open("GET","admin_ajax.php?action=update_staff&date="+date+"&user_id="+user_id,true);
	xmlhttp.send();
}
function cancel_staff(month,year,user_id)
{
	var date = year+"-"+month+"-01";
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
				alert("update thành công");
				window.location.href='staff_manager.php';
			}
			else
			{
				alert("update không thành công");
				window.location.href='staff_manager.php';
			}
		}
	}
	xmlhttp.open("GET","admin_ajax.php?action=cancel_staff&date="+date+"&user_id="+user_id,true);
	xmlhttp.send();
}
</script>
<div class="content-wrapper" style="min-height: 916px;">
	<section class="content-header">
	<h1>Danh Sách Xác Nhận Lương</h1>
	</section>
	<div class="content">
		
		<div class="box">
			<table class="table table-bordered">
				<tr>
					<td>Tháng Xác Nhận</td>
					<td>Tên Nhân Viên</td>
					<td>Lương</td>
					<td>Số Ngày Làm Trong Tháng</td>
					<td>Số Giờ OT Trong Tháng</td>
					<td>Lương Nhận Được</td>
					<td>Action</td>
				<tr>
				<?php
				$results = mysql_query($sql);
				while($row = mysql_fetch_array($results))
				{
					?>
						<tr>
						<td><a href="staff_month_info.php?month_accept=<?php echo date("m-Y",strtotime($row['month_accept'])); ?>&user_id=<?php echo $row['user_id']; ?>&month_confirm_id=<?php echo $row['month_confirm_id']; ?>"><?php echo date("m-Y",strtotime($row['month_accept'])); ?></a></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['luong']; ?></td>
						<?php
							$endday =  date("Y-m-t", strtotime($row['month_accept']));
							$startday =  date("Y-m-01", strtotime($row['month_accept']));
							$sql1 = "select count(*) as count  from staff_time where user_id=".$row['id']." and time_start between '".$startday."' and '".$endday."'";
							$results1 = mysql_query($sql1);
							$row1 = mysql_fetch_array($results1);
							$daywork = $row1['count'];
							$total_ot = 0;
							$sql2 = "select * from staff_time where user_id=".$row['id']." and time_start between '".$startday."' and '".$endday."'";
							$results2 = mysql_query($sql2);
							while($row2 = mysql_fetch_array($results2))
							{
								$time =  date("H",strtotime($row2['time_OT'])) * 3600;
								$time1 =  date("i",strtotime($row2['time_OT'])) * 60;
								$total_ot += $time + $time1;
							
							}
							$total_ot = $total_ot/60;
						?>
						<td><?php echo $daywork;?></td>
						<td><?php echo sprintf("%02dh %02dm", floor($total_ot/60), $total_ot%60);?></td>
						<td><?php echo $row['luong_inmonth'] ?></td>
						<td><input type="button" value="Update" onclick="return update_staff(<?php echo date("m",strtotime($row['month_accept'])).",".date("Y",strtotime($row['month_accept'])).",".$row['id']; ?>)">
						<input type="button" value="Cacel" onclick="return cancel_staff(<?php echo date("m",strtotime($row['month_accept'])).",".date("Y",strtotime($row['month_accept'])).",".$row['id']; ?>)">
						</td>
						</tr>
					<?php
				}
				?>
			</table>
		</div>
	</div>
</div>
<?php
include("layout/footer.php");


?>