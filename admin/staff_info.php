<?php
include("layout/header.php");
$user_id = @$_REQUEST['id'];
$sql1 = "select * from user where id=".$user_id."";
$results1 = mysql_query($sql1);
$num_rows1 = mysql_num_rows($results1);	
if(@$_REQUEST['delete'])
{
	$user_id =$_REQUEST['user_id'];
	$check = mysql_query("delete from user where id=".$user_id);
	if($check == TRUE)
	{
		echo "<script>alert('Xoá Nhân Viên Thành Công');window.location.href='index.php';</script>";
	}
	else
	{
		echo "<script>alert('Xoá Nhân Viên Thất Bại');window.location.href='index.php';</script>";
	}
}
if($num_rows1 > 0)
{
	
	$row = mysql_fetch_array($results1);
	
	
	if(@$_REQUEST['update'])
	{
		$user_id =$_REQUEST['user_id'];
		$ten =$_REQUEST['ten'];
		$luong =$_REQUEST['luong'];
		$new_pass = @md5($_REQUEST['new_pass']);
		$confirm_new_pass = @md5($_REQUEST['confirm_new_pass']);
		$block = @$_REQUEST['block'];
		$day_leave = $_REQUEST['day_leave'];
		if($block != "")
		{
			$block = $_REQUEST['block'];
		}
		else
		{
			$block = 1;
		}
		if($new_pass == "")
		{
			$check = mysql_query("update user set name='".$ten."',luong='".$luong."',status='".$block."',day_leave='".$day_leave."' where id=".$user_id);
			if($check == TRUE)
			{
				echo "<script>alert('Thay Đổi Thông Tin Thành Công');window.location.href='staff_info.php?id=".$user_id."';</script>";
			}
			else
			{
				echo "<script>alert('Thay Đổi Thông Tin Thất Bại');window.location.href='staff_info.php?id=".$user_id."';</script>";
			}
		}
		else
		{
			if($new_pass != $confirm_new_pass)
			{
				echo "<script>alert('Mật Khẩu Nhập Lại Không Đúng');window.location.href='staff_info.php?id=".$user_id."';</script>";
			}
			else
			{
				$check = mysql_query("update user set name='".$ten."',luong='".$luong."',status='".$block."',user_pass='".$new_pass."',day_leave='".$day_leave."' where id=".$user_id);
				if($check == TRUE)
				{
					echo "<script>alert('Thay Đổi Thông Tin Thành Công');window.location.href='staff_info.php?id=".$user_id."';</script>";
				}
				else
				{
					echo "<script>alert('Thay Đổi Thông Tin Thất Bại');window.location.href='staff_info.php?id=".$user_id."';</script>";
				}
			}
		}
	}
}
else
{
	echo "<script>alert('Thông Tin Không Hợp Lệ');window.location.href='index.php';</script>";
}
?>
<div class="content-wrapper" style="min-height: 916px;">
	<section class="content-header">
	<h1></h1>
	</section>
	<div class="content">
		<div id="statistical" class="box">
			<div class="box-header with-border">
				<h3>Thông Tin Nhân Viên</h3>
			</div>
			<form role="form"  method ="POST" enctype="multipart/form-data">
				<div class="box-body">
					
					<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
					<div class="form-group">
						<label for="exampleInputEmail1">Tên Nhân Viên</label>
						<input type="text" name="ten" class="form-control" value="<?php echo $row['name']; ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">User Login</label>
						<input type="text" class="form-control" disabled="disabled" value="<?php echo $row['user_name']; ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Email</label>
						<input type="text" class="form-control" disabled="disabled" value="<?php echo $row['email']; ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Lương Nhân Viên</label>
						<input type="text"  name="luong" class="form-control" value="<?php echo $row['luong']; ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Số Ngày Nghỉ</label>
						<input type="number"  name="day_leave" class="form-control" value="<?php echo $row['day_leave']; ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">User Pass</label>
						<input type="password" class="form-control" value="<?php echo $row['user_pass']; ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">User New Pass</label>
						<input type="password"  name="new_pass" class="form-control" value="">
					</div>
					
					<div class="form-group">
						<label for="exampleInputEmail1">User Confirm New Pass</label>
						<input type="password"  name="confirm_new_pass" class="form-control" value="">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><input type="checkbox" value="0" name="block"> Block User</label> 
					</div>
					<div class="box-footer">
						<td style="text-align:center" colspan="2"><input type="submit" class="btn btn-primary" name="update" value="Thay Đổi Thông Tin"></td>
						<td style="text-align:center" colspan="2"><input type="submit" class="btn btn-primary" name="delete" value="Xoá Nhân Viên"></td>
						<td style="text-align:center" colspan="2"><a href="staff_month_cal.php?staff_id=<?php echo $user_id; ?>"><input type="button" class="btn btn-primary" name="delete" value="Thông Tin Đi Làm"></a></td>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<?php
include("layout/footer.php");
?>