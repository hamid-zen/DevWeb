<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>TP PHP - Personnalisation avec cookies</title>
    <style type="text/css">
        <?php 
        
            // On verifie l'envoi du formulaire
            if ($_POST){

                $fond = "";
                $texte = "";

                // On verifie si on ne soumet pas des couleurs
                if (empty($_POST["fond"]) && empty($_POST["texte"])) {

                    // On verfie si les cookies sont toujours valides
                    if (isset($_COOKIE["fond"]) && isset($_COOKIE["texte"])){
                        $fond = $_COOKIE["fond"];
                        $texte = $_COOKIE["texte"];
                    }
                    // Sinon valeurs par defaut
                    else{
                        $fond = "white";
                        $texte = "black";
                    }
                }
                // Si on soumet des couleurs alors on cree nos cookies
                else {
                    $fond = $_POST["fond"];
                    $texte = $_POST["texte"];

                    setcookie("fond", $fond, time()+20);
                    setcookie("texte", $texte, time()+20);
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
    <form method="post" action="cookies.php">
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
</body>

</html>