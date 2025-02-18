<?php include "admin_inc/header.php"; ?>

<div class="container">
    <!-- Sidebar -->
    <?php include "admin_inc/nav.php"; ?>

    <!-- Users Section (wrapped with .main-content) -->
    <div id="users" class="main-content">
        <div class="other-section-header">
            <h2 class="other-section-title">Admins</h2>
            <a href="add_admin.php" class="other-btn-action">Add Admins</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Admin ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch admins from the database
                $select_sql = "SELECT * FROM admin"; // Replace 'admin' with your actual table name if necessary
                $select_sql_result = $connection->query($select_sql);

                if ($select_sql_result->num_rows > 0) {
                    // Loop through all admins and display them
                    while ($row = $select_sql_result->fetch_assoc()) {
                        $admin_id = $row['admin_id']; // Assuming 'admin_id' is the primary key
                        $admin_name = $row['admin_name'];
                        $admin_email = $row['admin_email'];
                        
                        echo "<tr>
                            <td>$admin_id</td>
                            <td>$admin_name</td>
                            <td>$admin_email</td>
                            <td><a href='view_admins.php?id=$admin_id' class='delete-link'>Delete</a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No admins found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    if (isset($_GET['id'])) {
        $admin_id = $_GET['id'];
    
        // Prepare the delete SQL query
        $delete_sql = "DELETE FROM admin WHERE admin_id = '$admin_id'";
    
        // Execute the query
        if ($connection->query($delete_sql) === TRUE) {
            echo "Admin deleted successfully!";
            // Optionally redirect to the admin list page
            header("Location: view_admins.php"); // Make sure to change this to your actual admin list page URL
            exit();
        } else {
            echo "Error deleting admin: " . $connection->error;
        }
    } else {
        echo "Admin ID not specified!";
    }
?>

<?php include "admin_inc/footer.php"; ?>
