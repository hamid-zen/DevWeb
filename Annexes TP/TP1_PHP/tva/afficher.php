<?php
// Calcul et génération taxe et coût TTC par article sous forme de ligne de tableau HTML
// $value : valeur de type array d'un élément du tableau $prix_taux
// $key : clé de type string d'un élément du tableau $prix_taux
// $param : paramètre additionnel de type string (couleur de fond CSS)
//
function taxe($value, $key, $param)
{
    $prixHT = $value["Prix"];
    $taux = $value["Taux"];
    $taxe = $prixHT * $taux;
    $prixTTC = $prixHT + $taxe;
    return
        <<<HTML
    <tr>
        <td style = "$param">$key</td>
        <td style = "$param">$prixHT</td>
        <td style = "$param">$taux</td>
        <td style = "$param">$taxe</td>
        <td style = "$param">$prixTTC</td>
    </tr>
HTML;

}

// Génération de tableau HTML
//
function generer_tableau($prix_taux)
{
    // On commence par initaliser un tableau html
    $code =
        <<<HTML
        <table style = "border-collapse: collapse; border: 1px solid black;">
            <thead>
                <tr>
                    <th style = "border: 1px solid black;">Article</th>
                    <th style = "border: 1px solid black;">Prix</th>
                    <th style = "border: 1px solid black;">Taux T.V.A</th>
                    <th style = "border: 1px solid black;">Taxe</th>
                    <th style = "border: 1px solid black;">Coût T.T.C</th>
                </tr>
            </thead>
            <tbody>
    HTML;

    // On ajoute toutes les lignes
    array_walk($prix_taux, function ($value, $key) use (&$code) {
        $code .= taxe($value, $key, 'border: 1px solid black;');
    });

    // On ajoute la fin du code html
    $code .=
        <<<HTML
        </tbody>
        </table>
    HTML;

    echo $code;
}

require("creer.php");

// Affichage du tableau
generer_tableau($prix_taux);

// tri du tableau
// On commence par trier notre array
// Par taux puis par prix
usort(
    $prix_taux,
    fn($a, $b) =>
        ((($a['Taux'] <=> $b['Taux']) != 0) ? $a['Taux'] <=> $b['Taux'] : $b['Prix'] <=> $a['Prix'])
);

// On rappelle pour generer un tableau
generer_tableau($prix_taux);
?>