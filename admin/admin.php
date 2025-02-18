<?php include "admin_inc/header.php"; ?>

<div class="container">
    <!-- Sidebar -->
    <?php include "admin_inc/nav.php"; ?>

    <!-- Main Content -->
    <div class="main-content">

        <div class="dashboard-stats">
            <?php
                // Query to get the count of orders
                $orders_sql = "SELECT COUNT(*) AS total_orders FROM orders";
                $orders_result = $connection->query($orders_sql);
                if ($orders_result) {
                    $orders_count = $orders_result->fetch_assoc()['total_orders'];
                } else {
                    $orders_count = 0; // Set to 0 if query fails
                }

                // Query to get the count of users
                $users_sql = "SELECT COUNT(*) AS total_users FROM users";
                $users_result = $connection->query($users_sql);
                if ($users_result) {
                    $users_count = $users_result->fetch_assoc()['total_users'];
                } else {
                    $users_count = 0; // Set to 0 if query fails
                }

                // Query to get the count of products
                $products_sql = "SELECT COUNT(*) AS total_products FROM products";
                $products_result = $connection->query($products_sql);
                if ($products_result) {
                    $products_count = $products_result->fetch_assoc()['total_products'];
                } else {
                    $products_count = 0; // Set to 0 if query fails
                }

                // Query to get the count of admins
                $admins_sql = "SELECT COUNT(*) AS total_admins FROM admin";
                $admins_result = $connection->query($admins_sql);
                if ($admins_result) {
                    $admins_count = $admins_result->fetch_assoc()['total_admins'];
                } else {
                    $admins_count = 0; // Set to 0 if query fails
                }

                // Debugging output
                // echo "Orders: " . $orders_count . "<br>";
                // echo "Users: " . $users_count . "<br>";
                // echo "Products: " . $products_count . "<br>";
                // echo "Admins: " . $admins_count . "<br>";
            ?>

<div class="dashboard-stats">
    <div class="stat-box orders" style="background: #2196f3;">
        Orders
        <span><?php echo $orders_count ?: 0; ?></span>
    </div>
    <div class="stat-box users" style="background: #ff9800;">
        Users
        <span><?php echo $users_count ?: 0; ?></span>
    </div>
    <div class="stat-box products" style="background: #9c27b0;">
        Products
        <span><?php echo $products_count ?: 0; ?></span>
    </div>
    <div class="stat-box admins" style="background: #009688;">
        Admins
        <span><?php echo $admins_count ?: 0; ?></span>
    </div>
</div>



        </div>
    </div>
</div>

<?php include "admin_inc/footer.php"; ?>
