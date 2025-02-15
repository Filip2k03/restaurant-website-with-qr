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
    <title>Menu</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    
    <div class="container">
        <h1>Menu</h1>
        <ul>
            <?php foreach ($menu_items as $item): ?>
            <li>
                <h2><?php echo htmlspecialchars($item['name']); ?></h2>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
                <p>Price: <?php echo htmlspecialchars($item['price']); ?></p>
                <img src="../<?php echo $item['image']; ?>" alt="Image" width="100">
                <img src="<?php echo $item['qr_code']; ?>" alt="QR Code" width="50">
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php include('../includes/footer.php'); ?>
    
    <script src="../assets/js/scripts.js"></script>
</body>
</html>