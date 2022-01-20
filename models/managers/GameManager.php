<?php
require_once "models/GameClass.php";
require_once "models/ModelClass.php";
class GameManager extends Model{
    
    private $top5; //tableau des 5 meilleurs scores
    
    /**
     * addGameToTop5
     * 
     *  Rajoute une partie du top 5 du classement à mon tableau de top 5.
     * 
     * @param  Object $game objet d'une partie
     * 
     */
    public function addGameToTop5($game){
        $this->top5[] = $game;
    }

        
    /**
     * getTop5
     *
     * @return array avec le top 5 du classement
     */
    public function getTop5(){
        return $this->top5;
    }
    
    /**
     * loadingTop5
     * 
     * Récupère mon top 5 en BDD et réutilise ma fonction addScoreToTop5 pour les stocker dans l'attribut top 5.
     *
     * @return void
     */
    public function loadingTop5(){
        $this->top5 = null;
        // Je classe par secondes et je limite à 5 pour avoir mon TOP 5
        $sql ="SELECT * FROM game ORDER BY secondes LIMIT 5 ";
        // Il n'y a pas de paramètres donc aucun risque d'injection SQL, MAIS j'utilise quand même "prepare execute" par habitude.
        $req = $this->getDB()->prepare($sql);
        $req->execute();
        // Je stocke le données dans $games, FETCH OBJ permet de stocker chaque entrée sous forme d'objet.
        $games = $req->fetchALL(PDO::FETCH_OBJ);
        // Je rajoute chaque jeu dans mon tableau de jeu à l'aide de ma fonction.
        foreach($games as $game){
            $add = new Game($game->id_game,$game->pseudo_joueur,$game->secondes);
            $this->addGameToTop5($add);
        }
    }
    /**
     * addGameDb
     *
     * Ajoute un joueur à la bdd
     * 
     * @param  mixed $pseudo_joueur
     * @param  int $secondes
     * @return bool
     */
    public function addGameDb($pseudo_joueur,$secondes){
        // TRES IMPORTANT ICI
        // Les paramètres pseudo_joueur et secondes sont des variables.
        // Pour protéger ma bdd des injections SQL, il faut utiliser des paramètres nommés.
        // Je "bind" les paramètres aux variables dans le execute.
        // Avec cette méthode si du code sql est passé, il sera automatiquement "échappé"
        $sql = "INSERT INTO game (pseudo_joueur, secondes) VALUES (:pseudo_joueur, :secondes)";
        $req = $this->getDB()->prepare($sql);
        $result = $req->execute([
            ":pseudo_joueur"=>$pseudo_joueur,
            ":secondes"=>$secondes
        ]);
        return $result;
    }
}