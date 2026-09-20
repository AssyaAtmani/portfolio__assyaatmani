<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=dress_up;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


function getProductsByCategory($pdo, $category) {
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE categorie = :categorie");
    $stmt->execute(['categorie' => $category]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$sets = getProductsByCategory($pdo, 'sets');
$pants = getProductsByCategory($pdo, 'pants');
$blazers = getProductsByCategory($pdo, 'blazers');
$coats = getProductsByCategory($pdo, 'coats');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dress-Up</title>
    <link rel="icon" href="images/logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <img class="logo" src="images/logo.png" alt="Logo Dress-Up">
        <form class="search" action="#" method="GET">
            <input type="search" name="query" placeholder="Rechercher un article...">
            <button type="submit" class="button2" style="padding: 5px 10px; margin: 0;">OK</button>
        </form>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="#sets">Sets</a></li>
            <li><a href="#pants">Pants</a></li>
            <li><a href="#blazers">Blazers</a></li>
            <li><a href="#coats">Coats</a></li>
            <li><a href="panier.php">Mon Panier (<span id="panier-count">0</span>)</a></li>
        </ul>
    </nav>

    <main>
        <!-- SECTION SETS -->
        <fieldset id="sets">
            <legend><h2><i>Ensembles & Sets</i></h2></legend>
            <section class="products-grid">
                <?php if (empty($sets)): ?>
                    <p>Aucun article disponible pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($sets as $product): ?>
                        <div class="box">
                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                            <p class="price">
                                <del><?php echo htmlspecialchars($product['ancien_prix']); ?> DH</del> 
                                <strong><?php echo htmlspecialchars($product['prix']); ?> DH</strong>
                            </p>
                            <!-- Data Attributes Dynamic l-Panier -->
                            <button class="button2 btn-ajouter-panier" 
                                    data-id="<?php echo $product['id']; ?>"
                                    data-nom="<?php echo htmlspecialchars($product['nom']); ?>"
                                    data-prix="<?php echo $product['prix']; ?>"
                                    data-image="<?php echo htmlspecialchars($product['image']); ?>">
                                Ajouter au panier
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </fieldset>

        <!-- SECTION PANTS -->
        <fieldset id="pants">
            <legend><h2><i>Pantalons</i></h2></legend>
            <section class="products-grid">
                <?php if (empty($pants)): ?>
                    <p>Aucun article disponible pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($pants as $product): ?>
                        <div class="box">
                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                            <p class="price">
                                <del><?php echo htmlspecialchars($product['ancien_prix']); ?> DH</del> 
                                <strong><?php echo htmlspecialchars($product['prix']); ?> DH</strong>
                            </p>
                            <button class="button2 btn-ajouter-panier" 
                                    data-id="<?php echo $product['id']; ?>"
                                    data-nom="<?php echo htmlspecialchars($product['nom']); ?>"
                                    data-prix="<?php echo $product['prix']; ?>"
                                    data-image="<?php echo htmlspecialchars($product['image']); ?>">
                                Ajouter au panier
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </fieldset>

        <!-- SECTION BLAZERS -->
        <fieldset id="blazers">
            <legend><h2><i>Blazers & Vestons</i></h2></legend>
            <section class="products-grid">
                <?php if (empty($blazers)): ?>
                    <p>Aucun article disponible pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($blazers as $product): ?>
                        <div class="box">
                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                            <p class="price">
                                <del><?php echo htmlspecialchars($product['ancien_prix']); ?> DH</del> 
                                <strong><?php echo htmlspecialchars($product['prix']); ?> DH</strong>
                            </p>
                            <button class="button2 btn-ajouter-panier" 
                                    data-id="<?php echo $product['id']; ?>"
                                    data-nom="<?php echo htmlspecialchars($product['nom']); ?>"
                                    data-prix="<?php echo $product['prix']; ?>"
                                    data-image="<?php echo htmlspecialchars($product['image']); ?>">
                                Ajouter au panier
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </fieldset>

        <!-- SECTION COATS -->
        <fieldset id="coats">
            <legend><h2><i>Manteaux</i></h2></legend>
            <section class="products-grid">
                <?php if (empty($coats)): ?>
                    <p>Aucun article disponible pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($coats as $product): ?>
                        <div class="box">
                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                            <p class="price">
                                <del><?php echo htmlspecialchars($product['ancien_prix']); ?> DH</del> 
                                <strong><?php echo htmlspecialchars($product['prix']); ?> DH</strong>
                            </p>
                            <button class="button2 btn-ajouter-panier" 
                                    data-id="<?php echo $product['id']; ?>"
                                    data-nom="<?php echo htmlspecialchars($product['nom']); ?>"
                                    data-prix="<?php echo $product['prix']; ?>"
                                    data-image="<?php echo htmlspecialchars($product['image']); ?>">
                                Ajouter au panier
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </fieldset>
    </main>

    <footer>
        <p>&copy; 2026 Dress-Up. Tous droits réservés.</p>
    </footer>

    <script src="panier.js"></script>
</body>
</html>

