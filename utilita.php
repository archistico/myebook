<?php
function solonumeri($str) {
    // FILTER_SANITIZE_MAGIC_QUOTES
    return filter_var(str_replace(array('+','-','_','|','%',';',':','"','\'','/'), '', $str), FILTER_SANITIZE_NUMBER_INT);
}

function soloNumeriLettere($str) {
    return preg_replace("/[^a-zA-Z0-9]+/", "", $str);
}

function codiceValido($str) {
    return preg_match('/^[a-zA-Z0-9 .\-]+$/i', $str);
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


class Utilita {
    public static function PULISCISTRINGA($str){
        $str = str_replace("'", "''", $str);
        $str = str_replace("’", "''", $str);
        $str = str_replace("\"", "", $str);
        return trim($str);
    }

    public static function PARAMETRI() {
        define('CHARSET', 'UTF-8');
        define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

        ini_set('display_errors',1);
        error_reporting(E_ALL);

        session_start();
    }

    public static function LOG($descrizione_log, $codice_log, $download_log, $login_log) {
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
}
