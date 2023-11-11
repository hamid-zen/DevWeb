<?php 
namespace Acme;
require_once __DIR__ . '/../vendor/autoload.php';

use Acme\Employee;
use Acme\Manager;

$emp = new Employee(2, "Pif", 10, 10);
$man = new Manager(0, "John", 2000.0, 40);

$ref = new \ReflectionClass($emp);


echo "**Classe : <br>" . get_class($emp) . "<br>";

echo "**Classe Parent : <br>" . (($ref->getParentClass() == false) ? "Pase de classe Parent" : $ref->getParentClass()->getName()) . "<br>";

echo "**Propriétés visibles ayant une valeur par défaut : <br>";
print_r(array_filter($ref->getDefaultProperties()));

echo "<br>**Propriétés publique : <br>";
print_r(get_object_vars($emp));

echo "<br>**Toutes les propriété : <br>";
$props = $ref->getProperties();
$allProps = array();// Pour stocker toutes les proprietes


array_walk($props, function ($value, $key) use(&$allProps, $emp){
    $allProps[$value->getName()] = $value->getValue($emp);
});

print_r($allProps);
?>