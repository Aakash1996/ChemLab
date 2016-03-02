<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'S'){
		header('Location: logout.php');
		die();
		}
	$sql = "select * from borrowrequests where uid='".$_SESSION['user']."'";
	if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['clear'])){
		//var_dump($_POST);
		$filterby = $_POST['filter'];
		$reqtype = $_POST['type'];
		$apstatus = $_POST['apstatus'];
		if($apstatus == '')
			$apstatus = "NULL";
		//echo $filterby;
		if($filterby == 'approved'){
			if($apstatus == 'NULL')
				$sql = "select * from requests where aprooved is NULL and user='".$_SESSION['user']."'";
			else
				$sql = "select * from requests where aprooved='".$apstatus."' and user='".$_SESSION['user']."'";
		}
		else if($filterby == 'request'){
			$sql = "select * from requests where type='".$reqtype."' and user='".$_SESSION['user']."'";
		}
	}

	$result2 = mysqli_query($conn, $sql);
	//unset($_SESSION['sql']);
	//var_dump($_POST);
	if(isset($_SESSION['sql']))
		$sql = $_SESSION['sql'];
	else
		$sql = 'select id, type, item, date, number, id from requests where user=\''.$_SESSION['user'].'\'';
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//var_dump($_POST);
		if(isset($_POST['sort'])){
			$sql = 'select id, type, item, date, number,  from requests where user=\''.$_SESSION['user'].'\' order by '.$_POST['filterby'].' '.$_POST['filter'];
		}

		else if(isset($_POST['update'])){
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_row($result)){
				$id = $row[5];
				$update = $_POST[$id];
				$query = ' ';
				if($update != 'NULL' && isset($_POST[$id])){
					$query = 'update requests set aprooved=\''.$update.'\' where id='.$id;
					echo $query;
					mysqli_query($conn, $query);
				}
			}
		}
	}
	$_SESSION['sql'] = $sql;
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
		        <li><a href="makerequest.php">Make a Request</a></li>
		        <li><a href="trackrepair.php">Track Repair</a></li>
		        <li><a href="showinventory.php">View inventory</a></li>
		        <li><a href="reset2.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br>
	</header>
	
<div class = "fieldset-auto-width">
	<form action = 'dashboard.php' method="post">
		<fieldset>
			<legend>Status of Requests</legend>
				Filter By:
			<select name='filter'>
				<option value='approved'>Approved</option>
				<option value='request'>Request Type</option>
			</select><br>
			Request Type:
			<select name='type'>
				<option value='purchase'>Purchase</option>
				<option value='repair'>Repairs</option>
				<option value='discard'>Discards</option>
			</select><br>
			Approval status:<input type='radio' name='apstatus' value='Y'>Yes <input type='radio' name='apstatus' value='N'>No <input type='radio' name='apstatus' value='NULL'>Pending
			<br><br><button type='submit'>Filter</button> <button type='submit' name='clear'>Clear Filters</button>
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
			
		</fieldset>
	</form>
	</div>
	
</BODY>
</HTML>
