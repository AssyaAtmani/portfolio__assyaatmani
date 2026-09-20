<?php
require_once 'config.php';

$username = "admin";
$password = "1234";

// مهم: hashing
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashedPassword]);

echo "✅ Admin created for testing";
?>