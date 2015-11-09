<?php
header("Content-type: text/html;charset=UTF-8");
$host       = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'staff_manager';
include '../PHPMailer/class.phpmailer.php';
$con = mysql_connect($host, $username, $password);
mysql_select_db($database, $con);
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
mysql_query("SET CHARACTER SET utf8");
$action = @$_REQUEST['action'];

if($action == "send_mail")
{
	$reason = $_REQUEST['reason'];
	$user_id = $_REQUEST['user_id'];
	$user_info = mysql_query("select * from user where id=".$user_id);
	$row = mysql_fetch_array($user_info);
	
	$mail = new PHPMailer(); // defaults to using php "mail()"
	$mail->CharSet = 'UTF-8';
	$mail->SetFrom('baquevn17@gmail.com', 'First Last');
	$mail->addAddress($row['email']);
	$mail->Subject = "Thông Báo Từ Paditech";
	$mail->MsgHTML("Gửi ".$row['name']."<br>");
	$mail->MsgHTML($reason);
	if(!$mail->send()) {
		echo "Fail";
	} else {
		echo "OK";
	}
}
if($action == "update_staff")
{
	$time_accept = date('Y-m-d H:i:s');	
	$month_accept = $_REQUEST['date'];
	$user_id = $_REQUEST['user_id'];
	$results = mysql_query("update month_confirm set status=0,is_view=1,time_accept='".$time_accept."' where month_accept='".$month_accept."' and user_id=".$user_id);
	if($results == true)
	{
		echo "OK";
	}
	else
	{
		echo "Fail";
	}
}
if($action == "cancel_staff")
{
	$time_accept = date('Y-m-d H:i:s');	
	$month_accept = $_REQUEST['date'];
	$user_id = $_REQUEST['user_id'];
	$reason = $_REQUEST['reason'];
	$results = mysql_query("update month_confirm set status=2,is_view=1,time_accept='".$time_accept."',reason='".$reason."' where month_accept='".$month_accept."' and user_id=".$user_id);
	if($results == true)
	{
		echo "OK";
	}
	else
	{
		echo "Fail";
	}
}
?>