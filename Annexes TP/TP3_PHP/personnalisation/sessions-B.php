<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>TP PHP - Personnalisation avec sessions</title>
    <style type="text/css">
        /* A COMPLETER */
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
        session_start();
        var_dump($_SESSION);
    ?>
   <p>Contenu de la page B avec les couleurs choisies <br />
   <a href="sessions.php">Retour vers la page principale</a>
</p>
</body>
</html>