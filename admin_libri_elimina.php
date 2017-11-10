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
if (!empty($_GET['id'])) {
    
    if (empty($_GET['id'])) {
        $errors['id'] = 'ID libro non passato';
    } else {
        $id = Utilita::PULISCISTRINGA($_GET['id']);
    }

    if (empty($errors)) {
        // SE VALIDAZIONE OK

        // SE LIBRO ESISTE
        if(Libro::EXIST($id)) {
            $libro = new Libro();
            $libro->getDataByID($id);
            TemplateHTML::SCELTA("ATTENZIONE! CANCELLARE IL LIBRO?", $libro->getInfo(), "CANCELLA", "", "", "");
        } else {
            TemplateHTML::ALERT("ATTENZIONE!","Nessun libro con questo ID");        
        }     
    }
} else {
    TemplateHTML::ALERT("ATTENZIONE!","ID non inserito");
}

// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True);
TemplateHTML::END();
