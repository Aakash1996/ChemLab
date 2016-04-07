<?php
	session_start();
	require('dbconnect.php');
	$a = array();
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type'])){
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
	<?php    
		if($_SESSION['user_type'] == 'S')
		echo '<div class="nav">
			<ul>
		        <ul>
		        <li><a href="stdash.php">Dashboard</a></li>
		        <li><a href="makerequest.php">Borrow</a></li>
		        <li><a href = "return.php">Return</a></li>
		        <li><a class = "active" href="#">View inventory</a></li>
		        <li><a href="reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>';
	    else if($_SESSION['user_type'] == 'A')
	    	echo '<div class="nav">
			<ul>
		        <li><a href="admindash.php">Dashboard</a></li>
		        <li><a href="showreq.php">All Requests</a></li>
		        <li><a class = "active" href="#">View Inventory</a></li>
		        <li><a href="adduser.php">Add User</a></li>
		        <li><a href="reset_admin.php">Account</a></li>
		    </ul>
	    </div>';
	    else if($_SESSION['user_type'] == 'R')
	    	echo '<div class="nav">
			<ul>
		        <ul>
		        <li><a href="rhdash.php">Dashboard</a></li>
		        <li><a href = "editstock.php">Add Stock</a></li>
		        <li><a class = "active" href = "#">View inventory</a></li>
		        <li><a href = "groupmanage.php">Manage Group</a></li>
		        <li><a href = "reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>'
	?>
	<p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br>
	</header>
	<fieldset>
		<legend>Current Inventory</legend>
		<table>
			<tr>
				<th width="200px" align="center">CAS Number</th>
				<th width="200px" align="center">IUPAC Name</th>
				<th width="200px" align="center">Common Name</th>
				<th width="200px" align="center">Stock</th>
				<th width="200px" align="center">Max Borrow Limit</th>
			</tr>
			<?php
				$sql = "select `id`, `chemID`, `iupac`, `common_name`, `amount`, `limit` from (stock, chemicals) where `id`=`chemID` and `gID` = ".$_SESSION['group'];
				$resultset = mysqli_query($conn, $sql);
				//echo $sql;
				while($row = mysqli_fetch_row($resultset)){
					echo "<tr><td align='center'><a href='showdetails.php?id=".$row[1]."' target='_blank'>".$row[1]."</a></td><td align='center'>".$row[2]."</td><td align='center'>".$row[3]."</td><td align='center'>".$row[4]."</td><td align='center'>".$row[5]."</td></tr>";
				}
			?>
		</table>
	</fieldset>
</BODY>