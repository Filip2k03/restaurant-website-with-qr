<?php
// Add new menu item and manage existing menu items
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
        $stock = $_POST['stock'];
        $qr_code = generateQRCode($name); // Function to generate QR code

        // Handle image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
        }

        $query = "INSERT INTO menu_items (name, description, price, stock, qr_code, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdiss", $name, $description, $price, $stock, $qr_code, $image);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit_menu_item'])) {
        // Edit existing menu item
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        // Handle image upload
        $image = $_POST['existing_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
        }

        $query = "UPDATE menu_items SET name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdisi", $name, $description, $price, $stock, $image, $id);
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

    <title>Manage Menu</title>

    <style>
        body {

            font-family: sans-serif;

            background-color: #f4f4f4;
            /* Example background color */

            color: #333;
            /* Example text color */

        }



        .container {

            width: 80%;

            margin: 20px auto;

            background-color: #fff;

            padding: 20px;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }



        h1 {

            text-align: center;

            color: #007bff;
            /* Example heading color */

        }



        h2 {

            margin-top: 20px;

            color: #333;
            /* Example subheading color */

        }



        table {

            width: 100%;

            border-collapse: collapse;

            margin-top: 20px;

        }



        th,
        td {

            padding: 10px;

            text-align: left;

            border-bottom: 1px solid #ddd;

        }



        th {

            background-color: #007bff;
            /* Example table header color */

            color: white;

        }



        tr:hover {

            background-color: #f0f0f0;
            /* Example row hover color */

        }



        /* Form styling */

        form {

            margin-top: 20px;

        }



        label {

            display: block;

            margin-bottom: 5px;

        }



        input[type="text"],

        input[type="number"],

        textarea {

            width: 100%;

            padding: 8px;

            margin-bottom: 10px;

            border: 1px solid #ccc;

            box-sizing: border-box;
            /* Include padding in width */

        }

        input[type="file"] {

            margin-bottom: 10px;

        }



        button {

            background-color: #007bff;
            /* Example button color */

            color: white;

            padding: 10px 20px;

            border: none;

            cursor: pointer;

        }

        .edit-form {

            display: none;
            /* Initially hidden */

            margin-top: 20px;

        }

        .edit-form label {

            display: block;

        }

        .edit-form input[type="text"],

        .edit-form input[type="number"],

        .edit-form textarea {

            width: 100%;

            padding: 8px;

            margin-bottom: 10px;

            border: 1px solid #ccc;

            box-sizing: border-box;
            /* Include padding in width */

        }

        .edit-form button {

            background-color: #007bff;
            /* Example button color */

            color: white;

            padding: 10px 20px;

            border: none;

            cursor: pointer;

        }

        img {

            max-width: 50px;
            /* Limit image width */

            height: auto;

        }
    </style>

</head>

<body>

    <div class="container">

        <h1>Manage Menu</h1>



        <form method="POST" action="" enctype="multipart/form-data">

            <h2>Add Menu Item</h2>

            <label for="name">Name:</label>

            <input type="text" name="name" id="name" placeholder="Item Name" required>

            <label for="description">Description:</label>

            <textarea name="description" id="description" placeholder="Description" required></textarea>

            <label for="price">Price:</label>

            <input type="number" name="price" id="price" placeholder="Price" step="0.01" required>

            <label for="stock">Stock:</label>

            <input type="number" name="stock" id="stock" placeholder="Stock" required>

            <label for="image">Image:</label>

            <input type="file" name="image" id="image" accept="image/*">

            <button type="submit" name="add_menu_item">Add Item</button>

        </form>



        <h2>Existing Menu Items</h2>
        <table>
            <thead>
                <tr>
                    <th>QR Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menu_items as $item): ?>
                <tr>
                    <td><img src="<?php echo $item['qr_code']; ?>" alt="QR Code" width="50"></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="existing_image" value="<?php echo $item['image']; ?>">
                            <button type="submit" name="delete_menu_item">Delete</button>
                        </form>
                        <button onclick="showEditForm(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['name']); ?>', '<?php echo htmlspecialchars($item['description']); ?>', <?php echo $item['price']; ?>, <?php echo $item['stock']; ?>, '<?php echo $item['image']; ?>')">Edit</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>



        <div class="edit-form" id="editForm">

            <h2>Edit Menu Item</h2>

            <form method="POST" action="" enctype="multipart/form-data">

                <input type="hidden" name="id" value="">

                <input type="hidden" name="existing_image" value="">

                <label for="name">Name:</label>

                <input type="text" name="name" id="editName" required>

                <label for="description">Description:</label>

                <textarea name="description" id="editDescription" required></textarea>

                <label for="price">Price:</label>

                <input type="number" name="price" id="editPrice" step="0.01" required>

                <label for="stock">Stock:</label>

                <input type="number" name="stock" id="editStock" required>

                <label for="image">Image:</label>

                <input type="file" name="image" id="editImage" accept="image/*">

                <button type="submit" name="edit_menu_item">Update Item</button>

                <button type="button" onclick="hideEditForm()">Cancel</button>

            </form>

        </div>

    </div>



    <script>
        function showEditForm(id, name, description, price, stock, image) {

            document.getElementById('editForm').style.display = 'block';

            document.querySelector('#editForm input[name="id"]').value = id;

            document.querySelector('#editForm input[name="name"]').value = name;

            document.querySelector('#editForm textarea[name="description"]').value = description;

            document.querySelector('#editForm input[name="price"]').value = price;

            document.querySelector('#editForm input[name="stock"]').value = stock;

            document.querySelector('#editForm input[name="existing_image"]').value = image;



            // Set the form action (if needed)



        }



        function hideEditForm() {

            document.getElementById('editForm').style.display = 'none';

        }
    </script>

</body>

</html>