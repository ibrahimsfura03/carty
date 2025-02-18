<?php include "user_inc/header.php"; ?>

<div class="container">
    <!-- Sidebar -->
    <?php include "user_inc/nav.php"; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-stats">
            <div class="stat-box orders" style="background: #2196f3;">
                <?php
                if (isset($_SESSION['user_id'])) {
                    $the_user_id = $_SESSION['user_id'];

                    // Query to get the number of orders for the logged-in user
                    $orders_sql = "SELECT COUNT(*) AS total_orders FROM orders WHERE user_id = $the_user_id";
                    $orders_result = $connection->query($orders_sql);
                    $orders_count = $orders_result->fetch_assoc()['total_orders'] ?? 0;

                    echo "<span>$orders_count</span>";
                } else {
                    echo "<span>No Orders :(</span>";
                }
                ?>
                Orders
            </div>

            <div class="stat-box carts" style="background: #ff9800;">
                <?php
                if (isset($_SESSION['user_id'])) {
                    // Query to get the number of items in the cart for the logged-in user
                    $cart_sql = "SELECT COUNT(*) AS total_cart_items FROM carts WHERE user_id = $the_user_id";
                    $cart_result = $connection->query($cart_sql);
                    $cart_count = $cart_result->fetch_assoc()['total_cart_items'] ?? 0;

                    echo "<span>$cart_count</span>";
                } else {
                    echo "<span>0</span>";
                }
                ?>
                Carts
            </div>

            <div class="stat-box settings" style="background: #009688; cursor: pointer;" onclick="location.href='settings.php';">
                Settings
                <p>Update Your Profile</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
