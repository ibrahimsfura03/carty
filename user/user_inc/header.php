<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "../includes/db.php"; ?>

<?php
if (!isset($_SESSION['user_email'])) {
    header("Location: ../login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Section</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
            if(isset($_SESSION['user_id'])){
                $user_id = $_SESSION['user_id'];
                $user_name = $_SESSION['user_name'];

                $sql = "SELECT * FROM users WHERE user_id = $user_id";
                $sql_result = $connection->query($sql);

                while($row = $sql_result->fetch_assoc()){
                 $user_image = $row['user_image'];
                
?>
    <header>
        <div class="top-left">
            <?php
                echo "<a href='../user/user.php'><img src='../img/$user_image' width='50' height='50' alt=''></a>";
            }
            ?>
        </div>
      <?php
        echo "<h1>Welocome to dashboard $user_name</h1>";
            }
        ?>
        
        <div class="top-right">
            <a href="../logout.php">
                <button>Log out</button>
            </a>
        </div>
    </header>