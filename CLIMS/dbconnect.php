<?php
	$mysql_hostname = "localhost";
	$mysql_user = "root";
	$mysql_password = "";
	$mysql_database = "clims";
	$conn = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database) 
	or die("Oops some thing went wrong");
	mysqli_select_db($conn, $mysql_database) or die("Opps some thing went wrong while selecting database");
?>
