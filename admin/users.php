<?php include "admin_inc/header.php"; ?>
<?php
    


$query = "SELECT user_id, user_name, user_email, user_image FROM users"; //Assuming your users table has these columns
$result = $connection->query($query);

?>

<div class="container">
    <!-- Sidebar -->
    <?php include "admin_inc/nav.php"; ?>

    <!-- Users Section (wrapped with .main-content) -->
    <div id="users" class="main-content">
        <h2>Users</h2>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Picture</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any users in the database
                if ($result->num_rows > 0) {
                    // Loop through each user and display in table rows
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['user_name'] . "</td>";
                        echo "<td>" . $row['user_email'] . "</td>";
                        
                        // Display user picture if exists
                        if (!empty($row['user_image'])) {
                            echo "<td><img src='../img" . $row['user_image'] . "' alt='User Picture' style='width: 50px; height: 50px;'></td>";
                        } else {
                            echo "<td>No Picture</td>";
                        }

                        echo "</tr>";
                    }
                } else {
                    // If no users are found
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include "admin_inc/footer.php";
?>
