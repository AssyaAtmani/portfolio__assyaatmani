<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: log.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="dress-up-logo.png" type="image/png">
    <link rel="stylesheet" href="accueil.css?v=2">
    <title>Accueil - Dress-Up</title>
</head>
<body>

    <?php include 'header.php'; ?>

    <section class="featured">
        <h2>Featured Outfits</h2>
        <p>Bonjour, <b><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Inconnu'); ?></b> ! Check out these empowering looks for women,<br>
            <i><b>Choose your favorite look.</b></i>
        </p>
    </section>
    
    <section class="type">
        
        <article class="box">
            <a href="dresses.php"><img class="elegant" src="elegant-pink-dress.png" alt="Elegant Dresses"></a>
            <button onclick="window.location.href='dresses.php'">
                <h3>Elegant dresses</h3>
                <p>Graceful designs for special occasions.</p>
            </button>
        </article>

        <article class="box">
            <a href="professional.php"><img class="professional" src="Professional-suits.png" alt="Professional Suits"></a>
            <button onclick="window.location.href='professional.php'">
                <h3>Professional Suits</h3>
                <p>Elegance that empowers your workday.</p>
            </button>
        </article>

        <article class="box">
            <a href="casual-day-look.php"><img class="casual" src="casual-day-look.png" alt="Casual Look"></a>
            <button onclick="window.location.href='casual-day-look.php'">
                <h3>Casual Day Look</h3>
                <p>Comfortable and Stylish for everyday Adventures.</p>
            </button>
        </article>

        <article class="box">
            <a href="bags.php"><img class="bags" src="Bags.png" alt="Bags"></a>
            <button onclick="window.location.href='bags.php'">
                <h3>Bags</h3>
                <p>Complete your Outfit effortlessly.</p>
            </button>
        </article>

    </section>

    <footer>
        <p><b>&copy; Dress-Up Site</b></p>
    </footer>
    
</body>
</html>