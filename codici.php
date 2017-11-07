<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Codici - Ebook</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
  <link href="css/stile.css" rel="stylesheet">
</head>
<body>

  <div class="container theme-showcase" role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <h1>Nuovo Codice</h1>
    </div>

    <!-- Fixed navbar -->
    <?php include 'menu.php'; ?>

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
    if (!empty($_POST['librofk']) && (isset($_POST['formid']) && isset($_SESSION['formid']) && $_POST["formid"] == $_SESSION["formid"])) {
      // cancello il formid
      $_SESSION["formid"] = '';

      if (empty($_POST['librofk'])) {
        $errors['librofk'] = 'libro non passato';
      } else {
        $librofk = str_replace("'", "''",$_POST['librofk']);
      }

      if (empty($_POST['denominazione'])) {
        $errors['denominazione'] = 'denominazione non passato';
      } else {
        $denominazione = str_replace("'", "''",$_POST['denominazione']);
      }


      if (empty($errors)) {

        // CALCOLA CODICE
        // IN BASE ALL'LIBROFK TROVA ISBN E NUMERO PROGRESSIVO
        include 'config.php';
        try {
          $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
          $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

          $result = $db->query("SELECT COUNT(*) AS numero FROM codice WHERE librofk = '" . $librofk . "'");
          $row = $result->fetch(PDO::FETCH_ASSOC);
          $progressivo = $row['numero'] + 1;

          $result = $db->query("SELECT libro.isbn FROM libro WHERE libroid = '" . $librofk . "'");
          $row = $result->fetch(PDO::FETCH_ASSOC);
          $isbn = $row['isbn'];

          // chiude il database
          $db = NULL;
        } catch (PDOException $e) {
          $errors['database'] = "Errore ricerca ISBN e numero progressivo nel database";
        }

        include 'classecodici.php';

        $download = 0;
        $codice = new Codice($isbn,$progressivo);

        try {
          $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
          $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

          $sql = "INSERT INTO codice (codiceid, denominazione, codice, librofk, download) "
          ."VALUES (NULL, '" . $denominazione . "', '" . $codice->getCodice() . "', '" . $librofk . "', '" . $download ."');";

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
      }
      unset($_POST);
      $_POST = array();
    }

    // Creo il formid per questa sessione
    $_SESSION["formid"] = md5(rand(0,10000000));

    ?>


    <div class="page-header">
      <h1>Inserisci</h1>
    </div>
    <div class="row">

      <form action="codici.php" method="post">

        <div class="col-md-12">
          <div class="form-group">
            <label for="librofk">Seleziona il libro</label>
            <select class="form-control" style="width: 100%;" name='librofk' required>
            <?php

            try {
              include 'config.php';
              $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
              $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
              $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

              $sql = 'SELECT libro.* FROM libro '
              .'ORDER BY casaeditrice ASC, titolo ASC, autore ASC';

              $result = $db->query($sql);
              foreach ($result as $row) {
                $row = get_object_vars($row);
                print "<option value='" . $row['libroid'] . "'>" . db2html($row['casaeditrice']." - ".$row['titolo']) . "</option>\n";
              }
              // chiude il database
              $db = NULL;
            } catch (PDOException $e) {
              throw new PDOException("Error  : " . $e->getMessage());
            }

            ?>
            </select>
          </div>
          <div class="form-group">
            <label for="Denominazione">Denominazione</label>
            <input type="text" class="form-control" id="Denominazione" placeholder="Denominazione" name="denominazione" required>
          </div>
        </div>

        <div class="col-md-12">
          <input type="hidden" name="formid" value='<?php echo htmlspecialchars($_SESSION["formid"]); ?>'>
          <button type="submit" class="btn btn-info btn-block btn-lg">NUOVO</button>
        </div>

      </form>


    </div>






    <div class="page-header">
      <h1>Lista codici</h1>
    </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Denominazione</th>
              <th>Titolo</th>
              <th class='hidden-xs hidden-sm'>Prezzo</th>
              <th>Codice</th>
              <th class='hidden-xs hidden-sm'>Download</th>
              <th>#</th>
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
              $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET CHARACTER SET UTF8');

              $sql = 'SELECT codice.*, libro.titolo, libro.casaeditrice, libro.prezzo FROM codice '
              .'INNER JOIN libro ON codice.librofk = libro.libroid '
              .'ORDER BY codiceid DESC ';

              $result = $db->query($sql);
              foreach ($result as $row) {
                $row = get_object_vars($row);
                print "<tr>\n";
                print " <td>".db2html($row['denominazione'])."</td>\n";
                print " <td>".db2html($row['casaeditrice'])." - ".db2html($row['titolo'])."</td>\n";
                print " <td class='hidden-xs hidden-sm'>&euro; ".$row['prezzo']."</td>\n";
                print " <td>".convertiCodiceSeparatore($row['codice'])."</td>\n";
                print " <td class='hidden-xs hidden-sm'>".$row['download']."</td>\n";
                print " <td><a href='ripristina.php?codiceid=".$row['codiceid']."'><span class='glyphicon glyphicon-refresh verde' aria-hidden='true'></span></a></td>\n";
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








  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
