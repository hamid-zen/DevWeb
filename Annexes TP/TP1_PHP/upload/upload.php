<!DOCTYPE html>
<html>
<head>
<title>Téléversement de fichier</title>
</head>
<body>
	<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post"
		enctype="multipart/form-data">
		<fieldset>
			<legend>
				<b>Transférez un fichier ZIP</b>
			</legend>
			<table border="1">
				<tr>
					<td>Choisissez un fichier</td>
					<td><input type="file" name="fich" accept="application/zip" /></td>
					<td><input type="hidden" name="MAX_FILE_SIZE" value="1000000" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" value="ENVOI" /></td>
				</tr>
			</table>
		</fieldset>
	</form>
</body>
</html>
<?php

	// On check le bon envoi du formulaire
	// Qu'un fichier a ete envoyé
	if (isset($_POST["MAX_FILE_SIZE"]) && 
		!empty($_FILES) && 
		$_FILES["fich"]["name"] != '') {

		// On check bien que le fichier est un zip et qu'il a la bonne taille
		if ($_FILES["fich"]["type"] == "application/zip" && 
			intval($_FILES["fich"]["type"]) < intval($_POST["MAX_FILE_SIZE"])) {

			// On affiche les infos
			echo "<b> VOUS AVEZ BIEN TRANSFERÉ LE FICHIER</b> <hr>";
			echo "<pre>Le nom du fichier est ".$_FILES['fich']['name']."</pre> <hr>";
			echo "<pre>La taille du fichier est ".$_FILES['fich']['size']."</pre> <hr>";
		}
	}
?>
