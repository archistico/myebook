<?php
// Caricamento utilita
require_once('utilita.php');
Utilita::PARAMETRI();
$errors = [];

// Caricamento template html
require_once('template/templatehtml.php');

// Caricamento classi entità
require_once('classi/codice.php');
require_once('classi/libro.php');

TemplateHTML::HEAD("Download Ebook - Elmi's World");
TemplateHTML::OPENCONTAINER();
TemplateHTML::MENU();
TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Elimina libro");

// VALIDAZIONE
if (empty($_GET['id'])) {
    $errors[] = 'ID non inserito';
} else {
    $id = Utilita::PULISCISTRINGA($_GET['id']);
}

if (!isset($_GET['ok'])) {
    $errors[] = 'Bypass non attivo';
} else {
    $ok = Utilita::PULISCISTRINGA($_GET['ok']);
}

// CONTROLLO ID ESISTENTE
if (empty($errors) && !Libro::EXIST($id)) {
    $errors[] = 'Nessun libro con questo ID';
}

// CONTROLLO SE CODICI COLLEGATI
if(empty($errors) && !Libro::CODICICOLLEGATI($id)) { 
    $errors[] = 'Codici colleghi, cancellare prima quelli';
}

// SE LIBRO ESISTE
if(empty($errors) && $ok != 1) {
    $libro = new Libro();
    $libro->getDataByID($id);
    TemplateHTML::SCELTA("ATTENZIONE! CANCELLARE IL LIBRO?", $libro->getInfo(), "CANCELLA", "admin_libri_elimina.php?id=$id&ok=1", "admin_libri.php");
} else {
    echo "CANCELLA";
}

TemplateHTML::SHOW_NOTICE($errors);

// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True);
TemplateHTML::END();
