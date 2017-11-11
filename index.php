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
//TemplateHTML::MENU();
TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Download ebook tramite codice");

// SE E' STATO INVIATO IL FORM 
if (!empty($_POST['codice'])) {

    $codiceInserito = solonumeri($_POST['codice']);

    if (empty($_POST['codice'])) {
        $errors['codice'] = 'codice non valido';
    }

    if (empty($errors) && !empty($codiceInserito)) {

        $codice = new Codice();
        if($codice->getLibroByCodice($codiceInserito)) {
            TemplateHTML::DOWNLOAD_EBOOK($codice);

            TemplateHTML::HEADER("Cerca un'altro ebook");
            TemplateHTML::FORM_CERCA_CODICE();
            TemplateHTML::INFORMAZIONI();
        } else {
            TemplateHTML::ALERT("ATTENZIONE!","Codice non trovato");
            Utilita::LOG("Codice non trovato", $codiceInserito, 0, 0);

            TemplateHTML::HEADER("Cerca ebook");
            TemplateHTML::FORM_CERCA_CODICE();
            TemplateHTML::INFORMAZIONI();
        }
    } else {
        TemplateHTML::ALERT("ATTENZIONE!","Codice non valido");
        Utilita::LOG("Codice non valido", str_replace("'", "''",$codiceInserito), 0, 0);

        TemplateHTML::HEADER("Cerca ebook");
        TemplateHTML::FORM_CERCA_CODICE();
        TemplateHTML::INFORMAZIONI();
    }
} else {

    TemplateHTML::HEADER("Cerca ebook");
    TemplateHTML::FORM_CERCA_CODICE();
    TemplateHTML::INFORMAZIONI();
}

// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True);
TemplateHTML::END(); 
