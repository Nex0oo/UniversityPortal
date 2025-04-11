<?php
include_once('../progetto/functions.php');
ini_set("display_errors", "On");
ini_set("error_reporting", E_ALL);

$matricola = $_GET['matricola'];
$nome_studente = $_GET['nome_studente'];
$cognome_studente = $_GET['cognome_studente'];
$studente_attivo = $_GET['attivo'];
if ($studente_attivo == 'true') {
    $carriera_completa = carriera_studente_totale($matricola);
    $carriera_parziale = carriera_studente_parziale($matricola);
} else {
    $carriera_completa = storico_studente_totale($matricola);
    $carriera_parziale = storico_studente_parziale($matricola);
}



?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vedi carriera</title>
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
        <div class="container mt-5">
            <h4>Studente: <?php echo $nome_studente.' '.$cognome_studente.', '.$matricola?></h4>
        </div>
      <div class="container mt-3 border">
        <h3 class="text-center">Carriera completa:</h3>
        </br>
        <?php 
        if (count($carriera_completa) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun esame registrato.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Codice insegnamento</th>
                    <th>Nome insegnamento</th>
                    <th>Codice cdl</th>
                    <th>Data</th>
                    <th>Voto</th>
                </tr>
            </thead>
            <body>
        <?php
        
        foreach($carriera_completa as $esame_tot){
            if ($esame_tot[5] == 't') {
                $esame_tot[4] = $esame_tot[4].' e lode'; 
            }
        ?>
            <tr>
                <td><?php echo $esame_tot[0]; ?></td>
                <td><?php echo $esame_tot[1]; ?></td>
                <td><?php echo $esame_tot[2]; ?></td>
                <td><?php echo $esame_tot[3]; ?></td>
                <td><?php echo $esame_tot[4]; ?></td>
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
        <h3 class="text-center">Carriera parziale:</h3>
        </br>
        <?php 
        if (count($carriera_parziale) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun esame passato.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Codice insegnamento</th>
                    <th>Nome insegnamento</th>
                    <th>Codice cdl</th>
                    <th>Data</th>
                    <th>Voto</th>
                </tr>
            </thead>
            <body>
        <?php
        
        foreach($carriera_parziale as $esame_parziale){
            if ($esame_parziale[5] == 't') {
                $esame_parziale[4] = $esame_parziale[4].' e lode'; 
            }
        ?>
            <tr>
                <td><?php echo $esame_parziale[0]; ?></td>
                <td><?php echo $esame_parziale[1]; ?></td>
                <td><?php echo $esame_parziale[2]; ?></td>
                <td><?php echo $esame_parziale[3]; ?></td>
                <td><?php echo $esame_parziale[4]; ?></td>
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