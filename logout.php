<?php
session_start();
unset($_SESSION['uzytkownik']);
session_destroy();
header("Location:widok_logowanie.php?i=P");