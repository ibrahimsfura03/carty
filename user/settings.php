<?php include "user_inc/header.php"; ?>

<?php

$user_id = $_SESSION['user_id']; 

// Fetch user details
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = $connection->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle profile update
    $user_name = $connection->real_escape_string($_POST['user_name']);
    $user_password = $_POST['user_password'];

    
    if (!empty($_FILES['user_image']['name'])) {
        $file_name = $_FILES['user_image']['name'];
        $file_tmp = $_FILES['user_image']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        // $allowed_exts = ['jpg', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG'];

        if ($file_ext) {
            $new_file_name = $user_id . "_profile." . $file_ext;
            move_uploaded_file($file_tmp, "../img/" . $new_file_name);

            
            $update_sql = "UPDATE users SET user_image = '$new_file_name', user_name = '$user_name' WHERE user_id = '$user_id'";

            // Update password only if provided
            if (!empty($user_password)) {
                $update_sql = "UPDATE users SET user_image = '$new_file_name', user_name = '$user_name', user_password = '$user_password' WHERE user_id = '$user_id'";
            }
        } else {
            echo "<p>Invalid file type. Only JPG, JPEG, and PNG files are allowed.</p>";
        }
    } else {
        // Update without changing profile picture
        $update_sql = "UPDATE users SET user_name = '$user_name' WHERE user_id = '$user_id'";
         // Execute the update query
    if ($connection->query($update_sql) === TRUE) {
        $successMsg = "<h3 style='color: green; text-align: center;'>Updated Successful!</h3>";
      } else {
          echo "<div>Error: " . $connection->error . "</div>";
      }

        // Update password only if provided
        if (!empty($user_password)) {
            $update_sql = "UPDATE users SET user_name = '$user_name', user_password = '$user_password' WHERE user_id = '$user_id'";
        }
    }

    // Execute the update query
    if (isset($update_sql)) {
        $connection->query($update_sql);
    }
}
?>

<div class="container">
    <!-- Sidebar -->
    <?php include "user_inc/nav.php"; ?>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Profile Settings</h2>
        <form action="#" method="post" enctype="multipart/form-data">
        <?php
        if (isset($successMsg)) {
            echo $successMsg; // Display success message
        }
    ?>
            <label for="profile-picture">Profile Picture</label>
            <input type="file" id="profile-picture" name="user_image" accept="image/*" />

            <label for="name">Name</label>
            <input type="text" id="name" name="user_name" placeholder="Enter your name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required />

            <label for="password">Password</label>
    <input type="password" id="password" name="user_password" placeholder="Enter a new password (leave blank to keep current)" />

            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

</body>
</html>
