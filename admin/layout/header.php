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
	$link = $_SERVER['REQUEST_URI'];
	$link = explode("admin",$link);
	if($link[0] == "/staff_manager/")
	{
		$new_link = "/staff_manager/";
	}
	else
	{
		$new_link = "/";
	}
	echo "<script>window.location.href='http://" . $_SERVER['SERVER_NAME'] .$new_link."';</script>";
	
}
$check_link = explode("/",$_SERVER['SCRIPT_FILENAME']);
$check_link = $check_link[count($check_link) - 1];
if($check == "" &&  $check_link != "index.php")
{
	$link = $_SERVER['REQUEST_URI'];
	$link = explode("admin",$link);
	echo $link[0];
	if($link[0] == "/staff_manager/")
	{
		$new_link = "/staff_manager/";
	}
	else
	{
		$new_link = "/";
	}
	
	echo "<script>window.location.href='http://" . $_SERVER['SERVER_NAME'] .$new_link."';</script>";
}
else
{
	$check = "true";
	
}
if(@$_REQUEST['action'] == "logout")
{
	session_destroy();
	unset($_COOKIE['user']);
    unset($_COOKIE['pass']);
	unset($_COOKIE['remember']);
	setcookie('user', null, -1, '/');
    setcookie('pass', null, -1, '/');
	setcookie('remember', null, -1, '/');
	// setcookie("user", null, time() - 3600);
	// setcookie("pass", null, time() - 3600);
	// setcookie("remember", null, time() - 3600);

	$link = $_SERVER['REQUEST_URI'];
	$link = explode("admin",$link);
	if($link[0] == "/staff_manager/")
	{
		$new_link = "/staff_manager/";
	}
	else
	{
		$new_link = "/";
	}
	echo "<script>window.location.href='http://" . $_SERVER['SERVER_NAME'] .$new_link."';</script>";
	//echo "<script>window.location.href='index.php';</script>";
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
<script src="../js/jquery-cookie/src/jquery.cookie.js"></script>
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
<div class="loading"></div>

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
			<li class="treeview"><a href="index.php"><i class="fa fa-list-alt"></i><span>Danh Sách Nhân Viên</span></a></li>
			<li class="treeview"><a href="staff_manager.php"><i class="fa fa-edit"></i><span>Xác Nhận Lương Hàng Tháng</span></a></li>
			
			<li class="treeview"><a href="add_admin.php"><i class="fa fa-user-plus"></i><span>Thêm Mới Admin</span></a></li>
			<li class="treeview"><a href="add_staff.php"><i class="fa fa-user-plus"></i><span>Thêm Mới Nhân Viên</span></a></li>
			
		</ul>
	</section>
</aside>