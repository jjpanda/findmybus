<?php 
session_start();
include("connection.php");
?>

<html>
<title>Stop</title>
<link rel="stylesheet" href="w3.css">
<body class="w3-container w3-padding-32">

<a href="index.php">Back</a><p>

<?php
	$stopnumber = '99999';
	$numofrecords = 0;
	
	if (isset($_POST['stop_submit'])){
		
		$stopnumber = $_POST['stopnumber'];
		
	}
	
	$result1 = $conn->query("select 
								bs.StopNumber,
								bs.address,
								count(br.servicenumber) as 'total'
								from 
								bus_stop bs left join bus_route br on bs.stopnumber = br.stopnumber
								where 
								(bs.StopNumber like '%$stopnumber%' or bs.StopNumber like '%$stopnumber' or bs.StopNumber like '$stopnumber%')
								group by bs.stopnumber");

	$numofrecords = mysqli_num_rows($result1);
?>

<FORM NAME ="stop_service" METHOD ="POST" ACTION = "stop.php">
	<b>Search Stops:</b>
	<INPUT class="w3-input" TYPE = "TEXT" name = "stopnumber" value="<?php if(isset($_POST['stopnumber'])) { echo htmlentities ($_POST['stopnumber']); }?>"/><br>
	<INPUT class="w3-button" TYPE = "Submit" Name = "stop_submit" VALUE = "Stop Info">
</FORM>
<?php
	
?>
<h1>Stop Results</h1>
<?php 
	if($numofrecords > 0) {
		echo $numofrecords .' records returned';
	}
?>
<table class="w3-table-all">
	<tr>
	<th>Stop number</th>
	<th>Stop address</th>
	<th>Service numbers served </th>
	</tr>
	<?php
	
	if($numofrecords > 0){
		while($row = $result1->fetch_assoc()) 
		{
			echo 
				'<tr>
					<td>' . $row['StopNumber'] . '</td>
					<td>' . $row['address'] . '</td>
					<td>' . $row['total'] . '</td>
				</tr>';
		}
	}
	else {
		echo 
			'<tr>
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