# Restaurant Website Project

This project is a complete restaurant management system that includes a Point of Sale (POS) system, a user-friendly menu page with QR code functionality, an admin panel for managing the restaurant's operations, and a user panel for customer interactions.

## Project Structure

```
restaurant-website
├── admin
│   ├── index.php          # Admin dashboard displaying statistics
│   ├── manage_menu.php    # Manage restaurant menu items
│   ├── manage_orders.php   # View and manage customer orders
│   ├── manage_tables.php   # Manage restaurant tables
│   ├── pos.php            # Point of Sale system for processing orders
│   ├── login.php          # Admin login functionality
│   └── logout.php         # Admin logout functionality
├── assets
│   ├── css
│   │   └── styles.css     # CSS styles for the website
│   └── js
│       └── scripts.js      # JavaScript functionality for the website
├── includes
│   ├── db.php             # Database connection file
│   ├── functions.php       # Utility functions
│   ├── header.php         # Header component for the website
│   ├── footer.php         # Footer component for the website
│   └── config.php         # Configuration settings
├── user
│   ├── index.php          # Main page for the user panel
│   ├── menu.php           # Displays the restaurant's menu with QR codes
│   ├── order.php          # Allows users to place orders
│   ├── profile.php        # View and edit user profile
│   ├── register.php       # User registration functionality
│   ├── login.php          # User login functionality
│   └── logout.php         # User logout functionality
├── index.php              # Landing page for the restaurant website
├── qr_code.php            # Generates QR codes for menu items
├── README.md              # Project documentation
└── database
    └── restaurant.sql     # SQL script to create necessary database tables
```

## Features

- **Admin Panel**: Manage menu items, orders, tables, and view statistics.
- **User Panel**: Users can view the menu, place orders, and manage their profiles.
- **POS System**: A fully functional Point of Sale system for processing orders.
- **QR Code Functionality**: Each menu item has a QR code for easy access.
- **Responsive Design**: The website is designed to be user-friendly on both desktop and mobile devices.

## Database Structure

The database consists of the following tables:

- **users**: Stores user information (id, username, password, email, role).
- **menu_items**: Contains menu item details (id, name, description, price, qr_code).
- **orders**: Records customer orders (id, user_id, menu_item_id, quantity, order_date).
- **tables**: Manages restaurant tables (id, table_number, capacity, status).

## Installation

1. Clone the repository to your local machine.
2. Import the `restaurant.sql` file into your MySQL database.
3. Update the `config.php` file with your database connection details.
4. Access the application through your web server.

## Usage

- Access the admin panel via `admin/login.php`.
- Users can register and log in through the user panel.
- Navigate through the menu and place orders using the user interface.

## Contributing

Feel free to fork the repository and submit pull requests for any improvements or features you would like to add.