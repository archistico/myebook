<?php

class Codice
{
    public $id;
    public $codice;
    public $denominazione;
    public $download;
    public $libro;

    public function getLibro()
    {
        return $this->libro;
    }
    public function setLibro($libro)
    {
        $this->libro = $libro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCodice($codice)
    {
        $this->codice = $codice;
        return $this;
    }

    public function getCodice()
    {
        return $this->codice;
    }

    public function setDenominazione($denominazione)
    {
        $this->denominazione = $denominazione;
        return $this;
    }

    public function getDenominazione()
    {
        return $this->denominazione;
    }

    public function setDownload($download)
    {
        $this->download = $download;
        return $this;
    }

    public function getDownload()
    {
        return $this->download;
    }

    public function getOkMaxDownload()
    {
        if($this->download<=2) {
            return true;
        } else {
            return false;
        }

    }

    public function getLibroByCodice($codiceInserito) {
        // Parametri
        require('config.php');

        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $sql = "SELECT codice.*, libro.* FROM codice
                    INNER JOIN libro ON codice.librofk = libro.libroid 
                    WHERE codice.codice = $codiceInserito ORDER BY codiceid DESC LIMIT 1";
            $result = $db->query($sql);

            foreach ($result as $row) {
                $row = get_object_vars($row);
                if($codiceInserito==$row['codice']){
                    Utilita::LOG("Pagina scaricamento ebook", $codiceInserito, 0, 1);

                    $this->id = $row['codiceid'];
                    $this->codice = $row['codice'];
                    $this->denominazione = db2html($row['denominazione']);
                    $this->download = $row['download'];

                    $libro = new Libro();
                    $libro->id = $row['libroid'];
                    $libro->casaeditrice = db2html($row['casaeditrice']);
                    $libro->titolo = db2html($row['titolo']);
                    $libro->autore = db2html($row['autore']);
                    $libro->isbn = $row['isbn'];
                    $libro->prezzo = $row['prezzo'];
                    $libro->nomefile = $row['nomefile'];

                    $this->libro = $libro;
                }
            }
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
        // fine del try

        // chiude il database
        $db = NULL;
        if(!empty($this->getLibro()->id)) {
            return true;
        } else {
            return false;
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

            $sql = "SELECT COUNT(*) AS numero FROM codice
                    WHERE codiceid = $id";
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

    public function getDataByID($id) {
        // Parametri
        require('config.php');

        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $sql = "SELECT codice.*, libro.* FROM codice
                    INNER JOIN libro ON codice.librofk = libro.libroid 
                    WHERE codice.codiceid = $id LIMIT 1";
            $result = $db->query($sql);

            foreach ($result as $row) {
                $row = get_object_vars($row);

                $this->id = $row['codiceid'];
                $this->codice = $row['codice'];
                $this->denominazione = db2html($row['denominazione']);
                $this->download = $row['download'];

                $libro = new Libro();
                $libro->id = $row['libroid'];
                $libro->casaeditrice = db2html($row['casaeditrice']);
                $libro->titolo = db2html($row['titolo']);
                $libro->autore = db2html($row['autore']);
                $libro->isbn = $row['isbn'];
                $libro->prezzo = $row['prezzo'];
                $libro->nomefile = $row['nomefile'];

                $this->libro = $libro;

            }
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
        // fine del try

        // chiude il database
        $db = NULL;
        if(!empty($this->getLibro()->id)) {
            return true;
        } else {
            return false;
        }
    }

    public function AddDownload() {
        // Parametri
        require('config.php');

        $this->download += 1;

        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $sql = "UPDATE codice SET download = '$this->download' WHERE codice.codiceid = $this->id;";
            $result = $db->query($sql);

        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }

    public function getCodiceSeparatore($separatore) {
        return substr($this->codice, 0, 2).$separatore.
            substr($this->codice, 2, 2).$separatore.
            substr($this->codice, 4, 2).$separatore.
            substr($this->codice, 6, 2).$separatore.
            substr($this->codice, 8, 2).$separatore.
            substr($this->codice, 10, 2).$separatore.
            substr($this->codice, 12, 2);
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

            $sql = "DELETE FROM codice WHERE codiceid = $id";

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


}

/* -----------------------------------
 *            CLASSE CODICI
 * -----------------------------------
 */

class Codici {
    public $codici;

    public function __construct()
    {
        $this->codici = [];
    }

    public function Add($obj) {
        $this->codici[] = $obj;
    }

    public function getCodici() {
        return $this->codici;
    }

    public function getTuttiCodici() {
        // Parametri db
        require('config.php');

        try {

            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET CHARACTER SET UTF8');

            $sql = "SELECT codice.*, libro.* FROM codice
                    INNER JOIN libro ON codice.librofk = libro.libroid 
                    ORDER BY codiceid DESC";
            $result = $db->query($sql);

            foreach ($result as $row) {
                $row = get_object_vars($row);

                $codice = new Codice();

                $codice->id = $row['codiceid'];
                $codice->codice = $row['codice'];
                $codice->denominazione = db2html($row['denominazione']);
                $codice->download = $row['download'];

                $libro = new Libro();
                $libro->id = $row['libroid'];
                $libro->casaeditrice = db2html($row['casaeditrice']);
                $libro->titolo = db2html($row['titolo']);
                $libro->autore = db2html($row['autore']);
                $libro->isbn = $row['isbn'];
                $libro->prezzo = $row['prezzo'];
                $libro->nomefile = $row['nomefile'];

                $codice->libro = $libro;

                $this->Add($codice);
            }
            // chiude il database
            $db = NULL;
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }
}