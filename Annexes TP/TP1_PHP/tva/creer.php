<?php
// Création du tableau [..., "D" => ["Prix" => 22.71,"Taux" => 0.05], ...]
$tableau_labels = array();
$tableau_taux = array(0.05, 0.10, 0.20);

for ($i=0; $i < 11; $i++) { 
    $tableau_labels[$i] = chr($i+65);
}

// function creer_prix_articles(string $article) : array {
function creer_prix_articles($article)
{
    // On cree un prix random
    $prix_random = (rand(0, 100)+(rand(0,10)/10));

    // On prend un taux random
    $taux = array(0.05, 0.10, 0.20);
    $taux_random = $taux[array_rand($taux)];

    return ["Prix" => $prix_random, "Taux" => $taux_random];  
}

// initialisation de $prix_taux
$prix_taux = null;

// On met en keys nos labels
// En value on met nos calculs
$prix_taux = array_combine(
    $tableau_labels,
    array_map('creer_prix_articles', $tableau_labels)
);

?>