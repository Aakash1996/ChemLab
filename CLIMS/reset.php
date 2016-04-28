<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type'])){
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
		else if($newpass == ''){
			$error1 = -2;
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
	<link rel="stylesheet" type="text/css" href="CSS/navbar.css">
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
		        <li><a href="viewinv.php">View inventory</a></li>
		        <li><a class="active" href="#">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>';
	    else if($_SESSION['user_type'] == 'R')
	    	echo '<div class="nav">
			<ul>
		        <ul>
		        <li><a href="rhdash.php">Dashboard</a></li>
		        <li><a href = "editstock.php">Add Stock</a></li>
		        <li><a href = "updatechemical.php">Update Chemical</a></li>
		        <li><a href = "viewinv.php">View inventory</a></li>
		        <li><a href = "groupmanage.php">Manage Group</a></li>
		        <li><a class = "active" href = "#">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>';
	    else if($_SESSION['user_type'] == 'T')
	    	echo '<div class="nav">
			<ul>
		        <ul>
			        <li><a href ="tldash.php">Dashboard</a></li>
			        <li><a href = "viewinv.php">View Inventory</a></li>
			        <li><a class = "active" href = "#">Reset Password</a></li>
			    </ul>
		    </ul>
	    </div>';
	?>
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
		else if($error1 == -2)
			echo "New Password Cannot be empty";
	?>
</BODY>
</HTML>
