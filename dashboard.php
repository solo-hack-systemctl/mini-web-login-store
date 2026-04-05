<?php
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

require "config.php";

if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"])) {
	header("Location: /mini_web_login/index.php");
	exit;
}

$sql = "SELECT * FROM products";
$result = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>

	<style>
		body {
			font-family: Arial;
		}

		.products-container {
			display: flex;
			flex-wrap: wrap;
			gap: 22px;
		}

		.product-card {
			border: 2px solid black;
			padding: 12px;
			width: 215px;
			border-radius: 8px;
		}
	</style>

</head>
<body>
<h1><strong>Products</strong> Dashboard</h1>
<p>Welcome, <?php echo htmlspecialchars($_SESSION["username"]) ?>!</p><br><br>


<div class="products-container">

<?php
while ($row = $result->fetch_assoc()) {
?>

        <div class="product-card">
                <p><strong><?php echo htmlspecialchars($row["product_name"]); ?></strong></p>
                <p>Price: $<?php echo number_format($row["price"], 2); ?></p>

                <form method="POST" action="checkout.php">
                        <input type="hidden" name="product_id" value="<?php echo $row["product_id"]; ?>">

                        <label>Quantity</label>
                        <input type="number" name="quantity" min="1" value="1">

                        <button type="submit">Buy</button>
                </form>
        </div>
<?php
}
?>
</div><br><br>
<form method="GET" action="order_history.php">
	<button type="submit">Order History</button>
</form><br>
<form method="GET" action="logout.php">
	<button type="submit">Logout</button>
</form>
</body>
</html>



