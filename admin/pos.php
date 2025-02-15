<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle form submission for processing orders
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['process_order'])) {
    $menu_item_id = $_POST['menu_item_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

    // Function to process the order
    $order_id = processOrder($user_id, $menu_item_id, $quantity);
    if ($order_id) {
        $message = "Order processed successfully. Order ID: " . $order_id;
    } else {
        $message = "Failed to process order. Please try again.";
    }
}

// Fetch menu items for the POS system
$menu_items = getMenuItems(); // Function to get all menu items

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>POS System</title>
</head>
<body>
    <div class="container">
        <h1>Point of Sale System</h1>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="manage_menu.php">Manage Menu</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="manage_tables.php">Manage Tables</a></li>
                <li><a href="../index.php">View Site</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

        <h2>Process Order</h2>
        <form method="POST" action="">
            <label for="menu_item_id">Select Menu Item:</label>
            <select name="menu_item_id" id="menu_item_id" required>
                <?php foreach ($menu_items as $item) { ?>
                    <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?> - $<?php echo $item['price']; ?></option>
                <?php } ?>
            </select>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" required>
            <button type="submit" name="process_order">Process Order</button>
        </form>
    </div>
</body>
</html>