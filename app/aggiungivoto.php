<?php
include_once('../progetto/functions.php');
ini_set("display_errors", "On");
ini_set("error_reporting", E_ALL);
session_start();

$cdl = $_GET['cdl'];
$insegnamento = $_GET['insegnamento'];
$data_appello = $_GET['giorno'];
$matricola = $_GET['studente'];
$error_msg = '';
$success_msg = '';

if (isset($_GET['voto']) && isset($_GET['lode'])) {
    if (!empty($_GET['voto'])) {
        $voto = $_GET['voto'];
    } else {
        $error_msg = 'campo voto vuoto';
    }

    if (!empty($_GET['lode'])) {
        $lode = $_GET['lode'];
    } else {
        $error_msg = 'campo lode vuoto';
    }




    if (empty($error_msg)) {
        $db = open_pg_docenti_connection();

        $sql = "INSERT INTO unidb.esame VALUES ($1, $2, $3, DATE($4), $5, $6)";

        $params = array(
            $matricola,
            $insegnamento,
            $cdl,
            $data_appello,
            $voto,
            $lode
        );

        $result = pg_prepare($db, "aggiungi_esame", $sql);
        $result = pg_execute($db, "aggiungi_esame", $params);
        if ($result) {
            $success_msg = 'Esame aggiunto correttamente';
        } else {
            $error_msg = pg_last_error($db);
        }

        
    }

    if (!empty($success_msg)) {
        $_SESSION['success_msg'] = $success_msg;

        header("location: http://localhost/progetto/index.php");
    }


}


?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark" data-bs-theme="dark"">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">MyUni</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="aggiungiappelli.php">Aggiungi appelli</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="registrazioneesami.php">Registrazione esami</a>
              </li>
            </ul>
            <form action="logout.php" method="get">
              <input type="submit" value="Logout">
            </form> 
          </div>
        </div>
      </nav>


      <div class="container mt-5"> 
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div class="row">
            <h4>Inserisci il voto:</h4>
        </div>
        <div class="row mt-4">
            <div class="col-4">
                <input type="text" class="form-control-sm" placeholder="Voto" aria-label="Voto" name="voto">
            </div>
            <div class="col">
                <select class="form-select-sm" aria-label="Default select example" name="lode">
                    <option value="f">No</option>
                    <option value="t">Si</option>
                </select>
            </div>
            <div class="col">
                <input class="form-control-sm" type="text" value="<?php echo $matricola?>" name="studente" aria-label="readonly input example" readonly>
            </div>
            <div class="col">
                <input class="form-control-sm" type="text" value="<?php echo $insegnamento?>" name="insegnamento" aria-label="readonly input example" readonly>
            </div>
            <div class="col">
                <input class="form-control-sm" type="text" value="<?php echo $data_appello?>" name="giorno" aria-label="readonly input example" readonly>
            </div>
            <div class="col">
                <input class="form-control-sm" type="text" value="<?php echo $cdl?>" name="cdl" aria-label="readonly input example" readonly>
            </div>
        </div>
        <div class="mt-5">
            <button class="btn btn-secondary" type="submit" value="Submit">Conferma</button>
        </div>
        </form>
        </div>




        <?php 
        if (!empty($error_msg)) {
      ?>
        <div class="container mt-5">
            <div class="alert alert-danger" role="alert"> 
                <p><?php echo $error_msg?>
            </div>
        </div>
      <?php
        }
      ?>
        




</body>
</html>