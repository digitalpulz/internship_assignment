<?php
include 'functions.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get product ID
    $productId = $_POST['id'];

    // Delete the product using the backend API
    deleteProduct($productId);

    // Redirect to the index page after successful deletion
    header('Location: index.php');
    exit();
}

// Fetch product details if the product ID is provided
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $product = getProduct($productId);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Product</title>
</head>
<body>
    <h1>Delete Product</h1>
    <h2>Are you sure you want to delete the following product?</h2>
    <p>Product Code: <?php echo $product['productCode']; ?></p>
    <p>Product Name: <?php echo $product['productName']; ?></p>
    <form method="POST" action="delete_product.php">
        <input type="hidden" name="id" value="<?php echo $productId; ?>">
        <input type="submit" value="Delete">
    </form>
    <a href="index.php">Cancel</a>
</body>
</html>