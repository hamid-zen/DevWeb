<!DOCTYPE html >
<html>
<head>
    <meta charset="UTF-8" />
    <title>2023 CC-PHP Exercice 2</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
<?php
    require_once("bdd_select.php");

    var_dump(select_map(1));

    var_dump(select_nodes(1));

    var_dump(select_arcs(1));
?>
</body>
</html>

