<?php 
require_once('../utilita.php');
require_once('../classi/file.php');
require_once('../classi/libro.php');
require_once('../classi/codice.php');
require_once('../classecodici.php');

//echo File::FILENAME(__FILE__);

$isbn ='9788897192000';
$codici = [];
$min_codici = 0;
$max_codici = 10000;

for($c=$min_codici; $c < $max_codici; $c++) {
    $cod = new CodiceCalcolo($isbn, $c);

    if (in_array($cod->getCodice(), $codici)) {
        Utilita::WRITELINE($c .": ". $cod->getCodiceSeparatore());
    }

    $codici[] = $cod->getCodice();
}

Utilita::WRITELINE("OK: ".($max_codici-$min_codici). " codici creati senza sovrapposizione" );

