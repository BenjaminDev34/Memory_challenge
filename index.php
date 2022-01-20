<?php
// Création d'une constante pour avoir accès au chemin racine du site dans notre code.
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

// Instanciation de mon contrôleur de jeu.
include_once "controllers/GameController.php";
$gameController = new GameController;

try {
    // Grâce à notre structure MVC notre index sert de routeur.
    // L'utilisation de la superglobale GET et de l'index "page" nous servira à faire les différentes "routes" de notre site.
    // Nous utilisons le HTACCESS pour "gommer" l'index.php et le ?page= de l'url afin d'avoir une url propre et limpide.
    // La variable $url ci-dessous permet à l'aide de explode et filter_var de créer un tableau de sous-url
    if (isset($_GET['page'])) {
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
    }
    // Exemple : une url monsite/mon-compte/2
    // sera enfaite monsite/index.php?page=mon-compte/2 sans le HTACCESS.
    // On va faire de la réécriture d'URL grâce à notre HTACCESS.
    // Pour faire notre routeur nous allons décomposer tout ce qu'il y a après "?page=" en valeur dans le tableau url,
    // s'il n'y a rien ça veut dire qu'on ne demande aucune page (souvent l'accueil).
    // Chaque slash rajoutera un index à notre tableau
    // pour rester sur  notre exemple, url[0] serait "mon-compte" et url[1] serait "2"

    // Si GET page est vide on redirige vers l'accueil (ici notre jeu du mémory).
    if (empty($url[0])) {
        // Le routeur appelle la bonne méthode de notre contrôleur.
        $gameController->launchGame();
    } else {
        // Si une page en particulier est demandée on pourra prévoir ici toutes nos routes dans le switch.
        switch ($url[0]) {
            // Si la route add-game est demandée
            case "add-game":
                // J'appelle la bonne méthode du contrôleur.
                // Si une personne rentre manuellement l'url pour ajouter il trouvera une page 404.
                if(!empty(file_get_contents('php://input'))){
                    $gameController->addGame();
                    break;
                }else{
                    throw new Exception("La page n'existe pas");
                }
            default:
                // Au cas où une route non prévue est demandée, une erreur est levée avec "page inexistante".
                throw new Exception("La page n'existe pas");
        }
    }
    
}
// Ici la gestion d'erreur en cas de route non trouvée par notre routeur, en général une page 404 personnalisée est affichée.
// Ici il faut gérer les erreurs propres au routage.
// En cas d'erreur comme un formulaire mal rempli ou autre c'est dans les contrôleurs que ça se passe.
catch (Exception $e) {
    echo $e->getMessage();
    //TO-DO ici le require de votre page 404 personnalisée
    //  require "views/error.view.php";
}
