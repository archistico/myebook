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
TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Codici");
TemplateHTML::MENU();

// INSERIMENTO
// TODO: Controllare le stringhe per eventuale apostrofi e convertirli

// if sono presenti tutti
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

    include 'utilita.php';

    if (empty($_POST['isbn'])) {
        $errors['isbn'] = 'isbn non passato';
    } else {
        $isbn = solonumeri($_POST['isbn']);
    }

    if (empty($_POST['nomefile'])) {
        $errors['nomefile'] = 'nomefile non passato';
    } else {
        $nomefile = str_replace("'", "''",$_POST['nomefile']);
    }

    if (empty($_POST['prezzo'])) {
        $errors['prezzo'] = 'prezzo non passato';
    } else {
        $prezzo = str_replace(",", ".",$_POST['prezzo']);
    }

    if (empty($errors)) {
        try {
            include 'config.php';

            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $denominazione = trim($cognome . " " . $nome);

            $sql = "INSERT INTO libro (libroid, titolo, autore, casaeditrice, isbn, prezzo, nomefile) 
                    VALUES (NULL, '$titolo', '$autore', '$ce', '$isbn', '$prezzo', '$nomefile');";

            $db->exec($sql);

            // chiude il database
            $db = NULL;
        } catch (PDOException $e) {
            $errors['database'] = "Errore inserimento nel database";
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
