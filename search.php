<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "includes/db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carty - Search Results</title>
    <link rel="stylesheet" href="includes/style.css">
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
    <header>
        <h1> <a href="index.php" class="brand">Carty</a> </h1>
        <nav>
            <ul>
                <li><a href="#contact">Contact Us</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#shop">Shop</a></li>
            </ul>
        </nav>
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="search" placeholder="Search for products..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="auth-buttons">
            <?php
                if(isset($_SESSION['user_id'])){
                    $the_user_id = $_SESSION['user_id'];

                    $select_sql = "SELECT * FROM `users` WHERE user_id = $the_user_id";
                    $select_sql_result = $connection->query($select_sql);

                    while($row = $select_sql_result->fetch_assoc()){
                        $user_id = $row['user_id'];
                        $user_name = $row['user_name'];
                        $user_image = $row['user_image'];

                        $_SESSION['user_name'] = $user_name;

                        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
                            echo "<a href='user/user.php'>$user_name</a>";
                        }else{
                            echo " <a href='login.php'>Login</a>
                            <a href='signup.php'>Sign Up</a>";
                        }
                    }
                }
            ?>
        </div>
    </header>

    <main>
        <div class="container">
            <?php
            // Check if search query is set
            if (isset($_GET['search'])) {
                // Sanitize the search term
                $search_term = mysqli_real_escape_string($connection, $_GET['search']);
                
                // Query to search for matching products
                $search_sql = "SELECT * FROM products WHERE product_name LIKE '%$search_term%'";
                $search_result = $connection->query($search_sql);

                // Check if any products are found
                if ($search_result->num_rows > 0) {
                    while ($product = $search_result->fetch_assoc()) {
                        // Retrieve the image URL, name, description, and price
                        $product_image = $product['product_image']; // Assuming the image column is named 'product_image'
                        $product_name = $product['product_name'];
                        $product_description = $product['product_description'];
                        $product_price = $product['product_price'];

                        echo "<div class='product'>";
                        // Display the product image with a fallback in case there is no image
                        echo "<img src='img/" . $product_image . "' alt='" . $product_name . "' class='product-image' width='400'>";
                        echo "<h2>" . $product_name . "</h2>";
                        echo "<p>" . $product_description . "</p>";
                        echo "<p>Price: $" . $product_price . "</p>";
                        echo "</div>";
                    }
                } else {
                    // No products found
                    echo "<p>No products found for '<strong>" . $search_term . "</strong>'</p>";
                }
            } else {
                echo "<p>Please enter a search term to begin.</p>";
            }
            ?>
        </div>
    </main>

</body>
</html>
