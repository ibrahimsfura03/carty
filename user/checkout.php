<?php
include "user_inc/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the user
$select_sql = "SELECT * FROM carts WHERE user_id = '$user_id'";
$result = $connection->query($select_sql);

// Calculate total price
$total_price_query = "SELECT SUM(p.product_price * c.quantity) AS total_price
                      FROM carts c
                      JOIN products p ON c.product_id = p.product_id
                      WHERE c.user_id = '$user_id'";
$total_price_result = $connection->query($total_price_query);
$total_price_row = $total_price_result->fetch_assoc();
$total_price = $total_price_row['total_price'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the required fields are set before proceeding
    if (isset($_POST['address'], $_POST['phone'], $_POST['payment_method'])) {
        // Collect POST data
        $shipping_address = $_POST['address'];  // User's shipping address
        $phone = $_POST['phone'];  // User's phone number
        $payment_method = $_POST['payment_method'];  // User's payment method
    
        // Insert order into the orders table
        $insert_order_sql = "INSERT INTO orders (user_id, total_price, shipping_address, phone, payment_method, order_date)
                             VALUES ('$user_id', '$total_price', '$shipping_address', '$phone', '$payment_method', NOW())";
    
        if ($connection->query($insert_order_sql) === TRUE) {
            $order_id = $connection->insert_id;  // Get the last inserted order ID
            
            // Now, clear the user's cart (optional, can be done later)
            $delete_cart_sql = "DELETE FROM carts WHERE user_id = '$user_id'";
            $connection->query($delete_cart_sql);
            
            $order_message = "Order placed successfully!";
        } else {
            $order_message = "Error placing order: " . $connection->error;
        }
    }
}
?>

<head>
    <style>
 /* Centering the .container */
.container {
  display: flex;
  flex-direction: column; /* Stack elements vertically */
  justify-content: center; /* Center vertically */
  align-items: center; /* Center horizontally */
  min-height: 100vh; /* Full viewport height */
  padding: 20px;
  background-color: #f8f8f8; /* Optional background for visual distinction */
}

/* Fix for checkout-summary */
.checkout-summary {
  width: 100%; /* Ensure it takes full width of its container */
  max-width: 500px; /* Set max width for the content */
  margin-bottom: 30px; /* Space between checkout-summary and form */
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Style for the unique form */
.unique-form {
  width: 100%;
  max-width: 400px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  box-sizing: border-box;
}

/* Style for the headings */
.unique-form h4 {
  margin-bottom: 15px;
  color: #4caf50;
  font-size: 20px;
  border-bottom: 2px solid #4caf50;
  padding-bottom: 5px;
}

/* Style for the labels */
.unique-form label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

/* Style for inputs, textarea, and select */
.unique-form input,
.unique-form textarea,
.unique-form select {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

/* Style for the button */
.unique-form .checkout-btn {
  width: 100%;
  padding: 10px 15px;
  background-color: #4caf50;
  color: white;
  font-size: 16px;
  font-weight: bold;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.unique-form .checkout-btn:hover {
  background-color: #45a049;
}


    </style>
</head>
<div class="container">
    <div class="checkout-summary">
        <div class="total-price">
            <span>Total Price:</span>
            <span>$<?php echo number_format($total_price, 2); ?></span>
        </div>
    </div>

    <!-- Shipping address form -->
    <form method="POST" action="" class="unique-form">
        <div class="shipping-details">
            <h4>Shipping Details</h4>
            <label for="address">Address:</label>
            <textarea name="address" id="address" required></textarea>
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" required>
        </div>

        <div class="payment-method">
            <h4>Payment Method</h4>
            <select name="payment_method" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>

        <div class="action-buttons">
            <button type="submit" class="checkout-btn">Confirm and Pay</button>
        </div>
    </form>

    <!-- Order placed message (display when order is placed) -->
    <?php if (isset($order_message)): ?>
        <div id="order-message" class="order-message">
            <h3><?php echo $order_message; ?></h3>
            <p>You can <a href="orders.php">view your orders</a> here.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
