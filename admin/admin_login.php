<?php session_start(); ?>
<?php include '../includes/db.php'; ?>

<?php

if (isset($_POST['login'])) {
    $admin_email = mysqli_real_escape_string($connection, $_POST['admin_email']);
    $admin_password = mysqli_real_escape_string($connection, $_POST['admin_password']);


    // Check if admin credentials are correct
    $select_sql = "SELECT * FROM `admin` WHERE admin_email = '{$admin_email}' AND admin_password = '{$admin_password}'";
    $select_sql_result = $connection->query($select_sql);

    if ($select_sql_result->num_rows > 0) {
        // Admin found
        $row = $select_sql_result->fetch_assoc();
        $admin_id = $row['admin_id'];
        $admin_email = $row['admin_email'];

        // Check credentials and set session variables
        if ($admin_email === $admin_email && $row['admin_password'] === $admin_password) {
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_email'] = $admin_email;

            $successMsg = "<h3 style='color: green;'>Login Successful!</h3>";

            // Redirect to the admin dashboard after login
            header("Location: admin.php");
            exit; // Make sure no further code is executed after redirection
        }
    } else {
        $errorMsg = "<h3 style='color: red;'>Invalid Login Details!</h3>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Add your styling here */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            padding: 20px;
        }

        .login-form-box {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-form-box .form-title {
            text-align: center;
            margin-bottom: 20px;
            color: #4caf50;
        }

        .login-form-box form {
            display: flex;
            flex-direction: column;
        }

        .form-input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-submit {
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        .form-submit:hover {
            background-color: #45a049 !important;
        }

        .form-switch {
            text-align: center;
            margin-top: 10px;
        }

        .signup-link {
            color: #4caf50;
            text-decoration: none;
        }

        .signup-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 10px;
            }

            .login-form-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form-box" id="login-form">
            <h2 class="form-title">Admin Login</h2>
            <form action="" method="post">
                <?php
                    if (isset($successMsg)) {
                        echo $successMsg; // Display success message
                    }
                    if (isset($errorMsg)) {
                        echo $errorMsg; // Display error message
                    }
                ?>
                <input type="email" class="form-input email-input" name="admin_email" placeholder="Email" required>
                <input type="password" class="form-input password-input" name="admin_password" placeholder="Password" required>
                <input type="submit" class="btn-submit form-submit" name="login" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
