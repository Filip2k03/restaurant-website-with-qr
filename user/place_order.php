<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_items = $_POST['menu_items'];
    $quantities = $_POST['quantity'];
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in and user_id is stored in the session

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

    header('Location: order_confirmation.php?order_id=' . $order_id);
    exit();
}
?>