<?php 
session_start();
include("connection.php");
?>

<html>
<head>
	<title>Stop</title>
</head>
<body>

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
	Search Stops:
	<INPUT TYPE = "TEXT" name = "stopnumber" value="<?php if(isset($_POST['stopnumber'])) { echo htmlentities ($_POST['stopnumber']); }?>"/>
	<INPUT TYPE = "Submit" Name = "stop_submit" VALUE = "Stop Info">
</FORM>
<?php
	
?>
<h1>Stop Results</h1>
<?php 
	if($numofrecords > 0) {
		echo $numofrecords .' records returned';
	}
?>
<table width="100%" border="1" cellspacing="1" cellpadding="4">
	<tr>
	<td width="30%">Stop number</td>
	<td width="30%">Stop address</td>
	<td width="30%">Service numbers served </td>
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