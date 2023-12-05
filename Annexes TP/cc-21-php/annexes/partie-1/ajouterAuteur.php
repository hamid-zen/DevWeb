<?php
require_once("connexpdo.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Examen sur Machine : Objets et Base de Données en PHP</title>
</head>
<body>
    <?php
    // TODO
    // Ajout d'un auteur en base --> prévenir l'utilisateur si ajout OK
    if (!empty($_POST['nom'])){

        // On commence par recupere toutes les données
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $ddn = $_POST['ddn'];
        $ddd = $_POST['ddd'];

        // On se connecte a la base
        require_once("connexpdo.inc.php");
        $pdo = connexpdo("l3info_cc_21_php_biblio");

        // On commence a crer notre requete d'ajout
        $sql = "INSERT INTO auteurs(id, prenom, nom, ddn, ddd) VALUES (default, ?,?,?,?)";

        // On execute maintenant notre requete (on catch une eventuelle exception)
        try {
            // On lui donne pour values a ajouter les valeurs dans le tableau assoc $infos
            $pdo->prepare($sql)->execute(array($prenom, $nom, $ddn, $ddd));
        } catch (PDOException $e) {
            echo "<script> alert({$e->getMessage()})</script>";
            exit;
        }

        echo "<script> alert(\"Insertion de $nom,$prenom Reussie\")</script>";
    }
    ?>
    <p><a href="index.php">Home</a></p>
</body>
</html>
