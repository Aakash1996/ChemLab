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
		Manage Group
	</TITLE>
</HEAD>
<BODY>
	<header>
	    <div class="nav">
			<ul>
		        <ul>
		        <li><a href = "rhdash.php">Dashboard</a></li>
		        <li><a href = "editstock.php">Add Stock</a></li>
		        <li><a href = "viewinv.php">View inventory</a></li>
		        <li><a class = "active" href = "#">Manage Group</a></li>
		        <li><a href = "reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br></p>
	</header>
	<form action = "groupmanage.php">
	<fieldset>
		<legend>Update Budget</legend>
		<input type = 'Number' min = '1' name = 'budget'>
		<?php 
			$sql = "select `budget` from researchgroup where gID = ".$_SESSION['group'];
			$row = mysqli_fetch_row(mysqli_query($conn, $sql));
			echo $row[0];
		?>
		</input>
		<BUTTON name = 'budgetupd' id = 'budgetupd' type = 'submit'>Update</BUTTON>
	</fieldset>
	</form><br>
</BODY>
</HTML>