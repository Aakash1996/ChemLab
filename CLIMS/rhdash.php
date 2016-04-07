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
		        <li><a class = "active" href="#">Dashboard</a></li>
		        <li><a href = "editstock.php">Add Stock</a></li>
		        <li><a href = "viewinv.php">View inventory</a></li>
		        <li><a href = "groupmanage.php">Manage Group</a></li>
		        <li><a href = "reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br></p>
	</header>
	<H1>Budget:
	<?php 
		$sql = "select `budget` from researchgroup where gID = ".$_SESSION['group'];
		$row = mysqli_fetch_row(mysqli_query($conn, $sql));
		echo $row[0];
	?><br><br>
	<H1> Group Members</H1><br>
	<p>
	<?php
		$sql = "select name from users where id = (select memID from groupdetails where gID = ".$_SESSION['group'].")";
		$resultset = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_row($resultset))
			echo $row[0]."<br>";
	?>
	</p>
	<br><br>
	<H1>Grooup Incharge</H1>
	<p>
	<?php
		$sql = "select name from users where id = (select tlID from researchgroup where gID = ".$_SESSION['group'].")";
		$resultset = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_row($resultset))
			echo $row[0]."<br>";
	?>
	<br><br>
</BODY>
</HTML>