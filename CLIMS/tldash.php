<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'T'){
		header('Location: logout.php');
		die();
	}
?>
<HTML>
<HEAD>
	<link rel="stylesheet" type="text/css" href="CSS/navbar.css">
	<TITLE>
		Dashboard
	</TITLE>
</HEAD>
<BODY>
	<header>
	    <div class="nav">
			<ul>
		        <ul>
		        <li><a class = "active" href ="#">Dashboard</a></li>
		        <li><a href = acceptrequest.php>Pending Request</a></li>
		        <li><a href = "viewinv.php">View inventory</a></li>
		        <li><a href = "groupmanage.php">Manage Group</a></li>
		        <li><a href = "reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br></p>
	</header>
	

