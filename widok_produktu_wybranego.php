<?php
			session_start();
			if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
			unset($_SESSION['uzytkownik']);
			session_destroy();
			header('Location: widok_logowanie.html');
			}

	include('include/PHPTAL.php'); 
    $template = new PHPTAL('widok_produktu_wybranego.html');
	$id=$_SESSION['id_u'];
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
	class Opinie{
		public $imie;
		public $nazwisko;
		public $opinia;
		function __construct($imie,$nazwisko,$opinia){
			$this->imie=$imie;
			$this->nazwisko=$nazwisko;
			$this->opinia=$opinia;		
		}
	}
	$id_p=isset($_GET['id']) ? $_GET['id'] : '0';
	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=magazyn", "root", "");
		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$q="SELECT * FROM produkty where id=:id_p";
        $stm=$conn->prepare($q);
		$stm->bindParam(':id_p',$id_p);
	    $stm->execute();
	   
		foreach($stm as $row)
		{
			$Products=new Product($row['id'],$row['nazwa'],$row['ilosc'],$row['cena'],$row['opis'],$row['zdjecie'],$row['id_producenta']);
		}
		$template->Products=$Products;
		$q="SELECT pracownik FROM uzytkownik where id=:id";
        $stm=$conn->prepare($q);
		$stm->bindParam(':id',$id);	
	    $stm->execute();
	    	
		foreach($stm as $row)
		{
			$Czy_pracownik=$row['pracownik'];
		}
		
		if($Czy_pracownik=='1')
			$template->pracownik="Edytuj produkt";
		else
			$template->pracownik=null;
		
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
