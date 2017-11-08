<?php 
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);
$errors = array();
session_start();

require_once('template/start.php');
require_once('utilita.php');
require_once('template/opencontainer.php');
require_once('template/jumbotron.php');
require_once('template/pageheader.php'); 
require_once('template/templatehtml.php');

Jumbotron::make("Casa editrice Elmi's World", "Download ebook tramite codice");
require_once('menu.php');
require_once('classi/codice.php'); 

 

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
          TemplateHTML::makeDownloadEbook(
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
          echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Codice non trovato</div>";
          inserisciLog("Codice non trovato", $codice, 0, 0);
        }
      }
      // chiude il database
      $db = NULL;
    } catch (PDOException $e) {
      throw new PDOException("Error  : " . $e->getMessage());
    }
  } else {
    echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Codice non valido</div>";
    inserisciLog("Codice non valido", str_replace("'", "''",$_POST['codice']), 0, 0);
  }
  if (!empty($errors)) {
    echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Ci sono degli errori</div>";
  }
}

Header::make("Cerca ebook");
TemplateHTML::makeFormSearchCodice(htmlspecialchars($_SESSION["formid"]));

require_once('template/closecontainer.php');
require_once('template/script.php');  
require_once('template/end.php');  
?>
