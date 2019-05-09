<?php
	include('session.php');
	include('config.php');
?>
<html>
	<head>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
		<title>Edit Account Information</title>
	</head>
	<body>
		<h1>Edit Account Information</h1>
		<div class = "displaybox" align = "left">
			<div class = "displayboxinner">
				<div class = "displayheader"><b>Email</b></div>
					<?php
						$sql = "SELECT id,email FROM users WHERE username = '$login_session'";
						$result = mysqli_query($db,$sql);
						$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
						$userid = $row['id'];
						$curr_email = $row['email'];
						
						echo "<br>";
						echo "<label>Current email: $curr_email</label>";
						echo "<form action = '' method = 'post'>";
						echo "<br>";
						echo "<label>New email: </label><input type = 'text' name = 'new_email' class = 'box' required = 'required'/><br /><br />";
						echo "<input type = 'submit' name = 'submit_email' value = ' Submit '/><br />";
						if(isset($_POST['submit_email'])){
							$new_email = mysqli_real_escape_string($db,$_POST['new_email']);
							$sql = "UPDATE users SET email = '$new_email' WHERE username = '$login_session'";
							$result = mysqli_query($db,$sql);
							$curr_email = $new_email;
						}
						echo "</form>";
					?>
				<div class = "displayheader"><b>Payment</b></div>
					<?php
						$sql = "SELECT pay_method, auto_renew FROM finance WHERE userid = '$userid'";
						$result = mysqli_query($db,$sql);
						$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
						$pay_method = $row['pay_method'];
						
						if($row['auto_renew'] == 'Y'){
							$auto_renew = "Yes";
						}elseif($row['auto_renew'] == 'N'){
							$auto_renew = "No";
						}

						echo "<br>";
						echo "<label>Payment method: $pay_method</label>";
						echo "<br>";
						echo "<form action = '' method = 'post'>";
						echo "<label>Change payment method? </label>";
						echo "<input type = 'submit' name = 'submit_pay' value = ' Change '/><br />";
						if(isset($_POST['submit_pay'])){
							if($row['pay_method'] == 'credit'){
								$sql = "UPDATE finance SET pay_method = 'check' WHERE userid = '$userid'";
								$result = mysqli_query($db,$sql);
								echo "Payment method changed";
							}elseif($row['pay_method'] == 'check'){
								$sql = "UPDATE finance SET pay_method = 'credit' WHERE userid = '$userid'";
								$result = mysqli_query($db,$sql);
								echo "Payment method changed";
							}
						}
						echo "</form>";
						echo "<label>Auto renew: $auto_renew</label>";
						echo "<form action = '' method = 'post'>";
						if($row['auto_renew'] == 'Y'){
							echo "<label>Turn auto renew off? </label>";
							echo "<input type = 'submit' name = 'submit_renew' value = ' Turn off '/><br />";
							if(isset($_POST['submit_renew'])){
								$sql = "UPDATE finance SET auto_renew = 'N' WHERE userid = '$userid'";
								$result = mysqli_query($db,$sql);
								echo "<div>Auto renew disabled</div>";
							}
						}elseif($row['auto_renew'] == 'N'){
							echo "<label>Turn auto renew on? </label>";
							echo "<input type = 'submit' name = 'submit_renew' value = ' Turn on '/><br />";
							if(isset($_POST['submit_renew'])){
								$sql = "UPDATE finance SET auto_renew = 'Y' WHERE userid = '$userid'";
								$result = mysqli_query($db,$sql);
								echo "<div class = 'error'>Auto renew enabled</div>";
							}
						}
					?>
			</div>
		</div>
	</body>
	<footer>
		<h2><a href = "user.php">Back to Account Summary</a></h2>
		<h2><a href = "logout.php">Sign Out</a></h2>
	</footer>
</html>