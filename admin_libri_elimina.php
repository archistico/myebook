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
  
if (empty($_GET['id'])) {
    $errors[] = 'ID non inserito';
} else {
    $id = Utilita::PULISCISTRINGA($_GET['id']);
}
if (empty($errors)) {
    // SE VALIDAZIONE OK
    if(!Libro::EXIST($id)) { 
        $errors[] = 'Nessun libro con questo ID';
    }
    if(empty($errors) || !Libro::CODICICOLLEGATI($id)) { 
        $errors[] = 'Codici colleghi, cancellare prima quelli';
    }

    // SE LIBRO ESISTE
    if(empty($errors)) {
        $libro = new Libro();
        $libro->getDataByID($id);
        TemplateHTML::SCELTA("ATTENZIONE! CANCELLARE IL LIBRO?", $libro->getInfo(), "CANCELLA", "", "", "");
    }  
}

if(!empty($errors)) {
    foreach($errors as $err) {
        TemplateHTML::ALERT("ATTENZIONE!", $err);
    }    
}
    


// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True);
TemplateHTML::END();
