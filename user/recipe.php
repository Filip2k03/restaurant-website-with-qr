<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Fetch order details
$order_id = $_GET['order_id'];
$query = "SELECT order_items.*, menu_items.name FROM order_items JOIN menu_items ON order_items.menu_item_id = menu_items.id WHERE order_items.order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Recipe</title>
</head>
<body>
    <div class="container">
        <h1>Recipe</h1>
        <ul>
            <?php foreach ($order_items as $item): ?>
            <li><?php echo htmlspecialchars($item['name']); ?> - Quantity: <?php echo $item['quantity']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>