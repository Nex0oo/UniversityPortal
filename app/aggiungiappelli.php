<?php
include_once('../progetto/functions.php');
ini_set("display_errors", "On");
ini_set("error_reporting", E_ALL);
session_start();
$responsabili = get_responsabile($_SESSION['id_docente']);

$success_msg = '';
$error_msg = '';
if (isset($_POST['giorno']) && isset($_POST['mese']) && isset($_POST['anno']) && isset($_POST['cod_insegnamento'])&& isset($_POST['cod_cdl'])) {
    if (!empty($_POST['giorno'])) {
        $giorno = $_POST['giorno'];
    } else {
        $error_msg = 'Campo giorno vuoto';
    }

    if (!empty($_POST['mese'])) {
        $mese = $_POST['mese'];
    } else {
        $error_msg = 'Campo mese vuoto';
    }

    if (!empty($_POST['anno'])) {
        $anno = $_POST['anno'];
    } else {
        $error_msg = 'Campo anno vuoto';
    }

    if (!empty($_POST['cod_insegnamento'])) {
        $cod_insegnamento = $_POST['cod_insegnamento'];
    } else {
        $error_msg = 'Campo codice insegnamento vuoto';
    }

    if (!empty($_POST['cod_cdl'])) {
        $cod_cdl = $_POST['cod_cdl'];
    } else {
        $error_msg = 'Campo codice corso di laurea vuoto';
    }

    if ($mese == '4' or $mese == '6' or $mese == '9' or $mese == '11' and $giorno == '31') {
        $error_msg = 'Il seguente mese non ha 31 giorni';
    } else if ($mese == '2') {
        $check_anno = is_bisestile($anno);
        if (!$check_anno and $giorno == '29') {
            $error_msg = 'Non è un anno bisestile';
        }
    }
    $flag_responsabile = false;

    foreach($responsabili as $responsabile) {
        if ($responsabile[0] == $cod_insegnamento && $responsabile[2] == $cod_cdl) {
            $flag_responsabile = true;
        }
    }

    if (!$flag_responsabile) {
        $error_msg = 'Non sei responsabile di questo insegnamento';
    }

    $data_appello = $anno.'-'.$mese.'-'.$giorno;
    if (empty($error_msg) && $flag_responsabile) {
        $db = open_pg_docenti_connection();

        $sql = "INSERT INTO unidb.appello VALUES ($1, $2, $3)";

        $params = array(
            $data_appello,
            $cod_insegnamento,
            $cod_cdl
        );


        $result = pg_prepare($db, "aggiungi_appello", $sql);
        $result = pg_execute($db, "aggiungi_appello", $params);
        if ($result) {
            $success_msg = 'Appello aggiunto correttamente';
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
                <a class="nav-link" href="registrazioneesami.php">Gestione esami</a>
              </li>
            </ul>
            <form action="logout.php" method="get">
              <input type="submit" value="Logout">
            </form> 
          </div>
        </div>
      </nav>

     



      <div class="container">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="row mt-5">
            <h4>Inserisci le informazioni per il nuovo appello:</h4>
        </div>
        <div class="row mt-4">
            <div class="col">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="giorno">
                    <option selected>Seleziona il giorno:</option>
                   <?php 
                        for ($x = 1; $x <= 31; $x++) {
                    ?>
                    <option value="<?php echo $x;?>"><?php echo $x;?></option>
                    <?php
                          }

                    ?>
                </select>
            </div>
            <div class="col">
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="mese">
                    <option selected>Seleziona il mese:</option>
                   <?php 
                        for ($x = 1; $x <= 12; $x++) {
                    ?>
                    <option value="<?php echo $x;?>"><?php echo $x;?></option>
                    <?php
                          }

                    ?>
                </select>
            </div>
            <div class="col">
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="anno">
                    <option selected>Seleziona l'anno:</option>
                   <?php 
                        for ($x = 2023; $x <= 2040; $x++) {
                    ?>
                    <option value="<?php echo $x;?>"><?php echo $x;?></option>
                    <?php
                          }

                    ?>
                </select>
            </div>
            <div class="col">
                <input type="text" class="form-control-sm" placeholder="Codice insegnamento" aria-label="Codice insegnamento" name="cod_insegnamento">
            </div>
            <div class="col">
                <input type="text" class="form-control-sm" placeholder="Codice corso di laurea" aria-label="Codice corso di laurea" name="cod_cdl">
            </div>
        </div>
        <input class="btn btn-secondary mt-4" type="submit" value="Inserisci">
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