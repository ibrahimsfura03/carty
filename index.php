<?php include "includes/header.php"; ?>

<head>
    <style>
          .hero {
  text-align: center;
  padding: 50px 20px;
  background: url("images/pexels-n-voitkevich-6214383.jpg") center/cover
    no-repeat;
  color: white;
}
    </style>
</head>

    <div class="hero">
        <h2>Welcome to Carty!</h2>
        <p>Your one-stop shop for amazing products and unbeatable deals.</p>
        <button>Start Shopping</button>
    </div>

    <main>
        <section class="product-showcase">
            <h2>Featured Products</h2>
            <div class="product-row">
           <?php
               $select_sql = "SELECT * FROM products";
               $select_result = $connection->query($select_sql);
               
               while($row = $select_result->fetch_assoc()){
                    $product_id = $row['product_id'];
                    $product_name = $row['product_name'];
                    $product_image = $row['product_image'];
                    $product_description = $row['product_description'];
                    $product_price = $row['product_price'];

                    echo "  <div class='product-card'>
                    <img src='img/$product_image' alt='$product_name'>
                    <h2>$product_name</h2>
                    <p>$$product_price</p>
                    <p>$product_description</p>
                   <button> <a href='product.php?add_product={$product_id}' >Purchase</a> </button>
                </div>";
               }
           ?>
          
            </div>
        </section>

        <section class="services">
            <h2>Our Services</h2>
            <div class="service-list">
                <div class="service-item">
                    <img src="images/pexels-ron-lach-9594420.jpg" alt="Service 1">
                    <p>Free Shipping</p>
                </div>
                <div class="service-item">
                    <img src="images/pexels-pixabay-280250.jpg" alt="Service 2">
                    <p>24/7 Support</p>
                </div>
                <div class="service-item">
                    <img src="images/pexels-sam-lion-5709235.jpg" alt="Service 3">
                    <p>Quality Assurance</p>
                </div>
            </div>
        </section>

<?php include "includes/footer.php"; ?>