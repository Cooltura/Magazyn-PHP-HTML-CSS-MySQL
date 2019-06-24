<?php
session_start();
		if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
	    unset($_SESSION['uzytkownik']);
	    session_destroy();
		header('Location: widok_logowanie.html');
		}
		else {
	include('include/PHPTAL.php'); 
	$template = new PHPTAL('widok_moje_konto.html');
	class Person{
	public $id;
	public $imie;
	public $nazwisko;
	private $pracownik;
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
try 
{
    $conn = new PDO("mysql:host=localhost;dbname=magazyn", "root","");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$id=isset($_GET['i']) ? $_GET['i'] : $_SESSION['id_u'];
     $q="SELECT * FROM uzytkownik where id=:id ";
		$stm = $conn->prepare($q);
	    $stm->bindParam(':id',$id);
		$stm->execute();	 
	foreach($stm as $row)
	    {
			$Person=new Person($row['id'],$row['imie'],$row['nazwisko'],$row['pracownik']);
		}
		
	if($Person->czy_pracownik()=="1"){
    	$pracownik="|Dodaj produkt|";
		$uzytkownicy="|Lista uzytkownikow|";
		$statystyki="|Statystyki|";
	}
	else{
	  $pracownik=null;
	  $uzytkownicy=null;
	  $statystyki=null;
	}
	$template->Pracownik=$pracownik;
	$template->Uzytkownicy=$uzytkownicy;
	$template->Statystyki=$statystyki;
	$template->Person=$Person ;
	
	$q="SELECT sprzedaz.*,nazwa FROM sprzedaz INNER Join produkty ON sprzedaz.id_produktu=produkty.id where sprzedaz.id_kupujacego=:id ORDER BY sprzedaz.id_sprzedazy DESC";
		$stm = $conn->prepare($q);
	    $stm->bindParam(':id',$id);
		$stm->execute();
	$Shopping=array();
	foreach($stm as $row)
	    {
			$Shopping[]=new Shopping($row['nazwa'],$row['ilosc_produktow'],$row['cena_zakupow'],$row['data_zakupu'],$row['godzina_zakupu']);
		}
		$template->shop=$Shopping ;
		
		if(isset($_GET['info']))
			$info=$_GET['info'];
		else
			$info="";
		$template->info=$info;
		
		try {
			echo $template->execute();
		}
		catch (Exception $e){
			echo $e;		  
	}
	
	$stmt = null;
	}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

$pdo = null;

	
		}
	//$zalogowany = isset($_SESSION['uzytkownik']) && $_SESSION['uzytkownik'] == true ? true : false;	
 

?>

