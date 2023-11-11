<?php
namespace Acme;

require_once __DIR__ . '/../vendor/autoload.php';
use Acme\Employee;

function employee_raise($emp)
{
    if (is_a($emp, 'Employee'))
        $emp->setSalary($emp->getSalary() * 1.05);
    else
        throw new Exception("Le parametre n'est pas instance d'Employe");
}


$array = array(
    new Employee(1, "superman", 1.27, 80),
    new Employee(2, "batman", 1, 73),
    new Employee(3, "spiderman", 0.82, 50)
);

echo "Avant: <br>";

array_walk($array, function ($a) {
    echo $a . "<br>";
});

echo "<br> Apres <br>";

try {
    employee_raise($array[0]);
} catch (Exception $th) {
    echo $th->getMessage();
}

array_walk($array, function ($a) {
    echo $a . "<br>";
});

try {
    employee_raise(1);
} catch (Exception $th) {
    echo $th->getMessage();
}

?>