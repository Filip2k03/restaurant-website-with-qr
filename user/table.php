<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Fetch available tables
$query = "SELECT * FROM tables WHERE status = 'available'";
$result = $conn->query($query);
$tables = $result->fetch_all(MYSQLI_ASSOC);

// Fetch order details
$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Choose Table</title>
</head>
<body>
    <div class="container">
        <h1>Choose Table</h1>
        <form method="POST" action="assign_table.php">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <select name="table_id" required>
                <option value="">Select Table</option>
                <?php foreach ($tables as $table): ?>
                <option value="<?php echo $table['id']; ?>">Table <?php echo $table['table_number']; ?> (Capacity: <?php echo $table['capacity']; ?>)</option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Assign Table</button>
        </form>
    </div>
</body>
</html>