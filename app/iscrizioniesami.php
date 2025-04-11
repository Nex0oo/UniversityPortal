<?php 
include_once ('../progetto/functions.php'); 
  session_start();
  $appelli = get_appelli($_SESSION['cdl'], $_SESSION['matricola1']);
  
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iscrizione esami</title>
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
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="iscrizioniesami.php">Iscrizione esami</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pagecdl.php">Corsi di laurea</a>
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
        <h3 class="text-center">Appelli esami</h3>
        </br>
        <?php 
        if (count($appelli) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun appello disponibile.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Nome insegnamento</th>
                    <th>Data dell'appello</th>
                    <th>Codice insegnamento</th>
                    <th>Iscrizione</th>
                </tr>
            </thead>
            <tbody>
        <?php
        
        foreach($appelli as $appello){
            $link = 'getiscrizione.php?cdl='.$appello[3].'&insegnamento='.$appello[1].'&giorno='.$appello[0];
        ?>
            <tr>
                <td><?php echo $appello[2]; ?></td>
                <td><?php echo $appello[0]; ?></td>
                <td><?php echo $appello[1]; ?></td>
                <td><a href="<?php echo $link ?>">iscriviti</a></td>
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