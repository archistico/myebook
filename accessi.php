<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Codici - Accessi</title>

  <link href="vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
  <link href="css/stile.css" rel="stylesheet">
</head>
<body>

  <div class="container theme-showcase" role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <h1>Accessi effettuati</h1>
    </div>

    <!-- Fixed navbar -->
    <?php include 'menu.php'; ?>

    <div class="page-header">
      <h1>Lista accessi</h1>
    </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class='hidden-xs hidden-sm'>#</th>
              <th>Descrizione</th>
              <th>Codice</th>
              <th>Data</th>
              <th>IP</th>
              <th class='hidden-xs hidden-sm'>Download</th>
              <th class='hidden-xs hidden-sm'>Login</th>
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

              // INSERT INTO `accesso` (`accessoid`, `descrizione`, `codice`, `data`, `ip`, `download`, `login`) VALUES (NULL, 'Prova accesso iniziale', 'codice: nullo', CURRENT_TIMESTAMP, 'mio IP', '0', '0');

              $sql = 'SELECT accesso.* FROM accesso '
                    .'ORDER BY accessoid DESC';

              $result = $db->query($sql);
              foreach ($result as $row) {
                $row = get_object_vars($row);
                print "<tr>\n";

                print " <td class='hidden-xs hidden-sm'>".$row['accessoid']."</td>\n";
                print " <td>".$row['descrizione']."</td>\n";
                print " <td>".$row['codice']."</td>\n";
                print " <td>".$row['data']."</td>\n";
                print " <td>".$row['ip']."</td>\n";

                if ($row['download']) {
                  print " <td class='hidden-xs hidden-sm'><span class='glyphicon glyphicon-ok verde' aria-hidden='true'></span></td>\n";
                } else {
                  print " <td class='hidden-xs hidden-sm'><span class='glyphicon glyphicon-minus rosso' aria-hidden='true'></span></td>\n";
                }

                if ($row['login']) {
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
