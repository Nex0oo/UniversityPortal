<?php
include_once('../progetto/functions.php');
ini_set("display_errors", "On");
ini_set("error_reporting", E_ALL);
session_start();

$cdl = $_GET['cdl'];
$insegnamento = $_GET['insegnamento'];
$data_appello = $_GET['giorno'];

$iscrizioni = get_iscritti($data_appello, $insegnamento, $cdl);
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


      <div class="container mt-5 border">
        <h3 class="text-center">Iscritti:</h3>
        </br>
        <?php 
        if (count($iscrizioni) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun iscritto.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Matricola studente</th>
                    <th>Codice insegnamento</th>
                    <th>Codice cdl</th>
                    <th>Voto</th>
                </tr>
            </thead>
            <body>
        <?php
       
        foreach($iscrizioni as $iscrizione){
        ?>
            <tr>
                <td><?php echo $iscrizione[0]; ?></td>
                <td><?php echo $iscrizione[1]; ?></td>
                <td><?php echo $iscrizione[2]; ?></td>
                <?php
                $check_esame = get_voto($iscrizione[0], $insegnamento, $cdl, $data_appello);
                if ($check_esame) {
                    if ($_SESSION['lode'] == 't') {
                        ?>
                        <td><?php echo $_SESSION['voto'].' e lode'; ?></td>
                        <?php
                    } else {
                        ?>
                        <td><?php echo $_SESSION['voto']; ?></td>
                        <?php
                    }
                } else {
                    $link = 'aggiungivoto.php?cdl='.$cdl.'&insegnamento='.$insegnamento.'&giorno='.$data_appello.'&studente='.$iscrizione[0];
                    ?>
                        <td><a href="<?php echo $link; ?>">Inserisci voto</a></td>
                    <?php
                }

                    unset($_SESSION['voto']);
                    unset($_SESSION['lode']);

                ?>
            </tr>
        <?php
        }
        ?>
        </tbody>
        </table>
        <?php
            }
        ?>  
      </div>

</body>
</html>