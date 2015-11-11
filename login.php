<?php
include("layout/header.php");


?>
<script>
$('body').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        check_login();  
    }
});



function check_login()
{
	var user = $('#user_name').val();
	var pass = $('#pass').val();
	if ($('#remember_login').is(':checked')) 
	{
		var remember_login = 1;
	}
	else
	{
		var remember_login = 0;
	}
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
				$('#error_label').show();	
				document.getElementById("error_label").innerHTML = "<i class='fa fa-times-circle-o'></i>   Đăng Nhập Thất Bại";
				return false;
			}
			else if(xmlhttp.responseText== "OK")
			{
				Cookies.remove('user');
				Cookies.remove('pass');
				Cookies.remove('remember');
				window.location.href='index.php';
			}
			else  if(xmlhttp.responseText== "OK2")
			{
				Cookies.set('user', user, { expires: 7 });
				Cookies.set('pass', pass, { expires: 7 });
				Cookies.set('remember', true, { expires: 7 });	
				window.location.href='index.php';
			}
			else if(xmlhttp.responseText== "OK1")
			{

				Cookies.remove('user');
				Cookies.remove('pass');
				Cookies.remove('remember');
				window.location.href='admin/index.php';
			}
			else if(xmlhttp.responseText== "OK3")
			{
				Cookies.set('user', user, { expires: 7 });
				Cookies.set('pass', pass, { expires: 7 });
				Cookies.set('remember', true, { expires: 7 });
				window.location.href='admin/index.php';
			}
		}
	}
	xmlhttp.open("GET","ajax.php?action=check_login&user="+user+"&pass="+pass+"&remember="+remember_login,true);
	xmlhttp.send();
}
</script>
<div class="content-wrapper" style="min-height: 916px;">
	<section class="content-header">
	<h1></h1>
	</section>
	<div class="content">
		<div id="statistical" class="box">
			<div class="box-header with-border">
				<h3>Đăng Nhập</h3>
			</div>
			<label class="control-label error_label"   for="inputError"><i class="fa fa-times-circle-o"></i></label>
			<form action="">
				<div class="box-body">
					<div class="form-group has-error">
						<label class="control-label" id="error_label" for="inputError"></label>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Username</label>
						<input type="text" id="user_name" class="form-control" name="user">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Password</label>
						<input type="password" id="pass" class="form-control" name="pass">
					</div>
					<div class="form-group">
						<label><input type="checkbox" name="checkbox" value="1" id="remember_login"> Ghi Nhớ Đăng Nhập</label>
					</div>
				</div>
				<div class="box-footer">
					<td style="text-align:center" colspan="2"><input type="button" onclick="check_login();" name="login" value="Đăng Nhập"></td>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
include("layout/footer.php");
?>