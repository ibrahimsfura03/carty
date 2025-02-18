<?php 
include "admin_inc/header.php"; 

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // If no admin is logged in, redirect to the login page
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch current admin information
$select_sql = "SELECT * FROM admin WHERE admin_id = '$admin_id'";
$result = $connection->query($select_sql);

if ($result->num_rows > 0) {
    $admin_data = $result->fetch_assoc();
} else {
    echo "<div>Error: Admin not found!</div>";
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $admin_name = mysqli_real_escape_string($connection, $_POST['name']);
    $admin_password = mysqli_real_escape_string($connection, $_POST['password']);
    
    
    if (isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === 0) {
        $profile_picture = $_FILES['profile-picture'];
        $upload_dir = '../img/';
        $profile_picture_name = $profile_picture['name'];
        $profile_picture_tmp_name = $profile_picture['tmp_name'];
        $profile_picture_path = $upload_dir . $profile_picture_name;

        // Check if the file is an image
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($profile_picture['type'], $allowed_types)) {
            move_uploaded_file($profile_picture_tmp_name, $profile_picture_path);
        } else {
            echo "<div>Invalid file type. Only JPG, PNG, and GIF are allowed.</div>";
            $profile_picture_path = ''; // Set to empty string if the file type is invalid
        }
    } else {
        // If no profile picture is uploaded, keep the current one
        $profile_picture_path = isset($_FILES['profile-picture']) ? '' : $admin_data['admin_image'];
    }

    // Prepare the SQL query for updating the admin's profile
    $update_sql = "UPDATE admin SET admin_name='$admin_name'";

   // Only update the password if it's provided (not empty)
if (!empty($admin_password)) {
    $update_sql .= ", admin_password='$admin_password'";
}


    // Only update profile picture if a new one is provided
    if ($profile_picture_path) {
        $update_sql .= ", admin_image='$profile_picture_path'";
    }

    // Complete the update SQL query
    $update_sql .= " WHERE admin_id = '$admin_id'";

    // Execute the update query
    if ($connection->query($update_sql) === TRUE) {
      $successMsg = "<h3 style='color: green; text-align: center;'>Updated Successful!</h3>";
    } else {
        echo "<div>Error: " . $connection->error . "</div>";
    }
}
?>

<div class="container">
    <!-- Sidebar -->
    <?php include "admin_inc/nav.php"; ?>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Profile Settings</h2>
        <form action="" method="post" enctype="multipart/form-data">
    <?php
        if (isset($successMsg)) {
            echo $successMsg; // Display success message
        }
    ?>

    <label for="profile-picture">Profile Picture</label>
    <input type="file" id="profile-picture" name="profile-picture" accept="image/*" />

    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($admin_data['admin_name']); ?>" placeholder="Enter your name" />

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter a new password (leave blank to keep current)" />

    <button type="submit" name="save_changes">Save Changes</button>
</form>
    </div>
</div>

<?php include "admin_inc/footer.php"; ?>
