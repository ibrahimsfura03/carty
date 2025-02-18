<?php include "includes/header.php"; ?>

<?php
if (isset($_POST['login'])) {
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);

    
    $select_sql = "SELECT * FROM `users` WHERE user_email = '{$user_email}' AND user_password = '{$user_password}'";
    $select_sql_result = $connection->query($select_sql);

    
    if ($select_sql_result->num_rows > 0) {
        
        $row = $select_sql_result->fetch_assoc();
        $dbid = $row['user_id'];
        $dbemail = $row['user_email'];
        $dbpassword = $row['user_password'];

        if ($dbemail === $user_email && $dbpassword === $user_password) {
            $_SESSION['user_id'] = $dbid;
            $_SESSION['user_email'] = $dbemail;
            $_SESSION['user_password'] = $dbpassword;

            $successMsg = "<h3 style='color: green;'>Success!</h3>";
            
            header("Location: index.php");
            exit;
        }
    } else {
        // Invalid credentials
        $errorMsg = "<h3 style='color: red;'>Invalid Logins!</h3>";
    }
}
?>

    <div class="container">
    <div class="form-box" id="login-form">
            <h2>Login</h2>
            <form action="" method="post">
                
            <?php
                if(isset($successMsg)){
                    echo $successMsg;
                }
                if(isset($errorMsg)){
                    echo $errorMsg;
                }
            ?>
                <input type="email" name="user_email" placeholder="Email" required>
                <input type="password" name="user_password" placeholder="Password" required>
                <input type="submit" class="btn-submit" name="login" value="Login">
            </form>
            <div class="switch">
                Don't have an account? <a href="signup.php">Sign Up</a>
            </div>
        </div>
    </div>
</body>
</html>
