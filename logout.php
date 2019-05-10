<?php
   session_start();
   
   //This will destroy the current login session and bring the user back to the login page
   if(session_destroy()) {
      header("Location: login.php");
   }
?>