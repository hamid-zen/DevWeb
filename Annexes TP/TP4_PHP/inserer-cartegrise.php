<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title>Saisissez les caractéristiques du modèle</title>
</head>

<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="form1" method="post"
		enctype="application/x-www-form-urlencoded">
		<fieldset>
			<legend>
				<b>Enregistrement d'un véhicule</b>
			</legend>
			<table>
				<tr>
					<td colspan="2"><b>Propriétaire</b></td>
				</tr>
				<?php require_once("select-proprietaire.php"); ?>
				<tr>
					<td colspan="2"><b>Voiture</b></td>
				</tr>
				<?php require_once("select-voiture.php"); ?>
				<tr>
					<td colspan="2"><b>Carte grise</b></td>
				</tr>
				<?php require_once("input-cartegrise.php"); ?>
				<tr>
					<td><input type="reset" value="Effacer" /></td>
					<td><input type="submit" name="enreg" value="ENREGISTRER" /></td>
				</tr>
			</table>
		</fieldset>
	</form>
	<?php
	if (isset($_POST['enreg'])){
		// On recupere les données
		$id_pers = $_POST['nom_prenom'];
		$immat = $_POST['immat'];
		$date = $_POST['datecarte'];


		// Ensuite on lance la requete d'insertion
		require_once("connexpdo.inc.php");
		require_once("js.php");

		$pdo = connexpdo("voitures");
		$insertion = "INSERT INTO cartegrise(id_pers, immat, datecarte) VALUES (?,?,?)";

		try {
			$pdo->prepare($insertion)->execute([$id_pers, $immat, $date]);

			// On affiche une alerte pour la reussite
			alert("Ajout de la voiture immatriculée ".$immat." pour le proprio choisi");
		} catch (PDOException $e) {
			displayException($e);
			exit;
		}
	}
	?>
</body>

</html>