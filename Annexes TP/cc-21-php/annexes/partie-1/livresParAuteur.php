<?php
require_once("connexpdo.inc.php");

function afficherCellule($value)
{
    echo "<td>$value</td>";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Examen sur Machine : Objets et Base de Données en PHP</title>
    <style>
        table {
            text-align: center;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date de publication</th>
                <th>Auteur</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // TODO
            // Afficher la liste des Livres de l'auteur sélectionné
            if (isset($_GET)){
                // On commence par recuperer l'auteur
                $id = $_GET['auteur'];
                
                // On se connecte a la base
                require_once("connexpdo.inc.php");
                $pdo = connexpdo("l3info_cc_21_php_biblio");

                // On prepare la requete sql et on la lance
                $stmt = $pdo->prepare("SELECT titre,ddp,id_auteur FROM livres WHERE id_auteur=?");
                $stmt->execute([$id]); 
                $livres = $stmt->fetchAll(PDO::FETCH_NUM);

                // On affiche chaque ligne
                foreach ($livres as $row) {
                    echo "<tr>";
                    array_walk($row, "afficherCellule");
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <p><a href="index.php">Home</a></p>
</body>
</html>
