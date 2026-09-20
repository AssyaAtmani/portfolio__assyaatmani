<?php
session_start();
require_once 'config.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: log.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $pdo->prepare("
        INSERT INTO produits (nom, prix, categorie, image)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['nom'],
        $_POST['prix'],
        $_POST['categorie'],
        $_POST['image']
    ]);

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>

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
    box-shadow:0 0 10px rgba(0,0,0,0.2);
}

input{
    width:100%;
    padding:10px;
    margin:8px 0;
    border:1px solid #ccc;
}

button{
    width:100%;
    padding:10px;
    background:#ca3a4f;
    color:white;
    border:none;
}
</style>
</head>

<body>

<form method="POST">
    <h2 style="text-align:center;color:#ca3a4f;">Add Product</h2>

    <input name="nom" placeholder="Nom">
    <input name="prix" placeholder="Prix">
    <input name="categorie" placeholder="Categorie">
    <input name="image" placeholder="Image URL">

    <button>Add</button>
</form>

</body>
</html>