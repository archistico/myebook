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
TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Libri");

// SE FORM INVIATO
if (!empty($_POST['titolo']) && (isset($_POST['formid']) && isset($_SESSION['formid']) && $_POST["formid"] == $_SESSION["formid"])) {
    // cancello il formid
    $_SESSION["formid"] = '';

    if (empty($_POST['titolo'])) {
        $errors['titolo'] = 'titolo non passato';
    } else {
        $titolo = str_replace("'", "''",$_POST['titolo']);
    }

    if (empty($_POST['autore'])) {
        $errors['autore'] = 'autore non passato';
    } else {
        $autore = str_replace("'", "''",$_POST['autore']);
    }

    if (empty($_POST['ce'])) {
        $errors['ce'] = 'casa editrice non passato';
    } else {
        $ce = str_replace("'", "''",$_POST['ce']);
    }

    if (empty($_POST['isbn'])) {
        $errors['isbn'] = 'isbn non passato';
    } else {
        $isbn = solonumeri($_POST['isbn']);
    }

    if (empty($_POST['prezzo'])) {
        $errors['prezzo'] = 'prezzo non passato';
    } else {
        $prezzo = str_replace(",", ".",$_POST['prezzo']);
    }

    // Se tutto ok dal form
    if (empty($errors)) {
        $libro = new Libro();
        $libro->titolo = $titolo;
        $libro->autore = $autore;
        $libro->casaeditrice = $ce;
        $libro->isbn = $isbn;
        $libro->prezzo = $prezzo;
        $libro->nomefile = $libro->calcolaNomeFile();

        if(!$libro->storeDB()) {
            $errors['store'] = 'Errore database';
        } else {
            // Se ok
            // poi copio i file nella directory
        }
    }

    if (!empty($errors)) {
        TemplateHTML::ALERT("ATTENZIONE!","Ci sono degli errori");
    } else {
        TemplateHTML::SUCCESS("OK!","Inserimento riuscito");
    }
    unset($_POST);
    $_POST = array();
}

// Creo il formid per questa sessione
$_SESSION["formid"] = md5(rand(0,10000000));

TemplateHTML::HEADER("Nuovo libro");
TemplateHTML::FORM_NUOVO_LIBRO(htmlspecialchars($_SESSION["formid"]));

TemplateHTML::HEADER("Lista libri");
$libri = new Libri();
$libri->getTuttiLibri();
TemplateHTML::LIST_TABLE_LIBRI($libri->getLibri());

// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True);
TemplateHTML::END();
