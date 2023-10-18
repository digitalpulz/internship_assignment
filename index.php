<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">




    <title>MiniPulz</title>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">MiniPulz</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        
    </nav>
    <!--------------------------------------------------------------------------------------------------->

    <div class="container">
        <form method="POST" action="index.php" id="edit-form">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="hidden" name="product_id" id="edit_product_id" value="<?php echo $product['id']; ?>">
                    <label for="inputProductCode">Product Code</label>
                    <input type="text" class="form-control" id="inputProductCode" name="inputProductCode" placeholder="Ex:- Pxxx">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputProductName">Product Name</label>
                    <input type="text" class="form-control" id="inputProductName" name="inputProductName" placeholder="Name of the product">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputReorderLevel">Reorder Level</label>
                    <input type="text" class="form-control" id="inputReorderLevel" name="inputReorderLevel" placeholder="0">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputDangerLevel">Danger Level</label>
                    <input type="text" class="form-control" id="inputDangerLevel" name="inputDangerLevel" placeholder="0">
                </div>

            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="activeCheck" name="activeCheck">
                    <label class="form-check-label" for="activeCheck">
                        Active Status
                    </label>
                </div>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <button type="submit" class="btn btn-primary" value="add" id="add-button" action="http://localhost/Frontend_base-main/index.php">Add</button>

            <input type="hidden" name="action" id="action" value="add">
            <button type="submit" class="btn btn-primary" value="edit" id="update-button" style="display: none;" name="action">Update</button>
        </form>
    </div>


    <?php

    $backendUrl = "http://localhost:8092/BASE_API/rest/Product";


    $ch = curl_init($backendUrl);


    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic aGlzOmhpczEyMzQ1',
        'X-tenantID: D0001'
    ));


    $response = curl_exec($ch);


    curl_close($ch);


    $data = json_decode($response, true);


    echo '<div class="container">';


    if (is_array($data)) {
        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Product Code</th>';
        echo '<th scope="col">Product Name</th>';
        echo '<th scope="col">Reorder Level</th>';
        echo '<th scope="col">Danger Level</th>';
        echo '<th scope="col">Active Status</th>';
        echo '<th scope="col">Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($data as $product) {
            echo '<tr>';
            echo '<td>' . $product['productCode'] . '</td>';
            echo '<td>' . $product['productName'] . '</td>';
            echo '<td>' . $product['reorderLevel'] . '</td>';
            echo '<td>' . $product['dangerLevel'] . '</td>';
            echo '<td>' . ($product['active'] ? 'Active' : 'Inactive') . '</td>';
            // echo '<td><a class="btn btn-primary edit-button" href="update.php?product_id=' . $product['id'] . '">Edit</a></td>';
            echo '<td><button type="button" class="btn btn-primary edit-button" data-product-id="' . $product['id'] . '">Edit</button>';
            echo '<td><button type="button" class="btn btn-danger delete-button" data-product-id="' . $product['id'] . '">Delete</button>';

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No data available.';
    }
    echo '</div>';

    ?>


    <!-- ----------------------------------------------------------------------------------------------- -->


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        document.querySelector('button[value="add"]').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('action').value = 'add';
            submitForm();
        });
        document.querySelector('button[value="edit"]').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('action').value = 'edit';
            submitForm();
        });

        function refreshPage() {
            location.reload();
        }

        function submitForm() {
            var action = document.getElementById('action').value;
            var username = 'his';
            var password = 'his12345';
            var base64Credential = btoa(username + ':' + password);
            // Retrieve form input values
            var productCode = document.getElementById('inputProductCode').value;
            var productName = document.getElementById('inputProductName').value;
            var reorderLevel = document.getElementById('inputReorderLevel').value;
            var dangerLevel = document.getElementById('inputDangerLevel').value;
            var active = document.getElementById('activeCheck').checked;
            var user = 1;

            // Prepare the data as an object
            var postData = {
                product: {
                    productCode: productCode,
                    productName: productName,
                    reorderLevel: reorderLevel,
                    dangerLevel: dangerLevel,
                    active: active,
                    user: user
                }
            };

            // Determine whether to send a POST or PUT request
            var url;
            var method;

            if (action === 'add') {
                // Handle the "Add" operation
                url = 'http://localhost:8092/BASE_API/rest/Product';
                method = 'POST';
            } else if (action === 'edit') {
                // Handle the "Update" operation
                var productId = document.getElementById('edit_product_id').value;
                url = `http://localhost:8092/BASE_API/rest/Product/${productId}`;
                method = 'PUT';
            }

            // Send the request
            fetch(url, {
                    method: method,
                    headers: {
                        'Authorization': 'Basic ' + base64Credential,
                        'X-tenantID': 'D0001',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(postData)
                })
                .then(response => response.json())
                .then(data => {

                    if (action === 'add') {
                        alert('Product added successfully.');
                        refreshPage();
                        console.log('Product added successfully:', data);
                        
                    } else if (action === 'edit') {
                        refreshPage();
                        console.log('Product updated successfully:', data);
                        alert('Product updated successfully.');
                    }


                })
                .catch(error => {
                    // Handle errors
                    if (action === 'add') {
                        console.error('Error adding product:', error);
                    } else if (action === 'edit') {
                        console.error('Error updating product:', error);
                    }
                });
        }

        var username = 'his';
        var password = 'his12345';
        var base64Credential = btoa(username + ':' + password);

        document.addEventListener('DOMContentLoaded', function() {

            const editButtons = document.querySelectorAll('.edit-button');
            const addButton = document.getElementById('add-button');
            const updateButton = document.getElementById('update-button');

            editButtons.forEach((button) => {
                button.addEventListener('click', function() {
                    const productId = button.getAttribute('data-product-id');
                    console.log(productId);

                    updateButton.style.display = 'block';
                    addButton.style.display = 'none';


                    fetch(`http://localhost:8092/BASE_API/rest/Product/${productId}`, {
                            method: 'GET',
                            headers: {
                                'Authorization': 'Basic ' + base64Credential,
                                'X-tenantID': 'D0001'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);

                            document.getElementById('inputProductCode').value = data.productCode;
                            document.getElementById('inputProductName').value = data.productName;
                            document.getElementById('inputReorderLevel').value = data.reorderLevel;
                            document.getElementById('inputDangerLevel').value = data.dangerLevel;
                            document.getElementById('edit_product_id').value = productId;
                            document.getElementById('activeCheck').checked = data.active;
                        })
                        .catch(error => {
                            console.error('Error fetching product data:', error);
                        });
                });
            });


            document.getElementById('edit-form').addEventListener('submit', function(event) {
                event.preventDefault();


                const productId = document.getElementById('edit_product_id').value;
                const productCode = document.getElementById('inputProductCode').value;
                const productName = document.getElementById('inputProductName').value;
                const reorderLevel = document.getElementById('inputReorderLevel').value;
                const dangerLevel = document.getElementById('inputDangerLevel').value;


                const updatedData = {
                    product: {
                        productCode: productCode,
                        productName: productName,
                        reorderLevel: reorderLevel,
                        dangerLevel: dangerLevel,
                        user: 1,
                    }
                };


                fetch(`http://localhost:8092/BASE_API/rest/Product/${productId}`, {
                        method: 'PUT',
                        headers: {
                            'Authorization': 'Basic ' + base64Credential,
                            'X-tenantID': 'D0001'
                        },
                        body: JSON.stringify(updatedData),
                    })
                    .then(response => response.json())
                    .then(data => {

                        refreshPage();
                        console.log('Product updated successfully:', data);
                        alert('Product added/updated successfully.');


                    })
                    .catch(error => {
                        console.error('Error updating product:', error);
                    });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.delete-button').click(function() {
                let productId = $(this).data('product-id');


                if (confirm("Are you sure you want to delete this product?")) {

                    let username = 'his';
                    let password = 'his12345';
                    let base64Credentials = btoa(username + ':' + password);

                    // Headers
                    let headers = {
                        'Authorization': 'Basic ' + base64Credentials,
                        'X-tenantID': 'D0001'
                    };


                    let deleteUrl = 'http://localhost:8092/BASE_API/rest/Product/' + productId;

                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        headers: headers,
                        data: JSON.stringify({
                            "product": {
                                "user": 2
                            }
                        }),
                        contentType: 'application/json',
                        success: function(response) {

                            $(this).closest('tr').remove();
                            refreshPage();
                        },
                        error: function(xhr, status, error) {

                            console.error(error);
                        }
                    });
                }
            });
        });
    </script>




</body>

</html>