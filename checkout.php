<?php
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

require "config.php";

if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"])) {
	header("Location: /mini_web_login/index.php");
	exit;
}

if (!isset($_POST["product_id"]) || !isset($_POST["quantity"])) {
	die("Missing product_id or quantity.");
}

$product_id = (int) $_POST["product_id"];
$quantity = (int) $_POST["quantity"];
if ($quantity < 1) {
	die("quantity has to be atleast 1.");
}

$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $mysqli->prepare($sql);

$stmt->bind_param("i", $product_id);

$stmt->execute();



$result = $stmt->get_result();

if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();

	$product_name = $row["product_name"];
	$price = $row["price"];
	$subtotal = $price * $quantity;
	$tax = $subtotal * 0.08;
	$total = $tax + $subtotal;
} else {
	die("product not found.");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
</head>
<body>
<h1>Order summary</h1>
<p><strong>Product: </strong><?php echo htmlspecialchars($product_name); ?></p>
<p><strong>Price: $</strong><?php echo number_format($price, 2); ?></p>
<p><strong>Quantity: </strong><?php echo htmlspecialchars($quantity); ?></p>
<p><strong>Subtotal: $</strong><?php echo number_format($subtotal, 2); ?></p>
<p><strong>Tax: $</strong><?php echo number_format($tax, 2); ?></p>
<p><strong>Total: $</strong><?php echo number_format($total, 2); ?></p>

<form method="POST" action="submit_order.php">
	<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
	<input type="hidden" name="quantity" value="<?php echo $quantity; ?>">

	<button type="submit">confirm order</button>
</form><br>
<form method="GET" action="dashboard.php">
	<button type="submit">products</button>
</form>
</body>
</html>


