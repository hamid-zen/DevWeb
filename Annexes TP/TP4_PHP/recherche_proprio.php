<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <fieldset>
        <legend>Coordoonées de la personne</legend>
        <label>Nom:</label><input type="text" name="nom">
        <label>Prénom:</label><input type="text" name="prenom">
        <input type="submit" name="search" value="Chercher">
    </fieldset>
</form>

<?php
if (isset($_POST['search'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    require_once("html_table.inc.php");
    require_once("connexpdo.inc.php");
    // On recupere les voiture du proprio
    $pdo = connexpdo("voitures");
    $requete = $pdo->prepare("SELECT immat, modele 
                            FROM ((proprietaire p NATURAL JOIN cartegrise g) 
                                                NATURAL JOIN voiture v) 
                                                NATURAL JOIN modele m 
                            WHERE nom=? AND prenom=?;");
    $requete->execute([$nom, $prenom]);
    $data = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    // On affiche le tableau
    affiche_tableau($data);
}
?>
