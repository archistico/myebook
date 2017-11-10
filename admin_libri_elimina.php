<?php
// Caricamento utilita
require_once('utilita.php');
Utilita::PARAMETRI();

// Caricamento template html
require_once('template/templatehtml.php');

// Caricamento classi entità
require_once('classi/codice.php');
require_once('classi/libro.php');

TemplateHTML::HEAD("Download Ebook - Elmi's World");
TemplateHTML::OPENCONTAINER();
TemplateHTML::MENU();
TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Elimina libro");

// if sono presenti tutti
if (!empty($_POST['id']) && (isset($_POST['formid']) && isset($_SESSION['formid']) && $_POST["formid"] == $_SESSION["formid"])) {
    // cancello il formid
    $_SESSION["formid"] = '';

    if (empty($_POST['id'])) {
        $errors['id'] = 'ID libro non passato';
    } else {
        $librofk = Utilita::PULISCISTRINGA($_POST['libroID']);
    }

    if (empty($errors)) {
        // SE VALIDAZIONE OK
    }
        
    unset($_POST);
    $_POST = array();
}

// Creo il formid per questa sessione
$_SESSION["formid"] = md5(rand(0,10000000));

TemplateHTML::SCELTA("ATTENZIONE! CANCELLARE IL LIBRO?", "Elemento", "CANCELLA", "", "", "");

// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True);
TemplateHTML::END();
