<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Le jeu du mémory - Pour les grands et les petits, trouves les pairs !">
    <!-- Pensez à utiliser la constante URL créée dans mon index.php pour accéder aux fichiers depuis la racine. -->
    <link rel="stylesheet" href=<?= URL ?>public/css/main.css>
    <!-- Dans une page html il est important d'être le plus sémantique possible. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href=<?= URL ?>public/images/logo_bb_memory.png>
    <title>Le jeu du mémory </title>
</head>

<body>
    <header>
        <h1>Le jeu du mémory</h1>
        <nav>
            <ul>
                <li id="openScore"><i class="fas fa-stopwatch textNav"><span>Scores</span></i></li>
                <li><a href=<?= URL ?> class="fas fa-power-off textNav"><span>Recommencer</span></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Section de la modale avec les scores. -->
        <section id="score" class="modal">
            <!-- Le contenu de la modale. -->
            <div class="modal__content">
                <!-- &times permet de faire une croix. -->
                <span class="modal__content-close">&times;</span>
                <!-- Le titre de la modale est dans une span car sémantiquement, je ne voulais pas le considérer comme un titre. -->
                <span class=modal__content-title>top 5</span>
                <ul class="modal__content-ul">
                    <?php
                    // La boucle php, permettant d'afficher les 5 meilleurs scores du classement.
                    $i = 0;
                    if ($top5) {
                        foreach ($top5 as $game) {
                            $i++;
                            // Htmlspecialchars permet de bloquer d'eventuels scripts (protection failles xss)
                            echo '<li>#' . $i . ' ' . htmlspecialchars($game->getPseudo_joueur()) . ' <span>' . htmlspecialchars($game->getSecondes()) . ' secondes</span></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </section>
        <!-- Tout mes blocs avec les images des cartes, je les modifie avec le js pour changer les images-->
        <!-- Draggable false permet d'éviter de pouvoir drag les images -->
        <section class="container">
            <div class="container__card" id="box_1"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_2"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_3"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_4"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_5"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_6"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_7"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_8"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_9"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_10"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_11"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_12"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_13"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'une truite" draggable="false"></div>
            <div class="container__card" id="box_14"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_15"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_16"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_17"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_18"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_19"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_20"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_21"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_22"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_23"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_24"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_25"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_26"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_27"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_28"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_29"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_30"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_31"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_32"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_33"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_34"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_35"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
            <div class="container__card" id="box_36"><img class="container__card-img" src="public/images/cards/cards_1.png" alt="image d'un fruit" draggable="false"></div>
        </section>
        <!-- La barre de progression. -->
        <div id="progressBarContainer">
            <div id=progressBar>
                <div id="progressBar__value"></div>
            </div>
            <i id=secondsLeft></i>
        </div>
    </main>

</body>
<!-- Import de mes scripts JS. -->
<script src=<?= URL ?>public/js/const.js></script>
<script src=<?= URL ?>public/js/functions.js></script>
<script src=<?= URL ?>public/js/index.js></script>

</html>