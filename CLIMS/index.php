<HTML>
<HEAD>
	<style type="text/css">
    .fieldset-auto-width {
         display: inline-block;
         left: 50%;
         top: 50%;
    }
	</style>
	
	<TITLE>
		LOGIN PAGE
	</TITLE>
	<?php
	session_start();
	if(isset($_SESSION['user'])){
		if($_SESSION['user_type'] == 'A')
			header('Location: admindash.php');
		else if($_SESSION['user_type'] == 'R')
			header('Location: rhdash.php');
		else if($_SESSION['user_type'] == 'T')
			header('Location: tldash.php');
		else if($_SESSION['user_type'] == 'S')
			header('Location: stdash.php');
		echo $_SESSION['user']+' already set';
	}
	?>
</HEAD>

<BODY>
	<div class = "fieldset-auto-width">
		<form action = 'login.php' method="post">
			<fieldset>
				<legend>Login</legend>
					<table>
						<tr>
							<th>Username</th>
							<th>Password</th>
						</tr>
						<tr>
							<td><input type="text" id="uname" name='uname'></td>
							<td><input type="password" id="pass" name='pass'></td>
						</tr>
					</table>
					<button type="submit">Login</button>
			</fieldset>
		</form>
	</div><br>
	<?php
		if(isset($_SESSION['wrong_data'])){
			echo "<script type='text/javascript'>alert('Username/password incorrect!');</script>";
			unset($_SESSION['wrong_data']);
		}
	?>
</BODY>