<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'T' || $_SERVER['REQUEST_METHOD'] != 'POST'){
		header('Location: logout.php');
		die();
	}
	if(isset($_POST['close_AC'])){
		$sql = "update borrowrequest set state = 0 where reqID = ".$_SESSION['reqID'];
		mysqli_query($conn, $sql);
		header("Location: tldash.php");
	}
	if(isset($_POST['close_DEC'])){
		$sql = "update borrowrequest set state = 0 where reqID = ".$_SESSION['reqID'];
		mysqli_query($conn, $sql);
		header("Location: tldash.php");
	}
	$reqID = $_POST['reqID'];
	$_SESSION['reqID'] = $reqID;
	$sql = "select * from borrowrequest where reqID = ".$reqID;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_row($result);
?>
<HTML>
<HEAD>
	<TITLE>
		Dashboard
	</TITLE>
</HEAD>
<BODY>
	<table border = '1'>
	<tr><th>Request ID</th><td><?php echo $row[0];?></td></tr>
	<tr><th>User ID</th><td><?php echo $row[1];?></td></tr>
	<tr><th>CAS</th><td><?php echo "<a href = 'showdetails.php?id=".$row[2]."' target='_blank'>".$row[2]."</a>";?></td></tr>
	<tr><th>Amount</th><td><?php echo $row[3];?></td></tr>
	<tr><th>Date</th><td><?php echo $row[4];?></td></tr>
	<tr><th>Time</th><td><?php echo $row[5];?></td></tr>
	<tr><th>Over Limit</th><td>
	<?php 
		if($row[6] == 1)
			echo "No";
		else
			echo "Yes";
	?>
	</td></tr>
	</table>
	<form action = "verifyborrow.php" method="POST">
	<button type = 'submit' name='close_AC'>Verified</button>
	<?php
		if($row[6] == 2)
			echo "<button type = 'submit' name='close_DEC'>Declined</button>"
	?>
	</form>
</BODY>
</HTML>