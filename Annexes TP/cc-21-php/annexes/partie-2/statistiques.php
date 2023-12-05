<?php
require("livres.php");

$ageMoyen = 0; // Variable pour calculer les 2 ages moyens
$caracMoyen = 0; // Variable pour calculer le nombre de caractère moyen
$dates = array(); // Tableau permettant de stocker la liste des dates de publication

// TODO
// Affichage de quelques statistiques à partir du tableau $livres obtenu dans l'exercice précédent
// Si pas traité les calculer à partir du tableau $auteurs fourni.

// TODO
// Age moyen des auteurs au moment de la publication de leur livre
function array_average($array) {
    $carry = null;
    $count = count($array);
    return array_reduce($array, function ($carried, $titre) use ($count) {
         return ($carried===null?0:$carried) + strlen($titre)/$count;
    },$carry);
}

$ages = array_map(function($o) { return $o->age();}, $livres);
var_dump($ages);

echo "<p>Age moyen des auteurs au moment de la publication de leur livre : ".round($ageMoyen,2)." ans</p>";

// TODO
// Nombre de caractères moyen du titre des livres
$titres = array_map(function($o) { return $o->titre();}, $livres);
$caracMoyen = array_average($titres);

echo "<p>Nombre de caractères moyen du titre : ".round($caracMoyen,2)." caractères</p>";

// TODO
// Nombre de livre par date de publication


echo "<p>Dates de publications :<ul>";
//TODO : liste à puce d'affichage du tableau $dates

echo "</ul></p>";

// TODO
// Age moyen des auteurs par livre (1 livre = 1 age)


echo "<p>Age moyen des auteurs par livre : ".round($ageMoyen,2)." ans</p>";

?>
