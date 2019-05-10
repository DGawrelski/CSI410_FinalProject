<?php
   include('session.php');
   include('config.php');
?>
<html>
   
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>User Page</title>
	</head>
   
	<body>
		<h1>User Session for <?php echo $login_session; ?></h1>
		<!-- <h2><a href = "logout.php">Sign Out</a></h2> -->
		
		<div class="displaybox">
			<div class="displayboxinner">
				<!-- Displays the user's information -->
				<!-- <dt>User Information</dt> -->
				<div class="displayheader"><b>User Information</b></div>
					<?php
						$sql = "SELECT id, username, email FROM users WHERE username = '$login_session'";
						$result = mysqli_query($db,$sql);
						$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
						//$count = mysqli_num_rows($result);
						
						$uid = $row['id'];
						$uname = $row['username'];
						$email = $row['email'];
						
						echo "<dd>User ID: $uid</dd>";
						echo "<dd>Username: $uname</dd>";
						echo "<dd>Email: $email</dd>";
					?>
				<br>
				<!-- Displays the user's financial information -->
				<!-- <dt>Payment Information</dt> -->
				<div class="displayheader"><b>Payment Information</b></div>
					<?php
						$sql = "SELECT pay_method,auto_renew,infraction_due FROM finance WHERE userid = '$uid'";
						$result = mysqli_query($db,$sql);
						$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
						//$count = mysqli_num_rows($result);
						
						$pay_meth = $row['pay_method'];
						$auto_ren = $row['auto_renew'];
						$infract = $row['infraction_due'];
						
					
						echo "<dd>Payment Method: $pay_meth</dd>";
						echo "<dd>Auto-Renew: $auto_ren</dd>";
						echo "<dd>Infraction Due: $infract</dd>";
					?>
				<br>
				<!-- Displays the user's vehicle information -->
				<!-- <dt>Vehicle Information</dt> -->
				<div class="displayheader"><b>Vehicle Information</b></div>
					<?php
						$sql = "SELECT id, make, model, year, vin FROM vehicle WHERE userid = '$uid' ORDER BY id ASC";
						$result = mysqli_query($db,$sql);
						//$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
						$count = mysqli_num_rows($result);
						
						while($row = mysqli_fetch_assoc($result)){
							$vid = $row['id'];
							$make = $row['make'];
							$model = $row['model'];
							$year = $row['year'];
							$vin = $row['vin'];
						
							echo "<div>";
							echo "<dd>Vehicle ID: $vid</dd>";
							echo "<dd>Make: $make</dd>";
							echo "<dd>Model: $model</dd>";
							echo "<dd>Year: $year</dd>";
							echo "<dd>VIN: $vin</dd>";
							
							if($count > 1){
								echo "<hr>";
								$count -= 1;
							}
							echo "</div>";
						}
					?>
				<br>
				<!-- Displays the user's infractions -->
				<!-- <dt>Infractions</dt> -->
				<div class="displayheader"><b>Infractions</b></div>
					<?php
						$sql = "SELECT vehicleid, infraction_date, infraction_type, outstanding FROM infraction WHERE 
									userid = '$uid' ORDER BY infraction_date ASC";
						$result = mysqli_query($db,$sql);
						//$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
						$count = mysqli_num_rows($result);
						
						//Posts query results while we have at least one record
						while($row = mysqli_fetch_assoc($result)){
							$vid	  = $row['vehicleid'];
							$inf_date = $row['infraction_date'];
							$inf_type = $row['infraction_type'];
							$outstand = $row['outstanding'];
							
							echo "<div>";
							echo "<dd>Vehicle ID: $vid</dd>";
							echo "<dd>Infraction Date: $inf_date</dd>";
							echo "<dd>Infraction Type: $inf_type</dd>";
							echo "<dd>Outstanding: $outstand</dd>";
							
							//This helps present the information if there's more than one record
							if($count > 1){
								echo "<hr>";
								$count -= 1;
							}
							echo "</div>";
						}
					?>
			</div>
		</div>
	</body>
	<footer>
		<h2><a href = "useredit.php">Edit Account Information</a></h2>
		<h2><a href = "logout.php">Sign Out</a></h2>
	</footer>
   
</html>