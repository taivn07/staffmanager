</div>
</body>


<script type="text/javascript" src="js/public/javascript/zebra_datepicker.js"></script>
<link rel="stylesheet" href="js/public/css/default.css" type="text/css">
<script>
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