<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Assuming the user is logged in and user_id is stored in the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch order details if needed
$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Order Confirmation</title>
</head>
<body>
    <div class="container">
        <h1>Order Confirmation</h1>
        <form method="POST" action="place_order.php">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <label>
                <input type="radio" name="order_type" value="take_away" required> Take Away
            </label>
            <label>
                <input type="radio" name="order_type" value="eat_in" required> Eat In
            </label>
            <button type="submit">Confirm</button>
        </form>
    </div>
</body>
</html>