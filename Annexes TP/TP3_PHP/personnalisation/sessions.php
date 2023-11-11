<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>TP PHP - Personnalisation avec sessions</title>
    <style type="text/css">
        <?php
        $fond = "";
        $texte = "";
        session_start();
        // On verifie l'envoi du formulaire
        if ($_POST) {


            // On verifie si on ne soumet pas des couleurs
            if (empty($_POST["fond"]) && empty($_POST["texte"])) {

                // On verfie si les sessions sont toujours valides
                if (isset($_SESSION["fond"]) && isset($_SESSION["texte"])) {
                    $fond = $_SESSION["fond"];
                    $texte = $_SESSION["texte"];
                }
                // Sinon valeurs par defaut
                else {
                    $fond = "white";
                    $texte = "black";
                }
            }
            // Si on soumet des couleurs alors on cree nos sessions
            else {
                $fond = $_POST["fond"];
                $texte = $_POST["texte"];

                $_SESSION["fond"] = $fond;
                $_SESSION["texte"] = $texte;
            }

        }
        ?>

        body {
            background-color: <?php echo $fond?>;
            color: <?php echo $texte?>;
        }
        legend {
            font-weight: bold;
            font-family: cursive;
        }

        label {
            font-weight: bold;
            font-style: italic;
        }
    </style>
</head>

<body>
    <?php
        var_dump($fond, $texte);
    ?>
    <form method="post" action="sessions.php">
        <fieldset>
            <legend>Choisissez vos couleurs (mot clé ou code)</legend>
            <label>Couleur de fond
                <input type="text" name="fond" />
            </label><br /><br />
            <label>Couleur de texte
                <input type="text" name="texte" />
            </label><br />
            <input type="submit" value="Envoyer" />&nbsp;&nbsp;
            <input type="reset" value="Effacer" />
        </fieldset>
    </form>

    <p>Contenu de la page principale <br />
        <a href="sessions-B.php">Lien vers la page B qui aura ces couleurs</a>
    </p>
</body>

</html>