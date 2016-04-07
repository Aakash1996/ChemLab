<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'S'){
		//echo "GO BACK";
		header('Location: logout.php');
		die();
	}
	$error = -1;
	$amt = 0;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$id = $_POST['reqID'];
		$amt = $_POST['amt'];
		$sql = "select amount from borrowrequest where reqID = ".$id;
		$row = mysqli_fetch_row(mysqli_query($conn, $sql));
		if($amt>$row[0])
			$error = 1;
		else{
			$sql = "update table borrowrequest set state = -1 where reqID = ".$id;
			mysqli_query($conn, $sql);
			$sql = "insert into returnrequest values(".$id.", ".$amt.", CURDATE(), CURTIME(), 1)";
			mysqli_query($conn, $sql);
			$error = 0;
		}
	}
	$sql = "select reqID from borrowrequest where `state` = 0 and `uID` = '".$_SESSION['user']."'";
	$result = mysqli_query($conn, $sql);
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
		Return
	</TITLE>
</HEAD>
<BODY>
	<header>
	    <div class="nav">
			<ul>
		        <ul>
		        <li><a href="stdash.php">Dashboard</a></li>
		        <li><a href="makerequest.php">Borrow</a></li>
		        <li><a class = "active" href="#">Return</a></li>
		        <li><a href="viewinv.php">View inventory</a></li>
		        <li><a href="reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	</header>
	<p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br>
	    <div class = "fieldset-auto-width">
		<form action = 'return.php' method="post">
		<fieldset>
		<legend>Return Chemical</legend>
		<?php
		if(mysqli_num_rows($result) == 0){
			echo "No valid borrow requests";
		}
		else{
			echo "
			Borrow Request ID:
			<select name='reqID'><center>
				";
				while($row = mysqli_fetch_row($result)){
					echo "<option value='".$row[0]."'> ".$row[0]."</option>";
				}
			echo "
			</select>
			<br><br>
			Quantity: <input type='number' name='amt'>
			<br><br>
			<button type='submit' name='submit'>SUBMIT</button>
			";
		}
		?>
		</fieldset>
		<?php
			if($error == 0)
				echo "Return request successfull";
			else if($error == 1)
				echo "Failed. You can return only ".$amt." for this request";
		?>
</BODY>
</HTML>
