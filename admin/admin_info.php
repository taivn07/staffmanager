<?php
include("layout/header.php");
if(@$_REQUEST['update'])
{
	$user_id = @$_REQUEST['user_id'];
	$name = @$_REQUEST['name'];
	$user_oldpass = md5(@$_REQUEST['user_oldpass']);
	$user_pass = md5(@$_REQUEST['user_pass']);
	$user_pass1 = md5(@$_REQUEST['user_pass1']);
	if($_REQUEST['user_oldpass'] != "")
	{
		if($user_pass != $user_pass1)
		{
			echo "<script>alert('Mật Khẩu Nhập Lại Không Đúng');window.location.href='info.php';</script>";
		}
		else
		{
			$check_pass  = mysql_query("select * from user where id='".$user_id."' AND user_pass='".$user_oldpass."'");
			$num_rows = @mysql_num_rows($check_pass);	
			if($num_rows > 0)
			{
				if(basename($_FILES["image_file"]["name"]) == "")
				{
					$check = mysql_query("update user set user_pass='".$user_pass."',name='".$name."' where id='".$user_id."'");	
					if($check == TRUE)
					{
						echo "<script>alert('Thay Đổi Thông Tin Thành Công');window.location.href='info.php';</script>";
					}
					else
					{
						echo "<script>alert('Thay Đổi Thông Tin Thất Bại');window.location.href='info.php';</script>";
					}
				}
				else
				{
					$target_dir1 = "uploadfile/";
					$name_file_add = md5(date("Y-m-d H:i:s"));
					$target_file1 = $target_dir1 .$name_file_add. basename($_FILES["image_file"]["name"]);
					if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file1)) 
					{
						$text_file = $target_file1;
					}
					else	
					{
						$text_file ="";
					}
					$check = mysql_query("update user set user_pass='".$user_pass."',name='".$name."',image='".$text_file."' where id='".$user_id."'");	
					if($check == TRUE)
					{
						echo "<script>alert('Thay Đổi Thông Tin Thành Công');window.location.href='info.php';</script>";
					}
					else
					{
						echo "<script>alert('Thay Đổi Thông Tin Thất Bại');window.location.href='info.php';</script>";
					}
				}
				
			}
			else
			{
				echo "<script>alert('Mật Khẩu Không Đúng');window.location.href='info.php';</script>";
			}
		}
		
	}
	else
	{
		if(basename($_FILES["image_file"]["name"]) == "")
		{
			$check = mysql_query("update user set name='".$name."' where id='".$user_id."'");	
			if($check == TRUE)
			{
				echo "<script>alert('Thay Đổi Thông Tin Thành Công');window.location.href='info.php';</script>";
			}
			else
			{
				echo "<script>alert('Thay Đổi Thông Tin Thất Bại');window.location.href='info.php';</script>";
			}
		}
		else
		{
			$target_dir1 = "uploadfile/";
			$name_file_add = md5(date("Y-m-d H:i:s"));
			$target_file1 = $target_dir1 .$name_file_add. basename($_FILES["image_file"]["name"]);
			if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file1)) 
			{
				$text_file = $target_file1;
			}
			else	
			{
				$text_file ="";
			}
			$check = mysql_query("update user set name='".$name."',image='".$text_file."' where id='".$user_id."'");	
			if($check == TRUE)
			{
				echo "<script>alert('Thay Đổi Thông Tin Thành Công');window.location.href='info.php';</script>";
			}
			else
			{
				echo "<script>alert('Thay Đổi Thông Tin Thất Bại');window.location.href='info.php';</script>";
			}
		}
	}
	
}
?>
<div class="content-wrapper" style="min-height: 916px;">
	<section class="content-header">
	<h1></h1>
	</section>
	<div class="content">
		<div id="statistical" class="box">
			<div class="box-header with-border">
				<h3>Thông Tin Admin</h3>
			</div>
			<?php
			$user_id =  $_SESSION['id'];
			$sql = "select * from user where id='".$user_id."'";
			$get_user = mysql_query($sql);
			$row = mysql_fetch_array($get_user);
			?>
			<form role="form"  method ="POST" enctype="multipart/form-data">
				<div class="box-body">
					
					<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
					<div class="form-group">
						<label for="exampleInputEmail1">Username</label>
						<input type="text" class="form-control" disabled="disabled" value="<?php echo $row['user_name']; ?>">
					</div>
					<div class="form-group">
						<label>Họ Và Tên</label><input type="text" class="form-control"  name="name" value="<?php echo $row['name']; ?>">
					</div>

					<div class="form-group">
						<label>Old Password</label><input type="password" class="form-control" name="user_oldpass" value="">
					</div>
					<div class="form-group">
						<label>New Password</label><input type="password" class="form-control" name="user_pass" value="">
					</div>
					<div class="form-group">
						<label>Confirm Userpass</label><input type="password" class="form-control" name="user_pass1" value="">
					</div>
					<div class="form-group">
						<label>Image</label><input type="file" id="exampleInputFile" name="image_file">
					</div>
					<div class="box-footer">
						<td style="text-align:center" colspan="2"><input type="submit" class="btn btn-primary" name="update" value="Thay Đổi Thông Tin"></td>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<?php
include("layout/footer.php");
?>