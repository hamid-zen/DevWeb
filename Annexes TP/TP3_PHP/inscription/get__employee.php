<?php
// On recupere le nom et l'age
$name = $_GET['name'];
$age = intval($_GET['age']);

// On lance une instance de simplexml
$xml = simplexml_load_file("output.xml") or die("Error: Cannot create object");

// On recherche le bon employee
$employee = $xml->xpath("//employee[name='$name' and age=$age]")[0];

echo "employee: id={$employee->id} name={$employee->name} salary={$employee->salary} age={$employee->age}";
?>