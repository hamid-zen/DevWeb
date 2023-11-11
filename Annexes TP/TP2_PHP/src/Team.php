<?php
namespace Acme;

require_once __DIR__ . '/../vendor/autoload.php';
class Team
{
    private $equipe;

    public function __construct() {
        $this->equipe = array();
    }

    public function getEquipe(){
        return $this->equipe;
    }

    public function add($emp){
        array_push($this->equipe, $emp);
    }

    public function __tostring(){

        $str = "subordinates=[";

        array_walk($this->equipe, function ($emp) use(&$str) {
            if (is_a($emp, 'Acme\Employee') and !is_a($emp, 'Acme\Manager'))
                $str .= $emp->getName().' ';
        });

        $str .= " ]";
    
        return $str;
    }
}

    $test = new Team();

    echo $test;

    $test->add(new Employee(2, "Pif", 10, 10));
    $test->add(new Employee(2, "Paf", 10, 10));
    $test->add(new Employee(2, "Pouf", 10, 10));
    $test->add(new Manager(2, "Pouf", 10, 10));
    echo $test;var_dump($test);
?>