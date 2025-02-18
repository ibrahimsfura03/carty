<?php include "includes/header.php"; ?>

<?php
    if (!isset($_SESSION['user_email'])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Cart Page</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .cart-wrapper {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .cart-heading h2 {
            color: #4CAF50;
            margin: 0;
        }

        .cart-product {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .cart-product img {
            width: 150px;
            height: 150px;
            border-radius: 8px;
            object-fit: cover;
        }

        .cart-product-info {
            flex: 1;
        }

        .cart-product-info h3 {
            margin: 0;
            color: #333;
        }

        .cart-product-info p {
            margin: 5px 0;
            color: #555;
        }

        .cart-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .cart-buttons input[type="number"] {
            width: 60px;
            padding: 5px;
            font-size: 16px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .cart-buttons button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-update-cart {
            background: #4CAF50;
            color: white;
        }

        .btn-update-cart:hover {
            background: #45a049;
        }

        .btn-remove-item {
            background: #f44336;
            color: white;
        }

        .btn-remove-item:hover {
            background: #e53935;
        }

        .cart-footer {
            text-align: center;
        }

        .cart-footer a {
            text-decoration: none;
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
        }

        .cart-footer a:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<?php

if (isset($_POST['add_product'])) {
    $product_id = $_POST['product_id'];
    $the_user_id = $_SESSION['user_id'];
    $quantity = $_POST['quantity'];

    $insert_sql = "INSERT INTO `carts` (user_id, product_id, quantity) VALUES ('$the_user_id', '$product_id', '$quantity')";
    $insert_sql_result = $connection->query($insert_sql);

    if($insert_sql_result){
        $successMsg = "<h3>Successfully added!</h3>";
    }
}
?>

    <div class="cart-wrapper">
        <div class="cart-heading">
            <h2>Ready to checkout? Add to carts.</h2>
        </div>

        <?php
            if(isset($successMsg)){
                echo $successMsg;
            }
        ?>
        <div class="cart-product">

        <?php
            if(isset($_GET['add_product'])){
                $product_id = $_GET['add_product'];

                $select_sql = "SELECT * FROM products WHERE product_id = $product_id";
                $select_sql_result = $connection->query($select_sql);

                while($row = $select_sql_result->fetch_assoc()){
                    $product_id = $row['product_id'];
                    $product_name = $row['product_name'];
                    $product_image = $row['product_image'];
                    $product_description = $row['product_description'];
                    $product_price = $row['product_price'];

                    echo "
                    <img src='img/$product_image' alt='$product_name'>
            <div class='cart-product-info'>
                <h3>$product_name</h3>
                <p>$$product_price</p>
                <p>Description: $product_description</p>
            </div>
            <div class='cart-buttons'>
                  <form action='' method='POST'>
                        <input type='hidden' name='product_id' value='$product_id'>
                        <label for='quantity'>Quantity:</label>
                        <input type='number' id='quantity' name='quantity' value='1' min='1'><br>
                        <input type='submit' value='Add to Cart' name='add_product'>
                    </form>
            </div>
                    ";
                }
            }
        ?>

            
        </div>

        <div class="cart-footer">
            <a href="index.php">Continue Shopping</a>
        </div>
    </div>
</body>
</html>
