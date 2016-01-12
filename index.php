<?
/*
$mysqli = new mysqli("localhost", "root", "", "phpZanstra");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if ($result = $mysqli->query("SELECT DATABASE()")) {
    $row = $result->fetch_row();
    printf("Default database is %s.\n", $row[0]);
    $result->close();
}
*/
class IdNotMatch extends Exception {
    public function __construct($id) {
        $this->message = "ID = $id меньше чем нужно.";
    }

}


class shopProduct
{
    private $title;
    protected $productMainName;
    protected $productFirstName;
    protected $price;
      
    function __construct($title, $productMainName, $productFirstName, $price)
    {

            //throw new Exception('Неверная цена.');
            $this->title = $title;
            $this->productMainName = $productMainName;
            $this->productFirstName = $productFirstName;
            $this->price = $price;
    }
    
    public function getProductMainName()
    {
        return "$this->productMainName";
    }
    
    public function getSummaryLine()
    {
        $base = "$this->productMainName " . "$this->productFirstName";
		return $base;
    }
	
	public static function getInstance($id, PDO $pdo)
	{

		$stmt = $pdo->prepare("select * from products where id=?");

        if ($id<2) {
            throw new IdNotMatch($id);
        }

		$result = $stmt->execute(array($id));
		$row = $stmt->fetch();		
		
		if(empty($row)){return NULL;}
		
		if($row["type"]== "book")
		{
		$product = new BookProduct (
			$row['title'],
			$row['firstname'],
			$row['mainname'],
			$row['price'],
			$row['numpages']		
			);
		}
		elseif($row["type"]== "CD")
		{
		$product = new CDproduct (
			$row['title'],
			$row['firstname'],
			$row['mainname'],
			$row['price'],
			$row['playlength']	
			);
		}
		else
		{	
		$product = new ShopProduct (
			$row['title'],
			$row['firstname'],
			$row['mainname'],
			$row['price']

		);
		}
		return $product;		
	}
}

class CDproduct extends ShopProduct
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

class BookProduct extends ShopProduct
{
    private $numPages;
	
	function __construct($title, $productMainName, $productFirstName, $price, $numPages)
	{
		parent::__construct($title, $productMainName, $productFirstName, $price);
		$this->numPages = $numPages;
	}
    
    function getNumPages()
    {
        return $this->numPages;
    }
    
    function getSummaryLine()
    {
        $base = "$this->productMainName " . "$this->productFirstName";
        $base .= " Количество страниц $this->numPages";
        return $base;
    }
    
}

//$CDproduct = new CDproduct("CDISK", "BOGDANOVA", "NADIA", "100$", "100 min");
//var_export($CDproduct);

//$BookProduct = new BookProduct("BOOK", "ZAVGORODNY", "VADIM", "50$", "300 pages");
//$ShopProduct = new ShopProduct("BOOK", "ZAVGORODNY", "VADIM", "50$");
//var_export($BookProduct);
//echo $CDproduct->getSummaryLine();
//echo $BookProduct->getSummaryLine();

/*Класс экзепляр которого принимает обязательный обьект класса shopProduct*/
abstract class ShopProductWrite
{

	protected $productArray = array();
	
	public function addProduct(shopProduct $shopProduct)
	{
		$this->productArray[] = $shopProduct;
	}
	
	public function getProductArray()
	{
		return $this->productArray;
	}
	
   /* public function write()
	{
	    foreach($this->productArray as $value)
		{
			echo $value->getNumPages();
		}
    }*/
	
	abstract public function write();
}

class TextProductWrite  extends ShopProductWrite{
    public function write()
        {
                foreach($this->productArray as $key=>$value)
                {
                        var_export($value);
                }
        }
}


//$shopProductWrite->write();

$dns = "mysql:host=localhost; dbname=phpZanstra;";

$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

$pdo = new PDO($dns,"root",NULL,$opt);
try{$obj = ShopProduct::getInstance(1, $pdo);
}catch (IdNotMatch $e){
    echo "!!!!";
}
//var_export($obj);
//$textProduct = new TextProductWrite();
//$textProduct->addProduct($ShopProduct);
//$textProduct->write();
//echo $obj->getSummaryLine();
?>