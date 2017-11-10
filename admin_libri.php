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
        $titolo = utilita::PULISCISTRINGA($_POST['titolo']);
    }

    if (empty($_POST['autore'])) {
        $errors['autore'] = 'autore non passato';
    } else {
        $autore = utilita::PULISCISTRINGA($_POST['autore']);
    }

    if (empty($_POST['ce'])) {
        $errors['ce'] = 'casa editrice non passato';
    } else {
        $ce = utilita::PULISCISTRINGA($_POST['ce']);
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

        // TODO: COME FACCIO A CAPIRE COSA HO CARICATO? INVERTO PRIMA CARICO FILE E POI SALVO NEL DB
        // TODO: AGGIUNTO TRE BOOL ALLA BASE DATI CON PDF, EPUB, MOBI

        // CARICO I FILE

        // Parametri
        require('config.php');

        // PDF
        if(!empty($_FILES["filePDF"]["name"])) {
            $check_esistente = false;
            $check_dimensione = false;
            $check_estensione = false;
            $check_spostamento = false;

            $filePDF = $dir_upload . "/pdf/" . $libro->getPdf();
            $fileTypePDF = pathinfo($_FILES["filePDF"]["name"],PATHINFO_EXTENSION);

            // Check if file already exists
            if (!file_exists($filePDF)) {
                $check_esistente = true;
            } else {
                TemplateHTML::ALERT("ATTENZIONE!","File PDF già esistente");
            }

            // Check file size
            if ($check_esistente) {
                if ($_FILES["filePDF"]["size"] < $max_fileupload) {
                    $check_dimensione = true;
                } else {
                    TemplateHTML::ALERT("ATTENZIONE!", "Dimensione file PDF troppo grande - massimo: " . ($max_fileupload / 1000) . " Kb");
                }
            }

            // Allow certain file formats
            if($check_esistente && $check_dimensione) {
                if(strtolower($fileTypePDF) == "pdf") {
                    $check_estensione = true;
                } else {
                    TemplateHTML::ALERT("ATTENZIONE!", "Il file deve essere un PDF");
                }
            }

            if ($check_esistente && $check_dimensione && $check_estensione) {
                if (move_uploaded_file($_FILES["filePDF"]["tmp_name"], $filePDF)) {
                    $check_spostamento = true;
                } else {
                    TemplateHTML::ALERT("ATTENZIONE!","Impossibile copiare il PDF");
                }
            }

            if(!$check_esistente || !$check_dimensione || !$check_estensione || !$check_spostamento) {
                $errors['filePDF'] = "Errore caricamento PDF";
            }
        } // FINE CARICAMENTO PDF

        // EPUB
        if(!empty($_FILES["fileEPUB"]["name"])) {
            $check_esistente = false;
            $check_dimensione = false;
            $check_estensione = false;
            $check_spostamento = false;

            $fileEPUB = $dir_upload . "/epub/" . $libro->getEpub();
            $fileTypeEPUB = pathinfo($_FILES["fileEPUB"]["name"],PATHINFO_EXTENSION);

            // Check if file already exists
            if (!file_exists($fileEPUB)) {
                $check_esistente = true;
            } else {
                TemplateHTML::ALERT("ATTENZIONE!","File EPUB già esistente");
            }

            // Check file size
            if ($check_esistente) {
                if ($_FILES["fileEPUB"]["size"] < $max_fileupload) {
                    $check_dimensione = true;
                } else {
                    TemplateHTML::ALERT("ATTENZIONE!", "Dimensione file EPUB troppo grande - massimo: " . ($max_fileupload / 1000) . " Kb");
                }
            }

            // Allow certain file formats
            if($check_esistente && $check_dimensione) {
                if(strtolower($fileTypeEPUB) == "epub") {
                    $check_estensione = true;
                } else {
                    TemplateHTML::ALERT("ATTENZIONE!", "Il file deve essere un EPUB");
                }
            }

            if ($check_esistente && $check_dimensione && $check_estensione) {
                if (move_uploaded_file($_FILES["fileEPUB"]["tmp_name"], $fileEPUB)) {
                    $check_spostamento = true;
                } else {
                    TemplateHTML::ALERT("ATTENZIONE!","Impossibile copiare il EPUB");
                }
            }

            if(!$check_esistente || !$check_dimensione || !$check_estensione || !$check_spostamento) {
                $errors['fileEPUB'] = "Errore caricamento EPUB";
            }
        } // FINE CARICAMENTO EPUB

        // MOBI
        if(!empty($_FILES["fileMOBI"]["name"])) {
            $check_esistente = false;
            $check_dimensione = false;
            $check_estensione = false;
            $check_spostamento = false;

            $fileMOBI = $dir_upload . "/mobi/" . $libro->getMobi();
            $fileTypeMOBI = pathinfo($_FILES["fileMOBI"]["name"],PATHINFO_EXTENSION);

            // Check if file already exists
            if (!file_exists($fileMOBI)) {
                $check_esistente = true;
            } else {
                TemplateHTML::ALERT("ATTENZIONE!","File MOBI già esistente");
            }

            // Check file size
            if ($check_esistente) {
                if ($_FILES["fileMOBI"]["size"] < $max_fileupload) {
                    $check_dimensione = true;
                } else {
                    TemplateHTML::ALERT("ATTENZIONE!", "Dimensione file MOBI troppo grande - massimo: " . ($max_fileupload / 1000) . " Kb");
                }
            }

            // Allow certain file formats
            if($check_esistente && $check_dimensione) {
                if(strtolower($fileTypeMOBI) == "mobi") {
                    $check_estensione = true;
                } else {
                    TemplateHTML::ALERT("ATTENZIONE!", "Il file deve essere un MOBI");
                }
            }

            if ($check_esistente && $check_dimensione && $check_estensione) {
                if (move_uploaded_file($_FILES["fileMOBI"]["tmp_name"], $fileMOBI)) {
                    $check_spostamento = true;
                } else {
                    TemplateHTML::ALERT("ATTENZIONE!","Impossibile copiare il MOBI");
                }
            }

            if(!$check_esistente || !$check_dimensione || !$check_estensione || !$check_spostamento) {
                $errors['fileMOBI'] = "Errore caricamento MOBI";
            }
        } // FINE CARICAMENTO MOBI
    }

    if (empty($errors)) {
        if(!$libro->storeDB()) {
            $errors['store'] = 'Errore database';
        }
    }

    if (!empty($errors)) {
        TemplateHTML::ALERT("ATTENZIONE!","Inserimento NON riuscito");
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
