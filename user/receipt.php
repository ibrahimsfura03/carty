<?php include "user_inc/header.php"; ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    header("Location: orders.php");
    exit();
}

$user_id = $_SESSION['user_id']; 
$order_id = $_GET['order_id'];
$order_id = $connection->real_escape_string($order_id);

// Fetch order details
$order_sql = "SELECT * FROM orders WHERE order_id = '$order_id' AND user_id = '$user_id'";
$order_result = $connection->query($order_sql);
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "<p>Order not found.</p>";
    exit();
}

// Fetch ordered items
$items_sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
$items_result = $connection->query($items_sql);
?>

<style>
    .receipt-container {
        width: 50%;
        margin: auto;
        padding: 20px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        font-family: Arial, sans-serif;
    }
    .receipt-header {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .receipt-details {
        text-align: left;
        margin-bottom: 20px;
    }
    .receipt-table {
        width: 100%;
        border-collapse: collapse;
    }
    .receipt-table th, .receipt-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    .print-btn {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }
    .print-btn:hover {
        background-color: #0056b3;
    }
</style>

<div class="receipt-container" id="receipt">
    <div class="receipt-header">Order Receipt</div>
    <div class="receipt-details">
        <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
        <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
        <p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
        <p><strong>Status:</strong> Success!</p>
    </div>


    <button class="print-btn" onclick="printReceipt()">Print Receipt</button>
    <a href="orders.php" class="back-btn">Back to Orders</a>
</div>

<script>
    function printReceipt() {
        var printContents = document.getElementById("receipt").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

</body>
</html>
