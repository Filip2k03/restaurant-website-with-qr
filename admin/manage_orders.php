<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch all orders from the database
$orders = getAllOrders(); // Function to get all orders

// Function to delete an order
if (isset($_GET['delete'])) {
    $order_id = $_GET['delete'];
    deleteOrder($order_id); // Function to delete an order
    header('Location: manage_orders.php'); // Redirect after deletion
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Manage Orders</title>
</head>
<body>
    <div class="container">
        <h1>Manage Orders</h1>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="manage_menu.php">Manage Menu</a></li>
                <li><a href="manage_tables.php">Manage Tables</a></li>
                <li><a href="pos.php">POS System</a></li>
                <li><a href="../index.php">View Site</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Menu Item ID</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['menu_item_id']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $order['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>