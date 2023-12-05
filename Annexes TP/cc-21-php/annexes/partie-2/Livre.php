<?php
require_once('Auteur.php');

// TODO
// Définir la classe Livre
class Livre
{
    private $id;
    private $titre;
    private $ddp;
    private $id_auteur;

    
    public function __construct(int $id, string $titre, string $ddp, int $id_auteur) 
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->ddp = $ddp;
        $this->id_auteur = $id_auteur;
    }

    public function titre() : string {
        return $this->titre;
    }
}
?>
