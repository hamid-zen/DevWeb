<?php
namespace Acme;
require_once __DIR__ . '/../vendor/autoload.php';
use Acme\IManager;
use Acme\Employee;

class Manager extends Employee implements IManager
{

    private $ArrEmployeesId;

    public function __construct(int $id, string $name, float $salary, int $age)
    {
        new Employee($id, $name, $salary, $age);

        $this->ArrEmployeesId = array();
    }


    public function add(int $employeeId)
    {
        array_push($this->ArrEmployeesId, $employeeId);
    }

    public function getArrEmployeesId(): array
    {
        return $this->ArrEmployeesId;
    }
}


?>