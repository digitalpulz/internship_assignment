<?php
include 'functions.php';

// Fetch product details if the product ID is provided
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $product = getProduct($productId);
}

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

    // Update the product using the backend API
    updateProduct($productId, $productData);

    // Redirect to the index page after successful update
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form method="POST" action="edit_product.php?id=<?php echo $productId; ?>">
        <label for="productCode">Product Code:</label>
        <input type="text" name="productCode" value="<?php echo $product['productCode']; ?>" required>
        <br><br>
        <label for="productName">Product Name:</label>
        <input type="text" name="productName" value="<?php echo $product['productName']; ?>" required>
        <br><br>
        <label for="dangerLevel">Danger Level:</label>
        <input type="number" name="dangerLevel" value="<?php echo $product['dangerLevel']; ?>" required>
        <br><br>
        <label for="reorderLevel">Reorder Level:</label>
        <input type="number" name="reorderLevel" value="<?php echo $product['reorderLevel']; ?>" required>
        <br><br>
        <label for="active">Active:</label>
        <input type="checkbox" name="active" <?php echo $product['active'] ? 'checked' : ''; ?>>
        <br><br>
        <input type="submit" value="Update Product">
    </form>
</body>
</html>