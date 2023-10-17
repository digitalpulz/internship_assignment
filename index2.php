<?php
require('config.php');
require('db.sql');

// Ensure that your database and tables are set up before you proceed.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productCode = $_POST['productCode'];
    $productName = $_POST['productName'];
    $dangerLevel = (int)$_POST['dangerLevel'];
    $reorderLevel = (int)$_POST['reorderLevel'];
    $active = isset($_POST['active']) ? 1 : 0;
    $user = 1; // Replace with the actual user ID

    $sql = "INSERT INTO b_product (productCode, productName, dangerLevel, reorderLevel, active) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiii", $productCode, $productName, $dangerLevel, $reorderLevel, $active);

    if ($stmt->execute()) {
        // Product added successfully
        header("Location: index.php");
        exit();
    } else {
        // Handle the error
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Product Management</h1>
    <div class="product-form">
        <h2>Add New Product</h2>
        <form action="index.php" method="post">
            <input type="text" name="productCode" placeholder="Product Code" required>
            <input type="text" name="productName" placeholder="Product Name" required>
            <input type="number" name="dangerLevel" placeholder="Danger Level" required>
            <input type="number" name="reorderLevel" placeholder="Reorder Level" required>
            <label for="active">Active:</label>
            <input type="checkbox" name="active">
            <input type="submit" value="Add Product">
        </form>
    </div>
    
    <h2>Products</h2>
    <table class="product-table">
        <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Danger Level</th>
            <th>Reorder Level</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        <?php
        $sql = "SELECT * FROM b_product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['productCode'] . "</td>";
                echo "<td>" . $row['productName'] . "</td>";
                echo "<td>" . $row['dangerLevel'] . "</td>";
                echo "<td>" . $row['reorderLevel'] . "</td>";
                echo "<td>" . ($row['active'] ? 'Yes' : 'No') . "</td>";
                echo "<td><a href='update_product.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_product.php?id=" . $row['id'] . "'>Delete</a></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>
</html>
