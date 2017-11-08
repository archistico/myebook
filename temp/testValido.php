<?php 
require_once('../utilita.php');

$codice = "aei#a\"lo0-00199";

echo solonumeri($codice);
echo "<br>";
echo soloNumeriLettere($codice);
echo "<br>";
echo codiceValido($codice);