<?php
	require('dbconnect.php');
	session_start();
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'A'){
		header('Location: logout.php');
		die();
	}
	$error=-1;
	$depterror = -1;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['createuser'])){
			$error=0;
			//echo "Adding User";
			$user = $_POST['id'];
			$pass = $_POST['pwd'];
			$pass2 = $_POST['pwd2'];
			$type = $_POST['type'];
			$name = $_POST['name'];
			if($pass != $pass2)
				$error = 1;
			else if($user == '')
				$error = 3;
			else{
				$result = mysqli_query($conn, "select * from users where id='".$user."'");
				if(mysqli_num_rows($result)!=0)
					$error = 2;
				else{
					if(mysqli_query($conn, "insert into users values ('".$user."', password('".$pass."'),'".$type."', '".$name."' )"));
						$error = 0;
				}
			}
		}
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
		Add User
	</TITLE>
</HEAD>

<BODY>
	<header>
	    <div class="nav">
			<ul>
		        <li><a href="admindash.php">Dashboard</a></li>
		        <li><a href="showreq.php">All Requests</a></li>
		        <li><a href="viewinv.php">View Inventory</a></li>
		        <li><a class="active" href="#">Add User</a></li>
		        <li><a href="reset_admin.php">Account</a></li>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a></p><br>
	</header>

	<form action='adduser.php' method='POST'>
		<fieldset>
			<legend>Add User</legend>
			Username:<input type='text' name='id'><br>
			Password:<input type='password' name='pwd'><br>
			Re-enter Password:<input type='password' name='pwd2'><br>
			Name:<input type='text' name='name'><br>
			Account Type:<Input type='radio' name='type' value='A'>Admin</Input>
				<input type='radio' name='type' value='R'>Research Head<br><br>
			<button type='submit' name='createuser'>Create User</button>
		</fieldset>
		<br><br><br>
	</form>
	<p>

	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if($error == 0)
				echo "Account Created";
			else if($error == 1)
				echo "Passwords do not match";
			else if($error == 2)
				echo"User already exists";
			else if($error == 3)
				echo "User cannot be empty";
			if($depterror == 0)
				echo "Department Added";
			else if($depterror == 1)
				echo "Department cannot be empty";
			else if($depterror == 2)
				echo "Department already exist";
	}
	?>
	</p>
</BODY>