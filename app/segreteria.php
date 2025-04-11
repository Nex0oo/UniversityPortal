<?php
include_once('../progetto/functions.php');
ini_set("display_errors", "On");
ini_set("error_reporting", E_ALL);
$studenti = get_studenti_attivi();
$studenti_passati = get_studenti_storico();
$docenti = get_docenti();
$corsi = get_cdl_segreteria();




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


      <div class="container mt-5 border">
        <h3 class="text-center">Studenti iscritti attivi:</h3>
        </br>
        <?php 
        if (count($studenti) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun studente attivo.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Matricola</th>
                    <th>Nome studente</th>
                    <th>Cognome studente</th>
                    <th>Codice cdl</th>
                    <th>Nome cdl</th>
                    <th>Carriera</th>
                    <th>Eliminazione studente</th>
                </tr>
            </thead>
            <body>
        <?php
        
        foreach($studenti as $studente){
          $link = 'vedicarriera.php?matricola='.$studente[0].'&nome_studente='.$studente[1].'&cognome_studente='.$studente[2].'&attivo=true';
          $link_eliminazione_studente = 'eliminazioneutente.php?matricola='.$studente[0].'&tipo=studente';
        ?>
            <tr>
                <td><?php echo $studente[0]; ?></td>
                <td><?php echo $studente[1]; ?></td>
                <td><?php echo $studente[2]; ?></td>
                <td><?php echo $studente[3]; ?></td>
                <td><?php echo $studente[4]; ?></td>
                <td><a href="<?php echo $link; ?>">vedi carriera</a></td>
                <td><a href="<?php echo $link_eliminazione_studente; ?>">elimina studente</a></td>
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
        <h3 class="text-center">Storico studenti non più attivi:</h3>
        </br>
        <?php 
        if (count($studenti_passati) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun studente attivo.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Matricola</th>
                    <th>Nome studente</th>
                    <th>Cognome studente</th>
                    <th>Codice cdl</th>
                    <th>Nome cdl</th>
                    <th>Carriera</th>
                </tr>
            </thead>
            <body>
        <?php
        
        foreach($studenti_passati as $studente_storico){
          $link_storico = 'vedicarriera.php?matricola='.$studente_storico[0].'&nome_studente='.$studente_storico[1].'&cognome_studente='.$studente_storico[2].'&attivo=false';
        ?>
            <tr>
                <td><?php echo $studente_storico[0]; ?></td>
                <td><?php echo $studente_storico[1]; ?></td>
                <td><?php echo $studente_storico[2]; ?></td>
                <td><?php echo $studente_storico[3]; ?></td>
                <td><?php echo $studente_storico[4]; ?></td>
                <td><a href="<?php echo $link_storico; ?>">vedi carriera</a></td>
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
        <h3 class="text-center">Docenti:</h3>
        </br>
        <?php 
        if (count($docenti) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun docente.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Codice docente</th>
                    <th>Nome docente</th>
                    <th>Cognome docente</th>
                    <th>Corsi di cui è responsabile</th>
                    <th>Eliminazione docente</th>
                </tr>
            </thead>
            <body>
        <?php
        
        foreach($docenti as $docente){
          $link_corsi_responsabile = 'responsabilecorsi.php?id='.$docente[0];
          $link_eliminazione_docente = 'eliminazioneutente.php?id='.$docente[0].'&tipo=docente';
        ?>
            <tr>
                <td><?php echo $docente[0]; ?></td>
                <td><?php echo $docente[1]; ?></td>
                <td><?php echo $docente[2]; ?></td>
                <td><a href="<?php echo $link_corsi_responsabile?>"> vedi corsi</a></td>
                <td><a href="<?php echo $link_eliminazione_docente; ?>">elimina docente</a></td>
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
        <h3 class="text-center">Corsi di laurea:</h3>
        </br>
        <?php 
        if (count($corsi) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun docente.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Codice cdl</th>
                    <th>Nome cdl</th>
                    <th>Tipologia</th>
                    <th>Studenti iscritti</th>
                    <th>Insegnamenti</th>
                    <th>Eliminazione cdl</th>
                </tr>
            </thead>
            <body>
        <?php
       
        foreach($corsi as $corso){
          $link_insegnamenti = 'schedacdl.php?cdl='.$corso[0];
          $link_eliminazione_cdl = 'eliminazionecdl.php?cdl='.$corso[0];
          $link_studenti_iscritti = 'iscritticdl.php?cdl='.$corso[0].'&nome_cdl='.$corso[1];
        ?>
            <tr>
                <td><?php echo $corso[0]; ?></td>
                <td><?php echo $corso[1]; ?></td>
                <td><?php echo $corso[2]; ?></td>
                <td><a href="<?php echo $link_studenti_iscritti; ?>">vedi studenti iscritti</a></td>
                <td><a href="<?php echo $link_insegnamenti; ?>">vedi insegnamenti</a></td>
                <td><a href="<?php echo $link_eliminazione_cdl; ?>">elimina cdl</a></td>
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