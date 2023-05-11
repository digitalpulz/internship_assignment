<?php
include 'functions.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $productData = array(
        'productCode' => $_POST['productCode'],
        'productName' => $_POST['productName'],
        'dangerLevel' => $_POST['dangerLevel'],
        'reorderLevel' => $_POST['reorderLevel'],
        'active' => isset($_POST['active']) ? true : false
    );

    // Create the product using the backend API
    $result = createProduct($productData);

    // Redirect to the index page after successful creation
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h1>Add Product</h1>
    <form method="POST" action="add_product.php">
        <label for="productCode">Product Code:</label>
        <input type="text" name="productCode" required>
        <br><br>
        <label for="productName">Product Name:</label>
        <input type="text" name="productName" required>
        <br><br>
        <label for="dangerLevel">Danger Level:</label>
        <input type="number" name="dangerLevel" required>
        <br><br>
        <label for="reorderLevel">Reorder Level:</label>
        <input type="number" name="reorderLevel" required>
        <br><br>
        <label for="active">Active:</label>
        <input type="checkbox" name="active">
        <br><br>
        <input type="submit" value="Add Product">
    </form>
</body>
</html>