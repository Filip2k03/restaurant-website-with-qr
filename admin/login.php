<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminusername = $_POST['adminusername'];
    $adminpassword = $_POST['adminpassword'];

    // Validate credentials
    try {
        // Example using prepared statements (crucial!)
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $adminusername);
        $stmt->execute();
        $admin = $stmt->get_result()->fetch_assoc();

        if ($admin AND $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $adminusername;
            session_regenerate_id(true); // Important!
            header('Location: ./index.php');
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } catch (mysqli_sql_exception $e) {
        // Log the error (but not the query itself in production!)
        error_log("Admin login error: " . $e->getMessage());
        $error = "An error occurred. Please try again later."; // Don't expose detailed error info to the user
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="adminusername" required>
            <label for="password">Password:</label>
            <input type="password" name="adminpassword" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>