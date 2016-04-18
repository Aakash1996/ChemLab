<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'A'){
		header('Location: logout.php');
		die();
	}
	$sql = '';
	$date = date('Y-m-d H:i:s'); 
	//unset($_SESSION['sql']);
	//var_dump($_POST);
	if(isset($_SESSION['sql']))
		$sql = $_SESSION['sql'];
	else
		$sql = 'select user, type, item, date, time borrowrequests from requests where state = 0';
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//var_dump($_POST);
		if(isset($_POST['sort'])){
			$sql = 'select uid, cid, amount, date, number, id from borrowrequests where aprooved is null order by '.$_POST['orderby'].' '.$_POST['order'];
		}

		else if(isset($_POST['update'])){
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_row($result)){
				$id = $row[5];
				$update = $_POST[$id];
				$query = ' ';
				if($update != 'NULL' && isset($_POST[$id])){
					$query = 'update borrowrequests set aprooved=\''.$update.'\' where reqid='.$id;
					//echo $query;
					mysqli_query($conn, $query);
					if($update == 'N')
						continue;
					if($row[1] == 'purchase'){
						//Increment in table or add in table.
						$updatequery='';
						$checkquery = "select * from item where name='".$row[2]."' and dept=(select dept from user where id='".$row[0]."')";
						//echo $checkquery;
						$resultofcheck = mysqli_query($conn, $checkquery);
						if(mysqli_num_rows($resultofcheck) == 0)
							$updatequery = "insert into item select '".$row[2]."', dept, ".$row[4].", 0 from user where id='".$row[0]."'";
						else
							$updatequery = "update item set count=count+".$row[4]." where name='".$row[2]."' and dept=(select dept from user where id='".$row[0]."')";
						/*echo $updatequery;
						if(mysqli_query($conn, $updatequery))
							echo "Purchase successful";*/
						mysqli_query($conn, $updatequery);
					}
					else if($row[1] == 'repair'){
						//increase damaged count
						$updatequery = "update item set dcount = dcount+".$row[4]." where name='".$row[2]."' and dept=(select dept from user where id='".$row[0]."')";
						/*if(mysqli_query($conn, $updatequery))
							echo "Repair successful";
						echo $updatequery;*/
						mysqli_query($conn, $updatequery);
					}
					else if($row[1] == 'discard'){
						//Decrease count
						$updatequery = "update item set count = count-".$row[4]." where name='".$row[2]."' and dept=(select dept from user where id='".$row[0]."')";
						//if(mysqli_query($conn, $updatequery))
							//echo "Discard successful";
						//echo $updatequery;
						mysqli_query($conn, $updatequery);
					}
				}
			}
		}
	}
	$_SESSION['sql'] = $sql;
	//echo $sql;
	$result = mysqli_query($conn, $sql);
	/*if(isset($result)){
		//echo "Successful";
		//var_dump($result);
		var_dump($sql);
		echo mysqli_num_rows($result);
	}
	else echo "Unsuccessful";*/
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
		        <li><a class="active" href="#">Dashboard</a></li>
		        <!--<li><a href="showreq.php">All Requests</a></li>-->
		        <li><a href="viewinv.php">View Inventory</a></li>
		        <li><a href="adduser.php">Add User</a></li>
		        <li><a href="reset_admin.php">Account</a></li>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a></p><br>
	</header>

	<div class = "fieldset-auto-width">
	<form action = 'dashboard2.php' method="post">
		<fieldset>
			<legend>Pending Requests</legend>
				Sort By:
				<select name='orderby' >
					<option value='user'>User</option>
					<option value='type'>Request Type</option>
					<option value='item'>Item Type</option>
					<option value='date'>Date</option>
				</select>
				<select name='order'>
					<option value='asc'>Ascending</option>
					<option value='desc'>Descending</option>
				</select>
				<button type='submit' id='sort' name='sort'>Sort</button><br><br>
				<font align="center">
				<table>
					<tr>
						<th width="200px" align="center">Request ID</th> 
						<th width="200px" align="center">User</th>
						<th width="200px" align="center">Request Type</th>
						<th width="200px" align="center">Item Type</th>
						<th width="200px" align="center">Date</th>
						<th width="200px" align="center">Number</th>
						<th width="200px" align="center">Approve</th>
					</tr>
					<?php
						while($row = mysqli_fetch_row($result)){
							//echo var_dump($row);
							$statement = '<tr><td align="center">'.$row[5].'</td><td align="center">'.$row[0].'</td><td align="center">'.$row[1].'</td><td align="center">'.$row[2].'</td><td align="center">'.$row[3].'</td><td align="center">'.$row[4].'</td>';
							$radio1 = '<input type=\'radio\' name=\''.$row[5].'\' value=\'Y\'>Yes</input>';
							$radio2 = '<input type=\'radio\' name=\''.$row[5].'\' value=\'N\'>No</input>';
							$radio3 = '<input type=\'radio\' name=\''.$row[5].'\' value=\'NULL\'>Later</input>';
							echo $statement.'<td align="center">'.$radio1.$radio2.$radio3.'</td></tr>';
						}
					?>
				</table><br>
				</font>
					<?php
						if(mysqli_num_rows($result) == 0)
							echo "<p align='center'>Nothing to show</p>";
					?>
				<br><button type='submit' name='update'>Update Values</button>
		</fieldset>
	</form>
</BODY>
