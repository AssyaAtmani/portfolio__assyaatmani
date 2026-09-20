<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: log.php");
    exit();
}

$products = $pdo->query("SELECT * FROM produits ORDER BY id DESC")
                ->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<style>
/* 🌟 نفس theme ديال site */
body{
    background-color: rgba(128, 128, 128, 0.747);
    margin:0;
    font-family: 'Lucida Sans', Geneva, Verdana, sans-serif;
}

/* HEADER STYLE */
.header{
    background-image: linear-gradient(to right, rgba(0,0,0,0.863), rgba(202,58,79,0.877));
    height:90px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 20px;
    color:white;
}

.header h2{
    margin:0;
}

.header a{
    color:white;
    text-decoration:none;
    font-weight:bold;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    top:90px;
    left:0;
    width:200px;
    height:100%;
    background:#222;
    padding:15px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:10px;
    margin:10px 0;
    border-radius:5px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#ca3a4f;
}

/* MAIN */
.main{
    margin-left:220px;
    padding:20px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
}

th{
    background:#ca3a4f;
    color:white;
    padding:10px;
}

td{
    text-align:center;
    padding:10px;
    border-bottom:1px solid #ddd;
}

img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:8px;
}

/* BUTTONS */
.btn{
    padding:5px 10px;
    border-radius:5px;
    color:white;
    text-decoration:none;
    font-size:14px;
}

.add{background:#000;}
.edit{background:green;}
.delete{background:red;}

.btn:hover{
    opacity:0.8;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>ADMIN PANEL</h2>
    <a href="logout.php">Logout</a>
</div>

<!-- SIDEBAR -->
<div class="sidebar">
    <a href="admin_dashboard.php">📊 Dashboard</a>
    <a href="add_product.php">➕ Add Product</a>
</div>

<!-- MAIN -->
<div class="main">

<h1 style="color:#ca3a4f;">Products Management</h1>

<a class="btn add" href="add_product.php">+ Add Product</a>
<br><br>

<table>
<tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Prix</th>
    <th>Categorie</th>
    <th>Image</th>
    <th>Actions</th>
</tr>

<?php foreach($products as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['nom'] ?></td>
    <td><?= $p['prix'] ?> DH</td>
    <td><?= $p['categorie'] ?></td>
    <td><img src="<?= $p['image'] ?>"></td>

    <td>
        <a class="btn edit" href="edit_product.php?id=<?= $p['id'] ?>">Edit</a>
        <a class="btn delete" href="delete_product.php?id=<?= $p['id'] ?>"
           onclick="return confirm('Delete this product?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

</div>

</body>
</html>