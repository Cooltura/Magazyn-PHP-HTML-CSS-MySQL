<?php
	session_start();
	if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
		unset($_SESSION['uzytkownik']);
		session_destroy();
		header('Location: widok_logowanie.html');
	}
			
	include('include/PHPTAL.php'); 
	$template = new PHPTAL('dodawanie_produktu.html');
	
	if ($_FILES['zdjecie']['type'] != 'image/jpeg'){
		$info="Nie wysłano prawidlowego zdjecia ";
        $template->info=$info;
	}		
	else{
	  if ($_FILES['zdjecie']['error'] > 0){
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
	else if(empty($_POST['name']) || empty($_POST['cena']) || empty($_POST['sztuki']) || empty($_POST['opis']) || empty($_POST['id_producenta']) ){
			$info="Nie wszytskie pola zostaly wypelnione";
			$template->info=$info;
		
		}
		else{
			$timestamp = time();
			$name=$_POST['name'];
			$cena=$_POST['cena'];
			$sztuki=$_POST['sztuki'];
			$typ=$_POST['typ'];
			$opis=$_POST['opis'];
			$id_p=$_POST['id_producenta'];
			$lokalizacja = "zdjecia/$timestamp.jpg";
			
			 if(is_uploaded_file($_FILES['zdjecie']['tmp_name']))
			 {
			  if(!move_uploaded_file($_FILES['zdjecie']['tmp_name'], $lokalizacja)) {
				  $info="Nie udało się skopiować pliku do katalogu";
			      $template->info=$info;
			  }
			  else{
				try 
				{
				$conn = new PDO("mysql:host=localhost;dbname=magazyn", "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
				/*
				$stmt2 = $conn->query("SELECT * FROM produkty ");
					$i=0;
				foreach($stmt2 as $row)
				{	$i++;
				}
			
				
				$stmt = $conn->query('Select zdjecie from produkty ');
				for($j=0;$j<=$i;$j++){
				foreach($stmt as $row)
					{
						$image=$row['zdjecie'];
						if($timestamp==$image)
						{
							$j=0;
							$timestamp = time();
						}
					}
				
				}
				*/
				$timestamp=$timestamp.".jpg";
				$q="INSERT INTO produkty VALUES
				(NULL,:name,:sztuki,:cena,:timestamp,:typ,:opis,:id_p);";
				$stm = $conn->prepare($q);
	            $stm->bindParam(':name',$name);
			    $stm->bindParam(':sztuki',$sztuki);
  			    $stm->bindParam(':cena',$cena);
			    $stm->bindParam(':timestamp',$timestamp);
			    $stm->bindParam(':typ',$typ);
		    	$stm->bindParam(':opis',$opis);
			    $stm->bindParam(':id_p',$id_p);
					
		        $stm->execute();

				$stm = null;
				$pdo = null;
				header("Location: widok_moje_konto.php?info=Produkt Dodano");
				}
				catch(PDOException $e)
				{
					echo "Connection failed: " . $e->getMessage();
				}	
				}
			
			 }	
			 else{
				  $info="Możliwy atak podczas przesyłania pliku.Plik nie został zapisany";
			      $template->info=$info; 
			 }
		 }
      

}
try {
		echo $template->execute();
	}
	catch (Exception $e){
			echo $e;		  
	}

?>
