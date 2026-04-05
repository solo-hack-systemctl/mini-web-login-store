<?php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"])) {
	header("Location: /mini_web_login/index.php");
	exit;
}

$sql = "SELECT orders.order_id, products.product_id, orders.user_id, orders.quantity, orders.subtotal, orders.tax, orders.total, orders.created_at FROM orders JOIN products ON orders.product_id = products.product_id WHERE orders.user_id = ? ORDER BY orders.order_id DESC";
$stmt = $mysqli->prepare($sql);

$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Order History</title>
<head>
<body>
<h1>Your Order History</h1>
<form method="GET" action="dashboard.php">
	<button type="submit">Back to Products</button>
</form>

<?php while ($row = $result->fetch_assoc()) { ?>
	<div style="border:1px solid black; padding:10px; margin-bottom:10px; width:330px;">
		<p><strong>Order #<?php echo $row["order_id"]; ?></strong></p>
		<p>Product: <?php echo htmlspecialchars($row["product_name"]); ?></p>
		<p>Quantity: <?php echo $row["quantity"]; ?></p>
        	<p>Subtotal: $<?php echo number_format($row["subtotal"], 2); ?></p>
        	<p>Tax: $<?php echo number_format($row["tax"], 2); ?></p>
        	<p>Total: $<?php echo number_format($row["total"], 2); ?></p>
        	<p>Date: <?php echo $row["created_at"]; ?></p>
    	</div>
<?php } ?>

</body>
</html>

