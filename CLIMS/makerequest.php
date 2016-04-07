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
	$sql = "select `ID` from chemicals, stock where chemicals.ID = stock.chemID and stock.gID = ".$_SESSION['group']." order by ID asc";
	$result = mysqli_query($conn, $sql);
	$type = -1;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$CAS = $_POST['CAS'];
		$amt = $_POST['amount'];
		$sql = "select B.amount, R.amount from borrowrequest B, returnrequest R where B.reqID = R.reqID and YEAR(B.date) = YEAR(NOW()) AND MONTH(B.date)=MONTH(NOW()) and B.uid = '".$_SESSION['user']."' and B.cid = '".$CAS."'";
		$resultset = mysqli_query($conn, $sql);
		$tillnow = 0;
		while($row = mysqli_fetch_row($resultset))
			$tillnow += $row[0]-$row[1];
		$sql = "select limit from chemicals where id='".$CAS."'";
		$resultset = mysqli_query($conn, $sql);
		$row = mysqli_fetch_row($resultset);
		$type = 1;
		if($tillnow + $amt > $row[0])
			$type = 2;
		$sql = "insert into borrowrequest(`uID`, `cID`, `amount`, `date`, `time`, `state`) values ('".$_SESSION['user']."', '".$CAS."', ".$amt.", CURDATE(), CURTIME(), ".$type.")";
		mysqli_query($conn, $sql);
	}
?>
<HTML>
<HEAD>
	<STYLE type="text/css">
		.nav ul {
			list-style: none;
			background-color: #444;
			text-align: center;
			padding: 0;
			margin: 0;
		}

		.nav li {
			font-family: 'Oswald', sans-serif;
			font-size: 1.2em;
			line-height: 40px;
			height: 40px;
			border-bottom: 1px solid #888;
		}
 
		.nav a {
			text-decoration: none;
			color: #fff;
			display: block;
			transition: .3s background-color;
		}
 
		.nav a:hover {
			background-color: #005f5f;
		}
 
		.nav a.active {
			background-color: #fff;
			color: #444;
			cursor: default;
		}
 
		@media screen and (min-width: 600px) {
			.nav li {
				width: 120px;
				border-bottom: none;
				height: 50px;
				line-height: 50px;
				font-size: 1.4em;
			}

			.nav li {
				display: inline-block;
				margin-right: -4px;
			}
		}
	</STYLE>
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
			if(!$result || mysqli_num_rows($result == 0)){
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
		?>
</BODY>
</HTML>