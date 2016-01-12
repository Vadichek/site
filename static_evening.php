<?

abstract class DomainObject
{
    private $group;

    public function __construct()
    {
        $this->group = static::getGroup();
    }

    public static function createObj()
    {
        return new static();
    }

    public static function getGroup()
    {
        return "default";
    }
}

class User extends DomainObject
{

}

class Document extends DomainObject
{
    static function getGroup()
    {
        return "document";
    }
}

class spreadSheet extends Document
{

}

var_export(User::createObj());
var_export(spreadSheet::createObj());

abstract class A
{

    public static function create()
    {
        return new static();
    }

    public static function getName($name)
    {
        return __CLASS__;
    }
}

class B extends A
{
    public static function getName($name)
    {
        return __CLASS__;
    }
}

class C extends B
{

}

$nameB = B::getName('Vadim');
$nameC = C::getName("VadimC");


var_export($nameC);
//var_export($nameC);

?>
<!-- Позднее статическое связывание сайт-php -->
<?php
//class A {
//    private function foo() {
//        echo "success!\n";
//    }
//    public function test() {
//        $this->foo();
//        static::foo();
//    }
//}
//
//class B extends A {
//
//    /* foo() будет скопирован в В, следовательно его область действия по прежнему А,
//       и вызов будет успешен*/
//}
//
//class C extends A {
//    public function foo() {
//      echo "!!!";  /* исходный метод заменен; область действия нового метода С */
//    }
//}
//
//$b = new B();
//$b->test();
//$c = new C();
//$c->test();   //не верно
//
?>
