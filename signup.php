<?php include "includes/header.php"; ?>

<?php
if (isset($_POST['signup'])) {
    $user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);
    $user_confirm_password = mysqli_real_escape_string($connection, $_POST['user_confirm_password']);

    // Check if all inputs are provided and passwords match
    if ($user_name && $user_email && $user_password && $user_confirm_password != ' ' && $user_confirm_password == $user_password) {
        // Check if email already exists
        $check_email_sql = "SELECT * FROM users WHERE user_email = '$user_email'";
        $check_email_result = $connection->query($check_email_sql);

        if ($check_email_result->num_rows > 0) {
            $errorMsg = "<h3 style='color: red;'>Email already exists! Please use a different email.</h3>";
        } else {
            // Insert new user without hashing the password
            $insert_sql = "INSERT INTO users(user_name, user_email, user_password) VALUES ('$user_name', '$user_email', '$user_password')";
            if ($connection->query($insert_sql)) {
                $successMsg = "<h3 style='color: green;'>Account created successfully!</h3>";
            } else {
                $errorMsg = "<h3 style='color: red;'>Error: " . $connection->error . "</h3>";
            }
        }
    } else {
        $errorMsg = "<h3 style='color: red;'>Invalid Inputs or passwords do not match!</h3>";
    }
}
?>

<div class="container">
    <div class="form-box" id="signup-form">
        <h2>Sign-Up to continue</h2>
        <form action="signup.php" method="post">

            <?php
            if (isset($successMsg)) {
                echo $successMsg;
            }
            if (isset($errorMsg)) {
                echo $errorMsg;
            }
            ?>

            <input type="text" name="user_name" placeholder="Full Name" required>
            <input type="email" name="user_email" placeholder="Email" required>
            <input type="password" name="user_password" placeholder="Password" required>
            <input type="password" name="user_confirm_password" placeholder="Confirm Password" required>
            <input type="submit" class="btn-submit" name="signup" value="Sign Up">
        </form>
        <div class="switch">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </div>
</div>
</body>
</html>
