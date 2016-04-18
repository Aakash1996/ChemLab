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
		        <li><a href = "rhdash.php">Dashboard</a></li>
		        <li><a class = "active" href="#">Add Stock</a></li>
		        <li><a href = "viewinv.php">View inventory</a></li>
		        <li><a href = "groupmanage.php">Manage Group</a></li>
		        <li><a href = "reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br></p>
	</header>
	
	<?php

	$gid = "select gID from groupdetails where memID = '".$user."' ;";	
	$result = mysqli_query($conn, $gid);
	$row1 = mysqli_fetch_row($result);
		
	$sql= "select distinct chemID from stock where gID = '{$row1[0]}';";
	
	$result = mysqli_query($conn,$sql);
		
	?>
		
		<form action = 'editstock.php' method= 'POST'>
			<fieldset>
				<legend>Add Stock</legend>
				CAS Number:
				<select name='CAS'><center>
				
	<?php
				while($row = mysqli_fetch_row($result)){
					echo "<option value='".$row[0]."'> ".$row[0]."</option>";
				}
		?>
				
				</select>
				<br><br>
				Add Stock: <input type='number' name='amount'>
				<br><br>
				<button type='submit' name='submit' value='submit'>SUBMIT</button>
			</fieldset>
		</form>	
<?php
		if(isset($_POST['submit'])){
		$CAS= $_POST['CAS'];
		$amt = $_POST['amount'];
		$sql= "select amount from stock where chemID = '{$CAS}' and gID = '{$row1[0]}';";
		$result = mysqli_query($conn, $sql);
		$row2 = mysqli_fetch_row($result);
		
			
			if($amt == ''){
				echo "Enter the amount";
				}
			else{
				$amt = $amt + $row2[0];
				$sql= "update stock set amount = '".$amt."' where chemID = '{$CAS}' and gID = '{$row1[0]}';";
				$result = mysqli_query($conn, $sql);
				echo "stock updated";
			}
		}
?>	
</BODY>
