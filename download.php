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

// Parametri
require('config.php');

// VALIDAZIONE
if (empty($_POST['codice'])) {
    $notices[] = 'Codice non passato';
} else {
    $codiceinserito = Utilita::PULISCISTRINGA($_POST['codice']);
}

if (empty($_POST['tipo'])) {
    $notices[] = 'Tipologia non passata';
} else {
    $tipo = Utilita::PULISCISTRINGA($_POST['tipo']);
}

// CONTROLLO LIBRO ESISTE
if (empty($notices)) {

    $codice = new Codice();
    $codice->getLibroByCodice($codiceinserito);

    if(!Libro::EXIST($codice->getLibro()->id)) {
        $notices[] = 'Nessun libro collegato a questo codice';
    }
}

// CONTROLLO FILE ESISTE
if (empty($notices)) {
    if(!Libro::FILE_EXIST($codice->getLibro()->nomefile, $tipo)) {
        $notices[] = 'Nessun file collegato a questo codice';
    }
}

// CONTROLLO MASSIMO DOWNLOAD
if (empty($notices)) {
    if(!$codice->getOkMaxDownload()) {
        $notices[] = 'Massimo download raggiunto per questo codice';
    }
}

// DOWNLOAD DEL FILE
if (empty($notices)) {
    $filenameStore = $codice->getLibro()->getCompleteFilenameStore($tipo);
    $filenameDownload = $codice->getLibro()->getFilenameDownload($tipo);

    ob_clean();
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header('Content-Disposition: attachment; filename="'.basename($filenameDownload).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filenameStore));
    readfile($filenameStore);
    exit;
}

// SE CI SONO ERRORI MOSTRA PAGINA ERRORE
if (!empty($notices)) {
    TemplateHTML::HEAD("Download Ebook - Elmi's World");
    TemplateHTML::OPENCONTAINER();
    TemplateHTML::MENU();
    TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Scarica libro");

    TemplateHTML::SHOW_NOTICES($notices, "index.php");

    // Elementi di chiusura
    TemplateHTML::CLOSECONTAINER();
    TemplateHTML::SCRIPT(True);
    TemplateHTML::END();
}

/*

    // MODIFICA IL VALORE DI DOWNLOAD
    try {
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
        $sql = "UPDATE codice SET download = '{$download}' WHERE codice.codiceid = {$codiceid};";
        $db->exec($sql);
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        echo "Errore DB<br>";
        echo "<a href='index.php'>Torna indietro</a>";
        unlink($file);
        die();
    }


// inserisciLog("Download ebook", $codice, 1, 0);


*/
