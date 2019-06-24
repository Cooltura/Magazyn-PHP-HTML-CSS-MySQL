<?php
			session_start();
			if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
			unset($_SESSION['uzytkownik']);
			session_destroy();
			header('Location: widok_logowanie.html');
			}
			
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
	
	include('include/PHPTAL.php'); 
    $template = new PHPTAL('edytowanie_produktu.html');
	
	$id_u=isset($_SESSION['id_u']) ? $_SESSION['id_u'] : '0';
	$id_produktu=isset($_GET['id']) ? $_GET['id'] : '0';
	$do=isset($_GET['o']) ? $_GET['o'] : 'w';
	$timestamp = time();
	if($do=="e")
	{
		if ($_FILES['zdjecie']['name']!=null){
			if ($_FILES['zdjecie']['type'] != 'image/jpeg'){
			$info="Nie wysłano prawidlowego zdjecia ";
			$template->info=$info;
			}		
		
			else if ($_FILES['zdjecie']['error'] > 0){
				switch ($_FILES['zdjecie']['error']) {
					case 1: {
						$info="Rozmiar pliku jest zbyt duży";
						$template->info=$info;
					}
					case 2: {
						$info="Rozmiar pliku jest zbyt duży";
						$template->info=$info;
					}
						
					case 3: {
						$info="Plik wysłany tylko częściowo";
						$template->info=$info;
					}
					case 4: {
						$info="Nie wysłano żadnego pliku";
						$template->info=$info;
					}		  
					default: {
						$info="Wystąpił błąd podczas wysyłania";
						$template->info=$info;
							}	
					} 
			}	
			else {		
				$lokalizacja = "zdjecia/$timestamp.jpg";
		        if(is_uploaded_file($_FILES['zdjecie']['tmp_name']))
			    {
			        if(!move_uploaded_file($_FILES['zdjecie']['tmp_name'], $lokalizacja)) {
				      $info="Nie udało się skopiować zdjecia do katalogu";
			          $template->info=$info;
			    }
				
			}
		}
		$timestamp=$timestamp. ".jpg";
	    }
		else{
		$timestamp =isset($_GET['z']) ? $_GET['z'] : 'brak_zdjecia';
		}

		$e_name=isset($_POST['name']) ? $_POST['name'] : 'name';
		$e_quantity=isset($_POST['sztuki']) ? $_POST['sztuki'] : '0';
		$e_cost=isset($_POST['cena']) ? $_POST['cena'] : '0';
		$e_description=isset($_POST['opis']) ? $_POST['opis'] : 'opis';
		$e_type=isset($_POST['typ']) ? $_POST['typ'] : 'szafa';
		$e_id_producer=isset($_POST['id_producenta']) ? $_POST['id_producenta'] : '0';
		try{
	$conn = new PDO("mysql:host=localhost;dbname=magazyn", "root", "");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$update = "UPDATE produkty SET nazwa=:name,ilosc=:quantity,cena=:cost,zdjecie=:foto,typ=:typ,opis=:description,id_producenta=:id_producer WHERE id=:id_p";
		$stm = $conn->prepare($update);	
		$stm->bindParam(':id_p',$id_produktu);
		$stm->bindParam(':quantity',$e_quantity);
		$stm->bindParam(':name',$e_name);
		$stm->bindParam(':cost',$e_cost);
		$stm->bindParam(':description',$e_description);
		$stm->bindParam(':typ',$e_type);
		$stm->bindParam(':id_producer',$e_id_producer);
		$stm->bindParam(':foto',$timestamp);
		$stm->execute();
		
	$stm=null;
	$PDO = null;
	header("Location:widok_produktu_wybranego.php?id=$id_produktu");
	}
	catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
	}
	else if($do=='w') {
		try{
	$conn = new PDO("mysql:host=localhost;dbname=magazyn", "root", "");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	

	$stmt = $conn->query("SELECT * from produkty where id='$id_produktu'");	
	foreach($stmt as $row)
		{
			$Products=new Product($row['id'],$row['nazwa'],$row['ilosc'],$row['cena'],$row['opis'],$row['zdjecie'],$row['id_producenta']);
		}
		$template->Produkt=$Products;
		
	$stm=null;
	$PDO = null;
	try {
				echo $template->execute();
			}
			catch (Exception $e){
				echo $e;
	    }
	}
catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}


	
}
    else
	header('Location: widok_produkty.php');

?>

