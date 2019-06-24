<?php
			session_start();
			if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
			unset($_SESSION['uzytkownik']);
			session_destroy();
			header('Location: widok_logowanie.html');
			}

	include('include/PHPTAL.php'); 
    $template = new PHPTAL('widok_produkty.html');
	 
	class Product{
		public $id;
		public $name;
		public $quantity;
		public $cost;
		public $description;
		public $foto;
		public $type;
		public $id_producer;
		
		function __construct($id, $name,$quantity,$cost,$description,$foto,$id_producer,$type) {
			$this->id = $id;
			$this->name = $name;
			$this->quantity = $quantity;
			$this->cost = $cost;
			$this->type=$type;
			$this->description=$description;
			$this->foto = $foto;
			$this->id_producer = $id_producer;
		}
	}
	class Number{
	public $n;
	public $type;
		function __construct($n,$type)
		{
			$this->n=$n;
			$this->type=$type;
		}
	
	}
	$list_products=array();
	$product=isset($_GET['product']) ? $_GET['product'] : 'szafa';
	$ilosc_rekordow_na_stronie=5;
	$p=isset($_GET['p']) ? $_GET['p'] : '0';
	$min=($p*$ilosc_rekordow_na_stronie)-$ilosc_rekordow_na_stronie;
	$max=$p*$ilosc_rekordow_na_stronie;
	
	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=magazyn", "root", "");
		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q="SELECT * FROM produkty where typ=:product ";
		$stm = $conn->prepare($q);
	    $stm->bindParam(':product',$product);
		$stm->execute();
	
			$i=0;
		foreach($stm as $row)
		{	$i++;
		}
		$tablica=array();
		$j=1;
		for($x=0;$x<$i;$x=$x+$ilosc_rekordow_na_stronie)
		{
			$tablica[]=new Number($j++,$product);
		}
			$template->tablica=$tablica;
			
		$q="SELECT * FROM produkty where typ=:product";
		$stm = $conn->prepare($q);
	    $stm->bindParam(':product',$product);
		$stm->execute();
		$i=1;
		foreach($stm as $row)
		{
			if($i>($p-1)*5 && $i<=($p)*5){
			$list_products[]=new Product($row['id'],$row['nazwa'],$row['ilosc'],$row['cena'],$row['opis'],$row['zdjecie'],$row['id_producenta'],$row['typ']);
			$i++;
			}
			else
				$i++;
		}
		$template->list=$list_products;
	
		try {
			echo $template->execute();
		}
		catch (Exception $e){
			echo $e;
		$stm = null;
	}
	}
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}
	

	$pdo = null;
	

?>
