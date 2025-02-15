<?php
// Add new menu item and manage existing menu items
// @author: [Thu Ya Kyaw]

session_start();
include('../includes/db.php');
include('../includes/functions.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle form submission for adding or editing menu items
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_menu_item'])) {
        // Add new menu item
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $qr_code = generateQRCode($name); // Function to generate QR code

        // Handle image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
        }

        $query = "INSERT INTO menu_items (name, description, price, qr_code, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdss", $name, $description, $price, $qr_code, $image);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit_menu_item'])) {
        // Edit existing menu item
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Handle image upload
        $image = $_POST['existing_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
        }

        $query = "UPDATE menu_items SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_menu_item'])) {
        // Delete menu item
        $id = $_POST['id'];

        $query = "DELETE FROM menu_items WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

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
    <title>Manage Menu</title>
</head>
<body>
    <div class="container">
        <h1>Manage Menu</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <h2>Add Menu Item</h2>
            <input type="text" name="name" placeholder="Item Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <input type="file" name="image" accept="image/*">
            <button type="submit" name="add_menu_item">Add Item</button>
        </form>

        <h2>Existing Menu Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>QR Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menu_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                    <td><?php echo htmlspecialchars($item['price']); ?></td>
                    <td><img src="../<?php echo $item['image']; ?>" alt="Image" width="50"></td>
                    <td><img src="<?php echo $item['qr_code']; ?>" alt="QR Code" width="50"></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="existing_image" value="<?php echo $item['image']; ?>">
                            <button type="submit" name="delete_menu_item">Delete</button>
                        </form>
                        <button onclick="editMenuItem(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['name']); ?>', '<?php echo htmlspecialchars($item['description']); ?>', <?php echo $item['price']; ?>, '<?php echo $item['image']; ?>')">Edit</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editMenuItem(id, name, description, price, image) {
            document.querySelector('input[name="id"]').value = id;
            document.querySelector('input[name="name"]').value = name;
            document.querySelector('textarea[name="description"]').value = description;
            document.querySelector('input[name="price"]').value = price;
            document.querySelector('input[name="existing_image"]').value = image;
        }
    </script>
</body>
</html>
