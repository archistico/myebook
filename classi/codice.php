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

    public function getLibroByCodice($codiceInserito) {
        // Parametri db
        require_once('config.php');
        
        try {
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            $sql = 'SELECT codice.*, libro.* FROM codice '
            .'INNER JOIN libro ON codice.librofk = libro.libroid '
            .'WHERE codice.codice = '.$codiceInserito.' ORDER BY codiceid DESC LIMIT 1';
            $result = $db->query($sql);
            
            foreach ($result as $row) {
              $row = get_object_vars($row);
              if($codiceInserito==$row['codice']){
                Utilita::LOG("Pagina scaricamento ebook", $codiceInserito, 0, 1);

                $this->id = $row['codiceid'];
                $this->codice = $row['codice'];
                $this->denominazione = $row['denominazione'];
                $this->download = $row['download'];
                                
                $libro = new Libro();
                $libro->id = $row['libroid'];
                $libro->casaeditrice = $row['casaeditrice'];
                $libro->titolo = $row['titolo'];
                $libro->autore = $row['autore'];
                $libro->isbn = $row['isbn'];
                $libro->prezzo = $row['prezzo'];
                $libro->nomefile = $row['nomefile'];

                $this->libro = $libro;  
              }
            }          
          } catch (PDOException $e) {
            return false;
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
}