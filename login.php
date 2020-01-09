<?php
     
     $db_hostname = 'localhost';
     $db_database = 'blog';
     $db_username = 'root';
     $db_password = 'root';

     $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database); //connecting to the database
     if (!$conn) die("Unable to connect to MySQL: " . mysql_error()); //checking connection
?>