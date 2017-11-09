<?php

class CodiceCalcolo {
  private $isbn;
  private $progressivo;
  private $controllo1;
  private $controllo2;

  private $codicenumerico;
  private $codicestringa;

  //public static $lunghezze = array();

  public function __construct($isbn, $progressivo){
    $this->isbn = $isbn;
    $this->progressivo = $progressivo;
    $this->codicestringa = $isbn.$progressivo;
    $this->codicenumerico = sprintf("%u", crc32($this->codicestringa));

    // Controlla che il codice sia di 12 cifre
    if(strlen($this->codicenumerico)!=12) {
      //Self::$lunghezze[strval(strlen($this->codicenumerico))]+=1;
      $this->codicenumerico = $this->codicenumerico.strval( rand(0,99));
      $this->codicenumerico=str_pad($this->codicenumerico, 12, '0', STR_PAD_RIGHT);
    }

    $this->controllo1 = $this->calcoloControllo1();
    $this->controllo2 = $this->calcoloControllo2();
  }

  private function calcoloControllo1(){
    return 0;
  }

  private function calcoloControllo2(){
    $prodotto = intval(substr($this->codicenumerico, 0, 1))*1 + intval(substr($this->codicenumerico, 1, 1))*3+intval(substr($this->codicenumerico, 2, 1))*1+intval(substr($this->codicenumerico, 3, 1))*3+intval(substr($this->codicenumerico, 4, 1))*1+intval(substr($this->codicenumerico, 5, 1))*3+intval(substr($this->codicenumerico, 6, 1))*1+intval(substr($this->codicenumerico, 7, 1))*3+intval(substr($this->codicenumerico, 8, 1))*1+intval(substr($this->codicenumerico, 9, 1))*3+intval(substr($this->codicenumerico, 10, 1))*1+intval(substr($this->codicenumerico, 11, 1))*3;
    $resto = $prodotto % 10;

    if($resto==0) {
      $risultato=0;
    } else {
      $risultato = 10-$resto;
    }
    return $risultato;
  }

  public function getControllo1(){
    return $this->controllo1;
  }

  public function getControllo2(){
    return $this->controllo2;
  }

  public function controllo() {
    $prodottoconcontrollo = intval(substr($this->codicenumerico, 0, 1))*1 + intval(substr($this->codicenumerico, 1, 1))*3+intval(substr($this->codicenumerico, 2, 1))*1+intval(substr($this->codicenumerico, 3, 1))*3+intval(substr($this->codicenumerico, 4, 1))*1+intval(substr($this->codicenumerico, 5, 1))*3+intval(substr($this->codicenumerico, 6, 1))*1+intval(substr($this->codicenumerico, 7, 1))*3+intval(substr($this->codicenumerico, 8, 1))*1+intval(substr($this->codicenumerico, 9, 1))*3+intval(substr($this->codicenumerico, 10, 1))*1+intval(substr($this->codicenumerico, 11, 1))*3+$this->controllo2*1;

    if($prodottoconcontrollo % 10 == 0) {
      return "OK";
    } else return "ERRORE";
  }

  public function getCodice() {
    return $this->codicenumerico.$this->controllo1.$this->controllo2;
  }

  public function getIsbn() {
    return $this->isbn;
  }

  public function getProgressivo() {
    return $this->progressivo;
  }

  public function getCodiceSeparatore() {
    if(strlen($this->codicenumerico)+strlen($this->controllo1)+strlen($this->controllo2)==14){
      return substr($this->codicenumerico, 0, 2)."-".substr($this->codicenumerico, 2, 2)."-".substr($this->codicenumerico, 4, 2)."-".substr($this->codicenumerico, 6, 2)."-".substr($this->codicenumerico, 8, 2)."-".substr($this->codicenumerico, 10, 2)."-".$this->controllo1.$this->controllo2;
    } else
    return "ERRORE LUNGHEZZA: ".(strlen($this->codicenumerico)+strlen($this->controllo1)+strlen($this->controllo2));
  }
}
