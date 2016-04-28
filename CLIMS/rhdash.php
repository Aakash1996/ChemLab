<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'R'){
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
		        <li><a class = "active" href="#">Dashboard</a></li>
		        <li><a href = "editstock.php">Add Stock</a></li>
		        <li><a href = "updatechemical.php">Update Chemical</a></li>
		        <li><a href = "viewinv.php">View inventory</a></li>
		        <li><a href = "groupmanage.php">Manage Group</a></li>
		        <li><a href = "reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br></p>
	</header>
	
	
	<H3>Budget:
	
	<?php 
		$sql = "select `budget` from researchgroup where gID = '".$_SESSION['group']."'";
		$row = mysqli_fetch_row(mysqli_query($conn, $sql));
		echo $row[0]; 
	?>
	</H3><br>
	<H3> Group Members</H3>
	<p>
	<?php
		$sql="select memID from groupdetails where gID = '".$_SESSION['group']."'";
		$resultset = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_row($resultset))
			echo $row[0]."<br>";
	?>
	</p><br>
	<H3>Group Incharge</H3>
	<p>
	<?php
		$sql = "select tlID from researchgroup where gID = ".$_SESSION['group'];
		$resultset = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_row($resultset))
			echo $row[0]."<br>";
	?>
	</p><br>
	<H3>Chemicals running low</H3>
	<p>
	<?php
		$sql = "select chemID from stock where gID = ".$_SESSION['group']." and amount<=(select min from chemicals where id=chemID)";
		//echo $sql;
		$resultset = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_row($resultset))
			echo $row[0]."<br>";
	?>

</BODY>
</HTML>
