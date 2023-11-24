<?php
    function afficher_option($value)
    {
        echo "<option value=\"{$value[0]}\">{$value[1]}</option>";
    }

    echo "<tr>";
    echo "<td>Nom & Prénom</td>";
    echo "<td><select name=\"nom_prenom\">";

    // Pour les options du select on doit recuperer tout les nom,prenoms des proprio
    // On les concat directement dans le sql pour faciliter 
    // le passage d'argument de la callback afficher_option
    require_once("connexpdo.inc.php");
    $pdo = connexpdo("voitures");
    $requete = $pdo->prepare("SELECT id_pers, CONCAT(nom, ' ',prenom)
                            FROM proprietaire;");
    $requete->execute();
    $data = $requete->fetchAll(PDO::FETCH_NUM);

    // On ittere ansi sur les nom,prenoms pour mettre une option
    array_walk($data, 'afficher_option');

    echo "</select><td>";
    echo "</tr>";
?>