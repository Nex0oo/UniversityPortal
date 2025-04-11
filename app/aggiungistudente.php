<?php
include_once('../progetto/functions.php');
ini_set("display_errors", "On");
ini_set("error_reporting", E_ALL);
session_start();

$success_msg = '';
$error_msg = '';
if (isset($_POST['matricola']) && isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['cod_cdl']) && isset($_POST['username']) && isset($_POST['pw'])) {
    if (!empty($_POST['matricola'])) {
        $matricola = $_POST['matricola'];
    } else {
        $error_msg = 'Campo matricola vuoto';
    }

    if (!empty($_POST['nome'])) {
        $nome = $_POST['nome'];
    } else {
        $error_msg = 'Campo nome vuoto';
    }

    if (!empty($_POST['cognome'])) {
        $cognome = $_POST['cognome'];
    } else {
        $error_msg = 'Campo cognome vuoto';
    }

    if (!empty($_POST['cod_cdl'])) {
        $cod_cdl = $_POST['cod_cdl'];
    } else {
        $error_msg = 'Campo codice cdl vuoto';
    }

    if (!empty($_POST['cod_cdl'])) {
        $cod_cdl = $_POST['cod_cdl'];
    } else {
        $error_msg = 'Campo codice corso di laurea vuoto';
    }

    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $error_msg = 'Campo username vuoto';
    }

    if (!empty($_POST['pw'])) {
        $pw = $_POST['pw'];
    } else {
        $error_msg = 'Campo password vuoto';
    }


    if (empty($error_msg)) {
        $db = open_pg_segreteria_connection();

        $sql = "INSERT INTO unidb.studente VALUES ($1, $2, $3, $4, $5, $6)";

        $params = array(
            $matricola,
            $nome,
            $cognome,
            $cod_cdl,
            $username,
            $pw
        );


        $result = pg_prepare($db, "aggiungi_studente", $sql);
        $result = pg_execute($db, "aggiungi_studente", $params);
        if ($result) {
            $success_msg = 'Studente aggiunto correttamente';
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
    <title>Aggiungi studente</title>
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
            <h4>Inserisci le informazioni del nuovo studente:</h4>
        </div>
        <div class="row mt-4">
            <div class="col">
            <input type="text" class="form-control-sm" placeholder="Matricola" aria-label="matricola" name="matricola">
            </div>
            <div class="col">
            <input type="text" class="form-control-sm" placeholder="Nome" aria-label="nome" name="nome">
            </div>
            <div class="col">
            <input type="text" class="form-control-sm" placeholder="Cognome" aria-label="cognome" name="cognome">
            </div>
            <div class="col">
            <input type="text" class="form-control-sm" placeholder="Codice cdl" aria-label="cod_cdl" name="cod_cdl">
            </div>
            <div class="col">
            <input type="text" class="form-control-sm" placeholder="Username" aria-label="username" name="username">
            </div>
            <div class="col">
            <input type="password" class="form-control-sm" placeholder="Password" aria-label="pw" name="pw">
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