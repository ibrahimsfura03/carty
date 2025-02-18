<?php include "user_inc/header.php"; ?>

<?php

$user_id = $_SESSION['user_id']; 

$select_sql = "SELECT * FROM carts WHERE user_id = '$user_id'";
$result = $connection->query($select_sql);


?>

<div class="container">
    <!-- Sidebar -->
    <?php include "user_inc/nav.php"; ?>


    <div class="main-content">

        <div class="cart-list">
            <?php
  
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cart_id = $row['cart_id'];
                    $product_id = $row['product_id'];
                    $quantity = $row['quantity'];

                    
                    $select_product_sql = "SELECT * FROM products WHERE product_id = '$product_id'";
                    $product_result = $connection->query($select_product_sql);
                    $product = $product_result->fetch_assoc();

                    if ($product) {
                        $product_name = $product['product_name'];
                        $product_image = $product['product_image'];
                        $product_description = $product['product_description'];
                        $product_price = $product['product_price'];

                        
                        $total_item_price = $product_price * $quantity;

                        
                        echo "
                        <div class='cart-item'>
                            <img src='../img/$product_image' alt='$product_name' class='cart-item-img'>
                            <div class='cart-item-details'>
                                <h4 class='cart-item-name'>$product_name</h4>
                                <p class='cart-item-description'>$product_description</p>
                                <span class='cart-item-price'>$" . number_format($product_price, 2) . "</span>
                                <span class='cart-item-quantity'>Quantity: $quantity</span>
                                <span class='cart-item-total-price'>Total: $" . number_format($total_item_price, 2) . "</span>
                            </div>
                            <a href='carts.php?delete={$cart_id}' class='delete-btn' style='text-decoration: none;'>Delete</a>
                        </div>
                        ";
                    }
                }
            } else {
                echo "<p>Your cart is empty.</p>";
            }
            ?>
        </div>

        <?php
               if (isset($_GET['delete'])) {
                $cart_delete_id = $_GET['delete'];
                $user_id = $_SESSION['user_id']; 
                $cart_id = $connection->real_escape_string($cart_delete_id);
                $delete_sql = "DELETE FROM carts WHERE cart_id = '$cart_delete_id' AND user_id = '$user_id'";
                $connection->query($delete_sql);
                
                header("Location: carts.php");
            }
            ?>


        <div class="cart-footer">
            <?php
            
            $total_price_query = "SELECT SUM(p.product_price * c.quantity) AS total_price
                                  FROM carts c
                                  JOIN products p ON c.product_id = p.product_id
                                  WHERE c.user_id = '$user_id'";
            $total_price_result = $connection->query($total_price_query);
            $total_price_row = $total_price_result->fetch_assoc();
            $total_price = $total_price_row['total_price'];
            ?>
            <div class="total-price">
                <span>Total Price:</span>
                <span>$<?php echo number_format($total_price, 2); ?></span>
            </div>
            <div class="action-buttons">
            <form action="checkout.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button type="submit" class="checkout-btn">Proceed to Checkout</button>
            </form>
            <form action="../index.php">
            <a href="" class="continue-shopping-btn" style="text-decoration: none;">
                    <button class="continue-shopping-btn">Continue Shopping</button>
                </a>
            </form>
        </div>
        </div>
    </div>
</div>

</body>
</html>
