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
}