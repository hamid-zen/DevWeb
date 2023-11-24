<?php
function connexpdo(string $db)
{
    $sgbd = "mysql"; // choix de MySQL
    $host = "localhost";
    $charset = "UTF8";
    // LOGIN ET MOT DE PASSE A CONFIGURER
    $user = "root"; // user id
    $pass = "Admin"; // password

    try {
        $pdo = new PDO("$sgbd:host=$host;dbname=$db;charset=$charset", $user, $pass);
        // force le lancement d'exception en cas d'erreurs d'exécution de requêtes SQL
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // On commence par afficher le fichier qui a throw l'exception
        var_dump("Fichier : ".$e->getFile());

        // Ensuite la ligne
        var_dump("Ligne : ".$e->getLine());

        // Ensuite le message
        var_dump($e->getMessage());
    }

}
?>