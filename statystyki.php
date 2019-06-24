<?php
	session_start();
	if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
		unset($_SESSION['uzytkownik']);
		session_destroy();
		header('Location: widok_logowanie.html');
	}
	include('include/PHPTAL.php'); 
	$template = new PHPTAL('statystyki.html');
	class Shopping{
	public $id_sprzedazy ;
	public $id_kupujacego;
	public $nazwa_productu;
	public $ilosc_produktow ;
	public $cena_zakupow ;
	public $data_zakupu ;
	public $godzina_zakupu;
	function __construct($nazwa_productu,$ilosc_produktow,$cena_zakupow,$data_zakupu,$godzina_zakupu)
	{
		$this->nazwa_productu = $nazwa_productu;
		$this->ilosc_produktow = $ilosc_produktow;
		$this->cena_zakupow = $cena_zakupow;
		$this->data_zakupu = $data_zakupu;
		$this->godzina_zakupu = $godzina_zakupu;
	}
}

	class Sprzedane_produkty_dzien{
		public $data;
		public $suma;
		public $ilosc_zakupow;
		function __construct($data,$suma,$ilosc_zakupow){
		$this->data=$data;
		$this->suma=$suma;
		$this->ilosc_zakupow=$ilosc_zakupow;
		}
	}
	class Sprzedane_produkty_najlepsze{
		public $nazwa;
		public $suma;
		function __construct($nazwa,$suma){
		$this->nazwa=$nazwa;
		$this->suma=$suma;
		}
		
		
	}
	
	try 
				{
				$conn = new PDO("mysql:host=localhost;dbname=magazyn", "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
				
				$stmt = $conn->query("SELECT data_zakupu,SUM(cena_zakupow),count(id_sprzedazy) from sprzedaz group by data_zakupu order by data_zakupu desc LIMIT 5;");
				
				$Sprzedane_produkty_dzien=array();
				foreach($stmt as $row)
				{
					$Sprzedane_produkty_dzien[]=new Sprzedane_produkty_dzien($row['data_zakupu'],$row['SUM(cena_zakupow)'],$row['count(id_sprzedazy)']);	
				}
				$template->Sprzedane_produkty_dzien=$Sprzedane_produkty_dzien ;
				
$stmt = $conn->query("SELECT nazwa,count(id_sprzedazy) from sprzedaz INNER Join produkty ON sprzedaz.id_produktu=produkty.id group by id_produktu order by count(id_sprzedazy) desc LIMIT 5;");
				$Sprzedane_produkty_najlepsze=array();
				foreach($stmt as $row)
				{
					$Sprzedane_produkty_najlepsze[]=new Sprzedane_produkty_najlepsze($row['nazwa'],$row['count(id_sprzedazy)']);
				}
				$template->Sprzedane_produkty_najlepsze=$Sprzedane_produkty_najlepsze ;
				
				$stmt = $conn->query("SELECT sprzedaz.*,nazwa FROM sprzedaz INNER Join produkty ON sprzedaz.id_produktu=produkty.id ORDER BY sprzedaz.id_sprzedazy DESC LIMIT 5");
	            $Shopping=array();
				foreach($stmt as $row)
			    {
				$Shopping[]=new Shopping($row['nazwa'],$row['ilosc_produktow'],$row['cena_zakupow'],$row['data_zakupu'],$row['godzina_zakupu']);
			    }
				$template->shop=$Shopping ;
		
					
				$stm = null;
				$pdo = null;
				echo $template->execute();
				}
				catch(PDOException $e)
				{
					echo "Connection failed: " . $e->getMessage();
				}	
				
?>
