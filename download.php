
<?php
include 'utilita.php';
if (empty($_POST['file'])) {
  echo "ERRORE NELLA CREAZIONE DEL FILE<br>";
  echo "Contattare info@elmisworld.it<br>";
  echo "<a href='index.php'>Torna indietro</a>";
  die();
} else {
  $file = $_POST['file'];
}
if (empty($_POST['codiceid'])) {
  echo "ERRORE NELLA CREAZIONE DEL FILE<br>";
  echo "Contattare info@elmisworld.it<br>";
  echo "<a href='index.php'>Torna indietro</a>";
  die();
} else {
  $codiceid = $_POST['codiceid'];
}
$nomefilemd5 = md5("elmisworld".$file).".zip";
if (file_exists($nomefilemd5)) {
  try {
    copy($nomefilemd5, $file);
  } catch (Exception $e) {
    echo "Errore nella preparazione del file<br>\n";
    echo "<a href='index.php'>Torna indietro</a>";
    die();
  }
} else {
  echo "File ebook non presente sul server<br>";
  echo "<a href='index.php'>Torna indietro</a>";
  die();
}
if (file_exists($file)) {
  // Aggiungi uno alle volte che è stato scaricato il file
  // UPDATE `codice` SET `download` = '1' WHERE `codice`.`codiceid` = 2;
  include 'config.php';
  // CERCA IL VALORE ATTUALE DI DOWNLOAD
  try {
    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
    $sql ="SELECT codice.download, codice.codice FROM codice WHERE codice.codiceid = '{$codiceid}'";
    $result = $db->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $download = $row['download'] + 1;
    $codice = $row['codice'];
    // chiude il database
    $db = NULL;
  } catch (PDOException $e) {
    echo "Errore DB<br>";
    echo "<a href='index.php'>Torna indietro</a>";
    unlink($file);
    die();
  }
  if($download>3){
    echo "RAGGIUNTO IL MASSIMO DI SCARICAMENTO DEL FILE<br>";
    echo "Contattare info@elmisworld.it<br>";
    echo "<a href='index.php'>Torna indietro</a>";
    unlink($file);
    die();
  }
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
}

inserisciLog("Download ebook", $codice, 1, 0);

ob_clean();
if (file_exists($file)) {
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header("Content-Transfer-Encoding: Binary");
  header('Content-Disposition: attachment; filename="'.basename($file).'"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($file));
  readfile($file);
  unlink($file);
  exit;
}
?>
