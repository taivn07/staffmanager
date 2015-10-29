<?php
include("layout/header.php");
$sql = "select * from user where status != 2";
$results = mysql_query($sql);
?>
<div class="content-wrapper" style="min-height: 916px;">
	<section class="content-header">
	<h1>Danh Sách Nhân Viên</h1>
	</section>
	<div class="box">
		<table class="date_info_table table table-bordered">
			<tr>
				<td>ID</td>
				<td>Tên Nhân Viên</td>
				<td>User Login</td>
				<td>Lương</td>
				<td style="width:30px">Block</td>
			</tr>
			<?php
				while($row = mysql_fetch_array($results))
				{
					?>
						<tr>
							<td><a href="staff_info.php?id=<?php echo $row['id'] ?>"><?php echo $row['id'] ?></a></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['user_name'] ?></td>
							<td><?php echo $row['luong'] ?></td>
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
						</tr>
					<?php
				}
			?>
		</table>
	</div>

<?php
include("layout/footer.php");
?>