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
TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Elimina libro");

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
if (empty($notices) && !Libro::EXIST($id)) {
    $notices[] = 'Nessun libro con questo ID';
}

// CONTROLLO SE CODICI COLLEGATI
if(empty($notices) && !Libro::CODICICOLLEGATI($id)) { 
    $notices[] = 'Codici collegati al libro, cancellare prima quelli';
}

// MOSTRO LA SCELTA
if(empty($notices) && $ok != 1) {
    $libro = new Libro();
    $libro->getDataByID($id);
    TemplateHTML::SCELTA("ATTENZIONE! CANCELLARE IL LIBRO?", $libro->getInfo(), "CANCELLA", "admin_libri_elimina.php?id=$id&ok=1", "admin_libri.php");
} 

// SE INVECE HO ACCETTATO
if(empty($notices) && $ok == 1) {

    $libro = new Libro();
    $libro->getDataByID($id);

    // CANCELLA FILE
    if(Libro::FILE_EXIST($libro->nomefile, 'pdf')) {
        if(!Libro::FILE_DELETE($libro->nomefile, 'pdf')) {
            $notices[] = 'Errore nella cancellazione del file pdf';
        }
    }

    if(Libro::FILE_EXIST($libro->nomefile, 'epub')) {
        if(!Libro::FILE_DELETE($libro->nomefile, 'epub')) {
            $notices[] = 'Errore nella cancellazione del file epub';
        }
    }

    if(Libro::FILE_EXIST($libro->nomefile, 'mobi')) {
        if(!Libro::FILE_DELETE($libro->nomefile, 'mobi')) {
            $notices[] = 'Errore nella cancellazione del file mobi';
        }
    }

    // CANCELLA LIBRO DAL DB
    if(!Libro::DELETEBYID($id)) {
        $notices[] = 'Errore nella cancellazione sulla base dati';
    }

    $notices['ok'] = "Libro cancellato"; 
} 

TemplateHTML::SHOW_NOTICES($notices, "admin_libri.php");

// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True);
TemplateHTML::END();
