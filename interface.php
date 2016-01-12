<?
interface IntPrice{
    public function getPrice();
}

interface IntTitle{
    public function getTitle();
}


class shopProduct implements IntPrice,IntTitle
{
    private $title;
    protected $productMainName;
    protected $productFirstName;
    protected $price;

    function __construct($title, $productMainName, $productFirstName, $price)
    {
        $this->title = $title;
        $this->productMainName = $productMainName;
        $this->productFirstName = $productFirstName;
        $this->price = $price;
    }

    public function getPrice(){
        return ($this->price);
    }

    public function getTitle(){
        return ($this->title);
    }
}


class CDproduct extends ShopProduct implements IntPrice,IntTitle
{
    private $playLength;

    function __construct($title, $productMainName, $productFirstName, $price, $playLength)
    {
        parent::__construct($title, $productMainName, $productFirstName, $price);
        $this->playLength = $playLength;
    }

    function getPlayLength()
    {
        return "$this->playLength";
    }

    function getSummaryLine()
    {
        $base = parent::getSummaryLine();
        $base .= " Время проигрывания $this->playLength";
        return $base;
    }

}

$products = new CDproduct("Заголовок","Продукт","Мирко","100$","100min");

echo $products->getPrice();
?>