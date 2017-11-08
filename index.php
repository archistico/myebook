<?php 
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);
$errors = array();
session_start();

// Caricamento template html
require_once('template/templatehtml.php');

TemplateHTML::HEAD("Download Ebook - Elmi's World");
TemplateHTML::OPENCONTAINER();

// Caricamento classi entità
require_once('classi/codice.php');

// Caricamento utilita
require_once('utilita.php');

TemplateHTML::JUMBOTRON("Casa editrice Elmi's World", "Download ebook tramite codice");
TemplateHTML::MENU();

// TODO: Controllare le stringhe per eventuale apostrofi e convertirli
// RECUPERO DATI E AGGIUNGO
// if sono presenti tutti
if (!empty($_POST['codice'])) {
  if (empty($_POST['codice'])) {
    $errors['codice'] = 'codice non passato';
  } else {
    $codice = solonumeri($_POST['codice']);
  }
  if (empty($errors) && !empty($codice)) {
    // SE TUTTO OK CERCA IL CODICE
    try {
      include 'config.php';
      $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
      $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
      $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
      $sql = 'SELECT codice.*, libro.* FROM codice '
      .'INNER JOIN libro ON codice.librofk = libro.libroid '
      .'WHERE codice.codice = '.$codice.' ORDER BY codiceid DESC LIMIT 1';
      $result = $db->query($sql);
      foreach ($result as $row) {
        $row = get_object_vars($row);
        if($codice==$row['codice']){
          inserisciLog("Pagina scaricamento ebook", $codice, 0, 1);
          TemplateHTML::DOWNLOAD_EBOOK(
              $row['casaeditrice'], 
              $row['titolo'], 
              $row['autore'], 
              $row['isbn'], 
              $row['prezzo'],
              get_client_ip(), 
              (new DateTime())->format('H:i:s d/m/Y'),
              $row['download'], 
              $row['codiceid'], 
              $row['nomefile'], 
              $codice
              );
        } else {
          TemplateHTML::ALERT("ATTENZIONE!","Codice non trovato");
          inserisciLog("Codice non trovato", $codice, 0, 0);
        }
      }
      // chiude il database
      $db = NULL;
    } catch (PDOException $e) {
      throw new PDOException("Error  : " . $e->getMessage());
    }
  } else {
    TemplateHTML::ALERT("ATTENZIONE!","Codice non valido");
    inserisciLog("Codice non valido", str_replace("'", "''",$_POST['codice']), 0, 0);
  }
  if (!empty($errors)) {
    TemplateHTML::ALERT("ATTENZIONE!","Ci sono degli errori");
  }
}

// Aggiungi form cerca ebook
TemplateHTML::HEADER("Cerca ebook");
TemplateHTML::FORM_CERCA_CODICE(htmlspecialchars($_SESSION["formid"]));

// Elementi di chiusura
TemplateHTML::CLOSECONTAINER();
TemplateHTML::SCRIPT(True); 
TemplateHTML::END(); 

