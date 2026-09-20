<?php
session_start();
require_once 'config.php';

try {
    $categories = [
        'professional_sets' => ['professional_sets', 'sets'],
        'professional_pants' => ['professional_pants', 'pants'],
        'professional_blazers' => ['professional_blazers', 'blazers'],
        'professional_coats' => ['professional_coats', 'coats']
    ];

    $data = [];
    foreach ($categories as $key => $cats) {
        $placeholders = implode(',', array_fill(0, count($cats), '?'));
        $stmt = $pdo->prepare("SELECT * FROM produits WHERE categorie IN ($placeholders)");
        $stmt->execute($cats);
        $data[$key] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="professional.css?v=2">
    <title>Professional-suits</title>
    <link rel="icon" href="dress-up-logo.png" type="image/png">
</head>
<body>

<header>
    <img class="logo" src="dress-up-logo.png" alt="Logo Dress-Up">
    <fieldset class="search">
        <legend><b>Recherche</b></legend>
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Rechercher..." 
                   value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            <button type="submit">🔍</button>
        </form>
    </fieldset>
</header>

<nav>
    <ul>
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="Panier.php">Panier</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
    </ul>
</nav>

<main>
    <?php 
    $sections = ['professional_sets' => 'Sets', 'professional_pants' => 'Pants', 'professional_blazers' => 'Blazers', 'professional_coats' => 'Coats'];
    foreach ($sections as $key => $title): 
    ?>
        <fieldset>
            <legend><h2><i><?php echo $title; ?> Section</i></h2></legend>
            <section class="products-grid">
                <?php if(!empty($data[$key])): ?>
                    <?php foreach($data[$key] as $product): ?>
                        <article class="box">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <p class="desc"><?php echo htmlspecialchars($product['nom']); ?></p>
                            <p class="price-box">
                                <b>Prix: <?php echo htmlspecialchars($product['prix']); ?> DH</b><br>
                                <?php if(!empty($product['ancien_prix'])): ?>
                                    <del><?php echo htmlspecialchars($product['ancien_prix']); ?> DH</del>
                                <?php endif; ?>
                            </p>
                            <button class="button2 btn-ajouter-panier" 
                                    data-id="<?php echo htmlspecialchars($product['id']); ?>"
                                    data-nom="<?php echo htmlspecialchars($product['nom']); ?>" 
                                    data-prix="<?php echo htmlspecialchars($product['prix']); ?>" 
                                    data-image="<?php echo htmlspecialchars($product['image']); ?>">
                                Ajouter au panier
                            </button>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center; width:100%;">Aucun produit trouvé dans cette catégorie.</p>
                <?php endif; ?>
            </section>
        </fieldset>
    <?php endforeach; ?>
</main> 

<footer>
    <p><b>@Dress-Up Site</b></p>
</footer>

<script src="panier.js"></script>
</body>
</html>