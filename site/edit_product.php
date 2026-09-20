<?php
session_start();
require_once 'config.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: log.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM produits WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $pdo->prepare("
        UPDATE produits
        SET nom=?, prix=?, categorie=?, image=?
        WHERE id=?
    ");

    $stmt->execute([
        $_POST['nom'],
        $_POST['prix'],
        $_POST['categorie'],
        $_POST['image'],
        $id
    ]);

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>

<style>
body{
    background-color: rgba(128,128,128,0.747);
    font-family:'Lucida Sans';
}

form{
    width:320px;
    margin:80px auto;
    background:white;
    padding:20px;
    border-radius:10px;
}

input{
    width:100%;
    padding:10px;
    margin:8px 0;
}

button{
    width:100%;
    padding:10px;
    background:green;
    color:white;
    border:none;
}
</style>
</head>

<body>

<form method="POST">
    <h2 style="text-align:center;color:#ca3a4f;">Edit Product</h2>

    <input name="nom" value="<?= $product['nom'] ?>">
    <input name="prix" value="<?= $product['prix'] ?>">
    <input name="categorie" value="<?= $product['categorie'] ?>">
    <input name="image" value="<?= $product['image'] ?>">

    <button>Update</button>
</form>

</body>
</html>