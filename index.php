<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>Download Ebook - Elmi's World</title>
  
  <link href="vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
  <link href="css/stile.css" rel="stylesheet">
</head>
<body>



  <!-- Fixed navbar -->
  <?php //include 'menu.php'; ?>

  <div class="container theme-showcase" role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <h1>Casa editrice Elmi's World</h1>
      <p>Download ebook tramite codice<p>
      </div>

      <?php
      // INSERIMENTO
      // TODO: Controllare le stringhe per eventuale apostrofi e convertirli

      // RECUPERO DATI E AGGIUNGO
      define('CHARSET', 'UTF-8');
      define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);
      include 'utilita.php';

      $errors = array();
      session_start();

      // if sono presenti tutti
      if (!empty($_POST['codice'])) {

        if (empty($_POST['codice'])) {
          $errors['codice'] = 'codice non passato';
        } else {
          $codice = solonumeri($_POST['codice']);
        }

        if (empty($errors) && !empty($codice)) {
          // SE TUTTO OK CERCA IL CODICE

          try {
            include 'config.php';
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $sql = 'SELECT codice.*, libro.* FROM codice '
            .'INNER JOIN libro ON codice.librofk = libro.libroid '
            .'WHERE codice.codice = '.$codice.' ORDER BY codiceid DESC LIMIT 1';

            $result = $db->query($sql);
            foreach ($result as $row) {
              $row = get_object_vars($row);

              if($codice==$row['codice']){
                inserisciLog("Pagina scaricamento ebook", $codice, 0, 1);
                ?>

                <div class="row">

                  <div class="col-md-12">
                    <h3><?php echo $row['casaeditrice']. " - ". $row['titolo']; ?></h3>
                    <p>Autore: <?php echo $row['autore']; ?><br>
                      ISBN: <?php echo $row['isbn']; ?><br>
                      Prezzo: &euro; <?php echo $row['prezzo']; ?><br><br>

                      Acquirente: <?php echo $row['denominazione']; ?><br>
                      IP: <?php echo get_client_ip(); ?><br>
                      Data: <?php echo (new DateTime())->format('H:i:s d/m/Y'); ?><br><br>
                      Numero download: <?php echo $row['download']; ?>/3<br>
                    </p>
                    </div>

                    <?php if($row['download']<=2) { ?>
                      <form action="download.php" method="post">
                        <div class="col-md-12">
                          <input type="hidden" name="codiceid" value='<?php echo $row['codiceid']; ?>'>
                          <input type="hidden" name="file" value='<?php echo $row['nomefile']; ?>'>
                          <button type="submit" class="btn btn-info btn-lg">SCARICA</button>
                        </div>
                      </form>
                      </div>
                  <?php
                } else {
                  echo "</div>";
                  echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> Raggiunto il livello massimo di download permessi</h4>contattare info@elmisworld.it per ulteriori informazioni</div>";
                  inserisciLog("Massimo scaricamento raggiunto", $codice, 0, 0);
                }// chiudo il controllo max download


              } else {
                echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Codice non trovato</div>";
                inserisciLog("Codice non trovato", $codice, 0, 0);
              }

            }
            // chiude il database
            $db = NULL;
          } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
          }

        } else {
          echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Codice non valido</div>";
          inserisciLog("Codice non valido", str_replace("'", "''",$_POST['codice']), 0, 0);
        }

        if (!empty($errors)) {
          echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Ci sono degli errori</div>";
        }

      }


      ?>


      <div class="page-header">
        <h1>Cerca ebook</h1>
      </div>
      <div class="row">
      <div class="col-md-12">
        <form action="index.php" method="post">

          
            <div class="form-group">
              <label for="Codice">Inserisci il codice</label>
              <input type="text" class="form-control" id="Codice" placeholder="Codice" name="codice" maxlength="25" required>
            </div>
            <input type="hidden" name="formid" value='<?php echo htmlspecialchars($_SESSION["formid"]); ?>'>
            <button type="submit" class="btn btn-info btn-block btn-lg">CERCA</button>
          

        </form>
        </div>

      </div>

      <br>
    </div> <!-- /container -->








    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>
  </body>
  </html>
