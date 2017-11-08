<?php

class Codice {
    public static function makeFormSearch($formID) {
        $html = "
        <div class='row'>
        <div class='col-md-12'>
            <form action='index.php' method='post'>
                <div class='form-group'>
                    <label for='Codice'>Inserisci il codice</label>
                    <input type='text' class='form-control' id='Codice' placeholder='Codice' name='codice' maxlength='25' required>
                </div>
                <input type='hidden' name='formid' value='$formID'>
                <button type='submit' class='btn btn-info btn-block btn-lg'>CERCA</button>
            </form>
        </div>
        </div>
        ";
        echo $html;
    }

    public static function makeDownloadEbook($casaeditrice, $titolo, $autore, $isbn, $prezzo,
                                            $ip, $data, $download, $codiceid, $nomefile, $codice) {
        $html = "
        <div class='row'>
        <div class='col-md-12'>
        <h3>$casaeditrice - $titolo</h3>
        <p>Autore: $autore<br>
        ISBN: $isbn<br>
        Prezzo: &euro; $prezzo<br><br>
        Acquirente: $denominazione<br>
        IP: $ip<br>
        Data: $data<br><br>
        Numero download: $download/3<br>
        </p>
        </div>
        ";
        echo $html;

        if($download<=2) {
            $html = "
                <form action='download.php' method='post'>
                    <div class='col-md-12'>
                        <input type='hidden' name='codiceid' value='$codiceid'>
                        <input type='hidden' name='file' value='$nomefile'>
                        <button type='submit' class='btn btn-info btn-lg'>SCARICA</button>
                    </div>
                </form>
                </div>
            ";
            echo $html;
        } else {
            echo "</div>";
            echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> Raggiunto il livello massimo di download permessi</h4>contattare info@elmisworld.it per ulteriori informazioni</div>";
            inserisciLog("Massimo scaricamento raggiunto", $codice, 0, 0);
        }
    }
}