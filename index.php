<?php
// db.php
include('includes/db.php');
?>


<?php
include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Welcome to Our Restaurant</title>
</head>
<body>
    <div class="container" style="text-align: center;">
        <h1>Welcome to Our Restaurant</h1>
        <p>Your favorite place for delicious meals!</p>
        <div class="menu">
            <h2>Menu</h2>
            <ul>
                <li>
                    <h3>Breakfast</h3>
                    <p>Start your day with our delicious breakfast options.</p>
                </li>
                <li>
                    <h3>Lunch</h3>
                    <p>Enjoy a hearty lunch with our daily specials.</p>
                </li>
                <li>
                    <h3>Dinner</h3>
                    <p>Indulge in our mouth-watering dinner options.</p>
                </li>
            </ul>
        </div>
        <div class="contact">
            <h2>Contact Us</h2>
            <p>123 Main Street</p>
            <p>City, State 12345</p>
            <p>Phone: 123-456-7890</p>
            <p>Email: <a href="mailto:info@ourrestaurant.com">info@ourrestaurant.com</a></p>
            <p>Hours: Monday - Thursday 11am - 10pm, Friday - Saturday 11am - 11pm, Sunday 10am - 9pm</p>
        </div>
        <div class="user-link">
            <a class="btn" href="./user/index.php">Go to User Dashboard</a>
        </div>
    </div>
</body>
</html>

<?php
include('includes/footer.php');
?>