<?php
include('config/dbcon.php');

// Get form data from POST request
$productName = $_POST['product_name'];
$productDescription = $_POST['product_description'];
$propertyNumber = $_POST['property_number'];
$productPrice = $_POST['product_price'];
$productStock = $_POST['product_stock'];
$category = $_POST['product_category'];

// Prepare and execute the SQL query to insert data into the database
$sql = "INSERT INTO tbl_product (product_name, product_description,property_number,quantity_stock, price, category)
        VALUES ('$productName', '$productDescription', '$propertyNumber', '$productStock', '$productPrice', '$category')";

if ($conn->query($sql) === TRUE) {
    // Redirect to inventory-product.php
    header('Location: inventory-product.php');
    exit;
} else {
    // Redirect to add-product.php
    header('Location: add-product.php');
    exit;
}


// Close the database connection
$conn->close();
?>
