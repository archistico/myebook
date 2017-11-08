<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Codici - Ebook</title>

  <link href="vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
  <link href="css/stile.css" rel="stylesheet">
</head>
<body>

  <div class="container theme-showcase" role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <h1>Nuovo Ebook</h1>
    </div>

    <!-- Fixed navbar -->
    <?php include 'menu.php'; ?>

    <?php
    // INSERIMENTO
    // TODO: Controllare le stringhe per eventuale apostrofi e convertirli

    // RECUPERO DATI E AGGIUNGO
    define('CHARSET', 'UTF-8');
    define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

    $errors = array();
    session_start();

    // if sono presenti tutti
    if (!empty($_POST['titolo']) && (isset($_POST['formid']) && isset($_SESSION['formid']) && $_POST["formid"] == $_SESSION["formid"])) {
      // cancello il formid
      $_SESSION["formid"] = '';

      if (empty($_POST['titolo'])) {
        $errors['titolo'] = 'titolo non passato';
      } else {
        $titolo = str_replace("'", "''",$_POST['titolo']);
      }

      if (empty($_POST['autore'])) {
        $errors['autore'] = 'autore non passato';
      } else {
        $autore = str_replace("'", "''",$_POST['autore']);
      }

      if (empty($_POST['ce'])) {
        $errors['ce'] = 'casa editrice non passato';
      } else {
        $ce = str_replace("'", "''",$_POST['ce']);
      }

      include 'utilita.php';

      if (empty($_POST['isbn'])) {
        $errors['isbn'] = 'isbn non passato';
      } else {
        $isbn = solonumeri($_POST['isbn']);
      }

      if (empty($_POST['nomefile'])) {
        $errors['nomefile'] = 'nomefile non passato';
      } else {
        $nomefile = str_replace("'", "''",$_POST['nomefile']);
      }

      if (empty($_POST['prezzo'])) {
        $errors['prezzo'] = 'prezzo non passato';
      } else {
        $prezzo = str_replace(",", ".",$_POST['prezzo']);
      }

      if (empty($errors)) {
        try {
          include 'config.php';

          $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
          $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

          $denominazione = trim($cognome . " " . $nome);

          $sql = "INSERT INTO libro (libroid, titolo, autore, casaeditrice, isbn, prezzo, nomefile) "
          ."VALUES (NULL, '" . $titolo . "', '" . $autore . "', '" . $ce . "', '" . $isbn . "', '" . $prezzo . "', '" . $nomefile ."');";

          $db->exec($sql);
          //echo $sql."<br>";

          // chiude il database
          $db = NULL;
        } catch (PDOException $e) {
          $errors['database'] = "Errore inserimento nel database";
        }
      }

      if (!empty($errors)) {
        echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Ci sono degli errori</div>";
      } else {
        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Inserimento riuscito</div>";
        unset($_POST);
        $_POST = array();
      }

    }

    // Creo il formid per questa sessione
    $_SESSION["formid"] = md5(rand(0,10000000));

    ?>


    <div class="page-header">
      <h1>Inserisci</h1>
    </div>
    <div class="row">

      <form action="ebook.php" method="post">

        <div class="col-md-6">
          <div class="form-group">
            <label for="Titolo">Titolo</label>
            <input type="text" class="form-control" id="Titolo" placeholder="Titolo" name="titolo" required>
          </div>
          <div class="form-group">
            <label for="Autore">Autore</label>
            <input type="text" class="form-control" id="Autore" placeholder="Autore" name="autore" required>
          </div>
          <div class="form-group">
            <label for="Casa_Editrice">Casa Editrice</label>
            <input type="text" class="form-control" id="Casa_Editrice" placeholder="Casa Editrice" name="ce" required>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="ISBN">ISBN</label>
            <input type="text" class="form-control" id="ISBN" placeholder="ISBN" name="isbn" required>
          </div>
          <div class="form-group">
            <label for="Prezzo">Prezzo <em>(separatore ",")</em></label>
            <input type="number" class="form-control" id="Prezzo" placeholder="Prezzo" step="0.01" max="1000" min="0" name="prezzo" required>
          </div>
          <div class="form-group">
            <label for="Nome_file">Nome file</label>
            <input type="text" class="form-control" id="Nome_file" placeholder="Nome file" name="nomefile" required>
          </div>

        </div>

        <div class="col-md-12">
          <input type="hidden" name="formid" value='<?php echo htmlspecialchars($_SESSION["formid"]); ?>'>
          <button type="submit" class="btn btn-info btn-block btn-lg">NUOVO</button>
        </div>

      </form>


    </div>


    <div class="page-header">
      <h1>Carica ebook sul server</h1>
    </div>

    <div class="row">
      <form action="carica.php" method="post" enctype="multipart/form-data">
        <div class="col-md-6">
          <div class="form-group">
            <label for="librofk">Seleziona il libro</label>
            <select class="form-control" style="width: 100%;" name='librofk' required>
              <?php

              try {
                include 'config.php';
                include 'utilita.php';
                $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

                $sql = 'SELECT libro.* FROM libro '
                .'ORDER BY casaeditrice ASC, titolo ASC, autore ASC';

                $result = $db->query($sql);
                foreach ($result as $row) {
                  $row = get_object_vars($row);
                  print "<option value='" . $row['libroid'] . "'>" . convertiStringaToHTML($row['casaeditrice']." - ".$row['titolo']) . "</option>\n";
                }
                // chiude il database
                $db = NULL;
              } catch (PDOException $e) {
                throw new PDOException("Error  : " . $e->getMessage());
              }

              ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="fileToUpload">Seleziona il file da caricare</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
          </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <button type="submit" class="btn btn-info btn-block btn-lg">CARICA</button>
            </div>
          </div>
        </form>
      </div>


      <div class="page-header">
        <h1>Lista ebook</h1>
      </div>

      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered">
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
              <?php

              try {
                include 'config.php';
                $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

                $sql = 'SELECT libro.* FROM libro '
                .'ORDER BY casaeditrice ASC, titolo ASC, autore ASC';

                // TODO: sistemare i prezzi sul database

                $result = $db->query($sql);
                foreach ($result as $row) {
                  $row = get_object_vars($row);
                  print "<tr>\n";
                  print " <td>".$row['casaeditrice']." - ".$row['titolo']."</td>\n";
                  print " <td>".$row['autore']."</td>\n";
                  print " <td class='hidden-xs hidden-sm'>".$row['isbn']."</td>\n";
                  print " <td>&euro; ".$row['prezzo']."</td>\n";
                  print " <td class='hidden-xs hidden-sm'>".$row['nomefile']."</td>\n";
                  if (file_exists(md5("elmisworld".$row['nomefile']).".zip")) {
                    print " <td class='hidden-xs hidden-sm'><span class='glyphicon glyphicon-ok verde' aria-hidden='true'></span></td>\n";
                  } else {
                    print " <td class='hidden-xs hidden-sm'><span class='glyphicon glyphicon-minus rosso' aria-hidden='true'></span></td>\n";
                  }
                  print "</tr>\n";
                }
                // chiude il database
                $db = NULL;
              } catch (PDOException $e) {
                throw new PDOException("Error  : " . $e->getMessage());
              }

              ?>

            </tbody>
          </table>
        </div>
      </div>




      <br>
    </div> <!-- /container -->








    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>
  </body>
  </html>
