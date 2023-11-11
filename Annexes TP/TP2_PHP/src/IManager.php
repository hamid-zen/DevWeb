<?php
namespace Acme;

require_once __DIR__ . '/../vendor/autoload.php';

interface IManager extends IEmployee
{
    public function __construct(int $id, string $name, float $salary, int $age);
    public function add(int $employeeId);
    public function getArrEmployeesId(): array;
}
?>