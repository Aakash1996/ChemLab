<?php
	session_start();
	require('dbconnect.php');
	$a = array();
	$user = $_SESSION['user'];
	if(!isset($_SESSION['user']) || !isset($_SESSION['user_type'])){
		header('Location: logout.php');
		die();
	}

	$id = $_GET['id'];
	$sql = "select * from chemicals, stock where chemicals.id = stock.chemID and chemicals.id = '".$id."'";
	//echo $sql;
	$resultset = mysqli_query($conn, $sql);
	$row = mysqli_fetch_row($resultset);
?>
<HTML>
<HEAD>
	<script>
	function closeTab(){
		window.close()
	}
	</script>
	<TITLE>Details</TITLE>
</HEAD>
<BODY>
	<BUTTON OnClick = "window.close()">Close Window</BUTTON>
	<br><br>
	<TABLE border='1'>
		<tr><td align='Left'>CAS Number</td><td align='Left'><?php echo $row[0];?></td></tr>
		<tr><td align='Left'>Common Name</td><td align='Left'><?php echo $row[1];?></td></tr>
		<tr><td align='Left'>IUPAC Name</td><td align='Left'><?php echo $row[2];?></td></tr>
		<tr><td align='Left'>Current Stock</td><td align='Left'><?php echo $row[13];?></td></tr>
		<tr><td align='Left'>Boiling Point</td><td align='Left'><?php echo $row[3];?></td></tr>
		<tr><td align='Left'>Melting Point</td><td align='Left'><?php echo $row[4];?></td></tr>
		<tr><td align='Left'>Toxicity</td><td align='Left'><?php echo $row[5];?></td></tr>
		<tr><td align='Left'>pH</td><td align='Left'><?php echo $row[6];?></td></tr>
		<tr><td align='Left'>State</td><td align='Left'><?php echo $row[7];?></td></tr>
		<tr><td align='Left'>Borrow Limit</td><td align='Left'><?php echo $row[8];?></td></tr>
		<tr><td align='Left'>Threshold amount</td><td align='Left'><?php echo $row[9];?></td></tr>
		<tr><td align='Left'>Supplier</td><td align='Left'><?php echo $row[10];?></td></tr>
		<tr><td align='Left'>Price/Unit</td><td align='Left'><?php echo $row[11];?></td></tr>
	</TABLE>
</BODY>
</HTML>
