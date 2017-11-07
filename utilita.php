<?php
function solonumeri($str) {
  return filter_var(str_replace(array('+','-'), '', $str), FILTER_SANITIZE_NUMBER_INT);
}

function convertiStringaToHTML($stringa) {
  return htmlentities($stringa, ENT_COMPAT,'UTF-8', true);
}

function convertiHTMLToStringa($stringa) {
  return htmlspecialchars($stringa, ENT_COMPAT,'UTF-8', true);
}

function convertiApostrofi($stringa) {
  return htmlspecialchars($stringa, ENT_QUOTES,'UTF-8', true);
}

function convertiCodiceSeparatore($str) {
  if(strlen($str)==14){
    return substr($str, 0, 2)."-".substr($str, 2, 2)."-".substr($str, 4, 2)."-".substr($str, 6, 2)."-".substr($str, 8, 2)."-".substr($str, 10, 2)."-".substr($str, 12, 2);
  } else
  return "ERRORE LUNGHEZZA: ".(strlen($str));
}

function db2html($stringa) {
  return utf8_encode($stringa);
}
function html2db($stringa) {
  return utf8_decode($stringa);
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function inserisciLog($descrizione_log, $codice_log, $download_log, $login_log) {
  include 'config.php';
  try {
    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
    $ip_log = get_client_ip();
    $sql = "INSERT INTO accesso (accessoid, descrizione, codice, data, ip, download, login) VALUES (NULL, '{$descrizione_log}', '{$codice_log}', CURRENT_TIMESTAMP, '{$ip_log}', '{$download_log}', '{$login_log}');";
    $db->exec($sql);
    // chiude il database
    $db = NULL;
  } catch (PDOException $e) {
    echo "Errore nel loggin<br>";
  }
}


?>
