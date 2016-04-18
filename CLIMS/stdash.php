<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'S'){
		header('Location: logout.php');
		die();
	}
	$sql = 'select * from borrowrequest where uid=\''.$_SESSION['user'].'\' and `state` in (0, -1, 1, 2)';
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$stat = $_POST['apstatus'];
		if($stat == '0'){
				$sql = 'select * from borrowrequest where uid=\''.$_SESSION['user'].'\' and `state` = 0';
		}
		else if($stat == '-1')
			$sql = 'select * from borrowrequest where uid=\''.$_SESSION['user'].'\' and `state` = -1';
		else if($stat == 'P'){
			$sql = 'select * from borrowrequest where uid=\''.$_SESSION['user'].'\' and `state` in (1, 2)';
		}
	}
	$result = mysqli_query($conn, $sql);
?>
<HTML>
<HEAD>
	<link rel="stylesheet" type="text/css" href="CSS/navbar.css">
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
	<form action = 'stdash.php' method="post">
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
			Approval status:<input type='radio' name='apstatus' value='0'>Yes <input type='radio' name='apstatus' value='-1'>No <input type='radio' name='apstatus' value="P">Pending
			<br><br><button type='submit'>Filter</button> <button type='submit' name='clear'>Clear Filters</button>
			<br><br><table>
				<tr>
					<th width="200px" align="center">Request ID</th> 
					<th width="200px" align="center">User</th>
					<th width="200px" align="center">Chemical ID</th>
					<th width="200px" align="center">Amount</th>
					<th width="200px" align="center">Date of request</th>
					<th width="200px" align="center">Time of request</th>
					<th width="200px" align="center">Status</th>
				</tr>
				<?php
					while($row = mysqli_fetch_row($result)){
						if($row[6] == 0)
							$row[6] = 'Approved';
						else if($row[6] == 1)
							$row[6] = 'Pending';
						else if($row[6] == 2)
							$row[6] = 'Pending(Over Limit)';
						else if($row[6] == -1)
							$row[6] = 'Denied';
						else if($row[6] == -2)
							$row[6] = 'Already Returned';
						//echo var_dump($row);
						$statement = '<tr><td align="center">'.$row[0].'</td><td align="center">'.$row[1]."</td><td align='center'><a href='showdetails.php?id=".$row[2]."' target='_blank'>".$row[2].'</a></td><td align="center">'.$row[3].'</td><td align="center">'.$row[4].'</td><td align="center">'.$row[5].'</td><td align="center">'.$row[6].'</td></tr>';
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
