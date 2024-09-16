<?php
// Database configuration
$servername = "127.0.0.1";
$username = "root";
$password = ""; // Replace with your actual root password if there is one
$dbname = "doctor";
$port = 3308; // Specify the port number

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
