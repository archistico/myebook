<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Codici - Ebook ripristina download</title>

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

    <div class="page-header">
      <h1>Aggiornamento massimo download</h1>
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

    if (empty($_GET['codiceid'])) {
      $errors['codiceid'] = 'codiceid non passato';
    } else {
      $codiceid = $_GET['codiceid'];
    }

    if (empty($errors)) {

      // AGGIORNA IL DOWNLOAD
      include 'config.php';
      try {
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $sql = "UPDATE codice SET download = '0' WHERE codice.codiceid = {$codiceid};";
        $db->exec($sql);

        // chiude il database
        $db = NULL;
      } catch (PDOException $e) {
        $errors['database'] = "Errore inserimento nel database";
      }
    }
    if (!empty($errors)) {
      echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Ci sono degli errori</div>";
    } else {
      echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Aggiornamento riuscito</div>";
    }
    ?>


    <br>
  </div> <!-- /container -->

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
