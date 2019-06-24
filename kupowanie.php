<?php
session_start();
			if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
			unset($_SESSION['uzytkownik']);
			session_destroy();
			header('Location: widok_logowanie.html');
			}
$id_u=isset($_SESSION['id_u']) ? $_SESSION['id_u'] : '8';
$sz = $_POST['sztuki'];
$id_produktu=isset($_GET['id']) ? $_GET['id'] : '0';
$max=isset($_GET['max']) ? $_GET['max'] : '1';
if($sz<=0 || $sz>$max){
	header("Location: widok_produktu_wybranego.php?id=$id_produktu");
}
else{
$zostalo_sztuk=$max-$sz;
$cena_produktu=isset($_GET['cena']) ? $_GET['cena'] : '0';
$nazwa=isset($_GET['nazwa']) ? $_GET['nazwa'] : 'nic';
$cena_zakupow=$sz*$cena_produktu;
$data=date("y-m-d");
$time=date("H:i:s");

$conn = new PDO("mysql:host=localhost;dbname=magazyn", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
    $insert = "INSERT INTO sprzedaz VALUES(
	NULL,
	:id_u,
	:id_produktu,
	:sz,
	:cena_zakupow,
	:data,
	:time
	);	";
	
	
	$stm = $conn->prepare($insert);	
	$stm->bindParam(':id_u',$id_u);
	$stm->bindParam(':id_produktu',$id_produktu);
	$stm->bindParam(':sz',$sz);
	$stm->bindParam(':cena_zakupow',$cena_zakupow);
	$stm->bindParam(':data',$data);
	$stm->bindParam(':time',$time);
	$stm->execute();
	$update = "UPDATE produkty SET ilosc=:zostalo_sztuk WHERE id=:id_produktu";
	$stm = $conn->prepare($update);	
	$stm->bindParam(':zostalo_sztuk',$zostalo_sztuk);
	$stm->bindParam(':id_produktu',$id_produktu);
	$stm->execute();
	
$stm=null;
$PDO = null;
 header("Location: widok_moje_konto.php");
}
?>

