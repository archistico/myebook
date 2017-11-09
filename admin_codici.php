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

// if sono presenti tutti
if (!empty($_POST['librofk']) && (isset($_POST['formid']) && isset($_SESSION['formid']) && $_POST["formid"] == $_SESSION["formid"])) {
    // cancello il formid
    $_SESSION["formid"] = '';

    if (empty($_POST['librofk'])) {
        $errors['librofk'] = 'libro non passato';
    } else {
        $librofk = str_replace("'", "''",$_POST['librofk']);
    }

    if (empty($_POST['denominazione'])) {
        $errors['denominazione'] = 'denominazione non passato';
    } else {
        $denominazione = str_replace("'", "''",$_POST['denominazione']);
    }


    if (empty($errors)) {

        // CALCOLA CODICE
        // IN BASE ALL'LIBROFK TROVA ISBN E NUMERO PROGRESSIVO
        include 'config.php';
        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $result = $db->query("SELECT COUNT(*) AS numero FROM codice WHERE librofk = '" . $librofk . "'");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $progressivo = $row['numero'] + 1;

            $result = $db->query("SELECT libro.isbn FROM libro WHERE libroid = '" . $librofk . "'");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $isbn = $row['isbn'];

            // chiude il database
            $db = NULL;
        } catch (PDOException $e) {
            $errors['database'] = "Errore ricerca ISBN e numero progressivo nel database";
        }

        include 'classecodici.php';

        $download = 0;
        $codice = new Codice($isbn,$progressivo);

        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $sql = "INSERT INTO codice (codiceid, denominazione, codice, librofk, download) "
                ."VALUES (NULL, '" . $denominazione . "', '" . $codice->getCodice() . "', '" . $librofk . "', '" . $download ."');";

            $db->exec($sql);
            //echo $sql."<br>";

            // chiude il database
            $db = NULL;
        } catch (PDOException $e) {
            $errors['database'] = "Errore inserimento nel database";
        }
    }

    if (!empty($errors)) {
        echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Ci sono degli errori</div>";
    } else {
        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Inserimento riuscito</div>";
    }
    unset($_POST);
    $_POST = array();
}

// Creo il formid per questa sessione
$_SESSION["formid"] = md5(rand(0,10000000));


TemplateHTML::HEADER("Nuovo codice");
$libri = new Libri();
$libri->getTuttiLibri();
TemplateHTML::FORM_NUOVO_CODICE($libri->getLibri(), htmlspecialchars($_SESSION["formid"]));

TemplateHTML::HEADER("Lista codici");
$codici = new Codici();
$codici->getTuttiCodici();
TemplateHTML::LIST_TABLE_CODICE($codici->getCodici());


// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True);
TemplateHTML::END();
