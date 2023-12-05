<?php
require_once("Livre.php");

// TODO
// Définir la classe Auteur
class Auteur
{
    private $id;
    private $nom;
    private $prenom;
    private $ddn;
    private $ddd;
    
    public function __construct(int $id, string $nom, string $prenom, string $ddn, string $ddd) 
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->ddn = $ddn;
        $this->ddd = $ddd;
    }

    public function age() : int|bool {
        return (( $this->ddn != '' && $this->ddd != '') ? ($this->ddd - $this->ddn) : false);
    }
}

?>
