<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'S'){
		header('Location: logout.php');
		die();
	}
	$error1 = 0;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$current = $_POST['pass'];
		$newpass = $_POST['newpass'];
		$newpass2 = $_POST['newpass2'];
		if($newpass != $newpass2){
			$error1 = 1;
		}
		else{
			//echo "update users set pwd='".$newpass."' where id='".$_SESSION['user']."' and pwd='".$current."'";
			//echo mysqli_num_rows(mysqli_query($conn, "select * from users where id='".$_SESSION['user']."' and pwd='".$current."'"));
			if(mysqli_num_rows(mysqli_query($conn, "select * from users where id='".$_SESSION['user']."' and pass=password('".$current."')")) == 0)
				$error1 = 2;
			else{
				mysqli_query($conn, "update users set pass=password('".$newpass."') where id='".$_SESSION['user']."' and pass=password('".$current."')");
				$error1 = -1;
			}
		}
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
		Dashboard
	</TITLE>
</HEAD>
<BODY>
	<header>
	    <div class="nav">
			<ul>
		        <ul>
		        <li><a href="stdash.php">Dashboard</a></li>
		        <li><a href="makerequest.php">Make a Request</a></li>
		        <li><a href="viewinv.php">View inventory</a></li>
		        <li><a class="active" href="#">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br>
	</header>

	<form action="reset.php" method="POST">
		<fieldset>
			<legend>Reset Password</legend>
			Current Password:<input type="password" name="pass"><br>
			Enter New Password:<input type="password" name="newpass"><br>
			Re-enter Password:<input type="password" name="newpass2"><br>
			<button type="submit">Reset</button>
		</fieldset>
	</form>
	<?php
		if($error1 == -1)
			echo "Reset Successful";
		else if($error1 == 1)
			echo "Passwords do not match";
		else if($error1 == 2)
			echo "Current Password Wrong";
	?>
</BODY>
</HTML>
