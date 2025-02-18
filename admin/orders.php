<?php include "admin_inc/header.php"; ?>

<div class="container">
    <!-- Sidebar -->
    <?php include "admin_inc/nav.php"; ?>

    <div id="orders" class="main-content"> <!-- Main content wrapped in .main-content -->
        <h2>Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>

            <?php
                // Fetch orders from the database
                $select_sql = "SELECT * FROM orders";
                $select_sql_result = $connection->query($select_sql);

                // Loop through each order
                while ($row = $select_sql_result->fetch_assoc()) {
                    $order_id = $row['order_id'];
                    $user_id = $row['user_id'];  // Get the user_id for this order
                    $shipping_address = $row['shipping_address']; // Address is in the orders table
                    $total_price = $row['total_price'];

                    // Fetch user details for this order
                    $user_sql = "SELECT user_name FROM users WHERE user_id = '$user_id'";
                    $user_result = $connection->query($user_sql);

                    if (!$user_result) {
                        die("Error fetching user details: " . $connection->error);
                    }

                    $user_row = $user_result->fetch_assoc();
                    $customer_name = $user_row['user_name'];

                    echo "<tr>
                        <td>$order_id</td>
                        <td>$customer_name</td>
                        <td>$shipping_address</td>
                        <td>$$total_price</td>
                    </tr>";
                }
            ?>

            </tbody>
        </table>
    </div>
</div>

<?php include "admin_inc/footer.php"; ?>
