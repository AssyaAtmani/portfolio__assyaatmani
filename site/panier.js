document.addEventListener("DOMContentLoaded", () => {

    let panier = JSON.parse(localStorage.getItem("dressup_panier")) || [];

    const updatePanierCount = () => {
        const countSpan = document.getElementById("panier-count");

        if(countSpan){
            const totalArticles = panier.reduce(
                (total, item) => total + item.quantite,
                0
            );

            countSpan.textContent = totalArticles;
        }
    };

    updatePanierCount();

    const buttons = document.querySelectorAll(".btn-ajouter-panier");

    buttons.forEach(button => {

        button.addEventListener("click", () => {

            const item = {
                id: button.dataset.id,
                nom: button.dataset.nom,
                prix: parseFloat(button.dataset.prix),
                image: button.dataset.image,
                quantite: 1
            };

            const index = panier.findIndex(
                p => p.id === item.id
            );

            if(index !== -1){
                panier[index].quantite++;
            }else{
                panier.push(item);
            }

            localStorage.setItem(
                "dressup_panier",
                JSON.stringify(panier)
            );

            updatePanierCount();

            button.innerHTML = "Ajouté ✓";

            setTimeout(() => {
                button.innerHTML = "Ajouter au panier";
            }, 1200);

        });

    });

});