<tr>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <td>Immatriculation</td>
        <td><input type="text" name="immat" list="list"></td>
        <td><input type="submit" name="search" value="Chercher Voiture"></td>
    </form>
    <?php

        // function afficher_option($value)
        // {
        //     echo "<option value=\"{$value[0]}\">{$value[0]}</option>";
        // }

        if(isset($_POST['search'])){

            // On recupere la partie de l'immat donnée et on cree un pattern de recherche
            $pattern = '%'.$_POST['immat'].'%';

            // On lance une recherche sur le pattern
            require_once("connexpdo.inc.php");
            $pdo = connexpdo("voitures");
            $requete = $pdo->prepare("SELECT immat
                                    FROM cartegrise
                                    WHERE UPPER(immat) LIKE UPPER(:pattern)"); // Upper pour ignorer la case
            $requete->execute([':pattern' => $pattern]);
            $data = $requete->fetchAll(PDO::FETCH_NUM);

            // Maintenant qu'on a la data on affiche le menu deroulant
            echo "<datalist id=\"list\">";
                array_walk($data, 'afficher_option');
            echo "</datalist>";
        }
    ?>