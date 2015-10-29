<?php
include("layout/header.php");
if(@$_REQUEST['add'])
{
	$username = $_REQUEST['username'];
	$pass = $_REQUEST['pass'];
	$pass1 = $_REQUEST['pass1'];
	$name = $_REQUEST['name'];
	if($username == "" || $pass == "" || $pass1 == "" || $name == ""  )
	{
		echo "<script>alert('Chưa Nhập Đầy Đủ Thông Tin');window.location.href='add_admin.php';</script>";
	}
	else
	{
		$results = mysql_query("insert into user(user_name,user_pass,name,status) values('".$username."','".md5($pass)."','".$name."',2)");
		if($results == TRUE)
		{
			echo "<script>alert('thêm mới thành công');window.location.href='add_admin.php';</script>";
		}
		else
		{
			echo "<script>alert('thêm mới thất bại');window.location.href='add_admin.php';</script>";
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
				<h3>Thêm Mới Admin</h3>
			</div>
			<form role="form"  method ="POST" enctype="multipart/form-data">
				<div class="box-body">

					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="username" value="">
					</div>
					<div class="form-group">
						<label>Password</label><input type="password" class="form-control"  name="pass" value="">
					</div>
					<div class="form-group">
						<label>Confirm Password</label><input type="password" class="form-control"  name="pass1" value="">
					</div>
					<div class="form-group">
						<label>Họ Và Tên</label><input type="text" class="form-control"  name="name" value="">
					</div>
					<div class="box-footer">
						<td style="text-align:center" colspan="2"><input type="submit" class="btn btn-primary" name="add" value="Thêm Mới"></td>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
include("layout/footer.php");
?>