
<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
</head>
<body>
    <h1>Product Management</h1>
    <h2>Add New Product</h2>
    <link rel="stylesheet" type="text/css" href="style.css">
    <form action="create_product.php" method="post">
        <input type="text" name="productCode" placeholder="Product Code" required>
        <input type="text" name="productName" placeholder="Product Name" required>
        <input type="number" name="dangerLevel" placeholder="Danger Level" required>
        <input type="number" name="reorderLevel" placeholder="Reorder Level" required>
        <label for="active">Active:</label>
        <input type="checkbox" name="active">
        <input type="submit" value="Add Product">
    </form>

    <!-- List of Products with Update and Delete links -->
    <h2>Products</h2>
    <table>
        <!-- Table headers -->
        <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Danger Level</th>
            <th>Reorder Level</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        <!-- PHP code to display product list -->
        <?php
        require 'config.php';
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
        $conn->close();
        ?>
    </table>


    <script>
    // Add an event listener to the table rows for highlighting
    var tableRows = document.querySelectorAll('table tr');
    for (var i = 1; i < tableRows.length; i++) {
        tableRows[i].addEventListener('mouseover', function () {
            this.classList.add('highlight');
        });
        tableRows[i].addEventListener('mouseout', function () {
            this.classList.remove('highlight');
        });
    }
</script>

</body>
</html>
