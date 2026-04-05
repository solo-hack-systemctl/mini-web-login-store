<?php
session_start();

$_SESSION = [];
session_destroy();

header("Location: /mini_web_login/index.php");
exit;
?>
