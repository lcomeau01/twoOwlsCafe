# 🦉 Two Owls Cafe

A PHP practice project that builds a simple cafe menu ordering system with dynamic menu display, order submission, and receipt generation.

## Files Overview

### `menu.php`
- Displays the cafe menu by fetching items dynamically from a MySQL database.
- Shows item images, names, descriptions, and prices.
- Allows customers to select quantities for multiple menu items.
- Contains a form for customer details (first and last name) and special instructions.
- Includes JavaScript validation to ensure at least one item is selected and customer name is entered.
- Automatically sets a pickup time 20 minutes from order submission.

### `process_order.php`
- Processes the submitted order form.
- Connects to the database to retrieve item names and prices based on selected quantities.
- Calculates and displays an order receipt including:
  - Order number (randomized)
  - Pickup time
  - Each item ordered with quantity and total price per item
  - Overall total, tax, and total with tax
  - Special instructions if provided
- Thanks the customer by name.

### `cache_header.php`
- Prevents browser caching to ensure the website always loads the latest version.

### `header.php`
- Contains the website header, included in both `menu.php` and `process_order.php`.

### `dbinfo.inc`
- Stores database connection credentials (username, password, server, database name).

## Features
- Dynamic menu fetching from MySQL database.
- Form input validation using JavaScript.
- Order receipt generation with calculated totals and tax.
- Handles special instructions from customers.
- Responsive and styled with embedded CSS.
- Uses PHP includes for modularity (`cache_header.php`, `header.php`, `dbinfo.inc`).

## Technologies Used
- PHP for server-side scripting.
- MySQL for database management.
- HTML/CSS for structure and styling.
- JavaScript for form validation.


