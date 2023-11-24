<?php
function afficherCelluleEntete($value)
{
    echo "<th>$value</th>";
}

function afficherCellule($value)
{
    echo "<td>$value</td>";
}

function affiche_tableau(array $data)
{
    echo "<table>";
    echo "<thead>";
    $keys = array_keys($data[0]);
    array_walk($keys, "afficherCelluleEntete");
    echo "</thead>";
    foreach ($data as $row) {
        echo "<tr>";
        array_walk($row, "afficherCellule");
        echo "</tr>";
    }
    echo "</table>";
}
?>