<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Assuming the user is logged in and user_id is stored in the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_items = $_POST['menu_items'];
    $quantities = $_POST['quantity'];
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in and user_id is stored in the session
    $order_type = $_POST['order_type']; // Take Away or Eat In

    // Insert the order into the orders table
    $query = "INSERT INTO orders (user_id, order_date, total_amount, status) VALUES (?, NOW(), 0, 'pending')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Insert the order items into the order_items table
    foreach ($menu_items as $item_id) {
        $quantity = $quantities[$item_id];
        $query = "INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (?, ?, ?, (SELECT price FROM menu_items WHERE id = ?))";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiii", $order_id, $item_id, $quantity, $item_id);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect based on order type
    if ($order_type == 'take_away') {
        header('Location: recipe.php?order_id=' . $order_id);
    } else {
        header('Location: table.php?order_id=' . $order_id);
    }
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
        <form method="POST" action="">
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