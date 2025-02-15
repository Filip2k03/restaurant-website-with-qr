<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $table_id = $_POST['table_id'];

    // Update the order with the table_id
    $query = "UPDATE orders SET table_id = ?, status = 'assigned' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $table_id, $order_id);
    $stmt->execute();
    $stmt->close();

    // Update the table status to occupied
    $query = "UPDATE tables SET status = 'occupied' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $table_id);
    $stmt->execute();
    $stmt->close();

    header('Location: order_confirmation.php?order_id=' . $order_id);
    exit();
}
?>