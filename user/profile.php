<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch user profile information
$user_id = $_SESSION['user_id'];
$user = getUserById($user_id); // Function to get user details by ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update user profile
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    // Validate and update user information
    if (updateUserProfile($user_id, $username, $email)) {
        $message = "Profile updated successfully.";
        $user = getUserById($user_id); // Refresh user data
    } else {
        $message = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>User Profile</title>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <button type="submit">Update Profile</button>
        </form>
        <a href="index.php">Back to Dashboard</a>
    </div>
</body>
</html>