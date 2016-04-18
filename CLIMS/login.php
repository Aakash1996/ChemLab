<?php
	require('dbconnect.php');
	if($_SERVER['REQUEST_METHOD'] != 'POST'){
		header('Location: index.php');
	}
	else{
		session_start();
		unset($_SESSION['user']);
		session_unset();
		session_destroy();
		$user = $_POST['uname'];
		$pass = $_POST['pass'];
		//$pass = md5($pass);
		//echo $user.'<br>'.$pass.'<br>';
		$sql = 'select * from users where id=\''.$user.'\' and pass=password(\''.$pass.'\')';
		//echo $sql;
		$result = mysqli_query($conn, $sql);
		if(!$result){
			echo 'Query unsuccessful, please note down the credentials you entered and contact the developers.';
			die(0);
		}
		if (mysqli_num_rows($result) == 0){
			session_start();
			$_SESSION['wrong_data'] = 1;
			header('Location: index.php');
			//echo '<script type="text/javascript">location.href = \'index.php\';</script>';
			//echo 'Wrong username';
		}
		else{
			session_start();
			$_SESSION['user'] = $user;
			while($row = mysqli_fetch_row($result)){
				$_SESSION['user_type'] = $row[2];
				$_SESSION['disp_name'] = $row[3];
			}
			if($_SESSION['user_type'] == 'A')
				header('Location: admindash.php');
				//echo '<script type="text/javascript">location.href = \'admindash.php\';</script>';
			else if($_SESSION['user_type'] == 'R'){
				$sql = "select gID from researchgroup where hID = '".$user."'";
				//echo $sql;
				$row = mysqli_fetch_row(mysqli_query($conn, $sql));
				$_SESSION['group'] = $row[0];
				header('Location: rhdash.php');
			}
				//echo '<script type="text/javascript">location.href = \'rhdash.php\';</script>';
			else if($_SESSION['user_type'] == 'T'){
				$sql = "select gID from groupdetails where memID = '".$user."'";
				$result = mysqli_query($conn, $sql);
				//echo $sql."type is t";
				$row = mysqli_fetch_row(mysqli_query($conn, $sql));
				$_SESSION['group'] = $row[0];
				header('Location: tldash.php');
			}
				//echo '<script type="text/javascript">location.href = \'tldash.php\';</script>';
			else if($_SESSION['user_type'] == 'S'){
				$sql = "select gID from groupdetails where memID = '".$user."'";
				//echo $sql;
				$row = mysqli_fetch_row(mysqli_query($conn, $sql));
				$_SESSION['group'] = $row[0];
				//echo $_SESSION['group'];
				header('Location: stdash.php');
			}
				//echo '<script type="text/javascript">location.href = \'stdash.php\';</script>';
			//echo 'successful';
		}
	}
?>
