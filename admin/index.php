<?php
include("layout/header.php");
$sql = "select * from user where status != 2";
$results = mysql_query($sql);
?>
<script>
function send(user_id)
{
	var reason_text = $('.reason_text').val();
	if(reason_text != "")
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
					alert("Gửi Thư Thành Công");
					//window.location.href='index.php';
				}
				else
				{
					alert("Gửi Thư Không Thành Công");
					//window.location.href='index.php';
				}
			}
		}
		xmlhttp.open("GET","admin_ajax.php?action=send_mail&user_id="+user_id+"&reason="+reason_text,true);
		xmlhttp.send();
	}
	else
	{
		alert("Mời Nhập Lý Do");
		return false;
	}
}
function send_mail(user_id)
{
	$(".sendmail_form").show();
	$(".loading").show();
	$('#reason_ok').attr("onclick","return send("+user_id+")");
}
function close1()
{
	$(".sendmail_form").hide();
	$(".loading").hide();
}
$(document).ready(function()
{
	var width = $(window).width();
	var left = (width-450)/2;
	$(".sendmail_form").css("left",left);
	
	
});
</script>
<div class="sendmail_form">
	<ul>
		<li>
			Nội Dung
		</li>
		<li>
			<textarea class="reason_text" name="info"></textarea>
		</li>
	</ul>
	<ul>
		<li>
			<input type="submit" onclick="return send()" id="reason_ok" name="reason_ok" value="Send">
		</li>
		<li>
			<input type="submit" onclick="return close1()" id="reason_cancel" name="reason_cancel" value="Cancel">
		</li>
	</ul>
</div>
<div class="content-wrapper" style="min-height: 916px;">
	<section class="content-header">
	<h1>Danh Sách Nhân Viên</h1>
	</section>
	<div class="box">
		<table class="date_info_table table table-bordered">
			<tr>
				<th>ID</th>
				<th>Tên Nhân Viên</th>
				<th>User Login</th>
				<th>Lương</th>
				<th style="width:30px">Block</th>
				<th style="width:30px">Gửi Mail</th>
			</tr>
			<?php
				while($row = mysql_fetch_array($results))
				{
					?>
						<tr>
							<td><a href="staff_info.php?id=<?php echo $row['id'] ?>"><?php echo $row['id'] ?></a></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['user_name'] ?></td>
							<td><?php echo substr(number_format(ceil($row['luong']),2),0,-3); ?></td>
							<td style="width:30px">
							<?php
								if($row['status'] == 1)
								{
									echo "<input disabled='disabled' type='checkbox'>";
								}									
								else
								{
									echo "<input disabled='disabled'disabled='disabled' type='checkbox' checked>";
								}
							?></td>
							<td><input type="button" class="btn btn-primary" onclick="return send_mail(<?php echo $row['id'] ?>);" value="Gửi Mail"></td>
						</tr>
					<?php
				}
			?>
		</table>
	</div>

<?php
include("layout/footer.php");
?>