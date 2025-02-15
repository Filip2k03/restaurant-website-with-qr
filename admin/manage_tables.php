<?php
session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle table management actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_table'])) {
        $table_number = $_POST['table_number'];
        $capacity = $_POST['capacity'];
        $status = $_POST['status'];

        // Add table to the database
        addTable($table_number, $capacity, $status);
    } elseif (isset($_POST['update_table'])) {
        $table_id = $_POST['table_id'];
        $table_number = $_POST['table_number'];
        $capacity = $_POST['capacity'];
        $status = $_POST['status'];

        // Update table in the database
        updateTable($table_id, $table_number, $capacity, $status);
    } elseif (isset($_POST['delete_table'])) {
        $table_id = $_POST['table_id'];

        // Delete table from the database
        deleteTable($table_id);
    }
}

// Fetch all tables from the database
$tables = getAllTables();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Manage Tables</title>
</head>
<body>
    <div class="container">
        <h1>Manage Tables</h1>
        <form method="POST" action="">
            <h2>Add New Table</h2>
            <input type="text" name="table_number" placeholder="Table Number" required>
            <input type="number" name="capacity" placeholder="Capacity" required>
            <select name="status">
                <option value="available">Available</option>
                <option value="reserved">Reserved</option>
            </select>
            <button type="submit" name="add_table">Add Table</button>
        </form>

        <h2>Existing Tables</h2>
        <table>
            <thead>
                <tr>
                    <th>Table Number</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tables as $table): ?>
                <tr>
                    <td><?php echo $table['table_number']; ?></td>
                    <td><?php echo $table['capacity']; ?></td>
                    <td><?php echo $table['status']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="table_id" value="<?php echo $table['id']; ?>">
                            <input type="text" name="table_number" value="<?php echo $table['table_number']; ?>" required>
                            <input type="number" name="capacity" value="<?php echo $table['capacity']; ?>" required>
                            <select name="status">
                                <option value="available" <?php echo $table['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                                <option value="reserved" <?php echo $table['status'] == 'reserved' ? 'selected' : ''; ?>>Reserved</option>
                            </select>
                            <button type="submit" name="update_table">Update</button>
                            <button type="submit" name="delete_table">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>