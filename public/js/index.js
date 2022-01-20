
let secondsPast = 0;
// Mes deux variables qui vont être utilisées dans mes fonctions pour la barre de progression. 
let progressBar = document.querySelector("#progressBar__value");
let timerText = document.querySelector("#secondsLeft");
// Initialisation des variables qui vont m'être utiles.
// Je stock toutes mes divs correspondantes aux positions des cartes dans allCards.
let allCards = document.querySelectorAll(".container__card")
// Je génère un plateau de jeu dynamiquement, grâce à ma fonction randomPosition avec 18 cartes.
let gameTab = randomPosition(NUMBER_OF_GAME_CARDS);
// i pour itération, servira à assigner la bonne carte à la bonne position grâce à gameTab.
let i = 1
// J'initialise la variable qui servira à stocker les divs qui ont été cliquées par le joueur.
let cardObject = [];
// Nombre de coups en cours.
let shot = 0;
// Variable pour stocker le nombre de paires trouvées.
let pairFound = 0;
// Variable pour bloquer les cliques le temps que les cartes se retournent après un echec.
let blockClick = false;
// Fonction qui permet de gérer la modale des scores.
// Le compte à rebours se lance à la première fermeture de la modale.
handleModal();
// J'ai selectionné toutes mes divs qui vont contenir mes images, je boucle dessus afin d'y assigner mes images dynamiquement.
allCards.forEach(card => {
    card.children[0].attributes[1].textContent = "public/images/cards/cards_" + gameTab[i] + ".png";
    card.data = gameTab[i];
    i++;
    // Grâce à mon foreach un évenement de clic est assigné à toutes mes divs.
    // J'utilise dans mon "eventListener" en fonction de callBack une fonction anonyme.
    card.addEventListener("click", () => {
        // Si ma variable blockClick n'est pas active, le jeu peut continuer.
        if (!blockClick) {
            // Ici les conditions qui permettent de faire un coup.
            if (!Object.values(card.classList).includes("container__card--show") && shot !== 2) {
                // Je toggle mes différentes animations css.
                card.children[0].classList.toggle("container__card-img--showImg");
                card.classList.toggle("container__card--show");
                card.children[0].classList.remove("container__card-img--unShowImg");
                card.classList.remove("container__card--unShow");
                // Je rajoute un coup et j'ajoute l'objet de la div cliquée par le joueur dans ma variable initialisée plus tôt/
                shot++;
                cardObject.push(card);
            }
            // Je vérifie s'il y a bien 2 cartes dans mon cardObject et si la valeurs de "data" des deux est identique.
            if (cardObject.length === 2) {
                if (cardObject[0].data === cardObject[1].data) {
                    // Je toggle mes animations css de succès, je boucle pour éviter de répéter le code.
                    cardObject.forEach(card => {
                        card.classList.toggle("container__card--success");
                    });
                    // Je reboot mes coups et j'incrémente mon nombre de paires trouvées.
                    pairFound++;
                    cardObject = [];
                    shot = 0;
                    // Si toutes les paires sont trouvées avant le temps imparti l'utilisateur a gagné.
                    if (pairFound === NUMBER_OF_GAME_CARDS) {
                        // J'utilise setTimeout afin de laisser le temps à l'image de se retourner.
                        setTimeout(() => {
                            win(secondsPast);
                        }, 1000)
                    }
                }

                // Cette condition n'est remplie qu'en cas où la paire retournée ne correspond pas.
                else {
                    // J'active ma variable qui bloque les clics.
                    blockClick = true;
                    // Je mets un timeout afin de laisser le temps à l'utilisateur de voir les cartes avant qu'elles ne se retournent.
                    setTimeout(() => {
                        // Je toggle les classes css de mes divs gardés dans ma variable .
                        cardObject.forEach(card => {
                            card.classList.remove("container__card--show");
                            card.classList.toggle("container__card--unShow");
                            card.children[0].classList.remove("container__card-img--showImg");
                            card.children[0].classList.toggle("container__card-img--unShowImg");
                        });
                        // Je rénitialise les coups et je réautorise les clics  :) Enjoy !
                        cardObject = [];
                        shot = 0;
                        blockClick = false;
                    }, 800);
                }
            }
        }
    })
})

