<?php 
session_start();
include("connection.php");
?>

<html>
<head>
	<title>Sample Page</title>
</head>
<body>

<a href="index.php">Back</a><p>

<?php

	$init = 0;
	$offday = 0;
	
	if (isset($_POST['driver_submit'])){
		
		$offday = $_POST['offday'];
		if ($offday == 0){
			$init = 0;
		}
		else{
			$init = 1;
		}
	}
	
	$result1 = $conn->query("select
								distinct
								d.staffid,
								d.nric,
								d.drivername, 
								d.licensenumber
								from
								driver d left join driver_offdays do on d.staffid = do.staffid
								where 
								1 = '$init' and 
								do.offday <> '$offday'
								order by d.drivername, d.staffid");

?>

<FORM NAME ="driver_service" METHOD ="POST" ACTION = "driver.php">
	Work Day:
	<select name="offday" onchange='this.form.submit()'>
		<option value="0" <?php if (isset($_POST['offday']) && $_POST['offday']==8) {echo "selected='selected'"; } ?>>Select...</option>
		<option value="1" <?php if (isset($_POST['offday']) && $_POST['offday']==1) {echo "selected='selected'"; } ?>>Monday</option>
		<option value="2" <?php if (isset($_POST['offday']) && $_POST['offday']==2) {echo "selected='selected'"; } ?>>Tuesday</option>
		<option value="3" <?php if (isset($_POST['offday']) && $_POST['offday']==3) {echo "selected='selected'"; } ?>>Wednesday </option>
		<option value="4" <?php if (isset($_POST['offday']) && $_POST['offday']==4) {echo "selected='selected'"; } ?>>Thursday </option>
		<option value="5" <?php if (isset($_POST['offday']) && $_POST['offday']==5) {echo "selected='selected'"; } ?>>Friday </option>
		<option value="6" <?php if (isset($_POST['offday']) && $_POST['offday']==6) {echo "selected='selected'"; } ?>>Saturday </option>
		<option value="7" <?php if (isset($_POST['offday']) && $_POST['offday']==7) {echo "selected='selected'"; } ?>>Sunday</option>
	</select>
	<INPUT TYPE="hidden" name="driver_submit" />
</FORM>
<?php
	
?>
<h1>Driver Results</h1>
<table width="100%" border="1" cellspacing="1" cellpadding="4">
	<tr>
	<td width="25%">Staff ID</td>
	<td width="25%">NRIC</td>
	<td width="25%">Driver Name</td>
	<td width="25%">License Number </td>
	</tr>
	<?php
	
	if(mysqli_num_rows($result1) > 0){
		while($row = $result1->fetch_assoc()) 
		{
			echo 
				'<tr>
					<td>' . $row['staffid'] . '</td>
					<td>' . $row['nric'] . '</td>
					<td>' . $row['drivername'] . '</td>
					<td>' . $row['licensenumber'] . '</td>
				</tr>';
		}
	}
	else {
		echo 
			'<tr>
				<td>Empty</td>
				<td>Empty</td>
				<td>Empty</td>
				<td>Empty</td>
			</tr>';
	}
	
	$result1->free();
	?>
</table>

</body>
</html>