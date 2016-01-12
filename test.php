<?
class A
{
    public $name;
    protected $age;

    function getName()
    {
        return $this->name;
    }

    function __get($name)
    {
       return  "get".$name;
    }
}


class B extends A
{
    protected $wieght;



}

$A = new A();

echo $A->getName("Vadim");


?>