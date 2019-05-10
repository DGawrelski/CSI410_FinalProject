<?php
   include("config.php");
   session_start();
   $error = "";
   $userid = "";
   
   //This page serves as the homepage for our web app
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);
      
      $sql = "SELECT id FROM users WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
	
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
		 $_SESSION['user_id'] = $myuserid;
		 
		 $sql = "SELECT id,user_type FROM users WHERE username = '$myusername'";
		 $result = mysqli_query($db,$sql);
		 $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		 //$userid = $row['id'];
		 
		 //if the user's type is admin, go to admin.php
		 //if the user's type is user, go to user.php
		 if($row['user_type'] == 'admin'){
			 header("location: admin.php");
		 }elseif($row['user_type'] == 'user'){
			 header("location: user.php");
		 }
		 if($row['user_type'] != 'admin' || $row['user_type'] != 'user'){
			 $error = "Your profile has not been properly set up. Please contact an admin for assistance.\n";
		 }
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Transit Login Page</title>
		<div style = "displayheader" align = "center">
			<h2>Transit Pass</h2>
		</div>
	</head>
   
	<body bgcolor = "#FFFFFF">
	
		<div align = "center">
			<div style = "width:300px; border: solid 1px #333333; " align = "left">
				<div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
				<div style = "margin:30px">
               
					<!-- Login form for a user -->
					<form action = "" method = "post">
						<label>Username  : </label><input type = "text" name = "username" class = "box"/><br /><br />
						<label>Password  : </label><input type = "password" name = "password" class = "box"/><br/><br />
						<input type = "submit" value = " Submit "/><br />
					</form>
					
					<!-- If there is an error, it will display here -->
					<div class = "error"><?php echo $error; ?></div>
					<div class = "defaults">Default Username: user</div>
					<div class = "defaults">Default Password: pass</div>
					
				</div>
				
			</div>
			
		</div>

	</body>
	<footer>
		<div align = "center">
			<label>For admin assistance, send email to dgawrelski@albany.edu</label>
		</div>
	</footer>
</html>