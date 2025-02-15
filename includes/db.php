<?php
$host = 'localhost'; // Database host
$db_name = 'restaurent'; // Database name
$username = 'root'; // Database username
$password = 'passw'; // Database password

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$conn 
?>