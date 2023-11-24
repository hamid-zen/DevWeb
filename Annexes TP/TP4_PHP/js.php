<?php

function js(string $code)
{
    echo "<script type=\"text/javascript\">$code</script>";
}

function console(string $str)
{
    js("console.log(\"" . htmlentities($str) . "\");");
}

function alert(string $str)
{
    js("alert(\"$str\");");
}

function displayException(PDOException $e)
{
    // On commence par afficher le fichier qui a throw l'exception
    console("Fichier : ".$e->getFile());

    // Ensuite la ligne
    console("Ligne : ".$e->getLine());

    // Ensuite le message
    console($e->getMessage());

    // On affiche une alerte avec le code sql
    alert("Code SQL : ".$e->getCode());

}
?>