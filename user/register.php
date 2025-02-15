<?php
include('../includes/db.php');
include('../includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    if (!empty($username) && !empty($password) && !empty($email)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            header('Location: login.php?success=Registration successful. Please log in.');
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>User Registration</title>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>