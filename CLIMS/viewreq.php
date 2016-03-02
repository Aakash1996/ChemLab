<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 'Y'){
		header('Location: logout.php');
		die();
	}
	$sql = "select * from requests order by ";
	}

	$result2 = mysqli_query($conn, $sql);
	/*if($result2){
		echo "Successful query";
		echo $sql;
	}
	else{
		echo $sql;
	}*/
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
		        <li><a href="dashboard2.php">Dashboard</a></li>
		        <li><a  class="active" href="#">All Requests</a></li>
		        <li><a href="repair_retun.php">Repair return</a></li>
		        <li><a href="admininventory.php">View Inventory</a></li>
		        <li><a href="adduser.php">Add User</a></li>
		        <li><a href="reset.php">Account</a></li>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a></p><br>
	</header>
	<form action="showreq.php" method="POST">
	<fieldset>
			<legend>All Requests</legend>
			Filter by:
			<select name='filter'>
				<option value='approved'>Approved</option>
				<option value='user'>User</option>
				<option value='request'>Request Type</option>
			</select><br>
			User List:
			<select name='user'>
				<?php
					$userquery = "select id from user where admin='N'";
					$userlist = mysqli_query($conn, $userquery);
					while($row = mysqli_fetch_row($userlist))
						echo "<option value='".$row[0]."'>".$row[0]."</option>";
				?>
			</select><br>
			Request Type:
			<select name='type'>
				<option value='purchase'>Purchase</option>
				<option value='repair'>Repairs</option>
				<option value='discard'>Discards</option>
			</select><br>
			Approval status:<input type='radio' name='apstatus' value='Y'>Yes <input type='radio' name='apstatus' value='N'>No <input type='radio' name='apstatus' value='NULL'>Pending
			<br><button type='submit'>Filter</button> <button type='submit' name='clear'>Clear Filters</button>
			<br><br><table>
				<tr>
					<th width="200px" align="center">Request ID</th> 
					<th width="200px" align="center">User</th>
					<th width="200px" align="center">Request Type</th>
					<th width="200px" align="center">Item Type</th>
					<th width="200px" align="center">Date of request</th>
					<th width="200px" align="center">Number</th>
					<th width="200px" align="center">Approved</th>
					<th width="200px" align="center">Date of decision</th>
				</tr>
				<?php
					while($row = mysqli_fetch_row($result2)){
						//echo var_dump($row);
						$statement = '<tr><td align="center">'.$row[0].'</td><td align="center">'.$row[1].'</td><td align="center">'.$row[2].'</td><td align="center">'.$row[3].'</td><td align="center">'.$row[4].'</td><td align="center">'.$row[5].'</td><td align="center">'.$row[6].'</td><td align="center">'.$row[7]."</td></tr>";
						echo $statement;
					}
				?>
			</table>
		</fieldset>
	</form>
</BODY>