<?php
include('../includes/db.php');
include('../includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    $errors = []; // Array to store error messages

    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Check for username uniqueness
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->fetch_assoc()['COUNT(*)'] > 0) {
        $errors[] = "Username already exists.";
    }
    $stmt->close();


    if (empty($errors)) { // No errors, proceed with registration
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            $stmt->close();
            header('Location: login.php?success=Registration successful. Please log in.');
            exit();
        } else {
            // Log the error for debugging (but don't show the detailed error to the user)
            error_log("Registration error: " . $stmt->error);
            $errors[] = "Registration failed. Please try again."; // Generic error message
        }
        $stmt->close();
    }

    // If there are errors, redirect back to the registration form with error messages in the URL
    if (!empty($errors)) {
        $error_string = implode("&", array_map(function($val) { return "error[]=" . urlencode($val); }, $errors));
        header("Location: register.php?" . $error_string);
        exit();
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
        <form action="register.php" method="POST" class="login-form">
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