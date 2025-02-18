<?php 
include "../includes/db.php"; 
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // If no admin is logged in, redirect to the login page
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch the current admin's data
$select_sql = "SELECT * FROM admin WHERE admin_id = '$admin_id'";
$result = $connection->query($select_sql);

if ($result->num_rows > 0) {
    $admin_data = $result->fetch_assoc();
    $admin_name = $admin_data['admin_name'];
    $admin_image = $admin_data['admin_image'] ? $admin_data['admin_image'] : '../images/default-profile.jpg'; // Default image if no profile picture is set
} else {
    echo "<div>Error: Admin not found!</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Section</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="top-left">
            <img src="<?php echo htmlspecialchars($admin_image); ?>" width="50" height="50" alt="Profile Picture">
        </div>
        <h1>Welcome to the dashboard, <?php echo htmlspecialchars($admin_name); ?></h1>
        <div class="top-right">
            <a href="admin_inc/logout.php">
                <button>Log out</button>
            </a>
        </div>
    </header>