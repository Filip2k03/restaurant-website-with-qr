<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Fetch all menu items
$query = "SELECT * FROM menu_items";
$result = $conn->query($query);
$menu_items = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Order</title>
</head>
<body>
    <div class="container">
        <h1>Order</h1>
        <form method="POST" action="place_order.php">
            <ul>
                <?php foreach ($menu_items as $item): ?>
                <li>
                    <h2><?php echo htmlspecialchars($item['name']); ?></h2>
                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                    <p>Price: <?php echo htmlspecialchars($item['price']); ?></p>
                    <img src="../<?php echo $item['image']; ?>" alt="Image" width="100">
                    <img src="<?php echo $item['qr_code']; ?>" alt="QR Code" width="50">
                    <input type="number" name="quantity[<?php echo $item['id']; ?>]" value="1" min="1" max="10">
                    <input type="checkbox" name="menu_items[]" value="<?php echo $item['id']; ?>"> Add to Order
                </li>
                <?php endforeach; ?>
            </ul>
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>