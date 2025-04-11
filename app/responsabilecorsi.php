<?php
include_once('../progetto/functions.php');
ini_set("display_errors", "On");
ini_set("error_reporting", E_ALL);
$id_docente = $_GET['id'];
$corsi = get_corsi_responsabile($id_docente);



?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Responsabile corsi</title>
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


      <div class="container mt-5 border">
        <h3 class="text-center">Corsi di cui è responsabile:</h3>
        </br>
        <?php 
        if (count($corsi) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun corso.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Codice insegnamento</th>
                    <th>Nome insegnamento</th>
                    <th>Codice cdl</th>
                    <th>Nome cdl</th>
                    <th>Anno insegnamento</th>
                </tr>
            </thead>
            <body>
        <?php
        
        foreach($corsi as $corso){
        ?>
            <tr>
                <td><?php echo $corso[0]; ?></td>
                <td><?php echo $corso[1]; ?></td>
                <td><?php echo $corso[2]; ?></td>
                <td><?php echo $corso[3]; ?></td>
                <td><?php echo $corso[4]; ?></td>
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