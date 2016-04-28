<?php
	session_start();
	require('dbconnect.php');
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'R'){
		header('Location: logout.php');
		die();
	}
	$bup = 0;
	$error = 0;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//var_dump($_POST);
		if(isset($_POST['budgetupd'])){
			$sql = "update researchgroup set budget = ".$_POST['budget']." where gID = ".$_SESSION['group'];
			mysqli_query($conn, $sql);
			$bup = 1;
		}
		if(isset($_POST['createuser'])){
			$user = $_POST['id'];
			$pass = $_POST['pwd'];
			$pass2 = $_POST['pwd2'];
			$type = $_POST['type'];
			$name = $_POST['name'];
			echo $pass;
			//echo $pass2;
			if($pass != $pass2 )
				$error = 1;
			else if($user == '')
				$error = 3;
			else if($pass == '' && $pass2 == '')
				$error = 4;
			else{
				$result = mysqli_query($conn, "select * from users where id='".$user."'");
				if(mysqli_num_rows($result)!=0)
					$error = 2;
				if(mysqli_query($conn, "insert into users values ('".$user."', password('".$pass."'),'".$type."', '".$name."' )")){
					$error = 0;
					if($type == 'T'){
						$sql = "update researchgroup set tlID = '".$user."' where gID = ".$_SESSION['group'];
						mysqli_query($conn, $sql);
					}
					else{
						$sql = "insert into groupdetails values(".$_SESSION['group'].", '".$user."')";
						mysqli_query($conn, $sql);
					}
				}
			}
		}
		if(isset($_POST['reset_pass'])){
			$id = $_POST['userselect'];
			$pass = $_POST['pwd'];
			if($pass == '')
				$error = 1;
			else
				mysqli_query($conn, "update users set pass = password('".$pass."') where id='".$id."'");
		}
	}
	$sql = "select memID from groupdetails where gID = ".$_SESSION['group']." union select tlID from researchgroup where gID = ".$_SESSION['group'];
	$userlist = mysqli_query($conn, $sql);
?>
<HTML>
<HEAD>
	<link rel="stylesheet" type="text/css" href="CSS/navbar.css">
	<TITLE>
		Manage Group
	</TITLE>
</HEAD>
<BODY>
	<header>
	    <div class="nav">
			<ul>
		        <ul>
		        <li><a href = "rhdash.php">Dashboard</a></li>
		        <li><a href = "editstock.php">Add Stock</a></li>
		        <li><a href = "updatechemical.php">Update Chemical</a></li>
		        <li><a href = "viewinv.php">View inventory</a></li>
		        <li><a class = "active" href = "#">Manage Group</a></li>
		        <li><a href = "reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $_SESSION['user'];?><br><a href="logout.php">Logout</a><br></p>
	</header>
	<form action = "groupmanage.php" method = "POST">
	<fieldset>
		<legend>Update Budget</legend>
		<?php 
			$sql = "select `budget` from researchgroup where gID = ".$_SESSION['group'];
			$row2 = mysqli_fetch_row(mysqli_query($conn, $sql));
			$amt = $row2[0];
		?>
		<input type = 'number' name='budget' value=<?php echo "'".$amt."'"?>><br>
		</input>
		<BUTTON name = 'budgetupd' id = 'budgetupd' type = 'submit'>Update</BUTTON>
		<?php
			if($bup == 1)
				echo "<br>Budget Updated";
		?>
	</fieldset>
	</form><br>
	<form action = "groupmanage.php" method = "POST">
	<fieldset>
		<legend>Add student</legend>
			Username:<input type='text' name='id'><br>
			Password:<input type='password' name='pwd'><br>
			Re-enter Password:<input type='password' name='pwd2'><br>
			Name:<input type='text' name='name'><br>
			Account Type:<?php
				$sql = "select tlID from researchgroup where gID = ".$_SESSION['group'];
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_row($result);
				if($row[0] == '')
					echo "<Input type='radio' name='type' value='T'>Incharge</Input>"
			?>
				<input type='radio' name='type' value='S' checked="checked">Student<br><br>
			<button type='submit' name='createuser'>Create User</button>
			<?php
				if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createuser'])){
					if($error == 0)
						echo "Account Created";
					else if($error == 1)
						echo "Passwords do not match";
					else if($error == 4)
						echo "Password cannot be empty";
					else if($error == 2)
						echo"User already exists";
					else if($error == 3)
						echo "User cannot be empty";
				}	
			?>
	</fieldset>
	</form>
	<form action="groupmanage.php" method="POST">
	<fieldset>
		<legend>Reset Password</legend>
		User:
			<select name='userselect'>
				<?php
					while($row = mysqli_fetch_row($userlist))
						echo "<option value='".$row[0]."'>".$row[0]."</option>"
				?>
			</select>
			<br>
			New Password:<input type="password" name="pwd"><br>
			<button type="submit" name='reset_pass'>Reset</button>
			<?php
				if(isset($_POST['reset_pass'])){
					if($error == 0)
						echo "Reset Successful";
					else
						echo "Password cannot be empty";
				}
			?>
	</fieldset>
	</form><br>
</BODY>
</HTML>
