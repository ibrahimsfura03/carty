<?php include "user_inc/header.php"; ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 

// Fetch orders from the database
$select_sql = "SELECT * FROM orders WHERE user_id = '$user_id'";
$result = $connection->query($select_sql);
?>

<div class="container">
    <!-- Sidebar -->
    <?php include "user_inc/nav.php"; ?>

    <div class="main-content">
        <div class="orders-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $order_id = $row['order_id'];
                    $order_date = $row['order_date'];
                    $total_price = $row['total_price'];

                    echo "
                    <div class='order-item'>
                        <h4 class='order-item-title'>Order ID: $order_id</h4>
                        <p class='order-item-date'>Order Date: $order_date</p>
                        <p class='order-item-price'>Total Price: $" . number_format($total_price, 2) . "</p>
                        <p class='order-item-status'>Status: Success!</p>
                        <a href='receipt.php?order_id=$order_id' class='receipt-btn'>View Receipt</a>
                        <a href='orders.php?delete=$order_id' class='delete-btn' style='text-decoration: none;'>Delete Order</a>
                    </div>
                    ";
                }
            } else {
                echo "<p>No orders found.</p>";
            }
            ?>
        </div>

        <?php
        if (isset($_GET['delete'])) {
            $order_delete_id = $_GET['delete'];
            $order_delete_id = $connection->real_escape_string($order_delete_id);
            
            $delete_sql = "DELETE FROM orders WHERE order_id = '$order_delete_id' AND user_id = '$user_id'";
            
            if ($connection->query($delete_sql)) {
                header("Location: orders.php");
            } else {
                echo "Error deleting order: " . $connection->error;
            }
        }
        ?>

        <div class="orders-footer">
            <!-- Optional footer for navigation or summary -->
        </div>
    </div>
</div>

</body>
</html>
