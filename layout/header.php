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

$check_link = explode("/",$_SERVER['SCRIPT_FILENAME']);
$check_link = $check_link[count($check_link) - 1];
if($check_link == "login.php")
{
	?>
		<style>
			.main-sidebar,.main-header
			{
				display:none;
			}
			.content-wrapper
			{
				margin-left:0px !important
			}
			
		</style>
	<?php
}


if(@$_REQUEST['action'] == "logout")
{
	session_destroy();
	setcookie("user", "", time() - 3600);
	setcookie("pass", "", time() - 3600);
	setcookie("remember", "", time() - 3600);
	echo "<script>window.location.href='login.php';</script>";
}
?>
<html>
<head>
<link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">



<link rel="stylesheet" href="css/style.css">
<script src='js/jquery-1.9.1.min.js'></script>

<script src="https://code.jquery.com/jquery-2.1.4.js" type="text/javascript"></script>

<script src="js/js-cookie-master/src/js.cookie.js" type="text/javascript"></script>

<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="css/bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/fastclick/fastclick.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/chartjs/Chart.min.js"></script>
<script src="dist/js/demo.js"></script>



</head>
<script>
function update_noti(id)
{
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
				$("#update_noti_"+id).parent().hide();
				var count = $('.label-success').text() - 1;
				$("#label-success-header").text("Bạn Có "+count+" messages");
				$("#label-success").text(count);
				return false;
			}
			else
			{
				return false;
			}
		}
	}
	xmlhttp.open("GET","ajax.php?action=update_noti&id="+id,true);
	xmlhttp.send();
}
function update_noti1(id)
{
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
			
			$('.loading').show();
			$('.reason_popup').show();
			document.getElementById('reason_popup').innerHTML =xmlhttp.responseText;
			$("#update_noti_"+id).parent().hide();
			var count = $('.label-success').text() - 1;
			$("#label-success-header").text("Bạn Có "+count+" messages");
			$("#label-success").text(count);
			return false

		}
	}
	xmlhttp.open("GET","ajax.php?action=update_noti1&id="+id,true);
	xmlhttp.send();
}
function close_popup()
{
	$('.reason_popup').hide();
	$('.loading').hide();
	
}
function check_login1(user,pass)
{
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
			if(xmlhttp.responseText== "FAIL")
			{
				window.location.href='login.php';
			}
		}
	}
	xmlhttp.open("GET","ajax.php?action=check_login&user="+user+"&pass="+pass,true);
	xmlhttp.send();
	
}
$(document).ready(function()
{
	var width = $(window).width();
	var left = (width-450)/2;
	$(".login_form").css("left",left);
	
	$(".reason_popup").css("left",left);

});
</script>
<?php
$remember = @$_COOKIE['remember'];
$check = @$_SESSION['id'];
if($remember == "true")
{
	
	$user = $_COOKIE['user'];
	$pass = md5($_COOKIE['pass']);
	$check_login = mysql_query("select * from user where user_name='".$user."' AND user_pass='".$pass."'");
	$row = mysql_fetch_array($check_login);
	$_SESSION['id'] = $row['id'];
	if($row['status'] == 1)
	{
		echo "<script>window.location.href='index.php';</script>";
	}
	else
	{
		echo "<script>window.location.href='admin/index.php';</script>";
	}
}
else
{
	if($check == "" &&  $check_link != "login.php" && $remember != "true")
	{
		echo "<script>window.location.href='login.php';</script>";
	}
	else
	{
		
		$check = "true";
		
	}
}


?>
<div class="loading"></div>
<div class="reason_popup">
	<p id="reason_popup"></p>
	<a class="close_popup" onclick="close_popup();">X</a>
</div>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
<header class="main-header">
	<a href="index.php" class="logo">
	<span class="logo-mini">P</span>
	<span class="logo-lg"><img src="logo.png"></span>
	</a>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<?php
		if(@$_SESSION['id'] != "")
		{
			$get_username = mysql_query("select * from user where id='".$_SESSION['id']."'");
			$row1 = mysql_fetch_array($get_username);	
			$get_noti = mysql_query("select * from month_confirm where user_id='".$_SESSION['id']."' and status != 1 and is_view = 1");
			$get_noti_count = @mysql_num_rows($get_noti);
		?>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-envelope-o"></i>
							<span class="label label-success" id="label-success"><?php echo $get_noti_count; ?></span>
						</a>
						<ul class="dropdown-menu">
							<?php 
							if($get_noti_count > 0)
							{
								echo '<li class="header" id="label-success-header">Bạn Có '.$get_noti_count.' messages</li>';
								echo '<li>
										<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">';
								while($row2 = mysql_fetch_array($get_noti))
								{
									
										if($row2['status'] == 2)
										{
											?>
											<li>
												<a href="#" id="update_noti1_<?php echo $row2['id']?>" onclick="return update_noti1(<?php echo $row2['id']?>)">
												<div class="pull-left">
												<img src="noti.png" class="img-circle">
												</div>
												<h4>
												Admin
												<small><i class="fa fa-clock-o"></i>
												<?php
													$starttime = $row2['time_accept'];
													$stoptime = date('Y-m-d H:i:s');
													$diff = (strtotime($stoptime) - strtotime($starttime));
													$total = $diff/60;
													echo sprintf("%02dh %02dm", floor($total/60), $total%60);		
												?>
												</small>
												</h4>
												<?php										
													echo "<p>Báo Cáo Lương Tháng ".date("m",strtotime($row2['month_accept']))." Của Bạn Đã Bị Huỷ Bỏ</p>";
												?>
												
												</a>
											</li>
											<?php
										}
										else if($row2['status'] == 0)
										{
											?>
											<li>
												<a href="#" id="update_noti_<?php echo $row2['id']?>" onclick="return update_noti(<?php echo $row2['id']?>)">
												<div class="pull-left">
												<img src="noti.png" class="img-circle">
												</div>
												<h4>
												Admin
												<small><i class="fa fa-clock-o"></i>
												<?php
													$starttime = $row2['time_accept'];
													$stoptime = date('Y-m-d H:i:s');
													$diff = (strtotime($stoptime) - strtotime($starttime));
													$total = $diff/60;
													echo sprintf("%02dh %02dm", floor($total/60), $total%60);		
												?>
												</small>
												</h4>
												<?php										
													echo "<p>Báo Cáo Lương Tháng ".date("m",strtotime($row2['month_accept']))." Của Bạn Đã Được Chấp Nhận</p>";
												?>
												</a>
											</li>
											<?php
											
										}
								}
								echo '</div>
									</li>';
							}
							else
							{
								echo '<li class="header">Bạn Không Có Thông Báo Nào</li>';
							}
							?>
							
						</ul>
					</li>
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="<?php echo $row1['image'] ?>" class="user-image" alt="User Image">
						</a>
						<ul class="dropdown-menu">
							<li class="user-header">
								<img src="<?php echo $row1['image'] ?>" class="img-circle" alt="User Image">
								<p>
								<?php echo $row1['user_name']; ?>
								</p>
							</li>

							<li class="user-footer">
								<div class="pull-left">
									<a href="info.php" class="btn btn-default btn-flat">Profile</a>
								</div>
								<div class="pull-right">
									<a class="btn btn-default btn-flat" href='?action=logout'>Thoát</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<?php
		}
		?>
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
				echo "<div class='pull-left info'><p><a class='info' href='info.php'>".$row1['user_name']."</a></p></div>";
			}
			?>
			
			
		</div>
		<ul class="sidebar-menu">

					<li class="treeview"><a href="index.php"><i class="fa fa-home"></i><span>Home</span></a></li>
					<li class="treeview"><a href="info.php"><i class="fa fa-info-circle"></i><span>Thông Tin Nhân Viên</span></a></li>
			
		</ul>
	</section>
</aside>