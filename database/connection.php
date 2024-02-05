 <?php

$con = new mysqli("localhost","S4648866","v1v4!sAw00?.","S4648866");
//$con = new mysqli("localhost","root","","S4648866");

	if ($con->connect_error) {
		die("Failed to connect to MySQL: " . $con->connect_error);
	}
	
?>