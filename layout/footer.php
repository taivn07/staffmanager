</div>
</body>
<link type="text/css" href="css/bootstrap-timepicker.min.css" />
<script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="js/public/javascript/zebra_datepicker.js"></script>
<link rel="stylesheet" href="js/public/css/default.css" type="text/css">
<script>
$(document).ready(function()
{
	$('.timepicker2').timepicker({
		minuteStep: 1,
		template: 'modal',
		appendWidgetTo: 'body',
		showSeconds: false,
		showMeridian: false,
		defaultTime: false
	});
});

$('#datepicker1').Zebra_DatePicker({
	format: 'm-Y',
	onSelect: function() {
		var data = $('#datepicker1').val();
		var user_id = $('#user_id').val();
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
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("statistical").innerHTML=xmlhttp.responseText;
					$('.timepicker2').timepicker({
						minuteStep: 1,
						template: 'modal',
						appendWidgetTo: 'body',
						showSeconds: false,
						showMeridian: false,
						defaultTime: false
					});
				}
				else
				{
					alert("fail");
					return false;
				}
			}
		}
		xmlhttp.open("GET","ajax.php?action=staffmonthchange&data="+data+"&user_id="+user_id,true);
		xmlhttp.send();
	}
});

</script>
</html>