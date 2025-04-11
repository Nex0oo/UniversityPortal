
<?php 
  $row = get_user_studente($_SESSION['email']);
  $_SESSION['matricola1'] = $row['matricola'];
  $matricola_studente = $row['matricola'];
  $_SESSION['cdl'] = $row['id_cdl'];
  $iscrizioni = get_iscrizioni($matricola_studente);
  $esami_carriera = get_esami($matricola_studente);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Studente</title>
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
                <a class="nav-link" href="iscrizioniesami.php">Iscrizione esami</a>
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
              <h4>Le tue informazioni:</h4>
                <ul class="list-group">
                    <li class="list-group-item">Matricola: <?php echo $row['matricola']?></li>
                    <li class="list-group-item">Nome: <?php echo $row['nome_studente']?></li>
                    <li class="list-group-item">Cognome: <?php echo $row['cognome']?></li>
                    <li class="list-group-item">Corso di laurea: <?php echo $row['nome']?></li>
                  </ul>
            </div>
        </div>
      </div>


      <div class="container mt-5 border">
        <h3 class="text-center">Iscrizioni esami</h3>
        </br>
        <?php 
        if (count($iscrizioni) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun iscrizione.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Nome insegnamento</th>
                    <th>Data dell'appello</th>
                    <th>Codice insegnamento</th>
                </tr>
            </thead>
            <tbody>
        <?php
        
        foreach($iscrizioni as $iscrizione){
        ?>
            <tr>
                <td><?php echo $iscrizione[0]; ?></td>
                <td><?php echo $iscrizione[1]; ?></td>
                <td><?php echo $iscrizione[2]; ?></td>
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
        <h3 class="text-center">Esami dati</h3>
        </br>
        <?php 
        if (count($esami_carriera) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun esame.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Nome esame</th>
                    <th>Data</th>
                    <th>Voto</th>
                    <th>Lode</th>
                </tr>
            </thead>
            <tbody>
        <?php
        
        foreach($esami_carriera as $esame){
        ?>
            <tr>
                <td><?php echo $esame[1]; ?></td>
                <td><?php echo $esame[2]; ?></td>
                <td><?php echo $esame[3]; ?></td>
                <td><?php echo $esame[4]; ?></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        </table>
        <?php
            }
?>  


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>