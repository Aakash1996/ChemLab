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

<?php
	$errbp = 0;
	$errmp = 0;
	$errph = 0;
	$errtoxic = 0;
	$errstate = 0;
	$errmin = 0;
	$errsupplier = 0;
	$errprice = 0;
	$errlimit = 0;

?>

<BODY>
	<header>
	    <div class="nav">
			<ul>
		        <ul>
		        <li><a href = "rhdash.php">Dashboard</a></li>
		        <li><a href = "editstock.php">Add Stock</a></li>
		        <li><a class = "active" href="#">Update Chemical</a></li>
		        <li><a href = "viewinv.php">View inventory</a></li>
		        <li><a href = "groupmanage.php">Manage Group</a></li>
		        <li><a href = "reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br></p>
	</header>
	<form action = 'updatechemical.php' method= 'POST'>
			<fieldset>
				<legend></legend>
				CAS Number:
				<select name='CAS'><center>
				
	<?php
			$sql = "select id from chemicals;";
			$result = mysqli_query($conn, $sql);
				while($row = mysqli_fetch_row($result)){
					echo "<option value='".$row[0]."'> ".$row[0]."</option>";
				}
		?>
			</select>
				<table>
				<tr><th>BP:</th><td><input type ='number' name='bp'></td><td>
				<button type = 'submit' name='updatebp' value='UPDATE'>UPDATE</button></td></tr>
				<tr><th>MP:</th><td><input type ='number' name='mp'></td><td>
				<button type = "submit" name="updatemp" value="UPDATE">UPDATE</button></td></tr>
				<tr><th>Toxic:</th><td><input type ='text' name='toxic'></td><td>
				<button type = "submit" name="updatetoxic" value="UPDATE">UPDATE</button></td></tr>
				<tr><th>PH:</th><td><input type ='number' name='ph'></td><td>
				<button type = "submit" name="updateph" value="UPDATE">UPDATE</button></td></tr>
				<tr><th>State:</th><td><input type ='text' name='state'></td><td>
				<button type = "submit" name="updatestate" value="UPDATE">UPDATE</button></td></tr>
				<tr><th>Limit:</th><td><input type ='number' name='limit'></td><td>
				<button type = "submit" name="updatelimit" value="UPDATE">UPDATE</button></td></tr>
				<tr><th>Min:</th><td><input type ='number' name='min'></td><td>
				<button type = "submit" name="updatemin" value="UPDATE">UPDATE</button></td></tr>
				<tr><th>Supplier:</th><td><input type ='text' name='supplier'></td><td>
				<button type = "submit" name="updatesupplier" value="UPDATE">UPDATE</button></td></tr>
				<tr><th>Price:</th><td><input type ='number' name='price'></td><td>
				<button type = "submit" name="updateprice" value="UPDATE">UPDATE</button></td></tr>
				</table>				
				<br>
			</form>
	<?php 
		
			$CAS= $_POST['CAS'];
			$bp= $_POST['bp'];
			$mp= $_POST['mp'];
	        $ph= $_POST['ph'];
	        $state= $_POST['state'];
			$toxic= $_POST['toxic'];
			$price =$_POST['price'];
			$supplier =$_POST['supplier'];
			$limit= $_POST['limit'];
			$min= $_POST['min'];

			if(isset($_POST['updatebp'])){
				if($bp == ''){
					echo "Field was empty";
				}
				else{
				$sql = "update chemicals set bp ='{$bp}' where id ='{$CAS}'";
				$result = mysqli_query($conn, $sql);
				echo "BP updated";
				}
			}
			if(isset($_POST['updatemp'])){
				if($mp == ''){
					echo "Field was empty";
				}
				else{
					$sql = "update chemicals set mp = '{$mp}'where id ='{$CAS}'";
					$result = mysqli_query($conn, $sql);
					echo "MP updated";
				}
				
			}
			if(isset($_POST['updatetoxic'])){
				if($toxic == ''){
					echo "Field was empty";
				}
				else{
				$sql = "update chemicals set toxic ='{$toxic}' where id ='{$CAS}';";
				$result = mysqli_query($conn, $sql);
				echo "Toxic updated";
				}
			}
			if(isset($_POST['updatestate'])){
				if($state== ''){
					echo "Field was empty";
				}
				else{
				$sql = "update chemicals set state ='{$state}' where id ='{$CAS}';";
				$result = mysqli_query($conn, $sql);
				echo "State updated";
				}
			}
			if(isset($_POST['updateprice'])){
				if($price == ''){
					echo "Field was empty";
				}
				else{
				$sql = "update chemicals set price ='{$price}' where id ='{$CAS}';";
				$result = mysqli_query($conn, $sql);
				echo "Price updated";
				}
			}
			if(isset($_POST['updatesupplier'])){
				if($supplier == ''){
					echo "Field was empty";
				}
				$sql = "update chemicals set supplier ='{$supplier}'where id ='{$CAS}';";
				$result = mysqli_query($conn, $sql);
				echo "Supplier updated";
			}
			if(isset($_POST['updatelimit'])){
				if($limit == ''){
					echo "Field was empty";
				}
				$sql = "update chemicals set limit= '{$limit}' where id ='{$CAS}';";
				$result = mysqli_query($conn, $sql);
				echo "Limit updated";
			}
			if(isset($_POST['updatemin'])){
				if($min == ''){
					echo "Field was empty";
				}else{
				$sql = "update chemicals set min= '{$min}'where id ='{$CAS}';";
				$result = mysqli_query($conn, $sql);
				echo "Min updated";
				}
			}
			if(isset($_POST['updateph'])){
				if($ph == ''){
					echo "Field was empty";
				}
				else{
				$sql = "update chemicals set ph = '{$ph}' where id ='{$CAS}';";
				$result = mysqli_query($conn, $sql);
				echo "PH updated";
				}
			}
	?>
	</body>
</HTML>