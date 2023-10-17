<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productCode = $_POST['productCode'];
    $productName = $_POST['productName'];
    $dangerLevel = (int)$_POST['dangerLevel'];
    $reorderLevel = (int)$_POST['reorderLevel'];
    $active = isset($_POST['active']) ? 1 : 0;

    $sql = "INSERT INTO b_product (productCode, productName, dangerLevel, reorderLevel, active) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiis", $productCode, $productName, $dangerLevel, $reorderLevel, $active);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
