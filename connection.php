<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
   
    die(mysqli_error($conn));
}   
?>
