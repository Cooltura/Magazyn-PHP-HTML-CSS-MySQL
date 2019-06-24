<?php
			session_start();
			if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
			unset($_SESSION['uzytkownik']);
			session_destroy();
			header('Location: widok_logowanie.html');
			}

	include('include/PHPTAL.php'); 
    $template = new PHPTAL("widok_nowe_produkty.html");
	 
	class Product{
		public $id;
		public $name;
		public $quantity;
		public $cost;
		public $description;
		public $foto;
		public $id_producer;
		
		function __construct($id, $name,$quantity,$cost,$description,$foto,$id_producer) {
			$this->id = $id;
			$this->name = $name;
			$this->quantity = $quantity;
			$this->cost = $cost;
			$this->description=$description;
			$this->foto = $foto;
			$this->id_producer = $id_producer;
		}
	}
	$list_products=array();
	
	$product=isset($_GET['product']) ? $_GET['product'] : 'lozko';

	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=magazyn", "root", "");
		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt2 = $conn->query("SELECT * FROM produkty where ilosc>0");
			$i=0;
		foreach($stmt2 as $row)
		{	$i++;
		}
		$min=$i-12;
	
		$q="SELECT * FROM produkty where ilosc>0 && id>:min ORDER BY id DESC ";
		$stm = $conn->prepare($q);
	    $stm->bindParam(':min',$min);
		$stm->execute();
		foreach($stm as $row)
		{
			$list_products[]=new Product($row['id'],$row['nazwa'],$row['ilosc'],$row['cena'],$row['opis'],$row['zdjecie'],$row['id_producenta']);
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
