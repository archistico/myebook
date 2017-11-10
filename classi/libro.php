<?php

class Libro {
    public $id;
    public $casaeditrice;
    public $titolo;
    public $autore;
    public $isbn;
    public $prezzo;
    public $nomefile;

    public function getPdf()
    {
        return $this->nomefile.".pdf";
    }
    public function getEpub()
    {
        return $this->nomefile.".epub";
    }
    public function getMobi()
    {
        return $this->nomefile.".mobi";
    }

    public function getInfo()
    {
        return $this->casaeditrice . " - " .$this->titolo . " - " . $this->autore . " (" . $this->isbn .")";
    }

    public function getCompleteFilenameStore($tipo) {
        // Parametri
        require('config.php');

        $nomefile = $this->nomefile.".".$tipo;
        return $dir_upload."/".strtolower($tipo)."/".$nomefile;
    }

    public function getFilenameDownload($tipo) {
        $nomefile = $this->casaeditrice. " - " . $this->titolo . " (" . $this->autore. ")";
        return str_replace(array('+','_','|','%',';',':','"','\'','/','.'), '-', $nomefile).".".$tipo;
    }

    public function storeDB() {
        // Parametri
        require('config.php');

        $result = false;
        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $sql = "INSERT INTO libro (libroid, titolo, autore, casaeditrice, isbn, prezzo, nomefile) 
                    VALUES (NULL, '".html2db($this->titolo)."', '".html2db($this->autore)."', '".html2db($this->casaeditrice)."', '".html2db($this->isbn)."', '$this->prezzo', '$this->nomefile');";

            $db->exec($sql);
            $result = true;
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
        // chiude il database
        $db = NULL;
        if($result) {
            return true;
        } else {
            return false;
        }

    }

    public function calcolaNomeFile() {
        // Parametri db
        require('config.php');
        return substr(sha1($this->getInfo().$dbsalt),-10);
    }

    public function getDataByID($id) {
        // Parametri
        require('config.php');

        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET CHARACTER SET UTF8');

            $sql = "SELECT * FROM libro
                            WHERE libroid = $id LIMIT 1";
            $result = $db->query($sql);

            foreach ($result as $row) {
                $row = get_object_vars($row);

                $this->id = $row['libroid'];
                $this->casaeditrice = db2html($row['casaeditrice']);
                $this->titolo = db2html($row['titolo']);
                $this->autore = db2html($row['autore']);
                $this->isbn = $row['isbn'];
                $this->prezzo = $row['prezzo'];
                $this->nomefile = $row['nomefile'];
            }
            // chiude il database
            $db = NULL;
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }

    public static function EXIST($id) {
        // Ritorna true se esiste
        $exist = false;

        // Parametri
        require('config.php');

        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET CHARACTER SET UTF8');

            $sql = "SELECT COUNT(*) AS numero FROM libro
                    WHERE libroid = $id";
            $result = $db->query($sql);

            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row['numero']>0) {
                $exist = true;
            }

            // chiude il database
            $db = NULL;
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $exist;
    }

    public static function CODICICOLLEGATI($id) {
        // Ritorna true se non ha codici collegati
        $nonlibricollegati = false;

        // Parametri
        require('config.php');

        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET CHARACTER SET UTF8');

            $sql = "SELECT COUNT(*) AS numero FROM codice
                    WHERE librofk = $id";
            $result = $db->query($sql);

            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row['numero']==0) {
                $nonlibricollegati = true;
            }

            // chiude il database
            $db = NULL;
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $nonlibricollegati;
    }

    public static function DELETEBYID($id) {
        // Ritorna true se non ha codici collegati
        $effettuato = false;

        // Parametri
        require('config.php');

        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET CHARACTER SET UTF8');

            $sql = "DELETE FROM libro WHERE libroid = $id";

            if ($db->query($sql) === TRUE) {
                $effettuato = true;
            }

            // chiude il database
            $db = NULL;
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $effettuato;
    }

    public static function FILE_EXIST($nomefile, $tipo) {
        // Parametri
        require('config.php');

        if (file_exists($dir_upload."/".strtolower($tipo)."/".$nomefile.".".strtolower($tipo))) {
            return true;
        } else {
            return false;
        }
    }

    public static function FILE_DELETE($nomefile, $tipo) {
        // Parametri
        require('config.php');

        if(self::FILE_EXIST($nomefile, $tipo)) {
            if(unlink($dir_upload."/".strtolower($tipo)."/".$nomefile.".".strtolower($tipo))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

/*  ----------------------------
 *         CLASSE LIBRI
 *  ----------------------------
 */

class Libri {
    public $libri;

    public function __construct()
    {
        $this->libri = [];
    }

    public function Add($obj) {
        $this->libri[] = $obj;
    }

    public function getLibri() {
        return $this->libri;
    }

    public function getTuttiLibri() {
        // Parametri db
        require('config.php');

        try {

            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET CHARACTER SET UTF8');

            $sql = "SELECT * FROM libro
                    ORDER BY casaeditrice ASC, titolo ASC";
            $result = $db->query($sql);

            foreach ($result as $row) {
                $row = get_object_vars($row);

                $libro = new Libro();
                $libro->id = $row['libroid'];
                $libro->casaeditrice = db2html($row['casaeditrice']);
                $libro->titolo = db2html($row['titolo']);
                $libro->autore = db2html($row['autore']);
                $libro->isbn = $row['isbn'];
                $libro->prezzo = $row['prezzo'];
                $libro->nomefile = $row['nomefile'];

                $this->Add($libro);
            }
            // chiude il database
            $db = NULL;
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }
}