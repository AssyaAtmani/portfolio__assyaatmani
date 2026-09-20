<?php
require_once 'config.php';

try {
    $search = $_GET['search'] ?? '';

    if (!empty($search)) {
        // Small Bags
        $stmt_small = $pdo->prepare("SELECT * FROM produits WHERE categorie = 'small_bags' AND nom LIKE ?");
        $stmt_small->execute(["%$search%"]);
        $small_bags = $stmt_small->fetchAll(PDO::FETCH_ASSOC);

        // Big Bags
        $stmt_big = $pdo->prepare("SELECT * FROM produits WHERE categorie = 'big_bags' AND nom LIKE ?");
        $stmt_big->execute(["%$search%"]);
        $big_bags = $stmt_big->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Small Bags
        $stmt_small = $pdo->query("SELECT * FROM produits WHERE categorie = 'small_bags'");
        $small_bags = $stmt_small->fetchAll(PDO::FETCH_ASSOC);

        // Big Bags
        $stmt_big = $pdo->query("SELECT * FROM produits WHERE categorie = 'big_bags'");
        $big_bags = $stmt_big->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Bags - Dress-Up</title>
    <link rel="stylesheet" href="bags.css?v=2">
    <link rel="icon" href="dress-up-logo.png" type="image/png">
</head>
<body>

<header>
    <img class="logo" src="dress-up-logo.png" alt="Logo Dress-Up">
    <fieldset class="search">
        <legend><b>Recherche</b></legend>
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Rechercher un sac..."
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
    <fieldset class="main-fieldset">
        <legend><h2><i>Small Bags Section</i></h2></legend>
        <section class="products-grid">
            <?php if (!empty($small_bags)): ?>
                <?php foreach ($small_bags as $bag): ?>
                    <article class="box">
                        <img class="bags-img" src="<?php echo htmlspecialchars($bag['image']); ?>" alt="<?php echo htmlspecialchars($bag['nom']); ?>">
                        <p class="desc"><?php echo htmlspecialchars($bag['nom']); ?></p>
                        <p class="price-box">
                            <b>Prix: <?php echo htmlspecialchars($bag['prix']); ?> DH</b><br>
                            <?php if (!empty($bag['ancien_prix'])): ?>
                                <del><?php echo htmlspecialchars($bag['ancien_prix']); ?> DH</del>
                            <?php endif; ?>
                        </p>
                        <button class="button2 btn-ajouter-panier"
                                data-id="<?php echo htmlspecialchars($bag['id']); ?>"
                                data-nom="<?php echo htmlspecialchars($bag['nom']); ?>"
                                data-prix="<?php echo htmlspecialchars($bag['prix']); ?>"
                                data-image="<?php echo htmlspecialchars($bag['image']); ?>">
                            Ajouter au panier
                        </button>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; width:100%; color:white;">Aucun produit trouvé dans Small Bags.</p>
            <?php endif; ?>
        </section>
    </fieldset>

    <fieldset class="main-fieldset">
        <legend><h2><i>Big Bags Section</i></h2></legend>
        <section class="products-grid">
            <?php if (!empty($big_bags)): ?>
                <?php foreach ($big_bags as $bag): ?>
                    <article class="box">
                        <img class="bags-img" src="<?php echo htmlspecialchars($bag['image']); ?>" alt="<?php echo htmlspecialchars($bag['nom']); ?>">
                        <p class="desc"><?php echo htmlspecialchars($bag['nom']); ?></p>
                        <p class="price-box">
                            <b>Prix: <?php echo htmlspecialchars($bag['prix']); ?> DH</b><br>
                            <?php if (!empty($bag['ancien_prix'])): ?>
                                <del><?php echo htmlspecialchars($bag['ancien_prix']); ?> DH</del>
                            <?php endif; ?>
                        </p>
                        <button class="button2 btn-ajouter-panier"
                                data-id="<?php echo htmlspecialchars($bag['id']); ?>"
                                data-nom="<?php echo htmlspecialchars($bag['nom']); ?>"
                                data-prix="<?php echo htmlspecialchars($bag['prix']); ?>"
                                data-image="<?php echo htmlspecialchars($bag['image']); ?>">
                            Ajouter au panier
                        </button>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; width:100%; color:white;">Aucun produit trouvé dans Big Bags.</p>
            <?php endif; ?>
        </section>
    </fieldset>
</main>

<footer>
    <p><b>@Dress-Up Site</b></p>
</footer>

<script src="panier.js"></script>
</body>
</html>