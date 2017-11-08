<?php

class TemplateHTML {
    public static function makeFormSearchCodice($formID) {
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
            $html = "
                </div>
                <div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> Raggiunto il livello massimo di download permessi</h4>contattare info@elmisworld.it per ulteriori informazioni</div>
            ";
            echo $html;
            inserisciLog("Massimo scaricamento raggiunto", $codice, 0, 0);
        }
    }

    public static function makeMenu() {
        $html = "
        <div class='row'>
        <div class='col-md-12'>
          <div class='btn-group' role='group' aria-label='Menu'>
            <a role='button' class='btn btn-secondary' href='index.php'>Home</a>
            <a role='button' class='btn btn-secondary' href='codici.php'>Codici</a>
            <a role='button' class='btn btn-secondary' href='ebook.php'>Ebook</a>
            <a role='button' class='btn btn-secondary' href='accessi.php'>Accessi</a>
            <a role='button' class='btn btn-secondary' href='login.php'>Login</a>
            <a role='button' class='btn btn-secondary' href='logout.php'>Logout</a>
          </div>
        </div>
      </div>
      ";
      echo $html;
    }

    public static function makeJumbotron($titolo, $sottotitolo) {
        echo '<div class="jumbotron">';
        if(!empty($titolo)){
            echo "<h1>$titolo</h1>";
        }
        if(!empty($sottotitolo)){
            echo "<p>$sottotitolo</p>";
        }
        echo '</div>';
    }

    public static function makeScript($attivi) {
        if($attivi){
            $html = "
            <script src='vendor/jquery/jquery-3.2.1.min.js'></script>
            <script src='vendor/popper/popper.min.js'></script>
            <script src='vendor/bootstrap/bootstrap.min.js'></script>
            ";
            echo $html;
        }
    }

    public static function makeHeader($header) {
        if(!empty($header)){
            echo "<div class='page-header'>";
            echo "<h1>$header</h1>";
            echo "</div>";
        }            
    }
}