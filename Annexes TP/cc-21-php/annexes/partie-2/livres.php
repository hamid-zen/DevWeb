<?php
require("auteurs.php");
require("Livre.php");

$livres = array(); // Tableau contenant l'ensemble des livres (Objet Livre).


// TODO
// Remplir le tableau $livres pour chaque livre trouvé dans le tableau $auteurs (défini dans le fichier auteurs.php)
$callback = function ($livre) use (&$livres){
                $newlivre = new Livre($livre['id'], $livre['titre'], $livre['ddp'], $livre['id_auteur']);
                $livres[] = $newlivre;
            };

foreach ($auteurs as $auteur) {
    array_walk($auteur['livres'], $callback);
}


// Partie affichage
if(__FILE__ == $_SERVER["SCRIPT_FILENAME"]){
echo "<pre>";
print_r($livres);
echo "</pre>";
}
?>
