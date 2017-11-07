<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Download Ebook - Elmi's World</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
  <link href="css/stile.css" rel="stylesheet">
</head>
<body>

  <div class="container theme-showcase" role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <h1>Casa editrice Elmi's World</h1>
      <p>Download ebook tramite codice<p>
      </div>

      <!-- Fixed navbar -->
      <?php include 'menu.php'; ?>

      <div class="page-header">
        <h1>Caricamento</h1>
      </div>
      <div class="row">
        <div class="col-md-12">

          <?php

          // Controllare i dati passati
          // Cercare il nomedelfile in base al librofk
          // Cambiarlo con md5("elmisworld".$row['nomefile']).".zip"
          if (empty($_POST['librofk'])) {
            $errors['librofk'] = 'libro non passato';
          } else {
            $librofk = $_POST['librofk'];
          }

          if (empty($errors)) {

            include 'config.php';
            try {
              $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
              $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
              $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

              $sql = "SELECT libro.nomefile FROM libro WHERE libroid = '{$librofk}'";

              $result = $db->query($sql);
              $row = $result->fetch(PDO::FETCH_ASSOC);
              $nomefilemd5 = md5("elmisworld".$row['nomefile']).".zip";

              // chiude il database
              $db = NULL;
            } catch (PDOException $e) {
              $errors['database'] = "Errore ricerca ISBN e numero progressivo nel database";
            }

            $cartella = "";
            $destinazione_file = $cartella . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $tipofile = pathinfo($destinazione_file,PATHINFO_EXTENSION);

            //echo $destinazione_file."<br>";
            //echo $tipofile."<br>";
            //echo $nomefilemd5."<br>";

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
              $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
              if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
              } else {
                echo "File is not an image.";
                $uploadOk = 0;
              }
            }
            // Check if file already exists
            if (file_exists($destinazione_file)) {
              echo "ERRORE! Il file è già esistente<br>";
              $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 10000000) {
              echo "ERRORE! Il file è troppo grande<br>";
              $uploadOk = 0;
            }
            // Allow certain file formats
            if($tipofile != "epub") {
              echo "ERRORE! Formato di file non supportato";
              $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            $destinazione_file = $cartella . $nomefilemd5;
            
            if ($uploadOk == 0) {
              echo "ERRORE DURANTE IL CARICAMENTO<br>";
              // if everything is ok, try to upload file
            } else {
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $destinazione_file)) {
                echo "L'ebook ". basename( $_FILES["fileToUpload"]["name"]). " è stato caricato.";
              } else {
                echo "ERRORE DURANTE IL CARICAMENTO<br>";
              }
            }

            // Chiusura se non ci sono errori di invio
          }
          ?>





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
