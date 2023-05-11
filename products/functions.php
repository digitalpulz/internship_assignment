<?php

// Database connection parameters
$host = 'localhost';
$dbName = 'dp_base_test';
$username = 'root';
$password = '';

try {
    // Make a new PDO instance to connect to the database.
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle any database connection errors
    die("Connection failed: " . $e->getMessage());
}

function getProducts()
{
    global $pdo;

    // Prepare and execute a SELECT query to fetch products
    $stmt = $pdo->prepare("SELECT * FROM b_product");
    $stmt->execute();

    // Fetch all product records as associative arrays
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $products;
}

function createProduct($productData)
{
    global $pdo;

    // INSERT method products
    $stmt = $pdo->prepare("INSERT INTO b_product (productCode, productName, dangerLevel, reorderLevel, active) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $productData['productCode'],
        $productData['productName'],
        $productData['dangerLevel'],
        $productData['reorderLevel'],
        $productData['active']
    ]);

    // Check if the INSERT operation was successful
    $result = $stmt->rowCount() > 0;

    return $result;
}

function getProduct($productId)
{
    global $pdo;

    // Prepare and execute a SELECT query to fetch a specific product by ID
    $stmt = $pdo->prepare("SELECT * FROM b_product WHERE id = ?");
    $stmt->execute([$productId]);

    // Fetch the product record as an associative array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    return $product;
}

function updateProduct($productId, $productData)
{
    global $pdo;

    // Prepare and execute an UPDATE query to update a product
    $stmt = $pdo->prepare("UPDATE b_product SET productCode = ?, productName = ?, dangerLevel = ?, reorderLevel = ?, active = ? WHERE id = ?");
    $stmt->execute([
        $productData['productCode'],
        $productData['productName'],
        $productData['dangerLevel'],
        $productData['reorderLevel'],
        $productData['active'],
        $productId
    ]);

    // Check if the UPDATE operation was successful
    $result = $stmt->rowCount() > 0;

    return $result;
}

function deleteProduct($productId)
{
    global $pdo;

    // Prepare and execute a DELETE query to delete a product
    $stmt = $pdo->prepare("DELETE FROM b_product WHERE id = ?");
    $stmt->execute([$productId]);

    // Check if the DELETE operation was successful
    $result = $stmt->rowCount() > 0;

    return $result;
}