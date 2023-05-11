<?php

include 'functions.php';

// Fetch the list of products from the backend API
$products = getProducts();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Product List</h1>
    <table>
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Danger Level</th>
                <th>Reorder Level</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo $product['productCode']; ?></td>
                    <td><?php echo $product['productName']; ?></td>
                    <td><?php echo $product['dangerLevel']; ?></td>
                    <td><?php echo $product['reorderLevel']; ?></td>
                    <td><?php echo $product['active'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                        <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="add_product.php">Add New Product</a>
</body>
</html>