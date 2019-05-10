<?php
   include('session.php');
   
   //This page allows admins to perform creation, reading, and updating operations for user accounts
   
?>
<html>
   
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Admin Page</title>
	</head>
   
	<body>
		<h1>Admin Session for <?php echo $login_session; ?></h1>
		
		<div align = "left">
			<div class = "displaybox" align = "left">
				<div class = "displayboxinner">
					<!-- User ID section -->
					<div class = "displayheader" align = "left"><b>User ID Search</b></div>
					<?php
						echo "<br>";
						echo "<form action = '' method = 'post'>";
						echo "<label>Username   : </label><input type = 'text' name = 'username' class = 'box' required/><br /><br />";
						echo "<input type = 'submit' name = 'submit_uname' value = ' Submit '/><br />";
						echo "</form>";
						
						if(isset($_POST['submit_uname'])){
							$search_name = mysqli_real_escape_string($db,$_POST['username']);
							$sql = "SELECT id,user_type FROM users WHERE username = '$search_name'";
							$result = mysqli_query($db,$sql);
							$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
							
							//If the username doesn't exist, display an error
							if(mysqli_num_rows($result) == 0){
								echo "<div class = 'error'> User $search_name does not exist.</div>";
							}else{
								
								//Else, display the id for the given username
								$search_id = $row['id'];
								$search_role = $row['user_type'];
								echo "User ID for $search_role $search_name is $search_id ";
							}
							echo "<br>";
						}
						echo "<br>";
						//echo "</form>";
					?>
					<!-- Vehicle Search section -->
					<div class = "displayheader" align = "left"><b>Vehicle Search</b></div>
					<?php
						echo "<br>";
						echo "<form action = '' method = 'post'>";
						echo "<label>User ID   : </label><input type = 'text' name = 'veh_userid' class = 'box' required/><br /><br />";
						echo "<input type = 'submit' name = 'submit_veh_userid' value = ' Submit '/><br />";
						echo "</form>";
						
						if(isset($_POST['submit_veh_userid'])){
							$search_veh_userid = mysqli_real_escape_string($db,$_POST['veh_userid']);
							$sql = "SELECT id FROM users WHERE id = '$search_veh_userid'";
							$result = mysqli_query($db,$sql);
							
							//If no user exists with the given id, displays such
							if(mysqli_num_rows($result) == 0){
								echo "<div class = 'error'>A user with $search_veh_userid does not exist.</div>";
								echo "<br>";
							}else{
								$sql = "SELECT id, make, model, year, vin FROM vehicle WHERE userid = '$search_veh_userid' ORDER BY id ASC";
								$result = mysqli_query($db,$sql);
								
								//If the user doesn't own a vehicle, displays such. Else, displays the vehicles the user owns
								if(mysqli_num_rows($result) == 0){
									echo "<br>";
									echo "<div class = 'error'>User ID $search_veh_userid does not own any vehicles.</div>";
								}else{
									$count = mysqli_num_rows($result);
									echo "User ID $search_veh_userid owns : \n";
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
								}
								echo "<br>";
							}
							echo "<br>";
						}
						echo "<br>";
					?>
					<!-- Create New Users section -->
					<div class = "displayheader"><b>Create New User Account</b></div>
					<?php
						
						echo "<br>";
						echo "<form action = '' method = 'post'>";
						echo "<label>Username  : </label><input type = 'text' name = 'username' class = 'box'/><br /><br />";
						echo "<label>Password  : </label><input type = 'text' name = 'password' class = 'box'/><br /><br />";
						echo "<label>Email  : </label><input type = 'email' name = 'email' class = 'box'/><br /><br />";
						echo "<label>Payment Method: </label>";
						echo "<select name = 'pay_method'>";
						echo "<option value = 'credit'>Credit</option>";
						echo "<option value = 'check'>Check</option>";
						echo "</select>";
						echo "<br>";
						echo "<input type = 'submit' name = 'submit_user' value = ' Submit '/><br />";
						echo "</form>";
						
						//If the submit button is pushed, pull the values from input into variables and run SQL
						if(isset($_POST['submit_user'])){
							$user = mysqli_real_escape_string($db,$_POST['username']);
							$pass = mysqli_real_escape_string($db,$_POST['password']);
							$email = mysqli_real_escape_string($db,$_POST['email']);
							
							$sql = "SELECT username FROM users WHERE username = '$user'";
							$result = mysqli_query($db,$sql);
							
							if(mysqli_num_rows($result) == 0){
								$sql = "INSERT INTO users (username,email,user_type,password) VALUES ('$user','$email','user','$pass')";
								$result = mysqli_query($db,$sql);
							
								//With the new user created, we pull their id and output it for use further down the page
								$sql = "SELECT id FROM users WHERE username = '$user'";
								$result = mysqli_query($db,$sql);
								$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
								$curr_id = $row['id'];
								echo "User ID for $user is $curr_id";
								echo "<br>";
							}else{
								echo "<div class = 'error'> A user with that username already exists.</div>";
								echo "<br>";
							}
						}
						echo "<br>";
					?>
					<div class = "displayheader"><b>Register Vehicle</b></div>
					<?php
						
						echo "<br>";
						echo "<form action = '' method = 'post'>";
						echo "<label>User ID: </label><input type = 'text' name = 'userid' class = 'box'/><br /><br />";
						echo "<label>Make: </label><input type = 'text' name = 'veh_make' class = 'box'/><br /><br />";
						echo "<label>Model: </label><input type = 'text' name = 'veh_model' class = 'box'/><br /><br />";
						echo "<label>Year: </label><input type = 'text' maxlength = '4' name = 'veh_year' class = 'box'/><br /><br />";
						echo "<label>VIN: </label><input type = 'text' maxlength = '17' name = 'veh_vin' class = 'box'/><br /><br />";
						echo "<br>";
						echo "<input type = 'submit' name = 'submit_vehicle' value = ' Submit '/><br />";
						echo "</form>";
						if(isset($_POST['submit_vehicle'])){
							$userid = mysqli_real_escape_string($db,$_POST['userid']);
							$veh_make = mysqli_real_escape_string($db,$_POST['veh_make']);
							$veh_model = mysqli_real_escape_string($db,$_POST['veh_model']);
							$veh_year = mysqli_real_escape_string($db,$_POST['veh_year']);
							$veh_vin = mysqli_real_escape_string($db,$_POST['veh_vin']);
							
							//First get the corresponding userid
							$sql = "SELECT username FROM users WHERE id = '$userid'";
							$result = mysqli_query($db,$sql);
							$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
							$uname = $row['username'];
							
							//Then create a new record in the vehicle table
							$sql = "INSERT INTO vehicle(userid,ownername,make,model,year,vin) VALUES ('$userid','$uname','$veh_make','$veh_model','$veh_year','$veh_vin')";
							$result = mysqli_query($db,$sql);
						}
						echo "<br>";
					?>
					<!-- Register Infraction section -->
					<div class = "displayheader"><b>Register Infraction</b></div>
					<?php
						
						echo "<br>";
						echo "<form action = '' method = 'post'>";
						echo "<label>Vehicle ID: </label><input type = 'text' name = 'vehicle_id' class = 'box'/><br /><br />";
						echo "<label>Infraction Date: </label><input type = 'date' name = 'infraction_date' required/><br /><br />";
						echo "<label>Infraction Type: </label>";
						echo "<select name = 'infraction_type'>";
						echo "<option value = 'speeding'>Speeding</option>";
						echo "<option value = 'balance'>Balance</option>";
						echo "<option value = 'missed scan'>Missed Scan</option>";
						echo "</select>";
						echo "<br>";
						echo "<input type = 'submit' name = 'submit_infraction' value = ' Submit '/><br />";
						echo "</form>";
						if(isset($_POST['submit_infraction'])){
							$vehicleid = mysqli_real_escape_string($db,$_POST['vehicle_id']);
							$infrac_date = mysqli_real_escape_string($db,$_POST['infraction_date']);
							$infrac_type = mysqli_real_escape_string($db,$_POST['infraction_type']);
							
							//First get userid for the vehicle
							$sql = "SELECT userid FROM vehicle WHERE id = '$vehicleid'";
							$result = mysqli_query($db,$sql);
							$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
							
							$userid = $row['userid'];
							
							//Then use that userid to register an infraction in the infraction table
							$sql = "INSERT INTO infraction(userid,vehicleid,infraction_date,infraction_type,outstanding) VALUES ('$userid','$vehicleid','$infrac_date','$infrac_type','Y')";
							$result = mysqli_query($db,$sql);
							echo "";
						}
						echo "<br>";
					?>
					<!-- Edit Vehicle section -->
					<div class = "displayheader"><b>Edit Vehicle</b></div>
					<?php
						
						echo "<br>";
						echo "<form action = '' method = 'post'>";
						echo "<label>Vehicle ID: </label><input type = 'text' name = 'edit_vid' class = 'box' required/><br /><br />";
						echo "<label>Make: </label><input type = 'text' name = 'new_make' class = 'box'/><br /><br />";
						echo "<label>Model: </label><input type = 'text' name = 'new_model' class = 'box'/><br /><br />";
						echo "<label>Year: </label><input type = 'text' name = 'new_year' class = 'box'/><br /><br />";
						echo "<label>VIN: </label><input type = 'text' name = 'new_vin' class = 'box'/><br /><br />";
						echo "<input type = 'submit' name = 'submit_edit' value = ' Submit '/><br />";
						echo "</form>";
						if(isset($_POST['submit_edit'])){
							$edit_vid = mysqli_real_escape_string($db,$_POST['edit_vid']);
							
							$new_make = NULL;
							$new_model = NULL;
							$new_year = NULL;
							$new_vin = NULL;
							
							//This code is structured such that if one of the input fields above was left empty, the corresponding
							//fields in the database would not be deleted
							if($_POST['new_make']){
								$new_make = mysqli_real_escape_string($db,$_POST['new_make']);
								$sql = "UPDATE vehicle SET make = '$new_make' WHERE id = '$edit_vid'";
								$result = mysqli_query($db,$sql);
							}
							if($_POST['new_model']){
								$new_model = mysqli_real_escape_string($db,$_POST['new_model']);
								$sql = "UPDATE vehicle SET model = '$new_model' WHERE id = '$edit_vid'";
								$result = mysqli_query($db,$sql);
							}
							if($_POST['new_year']){
								$new_year = mysqli_real_escape_string($db,$_POST['new_year']);
								$sql = "UPDATE vehicle SET year = '$new_year' WHERE id = '$edit_vid'";
								$result = mysqli_query($db,$sql);
							}
							if($_POST['new_vin']){
								$new_vin = mysqli_real_escape_string($db,$_POST['new_vin']);
								$sql = "UPDATE vehicle SET vin = '$new_vin' WHERE id = '$edit_vid'";
								$result = mysqli_query($db,$sql);
							}
						}
						echo "<br>";
					?>
				</div>
			</div>
		</div>
	</body>
	<footer>
		<h2><a href = "logout.php">Sign out</a></h2>
		
	</footer>
   
</html>