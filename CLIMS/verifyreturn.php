<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'T' || $_SERVER['REQUEST_METHOD'] != 'POST'){
		header('Location: logout.php');
		die();
	}
	if(isset($_POST['close_AC'])){
		$sql = "update returnrequest set state = 0 where reqID = ".$_SESSION['reqID'];
		mysqli_query($conn, $sql);
		$sql = "update stock set amount = amount+".$_SESSION['amt']." where chemID = (select cID from borrowrequest where reqID=".$_SESSION['reqID'].") and gID=".$_SESSION['group'];
		mysqli_query($conn, $sql);
		//echo $sql;
		header("Location: tldash.php");
	}
	$reqID = $_POST['reqID'];
	$_SESSION['reqID'] = $reqID;
	$sql = "select R.reqID, B.uID, B.cID, R.amount, R.date, R.time from returnrequest R, borrowrequest B where R.reqID = B.reqID and R.reqID = ".$reqID;
	//echo $sql;
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
	<tr><th>Amount</th><td><?php $_SESSION['amt'] = $row[3]; echo $row[3];?></td></tr>
	<tr><th>Date</th><td><?php echo $row[4];?></td></tr>
	<tr><th>Time</th><td><?php echo $row[5];?></td></tr>
	</table>
	<form action = "verifyreturn.php" method="POST">
	<button type = 'submit' name='close_AC'>Verified</button>
	</form>
</BODY>
</HTML>