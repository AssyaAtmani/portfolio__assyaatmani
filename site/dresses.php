<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: log.php"); exit(); }
require_once 'connexion.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Elegant Dresses</title>
    <link rel="stylesheet" href="dresses.css?v=2">
</head>
<body>

<header>
    <img class="logo" src="dress-up-logo.png" alt="Logo">
    <fieldset class="search">
        <legend><b>Recherche</b></legend>
        <input type="text" id="live-search" placeholder="Rechercher une robe..." onkeyup="searchDresses()">
    </fieldset>
</header>

<main>
    <fieldset class="main-fieldset">
        <legend><h2><i>Long Dresses Section</i></h2></legend>
        <section class="products-grid" id="results-container">
            <?php
            $stmt = $pdo->query("SELECT * FROM produits WHERE categorie = 'long_dresses'");
            $dresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dresses as $dress): ?>
                <article class="box product-item" data-nom="<?php echo strtolower($dress['nom']); ?>">
                    <img src="<?php echo htmlspecialchars($dress['image']); ?>" alt="<?php echo htmlspecialchars($dress['nom']); ?>">
                    <p class="desc"><?php echo htmlspecialchars($dress['nom']); ?></p>
                    <p class="price-box"><b>Prix : <?php echo htmlspecialchars($dress['prix']); ?> DH</b></p>
                    <button class="button2 btn-ajouter-panier"
                            data-id="<?php echo htmlspecialchars($dress['id']); ?>"
                            data-nom="<?php echo htmlspecialchars($dress['nom']); ?>"
                            data-prix="<?php echo htmlspecialchars($dress['prix']); ?>"
                            data-image="<?php echo htmlspecialchars($dress['image']); ?>">
                        Ajouter au panier
                    </button>
                </article>
            <?php endforeach; ?>
        </section>
    </fieldset>
</main>

<script>
function searchDresses() {
    let filter = document.getElementById('live-search').value.toLowerCase();
    let items = document.getElementsByClassName('product-item');
    
    for (let i = 0; i < items.length; i++) {
        let name = items[i].getAttribute('data-nom');
        if (name.includes(filter)) {
            items[i].style.display = "";
        } else {
            items[i].style.display = "none";
        }
    }
}
</script>
<script src="panier.js"></script>
</body>
</html>