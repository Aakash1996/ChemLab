<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'S'){
		header('Location: logout.php');
		die();
	}
	$sql = 'select * from borrowrequest where uid=\''.$_SESSION['user'].'\'';
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
		Dashboard
	</TITLE>
</HEAD>
<BODY>
	<header>
	    <div class="nav">
			<ul>
		        <ul>
		        <li><a class="active" href="#">Dashboard</a></li>
		        <li><a href="makerequest.php">Borrow</a></li>
		        <li><a href = "return.php">Return</a></li>
		        <li><a href="viewinv.php">View inventory</a></li>
		        <li><a href="reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br>
	</header>	
<div class = "fieldset-auto-width">
	<form action = 'dashboard.php' method="post">
		<fieldset>
			<legend>Status of Requests</legend>
			<!--	Filter By:
			<select name='filter'>
				<option value='approved'>Approved</option>
				<option value='chemID'>Request Type</option>
			</select><br>
			Request Type:
			<select name='type'>
				<option value='purchase'>Purchase</option>
				<option value='repair'>Repairs</option>
				<option value='discard'>Discards</option>
			</select><br>-->
			Approval status:<input type='radio' name='apstatus' value='Y'>Yes <input type='radio' name='apstatus' value='N'>No <input type='radio' name='apstatus' value='NULL'>Pending
			<br><br><button type='submit'>Filter</button> <button type='submit' name='clear'>Clear Filters</button>
			<br><br><table>
				<tr>
					<th width="200px" align="center">Request ID</th> 
					<th width="200px" align="center">User</th>
					<th width="200px" align="center">Chemical ID</th>
					<th width="200px" align="center">Amount</th>
					<th width="200px" align="center">Date of request</th>
					<th width="200px" align="center">Time of request</th>
					<th width="200px" align="center">Approved</th>
				</tr>
				<?php
					while($row = mysqli_fetch_row($result)){
						//echo var_dump($row);
						$statement = '<tr><td align="center">'.$row[0].'</td><td align="center">'.$row[1].'</td><td align="center">'.$row[2].'</td><td align="center">'.$row[3].'</td><td align="center">'.$row[4].'</td><td align="center">'.$row[5].'</td><td align="center">'.$row[6].'</td></tr>';
						echo $statement;
					}
					if (mysqli_num_rows($result) == 0){
						echo "Nothing to Show";
					}
				?>
			
		</fieldset>
	</form>
	</div>
	
</BODY>
</HTML>
