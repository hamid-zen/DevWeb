<?php
    /**
     * module 'bdd_select'
     * 
     * function select_map(...)
     * function select_nodes(...) 
     * function select_arcs(...) 
     * 
     * Pour récupèrer les arcs dans une carte, en utilisant 
     * seulement son identifiant (<map_id>), utilisez la query suivante:
     * 
        SELECT a.id AS arc, a.head, a.tail, sl.value AS s_label, il.value AS i_label 
        FROM ARC a 
            LEFT JOIN SYMBOLIC_LABEL sl ON a.id = sl.arc
            LEFT JOIN INT_LABEL il      ON a.id = il.arc
        WHERE
            a.head IN (SELECT id FROM NODE where map=<map_id>) OR
            a.tail IN (SELECT id FROM NODE where map=<map_id>)";
     */

     // Construction PDO
    function connexpdo(string $db)
    {
        $sgbd = "mysql"; // choix de MySQL
        $host = "localhost";
        $charset = "UTF8";
        // LOGIN ET MOT DE PASSE A CONFIGURER
        $user = "root"; // user id
        $pass = "J8sK33"; // password
        try {
            $pdo = new PDO("$sgbd:host=$host;dbname=$db;charset=$charset", $user, $pass);
            // force le lancement d'exception en cas d'erreurs d'exécution de requêtes SQL
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getTrace();
            exit;
        }
    }

    function select_map(int $id) {

        // On commence par se connecter a la base
        $pdo = connexpdo("l3_cc_23_php_map");

        // Ensuite on lance la requete
        $stmt = $pdo->prepare("SELECT * FROM MAP WHERE id=?;");
        $stmt->execute([$id]); 
        $map = $stmt->fetch(PDO::FETCH_ASSOC); // PDO::FETCH_NUM par exemple

        return $map;
    }

    function select_nodes(int $id) {

        // On commence par se connecter a la base
        $pdo = connexpdo("l3_cc_23_php_map");

        // Ensuite on lance la requete
        $stmt = $pdo->prepare("SELECT * FROM NODE WHERE MAP=?;");
        $stmt->execute([$id]); 
        $nodes = $stmt->fetchAll(PDO::FETCH_ASSOC); // PDO::FETCH_NUM par exemple

        return $nodes;

    }

    function select_arcs(int $id) {


        // On commence par se connecter a la base
        $pdo = connexpdo("l3_cc_23_php_map");

        // Ensuite on lance la requete
        $stmt = $pdo->prepare("SELECT a.id AS arc, a.head, a.tail, sl.value AS s_label, il.value AS i_label 
                                FROM ARC a 
                                    LEFT JOIN SYMBOLIC_LABEL sl ON a.id = sl.arc
                                    LEFT JOIN INT_LABEL il      ON a.id = il.arc
                                WHERE
                                    a.head IN (SELECT id FROM NODE where map=?) OR
                                    a.tail IN (SELECT id FROM NODE where map=?);");
        $stmt->execute([$id, $id]); 
        $arcs = $stmt->fetchAll(PDO::FETCH_ASSOC); // PDO::FETCH_NUM par exemple

        return $arcs;    
    }
?>

