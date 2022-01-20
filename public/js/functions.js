
function timer(time) {
    // Je lance l'animation de la progressBar.
    progressBar.style.animation = "load "+time+"s linear forwards";
    timerText.textContent = time + " secondes restantes"
    // Ma variable de secondes restantes, le paramètre de fonction permet de la définir.
    let secondsLeft = time;
    // Utilisation de setInterval pour les secondes, je les décrémente jusqu'à 0 et arrête l'interval.
    chrono = setInterval(() => {
        // Toutes les secondes le texte change avec la nouvelle valeur de seconde.
        secondsLeft--;
        // Pour la sauvegarde du score je compte le nombre de secondes passées.
        secondsPast ++;
        // Gestion du pluriel pour le compte à rebours.
        if(secondsLeft > 1){
            timerText.textContent= secondsLeft + SECONDS_LEFT_MESSAGE
        }else if (secondsLeft === 1){
            timerText.textContent= secondsLeft + SECOND_LEFT_MESSAGE
        }
        // Quand le compte à rebours atteint 0, je stoppe l'intervalle et appelle ma fonction loose().
        else {
            clearInterval(chrono);
            loose();
        }
        // Les millisecondes sont utilisées pour les intervalles.
    }, 1000)
}


function win(seconds) {
    // Je stoppe le chrono.
    clearInterval(chrono);
    // Je demande à la personne son pseudo, et en profite pour vous montrer un exemple de boucle do-while .
    // Tant que la condition n'est pas respectée la boucle se répete.
    let pseudo = null
    do{
        pseudo = prompt(ASK_PSEUDO_MESSAGE)
    }
    while(!pseudo)
    // Si le pseudo est plus long que 8 caractères, je le coupe.
    if(pseudo.length > 8){
        pseudo = pseudo.substring(0,8)
    }
    // Le score s'ajoute à bdd via notre fonction addGameToScore qui fait un fetch avec notre serveur.
    addGameToScore(pseudo,seconds);

    // Selecteur de ma ul avec les scores.
    let scores = document.querySelector(".modal__content-ul")
    // Ajout du nouveau score à la suite du top 5 pour donner l'info que le score a bien été ajouté.
    let newScore = document.createElement('li');
    // L'utilisation de textContent permet d'éviter l'injection de code (xss).
    newScore.textContent = "Nouveau Score "+ pseudo +" : "+ seconds+" secondes";
    // Appendchild permet de rajouter l'élement à la suite des enfants.
    scores.appendChild(newScore);
    
    // J'arrête le chargement de la barre.
    progressBar.style.animation ="";
    // Je change le texte.
    timerText.textContent= WELL_DONE_MESSAGE;
    // Je stoppe la possibilité de retourner les cartes.
    blockClick=true;
}

function loose() {
    // J'affiche une alerte.
    alert(LOOSE_MESSAGE);
    // Je change le contenu du texte par GameOver
    timerText.textContent= GAME_OVER_MESSAGE;
    // Je stoppe la possibilité de jouer si la personne choisit de ne pas relancer le jeu.
    blockClick=true;
    
}
// Je crée ici ma fonction permettant d'assigner de façon aléatoire les numéros d'images à des index (correspondants aux cases).
// Le fait d'utiliser une fonction avec paramètre ici permettra facilement d'adapter le jeu si besoin.
function randomPosition(numberOfImage) {
    // les variables que j'ai besoin d'initialiser, ici mon tableau avec les positions(index) et les numéros d'images(valeurs).
    let tabImgRandom = [];
    // Je boucle sur le nombre d'images que j'ai, afin de les assigner par deux à une position aléatoire (ici pour 18 images il y aura 36 positions).
    for (let a = 1; a <= numberOfImage; a++) {
        // Pour un jeu du mémory il faut les images en double, je boucle donc 2x par images ici.
        for (let i = 0; i < 2; i++) {
            // Je stocke dans la variable random un nombre aléatoire entre 1 et 36 (mon nombre de positions).
            // Mathfloor permet d'arrondir à l'entier précédent.
            // Math random retourne un nombre aléatoire entre 0 et 1.
            // Je multiplie le tout par mon nombre de cartes et par 2 afin d'avoir un nombre entre 1 et 36 (nombre de positions).
            // Ne pas oublier de rajouter 1 vu que Math floor arrondi à l'entier précédent.
            random = Math.floor(Math.random() * numberOfImage * 2) + 1;
            // Je cherche une case de façon aléatoire tant que cette case n'est pas vide(une image par case).
            while (tabImgRandom[random]) {
                random = Math.floor(Math.random() * numberOfImage * 2) + 1;
            }
            // Pour finir je stocke le numéro de l'image dans un de mes 36 index de tableaux.
            tabImgRandom[random] = a;
        }
    }
    return tabImgRandom;
}
function handleModal(){
    let i = 0;
    // Récupération de la modale.
    let modal = document.querySelector("#score");

    // Récupération du bouton pour afficher les scores.
    let btn = document.querySelector("#openScore");

    // Récupération du bouton pour fermer la modale.
    let span = document.querySelector(".modal__content-close");
    // Event pour afficher la modale au clic du bouton.
    btn.addEventListener("click",()=>{
        modal.style.display = "flex";
    });
    
    // Fermeture de la modale au clic sur la croix ou à l'exterieur de celle-ci.
    // Si première fermeture, je lance le timer.
    span.addEventListener("click",()=>{
        if(i === 0){
            i=1;
            timer(TIME_TO_FINISH);
        }
        modal.style.display = "none";
    });
    window.addEventListener("click",(e)=>{
        if(i === 0){
            i=1;
            timer(TIME_TO_FINISH);
        }
        if (e.target === modal) {
            modal.style.display = "none";
        }
    })
}

// Fonction pour envoyer les infos à sauvegarder sur le serveur à l'aide de fetch.
function addGameToScore(pseudo,secondes){
    // Je crée mon objet.
    let game = {
        pseudo:pseudo,
        secondes:secondes
    }
    // Je fais un fetch vers la route prévue côté serveur pour l'ajout d'un jeu en bdd.
    // Pour éviter d'écrire à la main la racine je recupere l'url courant avec window.location.
    // L'utilisation de la methode fetch() permet l'échange de données avec le serveur de façon asynchrone.
    fetch(window.location.href+"add-game",{
        // Méthode d'envoi de la requête http (POST).
        method:"POST",
        // Je transforme l'objet en string json.
        body:JSON.stringify(game)
    })
    // Le .then attend la reponse du serveur (promesse). Promesse rompu si la requête HTTP n'est pas effectuée.
    // En cas d'erreur type 500 ou 404 la promesse est tenue, il faut donc vérifier manuellement le bon déroulement, 
    // comme ici avec la propriété status.
    .then((response)=>{
        if(response.status===200){
            // Lorsque la personne gagne, et que tout se passe bien côté serveur une popup de victoire s'affiche.
            alert(WIN_MESSAGE);
        }
        // Dans ce .then nous recevons juste les en-têtes HTTP.
        // La méthode, response.json() va nous permettre de récupérer le corps au format JSON dans le prochain .then().
            return response.json();
    })
    .then((response)=>{
        // Si le json que je fais passer ne comprend pas le message "success", c'est que j'ai levé une erreur côté SERVEUR
        if(response.message !== "success"){
            // Je lève une erreur, avec le message qui est disponible dans l'objet response.
            throw new Error(response.message);
        }
        // Si l'erreur n'est pas levé, le json avec succès est affiché dans la console.
        console.log(response);
    })
    .catch(err=>{
        // J'affiche mon erreur dans la console et à l'utilisateur.
        alert(err);
        console.error(err);
    });
}