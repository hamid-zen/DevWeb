<?php
namespace Acme;

require_once __DIR__ . '/../vendor/autoload.php';
use Acme\Employee;

$array = array(
    new Employee(1, "superman", 1.27, 80),
    new Employee(2, "batman", 1, 73),
    new Employee(3, "spiderman", 0.82, 50)
);

$array2 = usort($array, fn($a, $b) => $a <=> $b);
var_dump($array);
?>