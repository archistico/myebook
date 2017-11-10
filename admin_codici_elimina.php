<?php
// Caricamento utilita
require_once('utilita.php');
Utilita::PARAMETRI();
$notices = [];

// Caricamento template html
require_once('template/templatehtml.php');

// Caricamento classi entità
require_once('classi/codice.php');
require_once('classi/libro.php');

TemplateHTML::HEAD("Download Ebook - Elmi's World");
TemplateHTML::OPENCONTAINER();
TemplateHTML::MENU();
TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Elimina codice");

// VALIDAZIONE
if (empty($_GET['id'])) {
    $notices[] = 'ID non inserito';
} else {
    $id = Utilita::PULISCISTRINGA($_GET['id']);
}

if (!isset($_GET['ok'])) {
    $notices[] = 'Bypass non attivo';
} else {
    $ok = Utilita::PULISCISTRINGA($_GET['ok']);
}

// CONTROLLO ID ESISTENTE
if (empty($notices) && !Codice::EXIST($id)) {
    $notices[] = 'Nessun libro con questo ID';
}

// MOSTRO LA SCELTA
if(empty($notices) && $ok != 1) {
    $codice = new Codice();
    $codice->getDataByID($id);
    $info = $codice->denominazione." - ".$codice->getLibro()->titolo." - ".$codice->getCodiceSeparatore("-");
    TemplateHTML::SCELTA("ATTENZIONE! CANCELLARE IL CODICE?", $info, "CANCELLA", "admin_codici_elimina.php?id=$id&ok=1", "admin_codici.php");
}

// SE INVECE HO ACCETTATO
if(empty($notices) && $ok == 1) {

    // CANCELLA LIBRO DAL DB
    if(!Codice::DELETEBYID($id)) {
        $notices[] = 'Errore nella cancellazione sulla base dati';
    }

    $notices['ok'] = "Codice cancellato";
}

TemplateHTML::SHOW_NOTICES($notices, "admin_codici.php");

// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True);
TemplateHTML::END();
