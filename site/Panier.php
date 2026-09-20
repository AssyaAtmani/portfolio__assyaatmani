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
    <title>Mon Panier - Dress-Up</title>
    <link rel="icon" href="dress-up-logo.png" type="image/png">
    <link rel="stylesheet" href="Panier.css?v=3">
</head>
<body>

    <header>
        <img class="logo" src="dress-up-logo.png" alt="Logo">
        <fieldset class="search">
    <legend><b>Recherche</b></legend>
    <input type="text" id="search-panier" onkeyup="filterPanier()" placeholder="Rechercher un produit...">
</fieldset>
    </header>

    <nav class="main-nav">
        <ul>
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="Panier.php">Panier</a></li>
            <li><a href="log.php">Déconnexion</a></li>
        </ul>
    </nav>

    <main class="panier-container">
        <h1><i>Mon Panier d'Achats</i></h1>
        <div id="contenu-panier"></div>
    </main>

    <footer>
        <p><b>&copy; Dress-Up Site</b></p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            renderPanier();
        });

        function renderPanier() {
            const container = document.getElementById('contenu-panier');
            const panier = JSON.parse(localStorage.getItem('dressup_panier')) || [];

            if (panier.length === 0) {
                container.innerHTML = `
                    <div class="panier-vide">
                        <p>Votre panier est actuellement vide.</p>
                        <button class="btn-retour" onclick="window.location.href='accueil.php'">Retourner à la boutique</button>
                    </div>
                `;
                return;
            }

            let html = `
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Désignation</th>
                            <th>Prix Unitaire</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            let total = 0;

            panier.forEach((article, index) => {
                const sousTotal = article.prix * article.quantite;
                total += sousTotal;

                html += `
                    <tr>
                        <td>
                            <img src="${article.image}" alt="${article.nom}" class="box-panier-img">
                        </td>
                        <td class="product-title-td">${article.nom}</td>
                        <td>${article.prix} DH</td>
                        <td>
                            <div class="qty-control">
                                <button onclick="modifierQuantite(${index}, -1)">-</button>
                                <span>${article.quantite}</span>
                                <button onclick="modifierQuantite(${index}, 1)">+</button>
                            </div>
                        </td>
                        <td class="subtotal-td">${sousTotal} DH</td>
                        <td>
                            <button class="btn-supprimer" onclick="supprimerArticle(${index})">Supprimer</button>
                        </td>
                    </tr>
                `;
            });

            html += `
                    </tbody>
                </table>
                
                <div class="total-container">
                    Total Global : <span class="total-prix">${total} DH</span>
                </div>
                
                <div class="actions-panier">
                    <button class="btn-panier btn-vider" onclick="viderPanier()">Vider le panier</button>
                    <button class="btn-panier btn-commander" onclick="window.location.href='commande.php'">Passer la commande</button>
                </div>
            `;

            container.innerHTML = html;
        }

        window.modifierQuantite = function(index, change) {
            let panier = JSON.parse(localStorage.getItem('dressup_panier')) || [];
            panier[index].quantite += change;

            if (panier[index].quantite <= 0) {
                panier.splice(index, 1);
            }

            localStorage.setItem('dressup_panier', JSON.stringify(panier));
            renderPanier();
        };

        window.supprimerArticle = function(index) {
            let panier = JSON.parse(localStorage.getItem('dressup_panier')) || [];
            panier.splice(index, 1);
            localStorage.setItem('dressup_panier', JSON.stringify(panier));
            renderPanier();
        };

        window.viderPanier = function() {
            if (confirm("Voulez-vous vraiment vider tout votre panier ?")) {
                localStorage.removeItem('dressup_panier');
                renderPanier();
            }
        };
        window.filterPanier = function() {
    let input = document.getElementById('search-panier');
    let filter = input.value.toLowerCase();
    let table = document.querySelector('table');
    
    let rows = table.getElementsByTagName('tr');
    for (let i = 1; i < rows.length; i++) {
        let nameColumn = rows[i].getElementsByClassName('product-title-td')[0];
        
        if (nameColumn) {
            let txtValue = nameColumn.textContent || nameColumn.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
};
    </script>
</body>
</html>