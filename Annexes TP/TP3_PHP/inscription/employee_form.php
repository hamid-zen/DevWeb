<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>TP PHP - Inscription d'employés</title>
</head>

<body style="background-color: #ffcc00;">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <fieldset>
            <legend><b>Inscrire un employé</b></legend>
            <label>Nom :&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="nom" value="" size="30" maxlength="60" required="required" /><br /><br />
            <label>Salaire :&nbsp;</label>
            <input type="number" name="salaire" min="0" max="100000" step="5000" size="6"
                required="required" /><br /><br />
            <label>Age :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="number" name="age" min="18" max="100" size="6" required="required" /><br /><br />
            <input type="submit" value="Inscrire" name="inscrire" />
        </fieldset>
    </form>
    <?php
    session_start();

    // On commence par ouvrir le fichier en append
    $csv_file = fopen("employees.csv", 'a+');

    // On check la transmission du formulaire
    if (!empty($_POST["inscrire"])) {

        // On recupere les données
        $nom = $_POST["nom"];
        $salaire = $_POST["salaire"];
        $age = $_POST["age"];

        // On check si la personne est presente
        // Soit aucune données soit aucune personne correspondante
        // (filtre selon age et nom n'a rien donné)
        $ajout_possible = (!isset($_SESSION["csv_data"]) ||
            count(
                array_filter(
                    $_SESSION["csv_data"],
                    function ($a) use($nom, $age) {
                        return ($a[1] == $nom && $a[3] == $age); }
                )
            ) == 0
        );
        
        if ($ajout_possible) {

            // On doit recupere l'id
            // (dernier id ajouté + 1)
            // On check si on a un last_id
            if (isset($_SESSION["last_id"])) {
                $id = $_SESSION["last_id"] + 1;
                $_SESSION["last_id"]++;
            } else {
                $id = 0;
                // On le rajoute a la session
                $_SESSION["last_id"] = 0;
            }

            // On met ensuite la nouvelle ligne dans le fichier
            flock($csv_file, LOCK_EX);
            fwrite($csv_file, $id . ";" . $nom . ";" . $salaire . ";" . $age . "\n");
            flock($csv_file, LOCK_UN);

            // On met les infos dans notre session
            if (!isset($_SESSION["csv_data"]))
                $_SESSION["csv_data"] = array();
            array_push($_SESSION["csv_data"], array($id, $nom, intval($salaire), intval($age)));
        }
        else
            echo "$nom d'age $age : vous etes deja inscrits !";

    }
    fclose($csv_file);
    var_dump($_SESSION);
    ?>
</body>

</html>