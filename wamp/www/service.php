<?php 
session_start();
include("connection.php");
?>

<html>

<title>Service</title>
<link rel="stylesheet" href="w3.css">

<body class="w3-container w3-padding-32">

<a href="index.php">Back</a><p>

<?php
	$servicenumber = '';
	$numofrecords1 = 0;
	$numofrecords2 = 0;
	
	if (isset($_POST['service_submit'])){
		
		$servicenumber = $_POST['servicenumber'];
		
	}
	
	$result1 = $conn->query("select 
								br.stopnumber, 
								bs.locationdesc,
								br.stoporder
								from
								bus_route br left join bus_stop bs on br.stopnumber = bs.stopnumber
								where
								br.routenumber = 1 and
								br.servicenumber = '$servicenumber'
								order by br.stoporder");

	$result2 = $conn->query("select 
								br.stopnumber, 
								bs.locationdesc,
								br.stoporder
								from
								bus_route br left join bus_stop bs on br.stopnumber = bs.stopnumber
								where
								br.routenumber = 2 and
								br.servicenumber = '$servicenumber'
								order by br.stoporder");

	$numofrecords1 = mysqli_num_rows($result1);
	$numofrecords2 = mysqli_num_rows($result2);
?>

<FORM NAME ="search_service" METHOD ="POST" ACTION = "service.php">
	Service:
	<INPUT TYPE = "TEXT" name = "servicenumber" value="<?php if(isset($_POST['servicenumber'])) { echo htmlentities ($_POST['servicenumber']); }?>"/>
	<INPUT TYPE = "Submit" Name = "service_submit" VALUE = "Get Service Info">
</FORM>
<?php
	
?>
<h1>ROUTE 1</h1>
<?php 
	if($numofrecords1 > 0) {
		echo $numofrecords1 .' records returned';
	}
?>
<table width="100%" border="1" cellspacing="1" cellpadding="4">
	<tr>
	<td width="30%">Stop number</td>
	<td width="30%">Stop location description</td>
	<td width="30%">Stop order </td>
	</tr>
	<?php
	
	if($numofrecords1 > 0){
		while($row = $result1->fetch_assoc()) 
		{
			echo 
				'<tr>
					<td>' . $row['stopnumber'] . '</td>
					<td>' . $row['locationdesc'] . '</td>
					<td>' . $row['stoporder'] . '</td>
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
<?php
	if($numofrecords2 > 0){
		echo '<h1>ROUTE 2</h1>';
		echo $numofrecords1 .' records returned';
		echo '
			<table width="100%" border="1" cellspacing="1" cellpadding="4">
				<tr>
				<td width="30%">Stop number</td>
				<td width="30%">Stop location description</td>
				<td width="30%">Stop order </td>
				</tr>';
		while($row = $result2->fetch_assoc()) 
		{
			echo 
				'<tr>
					<td>' . $row['stopnumber'] . '</td>
					<td>' . $row['locationdesc'] . '</td>
					<td>' . $row['stoporder'] . '</td>
				</tr>';
		}
	}
	$result2->free();
?>

</body>
</html>