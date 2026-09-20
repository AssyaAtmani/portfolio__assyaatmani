<?php
require_once 'config.php';

$username = "admin";
$password = password_hash("1234", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo "Admin created successfully";
?>