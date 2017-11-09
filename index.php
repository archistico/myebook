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
TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Download ebook tramite codice");
TemplateHTML::MENU();

// SE E' STATO INVIATO IL FORM 
if (!empty($_POST['codice'])) {
  
  $codiceInserito = solonumeri($_POST['codice']);

  if (empty($_POST['codice'])) {
    $errors['codice'] = 'codice non valido';
  } 

  if (empty($errors) && !empty($codiceInserito)) {
    
    // Entro il codice
    // Esce il libro
    
    $codice = new Codice();
    $codice->getLibroByCodice($codiceInserito);

    TemplateHTML::DOWNLOAD_EBOOK($codice, get_client_ip(), (new DateTime())->format('H:i:s d/m/Y') );
    

  } else {
    TemplateHTML::ALERT("ATTENZIONE!","Codice non valido");
    Utilita::LOG("Codice non valido", str_replace("'", "''",$codiceInserito), 0, 0);
  }
  
  // SE ERRORI DB - DAI ERRORE GENERICO
  if (!empty($errors)) {
    TemplateHTML::ALERT("ATTENZIONE!","Ci sono degli errori");
  }

} else {
  // SE NON E' STATO INVIATO IL FORM
  $_SESSION["formid"] = md5(rand(0,10000000));

  TemplateHTML::HEADER("Cerca ebook");
  TemplateHTML::FORM_CERCA_CODICE(htmlspecialchars($_SESSION["formid"]));
}

// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True); 
TemplateHTML::END(); 
