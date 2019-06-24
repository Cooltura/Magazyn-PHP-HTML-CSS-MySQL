<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="mystyle.css" type="text/css" />
</head>
<body>

<div id="strona">

    <div id="naglowek">
 <a href="widok_glowna.php"><img src="zdjecia/baner.jpg"></a> 
    </div>
<div id="Kolumny">
    <div id="kolumnaLewa">

       

        <div id="menuPionowe">
		<ul class="ukladPionowy">
					<li><a href="widok_nowe_produkty.php" ><br/>NOWOŚCI  </a></li>
			<li><a href="widok_glowna.php?">O FIRMIE  </a></li>
			<li><a href="widok_moje_konto.php"> MOJE KONTO  </a></li>
			<li><a href="logout.php">WYLOGUJ SIĘ  </a></li>
		
		</ul>
        </div>

    </div>

    <div id="kolumnaPrawa">

        <div id="menuPoziome">
		<ul class="ukladPoziomy">
		<li><a href="widok_produkty.php?product=szafa&p=1" >SZAFY</a></li>
			<li><a href="widok_produkty.php?product=lozko&p=1" >LOZKA</a></li>
			<li><a href="widok_produkty.php?product=stol&p=1" >STOLY</a></li>
			<li><a href="widok_produkty.php?product=krzeslo&p=1" >KRZESLA</a></li>
			<li><a href="widok_produkty.php?product=drzwi&p=1" >DRZWI</a></li>
		</ul>
        </div>
		
        <div id="tresc" >
		<?php
		session_start();
		if (!isset($_SESSION['uzytkownik']) || $_SESSION['uzytkownik'] != true){
	    unset($_SESSION['uzytkownik']);
	    session_destroy();
		header('Location: widok_logowanie.html');
		}
	
			 echo '<center><h1>Salon meblowy SZAWA</center><h3>
SZAWA to salon meblowy z Księżyna koło Gdańska, istniejący na rynku od 2018 roku. Na początku działalności byliśmy niewielką, rodzinną firmą oferującą ciekawy wybór mebli na sprzedaż. Obecnie jesteśmy jedną z największych firm sprzedających meble w Polsce. Powierzchnia handlowa naszego salonu meblowego wynosi ok. 9000 m2. W naszym asortymencie znajdą Państwo meble z największych i najbardziej renomowanych fabryk. Specjalnością naszego sklepu meblowego jest sprzedaż mebli stylowych i nowoczesnych. Oferujemy duży wybór ekskluzywnych mebli do gabinetu czy salonu. Duża część z oferowanych przez nas mebli wypoczynkowych i gabinetowych dostępna jest w atrakcyjnych, niskich cenach. Naszym celem jest dostarczenie mebli spełniających Państwa oczekiwania pod względem estetycznym, funkcjonalnym oraz finansowym, dlatego też motto naszej firmy jest następujące: „Meble, jakich Ci potrzeba, kupisz tylko w sklepie Vega”.
<br>
<br>
Zapraszamy,
<br>
Właściciel i pracownicy 
';

phpinfo();

class workerThread extends Thread {
public function __construct($i){
  $this->i=$i;
}

public function run(){
  while(true){
  $x=$this->i;
   echo "<h2>$x<";
   sleep(1);
  }
}
}

for($i=0;$i<5;$i++){
$workers[$i]=new workerThread($i);
$workers[$i]->start();
}	
?>
		</div>
		
	</div>
	</div>
    <div id="stopka">
	  Radoslaw Rudziewicz 27.11.2018
    </div>

</div>

</body>
</html>