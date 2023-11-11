<?php

namespace Acme;

require_once __DIR__ . '/../vendor/autoload.php';
use Acme\Employee;

$array = array(
    new Employee(1, "superman", 1.27, 80),
    new Employee(2, "batman", 1, 73),
    new Employee(3, "spiderman", 0.82, 50)
);

array_walk($array, function ($a) {
    echo $a . "<br>";
});

$mean = array_reduce($array, function ($carry, $item) {
    return $carry + $item->getSalary();
}) / count($array);

echo "Moyenne salaires : ", $mean;
?>