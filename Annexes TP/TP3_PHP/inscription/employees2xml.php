<?php

$headers = array("id", "name", "salary", "age");

$csv_filename = 'employees.csv';
$xml_filename = 'output.xml';

// On ouvre le csv
$csv_file = fopen($csv_filename, 'r');

// On cree notre nouveau doc avec le bon dtd
$doc  = new DomDocument();
$doc->appendChild((new DOMImplementation)->createDocumentType('employees', '', 'employees.dtd'));

// On ajoute le bon root
$root = $doc->createElement('employees');
$root = $doc->appendChild($root);

// On ittere sur chaque ligne du csv
while (($row = fgetcsv($csv_file, separator:";")) !== FALSE)
{
    // On cree un nouvel element de type employee
    $container = $doc->createElement('employee');
    foreach($headers as $i => $header)
    {
        // Pour chaque header on cree un element du meme nom 
        // Et on l'ajoute au nouvel employée
        $child = $doc->createElement($header);
        $child = $container->appendChild($child);

        // Ensuite on remplit ce nouvel element avec le texte correspondant
        $value = $doc->createTextNode($row[$i]);
        $value = $child->appendChild($value);
    }

    // On ajoute le nouvel employé 
    $root->appendChild($container);
}

// On enregistre le fichier
$strxml = $doc->saveXML();
$xml_file = fopen($xml_filename, "w");
fwrite($xml_file, $strxml);
fclose($xml_file);
?>