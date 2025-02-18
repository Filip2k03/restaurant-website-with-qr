<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch statistics or any necessary data for the dashboard
$total_orders = getTotalOrders(); // Function to get total orders
$total_tables = getTotalTables(); // Function to get total tables
$total_menu_items = getTotalMenuItems(); // Function to get total menu items
$most_popular_item = getMostPopularOrderItem(); // Function to get most popular order item
$order_list = getOrderList(); // Function to get order list

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="./manage_menu.php">Manage Menu</a></li>
                <li><a href="./manage_orders.php">Manage Orders</a></li>
                <li><a href="./manage_tables.php">Manage Tables</a></li>
                <li><a href="./pos.php">POS System</a></li>
                <li><a href="../index.php">View Site</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="stats">
            <div class="admin-user">
                <h2>Admin Information</h2>
                <p>Username: <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
            </div>
            <h2>Statistics</h2>
            <p>Total Orders: <?php echo $total_orders; ?></p>
            <p>Total Tables: <?php echo $total_tables; ?></p>
            <p>Total Menu Items: <?php echo $total_menu_items; ?></p>
            <p>Most Popular Item: <?php echo htmlspecialchars($most_popular_item['name']); ?> (<?php echo $most_popular_item['order_count']; ?> orders)</p>
        </div>
        <div class="order-list">
            <h2>Recent Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Username</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_list as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                        <td><?php echo $order['total_amount']; ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>