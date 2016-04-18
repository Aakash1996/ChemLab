<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'S'){
		//echo "GO BACK";
		header('Location: logout.php');
		die();
	}
	//$sql = 'select `reqID` from borrowrequest where uid=\''.$_SESSION['user'].'\' MINUS select `reqID` from returnrequest where uid=\''.$_SESSION['user'].'\'';
	$type = -1;
	$error = 0;
	$stocklt = 0;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$CAS = $_POST['CAS'];
		$amt = $_POST['amount'];
	if(!$amt || $amt == 0){
 			$type = 3;}
	else{		
		$sql = "select amount from stock where chemID = '".$CAS."' and gID = '".$_SESSION['group']."'";
		//echo $sql;
		$row = mysqli_fetch_row(mysqli_query($conn, $sql));
		$stocklt = $row[0];
		//echo $stocklt;
		if($amt>$stocklt){
			$error = 1;
		}
		else{
			$sql = "select amount from borrowrequest where YEAR(date) = YEAR(NOW()) AND MONTH(date)=MONTH(NOW()) and uid = '".$_SESSION['user']."' and cid = '".$CAS."'";
			//echo $sql;
			$resultset = mysqli_query($conn, $sql);
			$tillnow = 0;
			while($row = mysqli_fetch_row($resultset))
				$tillnow += $row[0];
			$sql = "select amount from returnrequest where reqID in (select reqID from borrowrequest where YEAR(date) = YEAR(NOW()) AND MONTH(date)=MONTH(NOW()) and uid = '".$_SESSION['user']."' and cid = '".$CAS."')";
			$resultset = mysqli_query($conn, $sql);
			//echo $sql;
			while($row = mysqli_fetch_row($resultset))
				$tillnow -= $row[0];
			//echo $tillnow;
			$sql = "select `limit` from chemicals where id='".$CAS."'";
			$resultset = mysqli_query($conn, $sql);
			$row = mysqli_fetch_row($resultset);
			$type = 1;
			if($tillnow + $amt > $row[0])
				$type = 2;
			$sql = "insert into borrowrequest(`uID`, `cID`, `amount`, `date`, `time`, `state`) values ('".$_SESSION['user']."', '".$CAS."', ".$amt.", CURDATE(), CURTIME(), ".$type.")";
			mysqli_query($conn, $sql);
			$sql = "update stock set amount = amount-".$amt." where chemID=".$CAS." and gID=".$_SESSION['group']."";
			mysqli_query($conn, $sql);
			//echo $sql;
		}
	}
}
	$sql = "select `ID` from chemicals, stock where chemicals.ID = stock.chemID and stock.gID = ".$_SESSION['group']." and stock.amount>0 order by ID asc";
	$result = mysqli_query($conn, $sql);
?>
<HTML>
<HEAD>
	<link rel="stylesheet" type="text/css" href="CSS/navbar.css">
	<TITLE>
		Borrow
	</TITLE>
</HEAD>
<BODY>
	<header>
	    <div class="nav">
			<ul>
		        <ul>
		        <li><a href="stdash.php">Dashboard</a></li>
		        <li><a class = "active" href="#">Borrow</a></li>
		        <li><a href = "return.php">Return</a></li>
		        <li><a href="viewinv.php">View inventory</a></li>
		        <li><a href="reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	</header>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br>
	    <div class = "fieldset-auto-width">
		<form action = 'makerequest.php' method="post">
		<fieldset>
		<legend>Borrow Chemical</legend>
		<?php
			//echo var_dump($result);
			if(mysqli_num_rows($result) == 0){
				echo "No chemicals to borrow";
			}
			else{
				echo "
				CAS Number:
				<select name='CAS'><center>
				";
				while($row = mysqli_fetch_row($result)){
					echo "<option value='".$row[0]."'> ".$row[0]."</option>";
				}
				echo"
				</select>
				<br><br>
				Quantity: <input type='number' name='amount'>
				<br><br>
				<button type='submit' name='submit'>SUBMIT</button>
				";
			}
		?>
		</fieldset>

		<?php
			if($type == 1)
				echo "Request Made Successfully";
			else if($type == 2)
				echo "Amount over borrow limit for current month. Decision to accept is with incharge.";
			else if($type == 3)
				echo "Enter the amount.";
			if($error == 1)
				echo "Only ".$stocklt." of this chmical available";
		?>
</BODY>
</HTML>
