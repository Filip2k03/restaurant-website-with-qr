<?php
// session_start();
include('../includes/db.php');
include('../includes/functions.php');

// // Check if the user is logged in
// if (!isset($_SESSION['user_logged_in'])) {
//     header('Location: login.php');
//     exit();
// }

// Fetch user information
$user_id = $_SESSION['user_id'];
$user_info = getUserInfo($user_id); // Function to get user information

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>User Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user_info['username']); ?></h1>
        <nav>
            <ul>
                <li><a href="menu.php">View Menu</a></li>
                <li><a href="order.php">Place Order</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="user-info">
            <h2>Your Information</h2>
            <p>Email: <?php echo htmlspecialchars($user_info['email']); ?></p>
            <p>Role: <?php echo htmlspecialchars($user_info['role']); ?></p>
        </div>
    </div>
</body>
</html>