<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer la Commande - Dress-Up</title>
    <link rel="stylesheet" href="commande.css">
    <link rel="icon" href="dress-up-logo.png" type="image/png">
</head>
<body>
     
    <header>
        <img class="logo" src="dress-up-logo.png" alt="Dress-Up Logo">
        <h1>Dress-Up</h1>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="accueil.php">Boutique</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="container-commande">
        <fieldset class="section-formulaire">
            <legend><h2><i>Informations de Livraison</i></h2></legend>
            <form id="form-commande">
                <div class="input-group">
                    <label for="nom">Nom Complet :</label>
                    <input type="text" id="nom" required placeholder="Votre nom et prénom...">
                </div>

                <div class="input-group">
                    <label for="tel">Téléphone :</label>
                    <input type="tel" id="tel" required placeholder="06XXXXXXXX...">
                </div>

                <div class="input-group">
                    <label for="ville">Ville :</label>
                    <input type="text" id="ville" required placeholder="Ex: Casablanca, Rabat...">
                </div>

                <div class="input-group">
                    <label for="adresse">Adresse de résidence :</label>
                    <textarea id="adresse" rows="3" required placeholder="Votre adresse exacte..."></textarea>
                </div>

                <div class="input-group">
                    <label>Mode de Paiement :</label>
                    <div class="paiement-options">
                        <div class="paiement-methode">
                            <input type="radio" id="cod" name="paiement" value="cash" checked onclick="togglePaiementForm()">
                            <label for="cod"><b>Paiement à la livraison (Cash)</b></label>
                        </div>
                        <div class="paiement-methode">
                            <input type="radio" id="card" name="paiement" value="carte" onclick="togglePaiementForm()">
                            <label for="card"><b>Carte Bancaire (Visa / Mastercard)</b></label>
                        </div>
                    </div>
                </div>

                <div id="form-carte-bancaire" style="display: none; margin-top: 15px; padding: 15px; background-color: rgba(255,255,255,0.6); border-radius: 8px; border: 1px solid #5506149d;">
                    <div class="input-group">
                        <label for="num-carte" style="color:#000;">Numéro de la carte :</label>
                        <input type="text" id="num-carte" placeholder="4000 1234 5678 9010" maxlength="19">
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <div class="input-group" style="flex: 1;">
                            <label for="exp-carte" style="color:#000;">Date d'expiration :</label>
                            <input type="text" id="exp-carte" placeholder="MM/AA" maxlength="5">
                        </div>
                        <div class="input-group" style="flex: 1;">
                            <label for="cvv-carte" style="color:#000;">CVV :</label>
                            <input type="text" id="cvv-carte" placeholder="123" maxlength="3">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-valider">Confirmer ma commande</button>
            </form>
        </fieldset>

        <fieldset class="section-recap">
            <legend><h2><i>Votre Panier</i></h2></legend>
            <div id="liste-recap">
                </div>
            <div class="total-box">
                <h3>Total à payer : <span id="total-commande">0</span> DH</h3>
            </div>
        </fieldset>
    </div>

    <footer>
        <p><b>@Dress-Up Site</b></p>
    </footer>

    <script>

        function togglePaiementForm() {
            const formCarte = document.getElementById('form-carte-bancaire');
            const isCarte = document.getElementById('card').checked;
            
            if (isCarte) {
                formCarte.style.display = 'block';
                document.getElementById('num-carte').required = true;
                document.getElementById('exp-carte').required = true;
                document.getElementById('cvv-carte').required = true;
            } else {
                formCarte.style.display = 'none';
                document.getElementById('num-carte').required = false;
                document.getElementById('exp-carte').required = false;
                document.getElementById('cvv-carte').required = false;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const panier = JSON.parse(localStorage.getItem('dressup_panier')) || [];
            const listeRecap = document.getElementById('liste-recap');
            const totalCommande = document.getElementById('total-commande');

            if (panier.length === 0) {
                listeRecap.innerHTML = "<p>Votre panier est vide. <a href='accueil.php' style='color:rgba(134, 75, 85, 0.94);'>Retourner à la boutique</a></p>";
                document.querySelector('.btn-valider').disabled = true;
                return;
            }

            let total = 0;
            listeRecap.innerHTML = "";

            panier.forEach(article => {
                const itemRecap = document.createElement('div');
                itemRecap.className = 'item-recap';
                
                let imgTag = "";
                if (article.isBag || article.image.includes('.')) {
                    imgTag = `<img src="${article.image}" alt="${article.nom}">`;
                } else {
                    imgTag = `<div class="mini-img-preview ${article.image}"></div>`;
                }

                itemRecap.innerHTML = `
                    ${imgTag}
                    <div class="item-details">
                        <h4>${article.nom}</h4>
                        <p>Quantité : ${article.quantite}</p>
                        <p class="prix-item">${article.prix * article.quantite} DH</p>
                    </div>
                `;
                listeRecap.appendChild(itemRecap);
                total += article.prix * article.quantite;
            });

            totalCommande.innerText = total;

            document.getElementById('form-commande').addEventListener('submit', function(e) {
                e.preventDefault();
                const nom = document.getElementById('nom').value;
                const modePaiement = document.querySelector('input[name="paiement"]:checked').value;
                
                let message = `Merci ${nom} ! Votre commande a été enregistrée avec succès.`;
                if(modePaiement === 'carte') {
                    message += " Le paiement par carte a été validé de manière sécurisée.";
                } else {
                    message += " Nous vous contacterons pour la livraison et le règlement en cash.";
                }
                
                alert(message);
                localStorage.removeItem('dressup_panier');
                window.location.href = "accueil.php";
            });
        });
    </script>
</body>
</html>