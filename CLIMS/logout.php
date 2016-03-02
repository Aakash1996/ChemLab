<?php
	session_start();
	unset($_SESSION['user']);
	unset($_SESSION['user_type']);
	unset($_SESSION['disp_name']);
	unset($_SESSION['wrong_data']);
	session_unset();
	session_destroy();
	header('Location: index.php');
?>