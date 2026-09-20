
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
    <title>Contactez-nous - Dress-Up</title>
    <link rel="icon" href="dress-up-logo.png" type="image/png">
    <link rel="stylesheet" href="contact.css?v=2">
</head>
<body>
     
    <?php include 'header.php'; ?>

    <section class="contact-section">
        <fieldset class="contact-container">
            <legend><h2><i>Contactez-nous</i></h2></legend>
            <p class="descrip">N'hésitez pas à nous envoyer un message</p>

            <div class="contact-content">
                <form class="formul" id="form-contact">
                    <div class="input-group">
                        <label for="prenom"><b>Prénom :</b></label>
                        <input type="text" id="prenom" required placeholder="Votre prénom...">
                    </div>

                    <div class="input-group">
                        <label for="nom"><b>Nom :</b></label>
                        <input type="text" id="nom" required placeholder="Votre nom...">
                    </div>

                    <div class="input-group">
                        <label for="email"><b>Email :</b></label>
                        <input type="email" id="email" required placeholder="email@gmail.com">
                    </div>

                    <div class="input-group">
                        <label for="message"><b>Message :</b></label>
                        <textarea id="message" rows="4" required placeholder="Votre message ici..."></textarea>
                    </div>

                    <button type="submit" class="btn-envoyer">Envoyer le message</button>
                </form>

                <div class="continfo">
                    <div class="contact-info">
                        <p><b>📍 Adresse :</b> Casablanca, Maroc</p>
                        <p><b>📞 Téléphone :</b> +212 6 00 00 00 00</p>
                        <p><b>📧 Email :</b> contact@site.com</p>
                    </div>

                    <ul class="social">
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">WhatsApp</a></li>
                    </ul>
                </div>
            </div>
        </fieldset>
    </section>

    <footer>
        <p><b>&copy; Dress-Up Site</b></p>
    </footer>

    <script>
        document.getElementById('form-contact').addEventListener('submit', function(e) {
            e.preventDefault();
            const prenom = document.getElementById('prenom').value;
            alert(`Merci ${prenom} ! Votre message a été envoyé avec succès. Notre équipe vous répondra dans les plus brefs délais.`);
            this.reset(); 
        });
    </script>
</body>
</html>