<?php 
include_once ('../progetto/functions.php');
ini_set ("display_errors", "On");
ini_set("error_reporting", E_ALL);

    session_start();
    $error_msg = '';
    $success_msg = '';
    if (isset($_POST['pw']) && isset($_POST['pwconferma'])) {

        if (!empty($_POST['pw'])) {
            $pw = $_POST['pw'];
        } else {
            $error_msg = "Errore. Campo vuoto.";
        }

        if (!empty($_POST['pwconferma'])) {
            $pw_conf = $_POST['pwconferma'];
        } else {
            $error_msg = "Errore. Campo vuoto pw conferma.";
        } 
        
        if ($_POST['pw'] != $_POST['pwconferma']) {
            $error_msg = 'Le due password devono essere uguali!';
        }
        if (empty($error_msg)) {
            if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Studente') {
                $username = $_SESSION['email'];
                $db = open_pg_studenti_connection();

                $sql = "UPDATE unidb.studente SET password = $2 WHERE username = $1";

                $params = array(
                    $username,
                    $_POST['pw']
                );


                $result = pg_prepare($db, "edit_studente", $sql);
                $result = pg_execute($db, "edit_studente", $params);
                if ($result) {
                    $success_msg = 'Modifica andata a buon fine';
                } else {
                    $error_msg = pg_last_error($db);
                }
            }else if ($_SESSION['tipo'] == 'Docente') {
                $username = $_SESSION['email'];
                $db = open_pg_docenti_connection();

                $sql = "UPDATE unidb.docente SET password = $2 WHERE username = $1";

                $params = array(
                    $username,
                    $_POST['pw']
                );


                $result = pg_prepare($db, "edit_docente", $sql);
                $result = pg_execute($db, "edit_docente", $params);

                if ($result) {
                    $success_msg = 'Modifica andata a buon fine';
                } else {
                    $error_msg = pg_last_error($db);
                }
        } else {
                $username = $_SESSION['email'];
                $db = open_pg_segreteria_connection();

                $sql = "UPDATE unidb.segreteria SET password = $2 WHERE username = $1";

                $params = array(
                    $username,
                    $_POST['pw']
                );


                $result = pg_prepare($db, "edit_segreteria", $sql);
                $result = pg_execute($db, "edit_segreteria", $params);

                if ($result) {
                    $success_msg = 'Modifica andata a buon fine';
                } else {
                    $error_msg = pg_last_error($db);
                }
        } 
        
    }
}

    if (!empty($success_msg)) {
        $_SESSION['success_msg'] = $success_msg;

        header("location: http://localhost/progetto/index.php");
    }

    if (!empty($error_msg)) {
    ?>
        <div class="alert alert-danger" role="alert"> <p><?php echo $error_msg?></div>
    <?php
    }
   


?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifica password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">MyUni</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
              </li>
              <li>
                <a class="nav-link" href="modificapw.php">Modifica password</a>
              </li>
            </ul>
            <form action="logout.php" method="get">
              <input type="submit" value="Logout">
            </form> 
          </div>
        </div>
      </nav>

    

        
            <div class="container mt-5">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="row mt-5">
                    <h4>Modifica la tua password:</h4>
                </div>
                <div class="row g-3 align-items-center mt-3">
                    <div class="col-2">
                        <label for="inputPassword1" class="col-form-label">Nuova password</label>
                    </div>
                    <div class="col-auto">
                        <input type="password" class="form-control" aria-labelledby="passwordHelpInline" name="pw">
                    </div>
                </div>

                    <div class="row g-3 align-items-center mt-5">
                        <div class="col-2">
                            <label for="inputPassword2" class="col-form-label">Conferma password</label>
                        </div>
                        <div class="col-auto">
                            <input type="password" class="form-control" aria-labelledby="passwordHelpInline" name="pwconferma">
                        </div>   
                    </div>
                    <div class="mt-5">
                        <button class="btn btn-secondary" type="submit" value="Submit">Conferma</button>
                    </div>
                </div>
                </form>
            </div>
      
</body>
</html>