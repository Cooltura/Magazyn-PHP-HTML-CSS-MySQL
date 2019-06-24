<!DOCTYPE HTML>

<html>
<head>
<title>logowanie</title>
<meta charset="UTF-8" />
<link rel="stylesheet" type="text/css" href="mystyle.css">

</head>
<body>

		
		<div id="col_12">

			<h4><center>Logowanie </h4>

         <br>
			<form name="passwordform" method="post" action="clogin.php" enctype="multipart/form-data">
			  <center>  Login: <input type="login" name="login" autofocus="autofocus" /><br><br>
			   <center>	Haslo: <input type="password" name="password" autofocus="autofocus" /><br><br>
				<input type="submit" value="Zaloguj" />
			</form>
			<br><br>
						<?php

$info=isset($_GET['i']) ? $_GET['i'] : "N";
if($info=='B')
	echo "<font color='red'>Zly login lub haslo</font>";
else if($info=='P')
	echo "<font color='green'>Wylogowano poprawnie</font>";
else
echo "Zaloguj sie by zobaczyc ofertę ";
?>
			
			

		</div>    

</body>
</html>
