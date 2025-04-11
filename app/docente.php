<?php 
ini_set ("display_errors", "On");
ini_set("error_reporting", E_ALL);
  $row = get_user_docente($_SESSION['email']);
  $_SESSION['id_docente'] = $row['id'];
  $responsabili = get_responsabile($_SESSION['id_docente']);
  $appelli = get_appelli_docente($_SESSION['id_docente']);
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
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="aggiungiappelli.php">Aggiungi appelli</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="registrazioneesami.php">Registrazione esami</a>
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


      <?php 
        if (isset($_SESSION['success_msg'])) {
      ?>

      <div class="alert alert-success" role="alert">
        <p><?php echo $_SESSION['success_msg']; ?></p>
      </div>



      <?php
        unset($_SESSION['success_msg']);
        }

      ?>

      <div class="container mt-5">
        <div class="row">
            <div class="col">
                <ul class="list-group">
                    <li class="list-group-item">Codice: <?php echo $row['id']?></li>
                    <li class="list-group-item">Nome: <?php echo $row['nome']?></li>
                    <li class="list-group-item">Cognome: <?php echo $row['cognome']?></li>
                  </ul>
            </div>
        </div>
      </div>

      <div class="container mt-5 border">
        <h3 class="text-center">Responsabile corsi:</h3>
        </br>
        <?php 
        if (count($responsabili) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Non sei responsabile di nessun corso.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Nome insegnamento</th>
                    <th>Codice insegnamento</th>
                    <th>Codice corso di laurea</th>
                </tr>
            </thead>
            <tbody>
        <?php
      
        foreach($responsabili as $responsabile){
        ?>
            <tr>
                <td><?php echo $responsabile[1]; ?></td>
                <td><?php echo $responsabile[0]; ?></td>
                <td><?php echo $responsabile[2]; ?></td>
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



      <div class="container mt-5 border">
        <h3 class="text-center">Appelli esami:</h3>
        </br>
        <?php 
        if (count($appelli) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun appello.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Nome insegnamento</th>
                    <th>Codice insegnamento</th>
                    <th>Codice corso di laurea</th>
                    <th>Data appello</th>
                    <th>Eliminazione appello</th>
                </tr>
            </thead>
            <tbody>
        <?php
        
        foreach($appelli as $appello){
          $link_eliminazione_appello = 'eliminazioneappello.php?data='.$appello[0].'&insegnamento='.$appello[1].'&cdl='.$appello[3];
        ?>
            <tr>
                <td><?php echo $appello[1]; ?></td>
                <td><?php echo $appello[2]; ?></td>
                <td><?php echo $appello[3]; ?></td>
                <td><?php echo $appello[0]; ?></td>
                <td><a href="<?php echo $link_eliminazione_appello; ?>">elimina appello</a></td>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>