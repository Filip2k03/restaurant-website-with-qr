<?php

function connectDB() {
    $conn = mysqli_connect("localhost", "root", "passw", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error()); // Handle connection error
    }
    return $conn;
}
function getTotalOrders() {
    global $conn;
    $query = "SELECT COUNT(*) as total FROM orders";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

function getTotalTables() {
    global $conn;
    $query = "SELECT COUNT(*) as total FROM tables";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

function getTotalMenuItems() {
    global $conn;
    $query = "SELECT COUNT(*) as total FROM menu_items";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

function generateQRCode($data) {
    return "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=thuyakyaw.vercel.app";
}

function getMenuItems() {
    global $conn;
    $query = "SELECT * FROM menu_items";
    $result = mysqli_query($conn, $query);
    $menu_items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $menu_items[] = $row;
    }
    return $menu_items;
}

function addTable($table_number, $capacity, $status) {
    global $conn;
    $query = "INSERT INTO tables (table_number, capacity, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sis", $table_number, $capacity, $status);
    $stmt->execute();
    $stmt->close();
}

function updateTable($table_id, $table_number, $capacity, $status) {
    global $conn;
    $query = "UPDATE tables SET table_number = ?, capacity = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sisi", $table_number, $capacity, $status, $table_id);
    $stmt->execute();
    $stmt->close();
}

function deleteTable($table_id) {
    global $conn;
    $query = "DELETE FROM tables WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $table_id);
    $stmt->execute();
    $stmt->close();
}

function getAllTables() {
    global $conn;
    $query = "SELECT * FROM tables";
    $result = $conn->query($query);
    $tables = [];
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row;
    }
    return $tables;
}


function createOrder($user_id, $menu_item_id, $quantity) {
    global $conn;
    $query = "INSERT INTO orders (user_id, menu_item_id, quantity, order_date) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iii', $user_id, $menu_item_id, $quantity);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getUserOrders($user_id) {
    global $conn;
    $query = "SELECT * FROM orders WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $orders;
}

function getAdminByUsername($username) {
    global $conn;
    $query = "SELECT * FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $admin;
}

function getUserByUsername($username) {
    global $conn;
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user;
}

function getUserInfo($user_id) {
    global $conn;
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user;
}

function getAllOrders() {
    global $conn;
    $query = "SELECT * FROM orders";
    $result = $conn->query($query);
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    return $orders;
}

function deleteOrder($order_id) {
    global $conn;
    $query = "DELETE FROM orders WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
}

function getMenuItemById($menu_item_id) {
    global $conn;
    $query = "SELECT * FROM menu_items WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $menu_item_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $menu_item = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $menu_item;
}

function getUserById($user_id) {
    global $conn;
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user;
}

function displayError($message) {
    echo "<div class='error'>" . $message . "</div>"; // Style this with CSS
}

function getMostPopularOrderItem() {
    global $conn;
    $query = "SELECT menu_items.name, COUNT(order_items.menu_item_id) AS order_count 
              FROM order_items 
              JOIN menu_items ON order_items.menu_item_id = menu_items.id 
              GROUP BY order_items.menu_item_id 
              ORDER BY order_count DESC 
              LIMIT 1";
    $result = $conn->query($query);
    return $result->fetch_assoc();
}

function getOrderList() {
    global $conn;
    $query = "SELECT orders.id, users.username, orders.order_date, orders.total_amount, orders.status 
              FROM orders 
              JOIN users ON orders.user_id = users.id 
              ORDER BY orders.order_date DESC";
    $result = $conn->query($query);
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    return $orders;
}
?>