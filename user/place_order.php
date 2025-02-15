<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_items = $_POST['menu_items'];
    $quantities = $_POST['quantity'];
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in and user_id is stored in the session

    foreach ($menu_items as $item_id) {
        $quantity = $quantities[$item_id];
        $query = "INSERT INTO orders (user_id, menu_item_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $user_id, $item_id, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: order_confirmation.php');
    exit();
}
?>