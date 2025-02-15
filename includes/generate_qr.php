<?php
require_once 'includes/functions.php';

if (isset($_GET['item_id'])) {
    $item_id = intval($_GET['item_id']);

    if ($item_id <= 0) {
        displayError("Invalid item ID.");
        exit();
    }

    $menu_item = getMenuItemById($item_id);

    if ($menu_item) {
        $qr_code_data = $base_url . "/user/menu.php?item_id=" . $item_id; // Use $base_url from config.php
        $qr_code_image = generateQRCode($qr_code_data);
    } else {
        displayError("Menu item not found.");
        exit();
    }
} else {
    displayError("Item ID not provided.");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>QR Code for <?php echo htmlspecialchars($menu_item['name']); ?></title>
</head>
<body>
    <div class="container">
        <h1>QR Code for <?php echo htmlspecialchars($menu_item['name']); ?></h1>
        <?php if (isset($qr_code_image)) : ?>
            <img src="<?php echo $qr_code_image; ?>" alt="QR Code for <?php echo htmlspecialchars($menu_item['name']); ?>">
            <p>Scan this QR code to view the menu item.</p>
        <?php endif; ?>
        <a href="user/menu.php">Back to Menu</a>
    </div>
</body>
</html>