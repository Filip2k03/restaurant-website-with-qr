<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/config.php';

if (isset($_GET['item_id'])) {
    $item_id = intval($_GET['item_id']);
    $menu_item = getMenuItemById($item_id); // Function to fetch menu item details

    if ($menu_item) {
        // Generate QR code for the menu item
        $qr_code_data = "http://localhost:8000/user/menu.php?item_id=" . $item_id; // URL to the menu item
        $qr_code_image = generateQRCode($qr_code_data); // Function to generate QR code
    } else {
        echo "Menu item not found.";
        exit();
    }



function generateQRCode($data) {
    // Use a QR code library or API to generate the QR code
    // For example, using Google's Chart API
    return "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=" . urlencode($data);
}
} else {
    echo "Invalid item ID.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>QR Code for Menu Item</title>
</head>
<body>
    <div class="container">
        <h1>QR Code for <?php echo htmlspecialchars($menu_item['name']); ?></h1>
        <img src="<?php echo $qr_code_image; ?>" alt="QR Code for <?php echo htmlspecialchars($menu_item['name']); ?>">
        <p>Scan this QR code to view the menu item.</p>
        <a href="user/menu.php">Back to Menu</a>
    </div>
</body>
</html>