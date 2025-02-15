<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    $user = getUserByUsername($username); // Function to fetch user by username
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>User Login</title>
</head>
<body>
    <div class="container">
        <h1 class="form-title">User Login</h1>
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST" class="login-form">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" class="form-input" required>
            
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-input" required>
            
            <button type="submit" class="form-btn">Login</button>
        </form>
        <p class="register-link">Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
// Compare this snippet from user/login.php: