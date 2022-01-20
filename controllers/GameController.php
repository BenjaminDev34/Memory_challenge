<?php
require_once "models/managers/GameManager.php";

class GameController
{
    private $gameManager;

    // A l'instanciation de la classe, le manager est automatiquement créé grâce à mon construct.
    // Mon top 5 est également chargé automatiquement.
    public function __construct()
    {
        $this->gameManager = new GameManager;
        $this->gameManager->loadingTop5();
    }

        
    /**
     * launchGame
     *
     * Recupere mes données necessaires et appelle la vue du jeu du mémory.
     */
    public function launchGame(){
        $top5 = $this->gameManager->getTop5();
        require "views/memoryView.php";
    }

     /**
     * addGame
     *
     * Ajoute un jeu à la bdd à l'aide du json envoyé depuis le javascript avec fetch. 
     */
    public function addGame(){
        // Fonction permettant de récupérer le json
        $game = file_get_contents('php://input');
        // Fonction permettant de transformer le json en objet php
        $game = json_decode($game);
        // J'ajoute le jeu en bdd à l'aide de mon manager.
        try{
            // En modifiant la console, il est possible de tricher assez facilement...
            // Après avoir fait plusieurs parties, il me semble impossible de battre 80 secondes sans tricher.
            // Je lève une erreur si le temps est inférieur à 50 secondes (je prévois large).
            if($game->secondes<50){
                throw new Exception("Je n'aime pas les tricheurs, ne touche pas la console !");
            }
            // En cas d'erreur sql je lève une exception.
            if(!$this->gameManager->addGameDb($game->pseudo,$game->secondes)){
                // Si on rentre dans cette condition c'est qu'une erreur sql a eu lieu et xdebug affichera un message.
                // Afin de juste renvoyer un message en json pour notre fetch il faut vider la mémoire tampon pour effacer le message xdebug.
                ob_clean();
                throw new Exception("Erreur ajout BDD");
            }else{
                // Json que l'on affichera dans la console, signifiant que tout s'est bien passé.
                echo json_encode(['message'=>"success"]);
                return;
            }
        }
        catch(Exception $e){
            // Si dans le try une exception est levée,
            // je renvoie une erreur 500 ainsi qu'un json avec l'erreur levée.
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo json_encode(['message'=>$e->getMessage()]);
            return;
        }
    }
}