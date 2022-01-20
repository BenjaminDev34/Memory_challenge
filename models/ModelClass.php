<?php
//Abstract pour ne pas avoir à instancier la classe et surtout pour l'utiliser dans de futurs héritages (polymorphisme).
abstract class Model{

    // Attribut privé dans lequel je stocke mon objet PDO.
    private $pdo;

    // Méthode me permettant d'instancier ma bdd, c'est ici qu'il faut la paramétrer.
    private function setDB(){
        $this->pdo = new PDO("mysql:host=localhost;dbname=memory;charset=utf8","root","");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }

    // Getter de mon attribut pdo, s'il est vide, appelle ma méthode setDB.
    // la visibilité protected permet l'utilisation de la méthode pour toutes les classes qui hériteront de notre classe Model
    protected function getDB(){
        if($this->pdo == null){
            $this->setDb();
        }
        return $this->pdo;
    }

}