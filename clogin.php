<?php
$servername = "localhost";
$username = "root";
$password = "";
try 
{
    $conn = new PDO("mysql:host=$servername;dbname=magazyn", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$login = $_POST['login'];
	$password = $_POST['password'];

     $stmt = $conn->query("SELECT * FROM uzytkownik where login='$login'");	
	foreach($stmt as $row)
	    {
			
		$id = $row['id'];  
		}
	
    $q = "SELECT id, login FROM uzytkownik WHERE login=:login AND password=SHA2(:password,256)";
	$stm = $conn->prepare($q);
	$stm->bindParam(':login',$login);
	$stm->bindParam(':password',$password);		
	$stm->execute();
	
	$t = $stm->fetchAll(PDO::FETCH_BOTH);		
	if (count($t) == 1)
	{
	
		session_start(); 
	if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
		session_regenerate_id();   // utworzenie nowego identyfikatora sesji
	}
		   $_SESSION['uzytkownik'] = true;
		   $_SESSION['id_u']=$id;
		  
		  header("Location: widok_glowna.php?page=o");
	}
	else{
		//self::$info = "Niepoprawne haslo lub login";
		session_destroy();
		header('Location: widok_logowanie.php?i=B');	
	}
	$stm = null;
	}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

$pdo = null;

	
	
	//$zalogowany = isset($_SESSION['uzytkownik']) && $_SESSION['uzytkownik'] == true ? true : false;	
 

?>

