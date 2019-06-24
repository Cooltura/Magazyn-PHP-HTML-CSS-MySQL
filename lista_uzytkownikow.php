<?php
	session_start();
	if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
		unset($_SESSION['uzytkownik']);
		session_destroy();
		header('Location: widok_logowanie.html');
	}
			
	include('include/PHPTAL.php'); 
	$template = new PHPTAL('lista_uzytkownikow.html');
	
	class Person{
	public $id;
	public $imie;
	public $nazwisko;
	public $pracownik;
	function __construct($id,$imie,$nazwisko,$pracownik)
	{
		$this->id = $id;
		$this->imie = $imie;
		$this->nazwisko = $nazwisko;
		$this->pracownik = $pracownik;
	}
	public function czy_pracownik(){
		return $this->pracownik;
	}
}
	$Person=array();
				try 
				{
				$conn = new PDO("mysql:host=localhost;dbname=magazyn", "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
				$stmt = $conn->query("SELECT * FROM uzytkownik  ");	
				foreach($stmt as $row)
				{
					if($row['pracownik']=='1')
					$Person[]=new Person($row['id'],$row['imie'],$row['nazwisko'],"pracownik");
			  	    else
					$Person[]=new Person($row['id'],$row['imie'],$row['nazwisko'],"klient");
				}
						
				$template->list=$Person ;
	
				
				$stm = null;
				$pdo = null;
				echo $template->execute();
				}
				catch(PDOException $e)
				{
					echo "Connection failed: " . $e->getMessage();
				}	
				
?>
