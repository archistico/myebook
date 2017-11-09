<?php

class TemplateHTML {

    public static function HEAD($titolo) {
        $html = "
        <!DOCTYPE html>
        <html lang='it'>
        <head>
            <meta charset='utf-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>

            <title>$titolo</title>

            <link rel='stylesheet' href='vendor/bootstrap/bootstrap.min.css'>
            <link rel='stylesheet' href='vendor/awesome/font-awesome.min.css'>
            <link href='https://fonts.googleapis.com/css?family=Ubuntu+Mono' rel='stylesheet'>
            <link href='css/stile.css' rel='stylesheet'>
        </head>
        <body>
        ";
        echo $html;
    }

    public static function OPENCONTAINER() {
        $html = "
        <div class='container theme-showcase' role='main'>
        ";
        echo $html;
    }

    public static function CLOSECONTAINER() {
        $html = "
        </div> <!-- /container -->
        ";
        echo $html;
    }

    public static function END() {
        $html = "
        </body>
        </html>
        ";
        echo $html;
    }

    public static function FORM_CERCA_CODICE($formID) {
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

    public static function DOWNLOAD_EBOOK($codice, $ip, $data) {

        $casaeditrice = $codice->getLibro()->casaeditrice;
        $titolo = $codice->getLibro()->titolo;
        $autore = $codice->getLibro()->autore;
        $isbn = $codice->getLibro()->isbn;
        $prezzo = $codice->getLibro()->prezzo;

        // Cerca i file sul disco se non ci sono annulla la variabile
        $pdf = $codice->getLibro()->getPdf();
        $epub = $codice->getLibro()->getEpub();
        $mobi = $codice->getLibro()->getMobi();

        $html = "
        <div class='row'>
            <div class='col-md-12'>
                <h3>$casaeditrice - $titolo</h3>
                <p>Autore: $autore<br>
                    ISBN: $isbn<br>
                    Prezzo: &euro; $prezzo<br><br>
                    Acquirente: $codice->denominazione<br>
                    IP: $ip<br>
                    Data: $data<br><br>
                    Numero download: $codice->download/3<br>
                </p>
            </div>
        ";
        echo $html;

        if($codice->download<=2) {
            $html = "
                <form action='download.php' method='post'>
                    <div class='col-md-12'>
                        <input type='hidden' name='codiceid' value='$codice->id'>
                        <input type='hidden' name='file' value='$pdf'>
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
            Utilita::LOG("Massimo scaricamento raggiunto", $codice->codice, 0, 0);
        }
    }

    public static function MENU() {
        $html = "
        <div class='row'>
        <div class='col-md-12'>
          <div class='btn-group' role='group' aria-label='Menu'>
            <a role='button' class='btn btn-secondary' href='index.php'>Home</a>
            <a role='button' class='btn btn-secondary' href='admin_codici.php'>Codici</a>
            <a role='button' class='btn btn-secondary' href='admin_libri.php'>Libri</a>
            <!-- <a role='button' class='btn btn-secondary' href='accessi.php'>Accessi</a>
            <a role='button' class='btn btn-secondary' href='login.php'>Login</a>
            <a role='button' class='btn btn-secondary' href='logout.php'>Logout</a> --> 
          </div>
        </div>
      </div>
      ";
        echo $html;
    }

    public static function JUMBOTRON($titolo, $sottotitolo) {
        echo '<div class="jumbotron">';
        if(!empty($titolo)){
            echo "<h1>$titolo</h1>";
        }
        if(!empty($sottotitolo)){
            echo "<p>$sottotitolo</p>";
        }
        echo '</div>';
    }

    public static function SCRIPT($attivi) {
        if($attivi){
            $html = "
            <script src='vendor/jquery/jquery-3.2.1.min.js'></script>
            <script src='vendor/popper/popper.min.js'></script>
            <script src='vendor/bootstrap/bootstrap.min.js'></script>
            ";
            echo $html;
        }
    }

    public static function HEADER($header) {
        if(!empty($header)){
            echo "<div class='page-header'>";
            echo "<h1>$header</h1>";
            echo "</div>";
        }
    }

    public static function ALERT($titolo, $messaggio) {
        $html = "
        <div class='alert alert-danger alert-dismissible'>
            <h4>
                <i class='fa fa-ban'></i> $titolo
            </h4>
            $messaggio
        </div>
        ";
        echo $html;
    }

    public static function SUCCESS($titolo, $messaggio) {
        $html = "
        <div class='alert alert-success alert-dismissible'>
            <h4>
                <i class='fa fa-check'></i> $titolo
            </h4>
            $messaggio
        </div>
        ";
        echo $html;
    }

    public static function FORM_NUOVO_CODICE($libri, $formID) {
        $html = "
        <div class='row'>
        <div class='col-md-12'>
            <form action='admin_codici.php' method='post'>
                        
            <div class='form-group'>
                <label for='librofk'>Seleziona il libro</label>
                <select class='form-control' style='width: 100%;' name='librofk' required>
        ";
        echo $html;

        foreach ($libri as $lib) {
            echo "<option value='$lib->id'>$lib->casaeditrice - $lib->titolo</option>";
        }

        $html = "
                </select>
            </div>    
            <div class='form-group'>
                <label for='Denominazione'>Denominazione</label>
                <input type='text' class='form-control' id='Denominazione' placeholder='Denominazione' name='denominazione' required>
            </div>

            <div class='form-group'>
                <input type='hidden' name='formid' value='$formID'>
                <button type='submit' class='btn btn-info btn-block btn-lg'>NUOVO</button>
            </div>
            </form>
        </div>
        </div>
        ";
        echo $html;
    }

    public static function LIST_TABLE_CODICE($codici) {
        $html = "
        <div class='row'>
        <div class='col-md-12'>
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th>Denominazione</th>
              <th>Titolo</th>
              <th class='hidden-xs hidden-sm'>Prezzo</th>
              <th>Codice</th>
              <th class='hidden-xs hidden-sm'>Download</th>
              <th>#</th>
              <th>X</th>
            </tr>
          </thead>
          <tbody>
        ";
        echo $html;

        foreach ($codici as $cod) {
            echo "<tr>";
            echo " <td>".$cod->denominazione."</td>";
            echo " <td>".$cod->getLibro()->titolo."</td>";
            echo " <td class='hidden-xs hidden-sm'>&euro; ".$cod->getLibro()->prezzo."</td>\n";
            echo " <td>".convertiCodiceSeparatore($cod->codice)."</td>\n";
            echo " <td class='hidden-xs hidden-sm'>".$cod->download."</td>\n";
            echo " <td><a href='ripristina.php?codiceid=".$cod->id."'><i class='fa fa-refresh fa-lg verde'></i></a></td>";
            echo " <td><i class='fa fa-times fa-lg rosso' aria-hidden='true'></i></td>";
            echo "</tr>";
        }

        $html = "
          </tbody>
        </table>
        </div>
        </div>
        ";
        echo $html;
    }

    public static function FORM_NUOVO_LIBRO($formID) {
        $html = "
        <div class='row'>
        <div class='col-md-12'>
            <form action='admin_libri.php' method='post'>
                <div class='form-group'>
                    <label for='Titolo'>Titolo</label>
                    <input type='text' class='form-control' id='Titolo' placeholder='Titolo' name='titolo' required>
                </div>
                <div class='form-group'>
                    <label for='Autore'>Autore</label>
                    <input type='text' class='form-control' id='Autore' placeholder='Autore' name='autore' required>
                </div>
                <div class='form-group'>
                    <label for='Casa_Editrice'>Casa Editrice</label>
                    <input type='text' class='form-control' id='Casa_Editrice' placeholder='Casa Editrice' name='ce' required>
                </div>
                <div class='form-group'>
                    <label for='ISBN'>ISBN</label>
                    <input type='text' class='form-control' id='ISBN' placeholder='ISBN' name='isbn' required>
                </div>
                <div class='form-group'>
                    <label for='Prezzo'>Prezzo <em>(separatore ',')</em></label>
                    <input type='number' class='form-control' id='Prezzo' placeholder='Prezzo' step='0.01' max='1000' min='0' name='prezzo' required>
                </div>
                <div class='form-group'>
                    <label for='Nome_file'>Nome file</label>
                    <input type='text' class='form-control' id='Nome_file' placeholder='Nome file' name='nomefile' required>
                </div>
                <div class='form-group'>
                    <label for='fileToUpload'>Seleziona il file da caricare</label>
                    <input type='file' name='fileToUpload' id='fileToUpload'>
                </div>
                <div class='form-group'>
                    <input type='hidden' name='formid' value='$formID'>
                    <button type='submit' class='btn btn-info btn-block btn-lg'>NUOVO</button>
                </div>
            </form>
        </div>
        </div>
        ";
        echo $html;
    }

    public static function LIST_TABLE_LIBRI($libri) {
        $html = "
        <div class='row'>
        <div class='col-md-12'>
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th>Titolo</th>
              <th>Autore</th>
              <th class='hidden-xs hidden-sm'>ISBN</th>
              <th>Prezzo</th>
              <th class='hidden-xs hidden-sm'>Nome file</th>
              <th class='hidden-xs hidden-sm'>#</th>
            </tr>
          </thead>
          <tbody>
        ";
        echo $html;

        foreach ($libri as $lib) {
            echo "<tr>";
            echo " <td>$lib->casaeditrice - $lib->titolo</td>";
            echo " <td>$lib->autore</td>";
            echo " <td>$lib->isbn</td>";
            echo " <td>&euro; $lib->prezzo</td>";
            echo " <td>$lib->nomefile</td>";
            echo " <td><i class='fa fa-times fa-lg rosso' aria-hidden='true'></i></td>";
            echo "</tr>";
        }

        $html = "
          </tbody>
        </table>
        </div>
        </div>
        ";
        echo $html;
    }
}