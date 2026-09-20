<?php
session_start();
require_once 'config.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: log.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM produits WHERE id=?");
$stmt->execute([$id]);

header("Location: admin_dashboard.php");
exit();
?>