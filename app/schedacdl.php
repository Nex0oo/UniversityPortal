<?php 
    include_once ('../progetto/functions.php'); 
    session_start();
    $cdl = $_GET['cdl'];
   if ($_SESSION['tipo'] == 'Studente') {
        $insegnamenti = get_insegnamenti_cdl($cdl);
    } else {
        $insegnamenti = get_insegnamenti_cdl_segreteria($cdl);
    } 
    
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark" data-bs-theme="dark">
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
              <?php
                if ($_SESSION['tipo'] == 'Segreteria') {
                    echo '<li class="nav-item"><a class="nav-link" href="aggiungistudente.php">Aggiungi studenti</a></li><li class="nav-item"><a class="nav-link" href="aggiungidocente.php">Aggiungi docenti</a></li><li class="nav-item"><a class="nav-link" href="aggiungicdl.php">Aggiungi cdl</a></li><li class="nav-item"><a class="nav-link" href="aggiungiinsegnamento.php">Gestione insegnamenti</a></li><li class="nav-item"><a class="nav-link" href="modificapw.php">Modifica password</a></li></ul>';
                } else if ($_SESSION['tipo'] == 'Studente') {
                    echo '<li class="nav-item"><a class="nav-link" href="iscrizioniesami.php">Iscrizione esami</a></li><li class="nav-item"><a class="nav-link" href="pagecdl.php">Corsi di laurea</a></li><li class="nav-item"><a class="nav-link" href="modificapw.php">Modifica password</a></li></ul>';
                }
              ?>



            <form action="logout.php" method="get">
              <input type="submit" value="Logout">
            </form> 
          </div>
        </div>
      </nav>

      <div class="container mt-5 border">
        <h3 class="text-center">Insegnamenti</h3>
        </br>
        <?php
        if (count($insegnamenti) == 0) {?>
            <div class="alert alert-warning" role="alert">
                <p>Nessun insegnamento.</p>
            </div>
        <?php }
        else {?>
            <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>Codice</th>
                    <th>Nome</th>
                    <th>Anno</th>
                    <th>Docente</th>
                    <th>Descrizione</th>
                    <?php 
                        if ($_SESSION['tipo'] == 'Segreteria') {
                            echo '<th>Eliminazione insegnamento</th>';
                        }
                    
                    ?>
                </tr>
            </thead>
            <tbody>
        <?php
        
        foreach($insegnamenti as $insegnamento){
            $link_eliminazione_insegnamento = 'eliminazioneinsegnamento.php?insegnamento='.$insegnamento[0].'&cdl='.$cdl;
        ?>
            <tr>
                <td><?php echo $insegnamento[0]; ?></td>
                <td><?php echo $insegnamento[1]; ?></td>
                <td><?php echo $insegnamento[2]; ?></td>
                <td><?php echo $insegnamento[3]; ?></td>
                <td><?php echo $insegnamento[4]; ?></td>
                <?php 
                        if ($_SESSION['tipo'] == 'Segreteria') {
                            echo '<td><a href="'.$link_eliminazione_insegnamento.'">elimina insegnamento</a></td>';
                        }
                    
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