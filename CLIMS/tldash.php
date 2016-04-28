<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'T'){
		header('Location: logout.php');
		die();
	}
	$sql = "select reqID from borrowrequest where uID in (select memID from groupdetails where gID = ".$_SESSION['group'].") and state in (1, 2)";
	$result = mysqli_query($conn, $sql);
	$sql = "select returnrequest.reqID from returnrequest where reqID in (select borrowrequest.reqID from borrowrequest where uID in (select memID from groupdetails where gID = ".$_SESSION['group'].")) and state = 1";
	$result2 = mysqli_query($conn, $sql);
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
			        <li><a href = "viewinv.php">View Inventory</a></li>
			        <li><a href = "reset.php">Reset Password</a></li>
			    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $_SESSION['user'];?><br><a href="logout.php">Logout</a><br></p>
	</header>
	<form action = "verifyborrow.php" method = "POST">
	<fieldset>
		<legend>Verify borrow request</legend>
		<?php
			if(mysqli_num_rows($result) == 0)
				echo "No Pending Borrow Requests";
			else{
				echo "Request ID : <select name = 'reqID'>";
			
				while($row = mysqli_fetch_row($result))
					echo "<option value = '".$row[0]."'>".$row[0]."</option>";
				echo "</select><br><button type = 'submit'>Continue</button>";
			}
		?>
	</fieldset>
	</form>
	<form action = "verifyreturn.php" method = "POST">
	<fieldset>
		<legend>Verify return requests</legend>
		<?php
			if(mysqli_num_rows($result2) == 0)
				echo "No Pending return Requests";
			else{
				echo "Request ID : <select name = 'reqID'>";
			
				while($row = mysqli_fetch_row($result2))
					echo "<option value = '".$row[0]."'>".$row[0]."</option>";
				echo "</select><br><button type = 'submit'>Continue</button>";
			}
		?>
	</fieldset>
	</form>
</BODY>
