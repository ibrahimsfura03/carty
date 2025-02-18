<?php include "admin_inc/header.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
    $admin_name = mysqli_real_escape_string($connection, $_POST['admin_name']);
    $admin_email = mysqli_real_escape_string($connection, $_POST['admin_email']);
    $admin_password = mysqli_real_escape_string($connection, $_POST['admin_password']);
    
    $insert_sql = "INSERT INTO admin (admin_name, admin_email, admin_password) 
                   VALUES ('$admin_name', '$admin_email', '$admin_password')";


    if ($connection->query($insert_sql) === TRUE) {
        $successMsg = "<h3>Successfully Added!</h3>";
    } else {
        echo "<div>Error: " . $connection->error . "</div>";
    }
}
?>

    <div class="container">
        <!-- Sidebar -->
        <?php include "admin_inc/nav.php"; ?>
       

        <!-- Add Products Section (wrapped with .main-content) -->
                <div id="add-products" class="main-content">
                    <h2>Add Admin</h2>
                    <form action="add_admin.php" method="POST" enctype="multipart/form-data">
            <?php
                if(isset($successMsg)){
                    echo $successMsg;
                }
            ?>
            <div>
                <label for="adminName">Admin Name</label>
                <input type="text" id="adminName" name="admin_name" placeholder="Admin Name" required>
            </div>
            <div>
                <label for="adminEmail">Admin Email</label>
                <input type="email" id="adminEmail" name="admin_email" placeholder="Admin Email" required>
            </div>
            <div>
                <label for="adminPassword">Admin Password</label>
                <input type="password" id="adminPassword" name="admin_password" placeholder="Admin Password" required>
            </div>
            <input type="submit" value="Add Admin" name="add_admin">
        </form>

        </div>
    </div>

    <?php include "admin_inc/footer.php"; ?>