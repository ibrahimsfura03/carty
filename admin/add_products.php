<?php include "admin_inc/header.php"; ?>

<?php
    if(isset($_POST['add_product'])){
        $product_name = $_POST['product_name'] ?? '';
        
        $product_image = '';
        $product_image_tmp = '';

        // $product_image = $_FILES['product_image']['name'];
        // $product_image_tmp = $_FILES['product_image']['tmp_name'];

        // move_uploaded_file($product_image_tmp, "../image/$product_image");

            // Handle file upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $product_image = $_FILES['product_image']['name'];
        $product_image_tmp = $_FILES['product_image']['tmp_name'];

        // Move the uploaded file
        move_uploaded_file($product_image_tmp, "../img/$product_image");
    } else {
        $product_image = ''; // Assign an empty string if no file uploaded
    }

        $product_description = $_POST['product_description'] ?? '';
        $product_price = $_POST['product_price'] ?? 0;

        $insert_sql = "INSERT INTO products (product_name, product_image, product_description, product_price) 
        VALUES ('$product_name', '$product_image', '$product_description', '$product_price')";

        $insert_result = $connection->query($insert_sql);

    }
?>

    <div class="container">
       
    <?php include "admin_inc/nav.php"; ?>

        <!-- Add Products Section (wrapped with .main-content) -->
        <div id="add-products" class="main-content">
            <h2>Add Product</h2>
            <form action="add_products.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="productName">Product Name</label>
                    <input type="text" name="product_name" placeholder="Product Name" required>
                </div>
                <div>
                    <label for="productImage">Product Picture</label>
                    <input type="file" name="product_image" placeholder="image" required>
                </div>
                <div>
                    <label for="productDescription">Product Description</label>
                    <input type="text" name="product_description" placeholder="Description..." required>
                </div>
                <div>
                    <label for="productPrice">Product Price</label>
                    <input type="number" name="product_price" placeholder="Price" value="100" min="100" max="5000" required>
                </div>
                <input type="submit" value="Add Product" name="add_product">
            </form>
        </div>
    </div>

    <?php include "admin_inc/footer.php"; ?>
