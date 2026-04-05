<?php
session_start();

require "config.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = trim($_POST["username"]);
	$email = trim($_POST["email"]);
	$password = $_POST["password"];

	if (empty($username) || empty($email) || empty($password)) {
		die("All fields are required.");
	} else {
		
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
		$stmt = $mysqli->prepare($sql);

		$stmt->bind_param("sss", $username, $email, $hashed_password);
		
		if ($stmt->execute()) {
			echo "<h1>Registered Successfully!</h1>";
		} else {
			echo "<p>Registration Failed.</p>";
		}
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>

<body>
<h1>Register Form</h1>

<form method="POST" action="">
	<label>username</label>
	<input type="text" name="username"><br><br>

	<label>email</label>
	<input type="email" name="email"><br><br>

	<label>password</label>
	<input type="password" name="password"><br><br>

	<button type="submit">Register</button>
</form><br>

<form method="GET" action="index.php">
	<button type="submit">Login</button>
</form>

</body>
</html>

