<?php
class Game{
    // Mes attributs en privé.
    private $id_game;
    private $pseudo_joueur;
    private $secondes;

    // Fonction __construct se lance automatiquement à l'instanciation d'une classe
    public function __construct($id_game,$pseudo_joueur,$secondes)
    {
        $this->id_game = $id_game;
        $this->pseudo_joueur = $pseudo_joueur;
        $this->secondes = $secondes;
    }

    /**
     * Getter d'id_game
     */ 
    public function getId_game()
    {
        return $this->id_game;
    }

    /**
     * Setter d'id_game
     *
     */ 
    public function setId_game($id_game)
    {
        $this->id_game = $id_game;

    }

    /**
     * Getter de pseudo_joueur
     */ 
    public function getPseudo_joueur()
    {
        return $this->pseudo_joueur;
    }

    /**
     *  Setter de pseudo_joueur
     *
     */ 
    public function setPseudo_joueur($pseudo_joueur)
    {
        $this->pseudo_joueur = $pseudo_joueur;

    }

    /**
     *  Getter de secondes
     */ 
    public function getSecondes()
    {
        return $this->secondes;
    }

    /**
     *  Setter de pseudo_joueur
     *
     */ 
    public function setSecondes($secondes)
    {
        $this->secondes = $secondes;

    }
}