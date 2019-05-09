<?php

   $db_serv = 'localhost';
   $db_user = 'root';
   $db_pass = 'usbw';
   $db_db = 'multi_login';
   
   $db = mysqli_connect($db_serv,$db_user,$db_pass,$db_db);
   
   if($db->connect_error){
	   die("Connection failed: " . $db->connect_error);
   }
   //echo "Connected successfully";
?>