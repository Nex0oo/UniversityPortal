<?php
include_once('../progetto/functions.php');
ini_set("display_errors", "On");
ini_set("error_reporting", E_ALL);
session_start();

$success_msg = '';
$error_msg = '';
if (isset($_POST['cod_cdl']) && isset($_POST['nome_cdl']) && isset($_POST['tipologia'])) {
    if (!empty($_POST['cod_cdl'])) {
        $cod_cdl = $_POST['cod_cdl'];
    } else {
        $error_msg = 'Campo codice corso di laurea vuoto';
    }

    if (!empty($_POST['nome_cdl'])) {
        $nome_cdl = $_POST['nome_cdl'];
    } else {
        $error_msg = 'Campo nome corso di laurea vuoto';
    }

    if (!empty($_POST['tipologia'])) {
        $tipologia = $_POST['tipologia'];
    } else {
        $error_msg = 'Campo tipologia vuoto';
    }

    if (empty($error_msg)) {
        $db = open_pg_segreteria_connection();

        $sql = "INSERT INTO unidb.cdl VALUES ($1, $2, $3)";

        $params = array(
            $cod_cdl,
            $nome_cdl,
            $tipologia
        );


        $result = pg_prepare($db, "aggiungi_cdl", $sql);
        $result = pg_execute($db, "aggiungi_cdl", $params);
        if ($result) {
            $success_msg = 'Corso di laurea aggiunto correttamente';
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
    <title>Aggiungi corso di laurea</title>
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
                <a class="nav-link" href="aggiungistudente.php">Aggiungi studenti</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="aggiungidocente.php">Aggiungi docenti</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="aggiungicdl.php">Aggiungi cdl</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="aggiungiinsegnamento.php">Gestione insegnamenti</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="modificapw.php">Modifica password</a>
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
            <h4>Inserisci le informazioni del nuovo corso di laurea:</h4>
        </div>
        <div class="row mt-4">
            <div class="col-md-2">
            <input type="text" class="form-control-sm" placeholder="Codice cdl" aria-label="cod_cdl" name="cod_cdl">
            </div>
            <div class="col-md-2">
            <input type="text" class="form-control-sm" placeholder="Nome cdl" aria-label="nome_cdl" name="nome_cdl">
            </div>
            <div class="col-md-2">
                <select class="form-select-sm" aria-label="Default select example" name="tipologia">
                    <option value="T">Triennale</option>
                    <option value="M">Magistrale</option>
                </select>
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