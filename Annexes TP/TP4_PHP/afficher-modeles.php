<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title>Lecture de la table modele</title>
	<style type="text/css">
		table,
		tr,
		td,
		th {
			border-style: solid;
			border-color: red;
			background-color: yellow;
		}

		table {
			border-width: 3px;
			border-collapse: collapse;
		}

		tr,
		td,
		th {
			border-width: 1px;
		}
	</style>
</head>

<body>
	<?php
	// On commence par se connecter a la base
	require_once("connexpdo.inc.php");
	$pdo = connexpdo("voitures");

	// On lance la requete pour recuperer les données
	$requete = $pdo->prepare("SELECT m.id_modele AS 'Code modele', m.modele AS 'Modele', m.carburant AS 'Carburant' 
								FROM modele m 
								ORDER BY m.modele;");
	$requete->execute();
	$data = $requete->fetchAll(PDO::FETCH_ASSOC);

	// On affiche les données
	require_once("html_table.inc.php");
	affiche_tableau($data);
	?>
</body>

</html>