<?php 
session_start();
include("connection.php");
?>

<html>
<title>Trip</title>
<link rel="stylesheet" href="w3.css">
<body class="w3-container w3-padding-32">

<a href="index.php">Back</a><p>

<?php

	$servicenumber = 0;
	$tripdate = '2222-01-01';
	$s_triptime = '00:00';
	$e_triptime = '23:59';
	$numofrecords = 0;
	
	if (isset($_POST['trip_submit'])){
		$servicenumber = $_POST['servicenumber'];
		
		if ($_POST['tripdate']==''){
			$tripdate = '2016-09-21';
		}
		else{
			$tripdate = $_POST['tripdate'];
		}
			
		if ($_POST['s_triptime']==''){
			$s_triptime = '00:00';
		}
		else{
			$s_triptime = $_POST['s_triptime'];
		}
		
		if ($_POST['e_triptime']==''){
			$e_triptime = '23:59';
		}
		else{
			$e_triptime = $_POST['e_triptime'];
		}
	}
	
	$result1 = $conn->query("select
								t.tripdate,
								t.triptime,
								t.routenumber,
								d.drivername,
								t.busplate,
								if(t.cancelled = '1', 'Cancelled', '') as 'status'
								from
								trip t left join driver d on t.driver = d.staffid
								where
								t.servicenumber = '$servicenumber' and
								t.tripdate = '$tripdate' and 
								t.TripTime between '$s_triptime' and '$e_triptime'
								order by triptime, routenumber
							");
	
	$numofrecords = mysqli_num_rows($result1);

?>

<FORM NAME ="trip_service" METHOD ="POST" ACTION = "trip2.php">
	Service:
	<select name="servicenumber">
		<?php 
			$sql = $conn->query("Select distinct servicenumber from trip order by servicenumber * 1");
			while ($row = $sql->fetch_assoc()){
				echo "<option value= '{$row['servicenumber']}'";
				    if (isset($_POST['servicenumber']) && $_POST['servicenumber']==$row['servicenumber'])
					echo "selected = 'selected'";
				echo "> {$row['servicenumber']} </option>";
			}
		?>
	</select><br>
	Date (yyyy-mm-dd)
	<INPUT TYPE = "TEXT" name = "tripdate" value="<?php if(isset($_POST['tripdate'])) { echo htmlentities ($_POST['tripdate']); }?>"/><br>
	Start Time (hh:mm)
	<INPUT TYPE = "TEXT" name = "s_triptime" value="<?php if(isset($_POST['s_triptime'])) { echo htmlentities ($_POST['s_triptime']); }?>"/><br>
	End Time (hh:mm)
	<INPUT TYPE = "TEXT" name = "e_triptime" value="<?php if(isset($_POST['e_triptime'])) { echo htmlentities ($_POST['e_triptime']); }?>"/><br>
	<INPUT TYPE = "Submit" Name = "trip_submit" VALUE = "Get Trip">
</FORM>
<?php
	
?>
<h1>Trip Results</h1>
<?php 
	if($numofrecords > 0) {
		echo $numofrecords .' records returned';
	}
?>
<table class="w3-table-all">
	<tr>
	<th>Trip Date</th>
	<th>Trip Time</th>
	<th>Route number</th>
	<th>Driver Name</th>
	<th>Bus plate number</th>
	<th>Status</th>
	</tr>
	<?php
	
	if($numofrecords > 0){
		while($row = $result1->fetch_assoc()) 
		{
			echo 
				'<tr>
					<td>' . $row['tripdate'] . '</td>
					<td>' . $row['triptime'] . '</td>
					<td>' . $row['routenumber'] . '</td>
					<td>' . $row['drivername'] . '</td>
					<td>' . $row['busplate'] . '</td>
					<td>' . $row['status'] . '</td>
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
				<td>Empty</td>
				<td>Empty</td>
			</tr>';
	}
	
	$result1->free();
	?>
</table>

</body>
</html>