<?php
header("Content-type: text/html;charset=UTF-8");
$host       = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'staff_manager';

$con = mysql_connect($host, $username, $password);
mysql_select_db($database, $con);

mysql_query("SET CHARACTER SET utf8");
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
$check = @$_SESSION['id'];
$check_login1 = mysql_query("select * from user where id='".$check."' AND status = 2");
$num_rows2 = @mysql_num_rows($check_login1);	
if($num_rows2 > 0)
{

}
else
{
	echo "<script>window.location.href='http://localhost/staff_manager/index.php';</script>";
}
$check_link = explode("/",$_SERVER['SCRIPT_FILENAME']);
$check_link = $check_link[count($check_link) - 1];
if($check == "" &&  $check_link != "index.php")
{
	echo "<script>alert('mời bạn đăng nhập');window.location.href='index.php';</script>";
}
else
{
	$check = "true";
	
}
if(@$_REQUEST['action'] == "logout")
{
	session_destroy();
	echo "<script>alert('đăng xuất thành công');window.location.href='index.php';</script>";
}
if(@$_REQUEST['login'])
{
	$user = $_REQUEST['user'];
	$pass = md5($_REQUEST['pass']);
	$check_login = mysql_query("select * from user where user_name='".$user."' AND user_pass='".$pass."'");
	$num_rows1 = @mysql_num_rows($check_login);	
	if($num_rows1 > 0)
	{
		
		$row = mysql_fetch_array($check_login);
		$_SESSION['id'] = $row['id'];  
		if($row['status'] == 1)
		{
			echo "<script>alert('đăng nhập thành công');window.location.href='index.php';</script>";
		}
		else
		{
			echo "<script>alert('đăng nhập thành công');window.location.href='admin/index.php';</script>";
		}
	}
	else
	{
		echo "<script>alert('đăng nhập thất bại');window.location.href='index.php';</script>";
	}
}
if(@$_REQUEST['register'])
{
	$user = $_REQUEST['user'];
	$pass = md5($_REQUEST['pass']);
	$check_user = mysql_query("select * from user where user_name='".$user."'");
	$num_rows1 = @mysql_num_rows($check_login);	
	if($num_rows1 > 0)
	{
		echo "<script>alert('tài khoản đã có người sử dụng');window.location.href='index.php';</script>";
	}
	else
	{
		$results = mysql_query("insert into user(user_name,user_pass,status) values('".$user."','".$pass."',1)");
		if($results == TRUE)
		{
			echo "<script>alert('đăng ký thành công');window.location.href='index.php';</script>";
		}
		else
		{
			echo "<script>alert('đăng ký thất bại');window.location.href='index.php';</script>";
		}
	}
}

?>
<html>
<head>
<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

<link rel="stylesheet" href="../css/style.css">
<script src='../js/jquery-1.9.1.min.js'></script>

<script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../css/bootstrap/js/bootstrap.min.js"></script>
<script src="../plugins/fastclick/fastclick.js"></script>
<script src="../dist/js/app.min.js"></script>
<script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../plugins/chartjs/Chart.min.js"></script>
<script src="../dist/js/demo.js"></script>
</head>
<script>
$(document).ready(function()
{
	var width = $(window).width();
	var left = (width-450)/2;
	$(".login_form").css("left",left);
	
	
});
</script>
<body class="hold-transition skin-blue sidebar-mini">
<?php
if(@$_SESSION['id'] != "")
{
	
}
else
{
?>
	<div class="loading"></div>
	<div class="login_form">
		<form>
			<ul>
				<li>
					User Name
				</li>
				<li>
					<input type="text" name="user">
				</li>
			</ul>
			<ul>
				<li>
					User Pass
				</li>
				<li>
					<input type="password" name="pass">
				</li>
			</ul>
			<ul>
				<li>
					<input type="submit" name="login" value="Đăng Nhập">
				</li>
				<li>
					<input type="submit" name="register" value="Đăng Ký">
				</li>
			</ul>
		</form>
	</div>
<?php
}
?>
<div class="wrapper">
<header class="main-header">
	<a href="index.php" class="logo">
	<span class="logo-mini">P</span>
	<span class="logo-lg"><img src="../logo.png"></span>
	</a>
	<nav class="navbar navbar-static-top" role="navigation">
		 <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		  </a>
	</nav>

</header>
<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<?php
			if(@$_SESSION['id'] != "")
			{

				$get_username = mysql_query("select * from user where id='".$_SESSION['id']."'");
				$row1 = mysql_fetch_array($get_username);	
				?>	
					<div class="pull-left image">
						<img src="<?php echo $row1['image'] ?>" class="img-circle" alt="User Image">
					</div>
				<?php					
				echo "<div class='pull-left info'><p><a class='info' href='admin_info.php'>".$row1['user_name']."</a>,<a class='logout' href='?action=logout'>Thoát</a></p></div>";
			}
			?>
			
			
		</div>
		<ul class="sidebar-menu">
			<li class="treeview"><a href="index.php"><i class="fa fa-edit"></i><span>Danh Sách Nhân Viên</span></a></li>
			<li class="treeview"><a href="staff_manager.php"><i class="fa fa-edit"></i><span>Xác Nhận Lương Hàng Tháng</span></a></li>
			<li class="treeview"><a href="add_admin.php"><i class="fa fa-edit"></i><span>Thêm Mới Admin</span></a></li>
		</ul>
	</section>
</aside>