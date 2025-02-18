<?php include "admin_inc/header.php"; ?>

<div class="container">
    <!-- Sidebar -->
    <?php include "admin_inc/nav.php"; ?>

    <!-- Products Section (wrapped with .main-content) -->
    <div id="products" class="main-content">
        <div class="other-section-header">
            <h2 class="other-section-title">Products</h2>
            <a href="add_products.php" class="other-btn-action">Add Products</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Action</th> <!-- Delete column -->
                </tr>
            </thead>
            <tbody>

            <?php
                // Fetch all products from the database
                $select_sql = "SELECT * FROM products";
                $select_sql_reseult = $connection->query($select_sql);

                while($row = $select_sql_reseult->fetch_assoc()){
                    $product_id = $row['product_id'];
                    $product_name = $row['product_name'];
                    $product_image = $row['product_image'];
                    $product_price = $row['product_price'];

                    echo "<tr>
                        <td>$product_id</td>
                        <td>$product_name</td>
                        <td> <img src='../img/$product_image' width='50'> </td>
                        <td>$$product_price</td>
                        <td><a href='?delete=$product_id' class='delete-btn'>Delete</a></td> <!-- Delete link -->
                    </tr>";
                }
            ?>

            </tbody>
        </table>
    </div>
</div>

<?php
    // Check if the delete request is made
    if (isset($_GET['delete'])) {
        $delete_product_id = $_GET['delete'];
        
        // Prepare the delete query
        $delete_sql = "DELETE FROM products WHERE product_id = '$delete_product_id'";

        if ($connection->query($delete_sql) === TRUE) {
            echo "<h3>Deleted Successfully</h3>";

            header("Location: products.php");
        } 
    }

?>

<?php include "admin_inc/footer.php"; ?>
