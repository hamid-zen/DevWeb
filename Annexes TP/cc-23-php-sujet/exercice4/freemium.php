<?php 
    /*
        Freemium :  Mot-valise des mots anglais 'free' (gratuit) et 'premium' (prime).

        Le modèle FREEMIUM s'agit souvent d'une version limitée dans le temps 
        servant à promouvoir une version complète payante.
     */



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>2023 CC-PHP Exercice 4</title>
</head>
<body>
    <h2>Service d'affichage de cartes cognitives</h2>
    <form method="post" action="<?= $_SERVER['PHP_SELF'];?>" >
        <label for="map">Choissez une carte cognitive:
            <select name="map" id="map">
                <option value="map1">Map_1</option>
                <option value="map2">Map_2</option>
                <option value="map3">Map_3</option>
            </select>
        </label>
        <input type="submit" name="submit" value="Afficher">
    </form>

    <?php
        if(!empty($_POST['submit'])){

            $choix_map = $_POST['map'];
            
            // On check si y'a un cookie correspondant
            if(isset($_COOKIE[$choix_map])){

                // Si il est set on check sa valeur
                if (intval($_COOKIE[$choix_map]) == 2){
                    $affichage = "nombre d'affichages max atteint";
                } else {
                    // On incremente le cookie
                    $val = strval(intval($_COOKIE[$choix_map])+1);
                    unset($_COOKIE[$choix_map]);
                    setcookie($choix_map, $val, time() + (10 * 365 * 24 * 60 * 60));
    
                    $affichage = "Affichage Autorisé il vous reste".(3-$val)."affichages";
                }
            } else {
                // Si il est pas set on le cree
                setcookie($choix_map, 1, time() + (10 * 365 * 24 * 60 * 60));
    
                $affichage = "Affichage Autorisé il vous reste 2 affichages";
            }
            echo $affichage;
        }
    ?>
</body>
</html>