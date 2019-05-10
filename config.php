<?php
	
   //Connection information for the MySQL database
   $db_serv = 'localhost';
   $db_user = 'root';
   $db_pass = 'usbw';
   $db_db = 'transit';
   
   $db = mysqli_connect($db_serv,$db_user,$db_pass,$db_db);
   
   //If unable to connect, this will tell us why
   if($db->connect_error){
	   die("Connection failed: " . $db->connect_error);
   }
   //echo "Connected successfully";
?>