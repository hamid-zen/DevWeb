<?php
    /**
     * module 'bdd_insert'
     * 
     * function insert_map(...)
     * function insert_nodes(...) 
     * function insert_arcs(...) 
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

     function insert_map(string $name, int $nr_nodes, int $nr_arcs){
        // On commence par se connecter a la base
        $pdo = connexpdo("l3_cc_23_php_map");

        // On commence a creer notre requete d'ajout
        $sql = "INSERT INTO MAP(ID, NAME, NUM_NODES, NUM_ARCS) VALUES (default, ?, ?, ?)";

        // On execute maintenant notre requete (on catch une eventuelle exception)
        try {
            // On lui donne pour values a ajouter les valeurs dans le tableau assoc $infos
            $pdo->prepare($sql)->execute(array($name, $nr_nodes, $nr_arcs));
        } catch (PDOException $e) {
            displayException($e);
            exit;
        }
     }

     function insert_nodes(array $nodes) {
        // On commence par se connecter a la base
        $pdo = connexpdo("l3_cc_23_php_map");

        // On commence a creer notre requete d'ajout
        $sql = "INSERT INTO NODE(ID, MAP, NAME, NODE_NUM) VALUES (default, ?, ?, ?)";

        foreach ($nodes as $node) {
            try {
                // On lui donne pour values a ajouter les valeurs dans le tableau assoc $infos
                $pdo->prepare($sql)->execute(array($node['map'], $node['name'], $node['node_num']));
            } catch (PDOException $e) {
                displayException($e);
                exit;
            }
        }
     }

     function insert_arcs(array $arcs) {
        // On commence par se connecter a la base
        $pdo = connexpdo("l3_cc_23_php_map");

        // On commence a creer notre requete d'ajout
        $sql = "INSERT INTO ARCS(ID, TAIL, HEAD) VALUES (?, ?, ?)";

        foreach ($arcs as $arcs) {
            try {
                // On lui donne pour values a ajouter les valeurs dans le tableau assoc $infos
                $pdo->prepare($sql)->execute(array($arcs['id'], $arcs['tail'], $arcs['head']));
            } catch (PDOException $e) {
                displayException($e);
                exit;
            }
        }
     }
?>