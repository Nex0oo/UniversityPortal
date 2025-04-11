<?php
include_once('../progetto/functions.php');
ini_set("display_errors", "On");
ini_set("error_reporting", E_ALL);
$corsi = get_cdl_segreteria();
$docenti = get_docenti();
session_start();

$success_msg = '';
$error_msg = '';
if (isset($_POST['cod_insegnamento']) && isset($_POST['nome_insegnamento']) && isset($_POST['anno']) && isset($_POST['descrizione'])  && isset($_POST['cdl'])  && isset($_POST['docente'])) {
    if (!empty($_POST['cod_insegnamento'])) {
        $cod_insegnamento = $_POST['cod_insegnamento'];
    } else {
        $error_msg = 'Campo codice insegnamento vuoto';
    }

    if (!empty($_POST['nome_insegnamento'])) {
        $nome_insegnamento = $_POST['nome_insegnamento'];
    } else {
        $error_msg = 'Campo nome insegnamento vuoto';
    }

    if (!empty($_POST['anno'])) {
        $anno = $_POST['anno'];
    } else {
        $error_msg = 'Campo anno vuoto';
    }

    if (!empty($_POST['descrizione'])) {
        $descrizione = $_POST['descrizione'];
    } else {
        $descrizione = NULL;
    }

    if (!empty($_POST['cdl'])) {
        $cdl = $_POST['cdl'];
    } else {
        $error_msg = 'Campo corso di laurea vuoto';
    }

    if (!empty($_POST['docente'])) {
        $docente = $_POST['docente'];
    } else {
        $error_msg = 'Campo docente vuoto';
    }

   if (empty($error_msg)) {
        $db = open_pg_segreteria_connection();

        $sql = "INSERT INTO unidb.insegnamento VALUES ($1, $2, $3, $4, $5, $6)";

        $params = array(
            $cod_insegnamento,
            $cdl,
            $nome_insegnamento,
            $anno,
            $docente,
            $descrizione
        );


        $result = pg_prepare($db, "aggiungi_insegnamento", $sql);
        $result = pg_execute($db, "aggiungi_insegnamento", $params);
        if ($result) {
            $success_msg = 'Insegnamento aggiunto correttamente';
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
    <title>Segreteria</title>
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
                <a class="nav-link" href="aggiungipropedeutico.php">Aggiungi propedeutico</a>
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
            <h4>Inserisci le informazioni per il nuovo insegnamento:</h4>
        </div>
        <div class="row mt-5">
                <input type="text" class="form-control-sm" placeholder="Codice insegnamento" aria-label="Codice insegnamento" name="cod_insegnamento">
            </div>

            <div class="row mt-4">
                <input type="text" class="form-control-sm" placeholder="Nome insegnamento" aria-label="Nome insegnamento" name="nome_insegnamento">
            </div>

            <div class="row mt-4">
                <input type="text" class="form-control-sm" placeholder="Anno insegnamento" aria-label="Anno insegnamento" name="anno">
            </div>
            <div class="row mt-4">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Descrizione insegnamento:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="descrizione"></textarea>
            </div>
            </div>
            <div class="row mt-4">
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="cdl">
                    <option selected>Seleziona il corso di laurea:</option>
                   <?php 
                        foreach ($corsi as $corso) {
                    ?>
                    <option value="<?php echo $corso[0];?>"><?php echo $corso[1];?></option>
                    <?php
                          }

                    ?>
                </select>
            </div>
            <div class="row mt-4">
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="docente">
                    <option selected>Seleziona il docente:</option>
                   <?php 
                        foreach ($docenti as $docente) {
                    ?>
                    <option value="<?php echo $docente[0];?>"><?php echo $docente[1].' '.$docente[2];?></option>
                    <?php
                          }

                    ?>
                </select>
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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>