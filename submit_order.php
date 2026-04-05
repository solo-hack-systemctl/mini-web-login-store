<?php

session_start();
require "config.php";

if (!isset($_SESSION["user_id"])) {
	header("Location: index.php");
	exit;
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!isset($_POST["product_id"]) || !isset($_POST["quantity"])) {
	die("Missing product_id or qunatity.");
}

$product_id = (int) $_POST["product_id"];
$quantity = (int) $_POST["quantity"];

if ($quantity < 1) {
	die("Invalid quantity.");
}

$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $mysqli->prepare($sql);

$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
	die("products not found.");
}

$row = $result->fetch_assoc();

$product_name = $row["product_name"];
$price = $row["price"];
$subtotal = $price * $quantity;
$tax = $subtotal * 0.08;
$total = $subtotal + $tax;

$sql2 = "INSERT INTO orders (user_id, product_id, quantity, subtotal, tax, total) VALUES (?,?,?,?,?,?)";
$stmt2 = $mysqli->prepare($sql2);

$stmt2->bind_param("iiiddd", $_SESSION["user_id"], $product_id, $quantity, $subtotal, $tax, $total);
$stmt2->execute();

$order_id = $mysqli->insert_id;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Order Confirmed</title>
</head>
<body>

<h1>Order Placed Successfully!</h1>
<p><strong>Your order # is: </strong><?php echo $order_id; ?></p>

<div style="border: 5px solid black; padding: 15px; margin-bottom:17px; width:200px;">
	<p><strong>Product: </strong><?php echo $product_name; ?></p>
	<p><strong>Price: $</strong><?php echo number_format($price, 2); ?></p>
	<p><strong>Quantity: </strong><?php echo $quantity; ?></p>
	<p><strong>Subtotal: $</strong><?php echo number_format($subtotal, 2); ?></p>
	<p><strong>Tax: $</strong><?php echo number_format($tax, 2); ?></p>
	<p><strong>Total: $</strong><?php echo number_format($total, 2); ?></p>
</div>
<p><a href="dashboard.php">Products</a></p>
<form method="GET" action="logout.php">
	<button type="submit">Logout</button>
</form>

</body>
</html>

