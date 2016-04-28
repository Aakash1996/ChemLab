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

<?php
	
	$error1 = -1;
	$error2 = -1;

		if(isset($_POST['submit'])){
			
			$CAS= $_POST['CAS'];
			$amt = $_POST['amount'];
			$sql="select chemID from stock where chemID='".$CAS."' and gID= {$_SESSION['group']};";
			//echo $sql;
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_row($result);	
			if($amt==0 || $amt==''){
				$error1 = 1;
			}
			else{
				if(mysqli_num_rows($result) == 0){
				$sql = "insert into stock values ('{$CAS}', {$amt}, {$_SESSION['group']});";
				echo $sql;
				$result = mysqli_query($conn, $sql);
				}
				else{
				$sql= "update stock set amount = amount + {$amt} where chemID = '{$CAS}' and gID = {$_SESSION['group']};";
				//echo $sql;
				$result = mysqli_query($conn, $sql);
				$error1 = 2;
				}
			}
			
		}
		
		if(isset($_POST['add'])){
			$CAS2= $_POST['cas2'];
			$comname = $_POST['cm'];
			$iupac= $_POST['iupac'];
			$bp = $_POST['bp'];
			$mp = $_POST['mp'];
	        $ph = $_POST['ph'];
	        $state = $_POST['state'];
			$toxic = $_POST['toxic'];
			$price =$_POST['price'];
			$supplier =$_POST['supplier'];
			$limit= $_POST['limit'];
			//$amt2 =$_POST['amount2'];
			
			$sql= "select * from chemicals where id = '{$CAS2}';";
			//echo $sql;
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) == 0){
				if($_POST['bp'] == '')
					$bp = 0;
				if($_POST['mp'] == '')
					$mp = 0;
				if($_POST['ph'] == '')
					$ph = 0;
				if($_POST['price'] == '')
					$price = 0;
				if($_POST['limit'] == '')
					$limit = 0;
				if($_POST['min'] == '')
					$min = 0;
				$sql = "insert into chemicals values ('{$CAS2}','{$comname}','{$iupac}',{$bp},{$mp},'{$toxic}',{$ph},'{$state}',{$limit},{$min},'{$supplier}',{$price});";
				//echo $sql;
				$result = mysqli_query($conn, $sql);
				//$sql = "insert into stock values ('{$CAS2}', '{$amt2}', '{$_SESSION['group']}');";
				//$result = mysqli_query($conn, $sql);
				echo "Chemical Added";
			}
		
			else{
					$error2 = 2;
			}
	}

?>		

	<header>
	    <div class="nav">
			<ul>
		        <ul>
		        <li><a href = "rhdash.php">Dashboard</a></li>
		        <li><a class = "active" href="#">Add Stock</a></li>
		        <li><a href = "updatechemical.php">Update Chemical</a></li>
		        <li><a href = "viewinv.php">View inventory</a></li>
		        <li><a href = "groupmanage.php">Manage Group</a></li>
		        <li><a href = "reset.php">Reset Password</a></li>
		    </ul>
		    </ul>
	    </div>
	    <p align="right">Welcome <?php echo $user;?><br><a href="logout.php">Logout</a><br></p>
	</header>
	
	<?php
	$sql= "select id from chemicals;";
	
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
				Add Stock: <input type='number' name='amount' step = '0.01'><font color='red'>*<br><br></font>
				
				<button type='submit' name='submit' value='submit'>SUBMIT</button>
			</fieldset>
		</form>	
		<?php
				if($error1 == 1)
					echo "Enter the amount";
				else if($error1 == 2)
					echo "Stock Updated";
		?>
		<form action = 'editstock.php' method= 'POST'>
			<fieldset>
				<legend>Add New Chemical</legend>
				<table>
				<tr><td>CAS:</td><td><input type ='number' name='cas2' required><font color='red'>*<br></td></tr>
				<tr><td>Common Name:</td><td><input type ='text' name='cm' required><font color='red'>*<br></td></tr>
				<tr><td>IUPAC:</td><td><input type ='text' name='iupac' required><font color='red'>*<br></td></tr>
				<tr><td>BP:</td><td><input type ='number' name='bp'><br></td></tr>
				<tr><td>MP:</td><td><input type ='number' name='mp'><br></td></tr>
				<tr><td>Toxic:</td><td><input type ='text' name='toxic'><br></td></tr>
				<tr><td>PH:</td><td><input type ='number' name='ph'><br></td></tr>
				<tr><td>State:</td><td><input type ='text' name='state'><br></td></tr>
				<tr><td>Limit:</td><td><input type ='number' name='limit'><br></td></tr>
				<tr><td>Min:</td><td><input type ='number' name='min'><br></td></tr>
				<tr><td>Supplier:</td><td><input type ='text' name='supplier' required><font color='red'>*<br></td></tr>
				<tr><td>Price:</td><td><input type ='number' name='price'><br></td></tr>
				</table>				
				<br>
				<button type='submit' name='add' value='submit'>SUBMIT</button>
			</fieldset>
		</form>	
		<?php if($error2 == 2){
				echo "Chemical already exists";
		}
		?>

</BODY>














