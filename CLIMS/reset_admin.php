<?php
	session_start();
	$error1 = 0;
	$error2 = 0;
	$error3 = -1;
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'A'){
		header('Location: logout.php');
		die();
	}
	$userlist = mysqli_query($conn, "select id from users where type != 'A'");
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['form1'])) {
			$current = $_POST['pass'];
			$newpass = $_POST['newpass'];
			$newpass2 = $_POST['newpass2'];
			/*var_dump($current);
			var_dump($newpass);
			var_dump($newpass2);*/
			if($newpass != $newpass2){
				$error1 = 1;
			}
			else if($pass1 == '' && $pass2 == '')
				$error1 = 4;
			else{
				//echo "update user set pwd='".$newpass."' where id='".$_SESSION['user']."' and pwd='".$current."'";
				//echo mysqli_num_rows(mysqli_query($conn, "select * from user where id='".$_SESSION['user']."' and pwd='".$current."'"));
				if(mysqli_num_rows(mysqli_query($conn, "select * from users where id='".$_SESSION['user']."' and pass=password('".$current."')")) == 0)
					$error1 = 2;
				else{
					mysqli_query($conn, "update users set pass=password('".$newpass."') where id='".$_SESSION['user']."' and pass=password('".$current."')");
					$error1 = -1;
					//echo "update users set pass=password('".$newpass."') where id='".$_SESSION['user']."' and pass=password('".$current."')";
				}
			}
		}
		else{
			$resetuser = $_POST['userselect'];
			$newpass = $_POST['pwd'];
			$sql = "update users set pass=password('".$newpass."') where id='".$resetuser."'";
			mysqli_query($conn, $sql);
			$error2 = 1;
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
	    <div class="nav">
			<ul>
		        <!--<li><a href="admindash.php">Dashboard</a></li>-->
		        <!--<li><a href="viewinv.php">View Inventory</a></li>-->
		        <li><a href="adduser.php">Add User</a></li>
		        <li><a class="active" href="#">Account</a></li>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a></p><br>
	</header>

	<form action="reset_admin.php" name="resetown" method="POST">
		<fieldset>
			<legend>Reset Password</legend>
			Current Password:<input type="password" name="pass"><br>
			Enter New Password:<input type="password" name="newpass"><br>
			Re-enter Password:<input type="password" name="newpass2"><br>
			<button type="submit" name='form1'>Reset</button>
		</fieldset>
	</form>
	<?php
		if($error1 == -1)
			echo "Reset Successful";
		else if($error1 == 1)
			echo "Passwords do not match";
		else if($error1 == 2)
			echo "Current Password Wrong";
		else if($error1 == 4)
			echo "Enter Password";
	?><br><br>
	<form action="reset_admin.php" name="resetother" method="POST">
		<fieldset>
			<legend>Reset Standard User's Password</legend>
			User:
			<select name='userselect'>
				<?php
					while($row = mysqli_fetch_row($userlist))
						echo "<option value='".$row[0]."'>".$row[0]."</option>"
				?>
			</select>
			<br>
			New Password:<input type="password" name="pwd"><br>
			<button type="submit" name='form2' value ='reset'>Reset</button>
		</fieldset>
	</form>
	
	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$pass3 = $_POST['pwd'];
			if(isset($_POST['reset'])){
			if($pass3 == '')
			$error3 = 0;
			if ($error3 == 0)
				echo "Enter Password";
			else
				echo "Reset Successful";
			}
		}
	?>
</BODY>
