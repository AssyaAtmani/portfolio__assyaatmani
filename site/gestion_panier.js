document.addEventListener("DOMContentLoaded", function() {
    afficherPanier();
});

function afficherPanier() {
    const conteneur = document.getElementById("contenu-panier");
    let panier = JSON.parse(localStorage.getItem('dressup_panier')) || [];

    if (panier.length === 0) {
        conteneur.innerHTML = `
            <div class="panier-vide" style="text-align: center; padding: 40px; color: white;">
                <p style="font-size: 20px; margin-bottom: 20px;">Votre panier est actuellement vide.</p>
                <a href="shop.php"><button class="btn-retour" style="padding: 10px 20px; border-radius: 5px 50px; border: 1px solid #5506149d; cursor: pointer;">Retour à la boutique</button></a>
            </div>
        `;
        return;
    }

    let html = `
        <table>
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Désignation & Description</th>
                    <th>Prix unitaire</th>
                    <th style="text-align: center;">Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    `;

    let totalGeneral = 0;

    panier.forEach((item, index) => {
        let totalArticle = item.prix * item.quantite;
        totalGeneral += totalArticle;


        let caseImage = `<img src="${item.image}" style="height: 90px; width: 75px; object-fit: cover; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.3);" alt="${item.nom}">`;

        html += `
            <tr>
                <td style="text-align: center;">${caseImage}</td>
                <td>
                    <strong style="color: #5506149d; font-size: 16px;">${item.nom}</strong><br>
                    <span style="color: #666; font-size: 13px; font-style: italic;">${item.description || ''}</span>
                </td>
                <td>${item.prix} DH</td>
                
                <td>
                    <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <button onclick="changerQuantite(${index}, -1)" style="background-color: #7f8c8d; color: white; border: none; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 16px;">-</button>
                        <span style="font-weight: bold; font-size: 16px; min-width: 25px; text-align: center; color: #000; display: inline-block;">${item.quantite}</span>
                        <button onclick="changerQuantite(${index}, 1)" style="background-color: #2c3e50; color: white; border: none; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 16px;">+</button>
                    </div>
                </td>
                
                <td><strong>${totalArticle} DH</strong></td>
                <td>
                    <button onclick="supprimerArticle(${index})" style="background-color: #e74c3c; color: white; padding: 6px 12px; border-radius: 5px; font-size: 12px; border: none; cursor: pointer;">
                        Supprimer
                    </button>
                </td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
        <div class="total-container" style="text-align: right; margin-top: 20px; font-size: 20px; font-weight: bold; color: white;">Total à payer : <span class="total-prix" style="color: #1e1e1e; background: #ffffff63; padding: 5px 15px; border-radius: 5px;">${totalGeneral} DH</span></div>
        <div class="actions-panier" style="display: flex; justify-content: space-between; margin-top: 25px;">
            <button class="btn-panier btn-vider" onclick="viderPanier()" style="background-color: #e74c3c; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Vider le panier</button>
            <button class="btn-panier btn-commander" onclick="validerCommande()" style="background-color: #2ecc71; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Valider la commande</button>
        </div>
    `;
    conteneur.innerHTML = html;
}

function changerQuantite(index, changement) {
    let panier = JSON.parse(localStorage.getItem('dressup_panier')) || [];
    panier[index].quantite += changement;
    
    if (panier[index].quantite < 1) {
        if(confirm("Voulez-vous supprimer cet article du panier ?")) {
            panier.splice(index, 1);
        } else {
            panier[index].quantite = 1;
        }
    }
    localStorage.setItem('dressup_panier', JSON.stringify(panier));
    afficherPanier();
}

function supprimerArticle(index) {
    let panier = JSON.parse(localStorage.getItem('dressup_panier')) || [];
    panier.splice(index, 1);
    localStorage.setItem('dressup_panier', JSON.stringify(panier));
    afficherPanier();
}

function viderPanier() {
    if(confirm("Voulez-vous vraiment vider tout votre panier ?")) {
        localStorage.removeItem('dressup_panier');
        afficherPanier();
    }
}

function validerCommande() {
    window.location.href = "commande.php";
}