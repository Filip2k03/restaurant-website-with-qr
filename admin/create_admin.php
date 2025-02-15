<?php
include('../includes/db.php');

// Admin credentials
$username = 'root';
$password = 'passw'; // Hash the password

// Insert admin user into the database
$query = "INSERT INTO admins (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>