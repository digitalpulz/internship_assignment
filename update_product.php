<style>

    /* Apply some basic styles to the form and table */
form {
    margin: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ddd;
}

/* Highlight rows when hovering over them */
tr:hover {
    background-color: #f5f5f5;
}

/* Style for the "Add Product" form */
form input[type="text"],
form input[type="number"],
form label {
    margin: 5px;
}

form input[type="submit"] {
    margin-top: 10px;
    padding: 5px 10px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    cursor: pointer;
}

/* Style for the table headers */
th {
    background-color: #007BFF;
    color: #fff;
    text-align: left;
    padding: 8px;
}

/* Style for the "Update Product" form */
form[name="update_product"] input[type="text"],
form[name="update_product"] input[type="number"],
form[name="update_product"] label {
    margin: 5px;
}

form[name="update_product"] input[type="submit"] {
    margin-top: 10px;
    padding: 5px 10px;
    background-color: #28A745;
    color: #fff;
    border: none;
    cursor: pointer;
}


    </style>



<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_product'])) {
        $productId = $_POST['id'];
        $productCode = $_POST['productCode'];
        $productName = $_POST['productName'];
        $dangerLevel = (int)$_POST['dangerLevel'];
        $reorderLevel = (int)$_POST['reorderLevel'];
        $active = isset($_POST['active']) ? 1 : 0;

        $sql = "UPDATE b_product SET productCode=?, productName=?, dangerLevel=?, reorderLevel=?, active=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiisi", $productCode, $productName, $dangerLevel, $reorderLevel, $active, $productId);

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "SELECT * FROM b_product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            // Display the update form with pre-filled data
            echo "<h2>Update Product</h2>";
            echo "<form action='update_product.php' method='post'>";
            echo "<input type='hidden' name='id' value='" . $product['id'] . "'>";
            echo "<input type='text' name='productCode' placeholder='Product Code' value='" . $product['productCode'] . "' required>";
            echo "<input type='text' name='productName' placeholder='Product Name' value='" . $product['productName'] . "' required>";
            echo "<input type='number' name='dangerLevel' placeholder='Danger Level' value='" . $product['dangerLevel'] . "' required>";
            echo "<input type='number' name='reorderLevel' placeholder='Reorder Level' value='" . $product['reorderLevel'] . "' required>";
            echo "<label for='active'>Active:</label>";
            echo "<input type='checkbox' name='active' " . ($product['active'] ? 'checked' : '') . ">";
            echo "<input type='submit' name='update_product' value='Update Product'>";
            echo "</form>";
        } else {
            echo "Product not found.";
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
