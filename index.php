<?php

session_start();

require "config.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!isset($_POST["email"]) || !isset($_POST["password"])) {
		die("Missing email or password.");
	}

	$email = trim($_POST["email"]);
	$password = $_POST["password"];

	if (empty($email) || empty($password)) {
		echo "<p>Email and Password are required.</p>";
	} else {
		$sql = "SELECT * FROM users WHERE email = ?";
		$stmt = $mysqli->prepare($sql);

		$stmt->bind_param("s", $email);
		$stmt->execute();

		$result = $stmt->get_result();
		if ($result->num_rows == 1) {
			
			$row = $result->fetch_assoc();
			if (password_verify($password, $row["password"])) {
				$_SESSION["user_id"] = $row["id"];
				$_SESSION["username"] = $row["username"];

				header("Location: /mini_web_login/dashboard.php");
				exit;
			} else {
				echo "<p>Invalid email or password.</p>";
			}
		} else {
			echo "<p>Invalid email or password.</p>";
		}
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
</head>

<body>

<h1>LOGIN</h1>

<form method="POST" action="">
	
	<label>Email</label>
	<input type="email" name="email"><br><br>

	<label>Password</label>
	<input type="password" name="password"><br><br>

	<button type="submit">Login</button>
</form><br>

<form method="GET" action="register.php">
	<button type="submit">Register</button>
</form>

</body>
</html>

