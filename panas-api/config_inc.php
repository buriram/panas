<?php
$servername = "localhost";
$username = "panas2018";
$password = "panas2018";
$dbname = "db_panasvue2018";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
mysqli_set_charset($conn, "utf8");
?>