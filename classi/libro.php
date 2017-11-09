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

    public function setCasaeditrice($casaeditrice)
    {
        $this->casaeditrice = $casaeditrice;
        return $this;
    }

    public function getCasaeditrice()
    {
        return $this->casaeditrice;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNomefile()
    {
        return $this->nomefile;
    }

    public function setNomefile($nomefile)
    {
        $this->nomefile = $nomefile;
    }

    public function getPrezzo()
    {
        return $this->prezzo;
    }

    public function setPrezzo($prezzo)
    {
        $this->prezzo = $prezzo;
    }

    public function getAutore()
    {
        return $this->autore;
    }

    public function setAutore($autore)
    {
        $this->autore = $autore;
    }

    public function getTitolo()
    {
        return $this->titolo;
    }

    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    public function getInfo()
    {
        return $this->casaeditrice . " - " .$this->titolo . " - " . $this->autore . " (" . $this->isbn .")";
    }

    public function getFilenamepdf() {
        return str_replace("/", "-", $this->getInfo().".pdf");
    }

    public function getFilenameepub() {
        return str_replace("/", "-", $this->getInfo().".epub");
    }

    public function getFilenamemobi() {
        return str_replace("/", "-", $this->getInfo().".mobi");
    }

    public function storeDB() {
        // Parametri db
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
}

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