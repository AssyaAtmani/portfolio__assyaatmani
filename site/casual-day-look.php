<?php
session_start();

// 🌟 Protection session
if (!isset($_SESSION['user_id'])) {
    header("Location: log.php");
    exit();
}

require_once 'config.php';

try {
    $search = $_GET['search'] ?? '';

    if (!empty($search)) {
        // Pants
        $stmt_pants = $pdo->prepare("SELECT * FROM produits WHERE (categorie = 'casual_pants' OR categorie = 'pants_casual') AND nom LIKE ?");
        $stmt_pants->execute(["%$search%"]);
        $casual_pants = $stmt_pants->fetchAll(PDO::FETCH_ASSOC);

        // Hoodies
        $stmt_hoodies = $pdo->prepare("SELECT * FROM produits WHERE (categorie = 'casual_hoodies' OR categorie = 'hoodies') AND nom LIKE ?");
        $stmt_hoodies->execute(["%$search%"]);
        $casual_hoodies = $stmt_hoodies->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Pants
        $stmt_pants = $pdo->query("SELECT * FROM produits WHERE categorie = 'casual_pants' OR categorie = 'pants_casual'");
        $casual_pants = $stmt_pants->fetchAll(PDO::FETCH_ASSOC);

        // Hoodies
        $stmt_hoodies = $pdo->query("SELECT * FROM produits WHERE categorie = 'casual_hoodies' OR categorie = 'hoodies'");
        $casual_hoodies = $stmt_hoodies->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Casual Day Look - Dress-Up</title>
    <link rel="stylesheet" href="casual-day-look.css?v=2">
    <link rel="icon" href="dress-up-logo.png" type="image/png">
</head>
<body>

<header>
    <img class="logo" src="dress-up-logo.png" alt="Logo Dress-Up">
    <fieldset class="search">
        <legend><b>Recherche</b></legend>
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Rechercher un produit..."
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
        <li><a href="logout.php" style="color:#ca3a4f;font-weight:bold;">Déconnexion</a></li>
    </ul>
</nav>

<main>
    <fieldset class="main-fieldset">
        <legend><h2><i>Pants Section</i></h2></legend>
        <section class="products-grid">
            <?php if (empty($casual_pants)): ?>
                <p style="text-align:center;color:white;width:100%;padding:20px;">Aucun pantalon disponible.</p>
            <?php else: ?>
                <?php foreach ($casual_pants as $product): ?>
                    <article class="box">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                        <p class="desc"><?php echo htmlspecialchars($product['nom']); ?></p>
                        <p class="price-box">
                            <b>Prix: <?php echo htmlspecialchars($product['prix']); ?> DH</b><br>
                            <?php if (!empty($product['ancien_prix'])): ?>
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
            <?php endif; ?>
        </section>
    </fieldset>

    <fieldset class="main-fieldset">
        <legend><h2><i>Hoodies Section</i></h2></legend>
        <section class="products-grid">
            <?php if (empty($casual_hoodies)): ?>
                <p style="text-align:center;color:white;width:100%;padding:20px;">Aucun hoodie disponible.</p>
            <?php else: ?>
                <?php foreach ($casual_hoodies as $product): ?>
                    <article class="box">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                        <p class="desc"><?php echo htmlspecialchars($product['nom']); ?></p>
                        <p class="price-box">
                            <b>Prix: <?php echo htmlspecialchars($product['prix']); ?> DH</b><br>
                            <?php if (!empty($product['ancien_prix'])): ?>
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