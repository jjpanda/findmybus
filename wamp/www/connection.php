<?php
$hostname='localhost';
$mysql_login='root';//costa_root
$mysql_password='';//omega
$database='findmybus';

$conn = new mysqli($hostname, $mysql_login , $mysql_password, $database);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>
