<?php 
include_once ('../progetto/functions.php'); 
    $corsi = get_cdl();
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
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
   
    

    <div class="container mt-5">
        <div class="row">
            <h3 class=".text-secondary">Scopri i vari corsi di laurea:</h3>
        </div>
        <div class="row">
    <?php
        
        for($i = 1; $i <= count($corsi); $i++){
            $link = 'schedacdl.php?cdl='.$corsi[$i][0];
            
    ?>

    <div class="card mb-3 mr-3" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title"><?php echo $corsi[$i][1]; ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo $corsi[$i][0]; ?></h6>
            <p class="card-text">Questo è un corso: <?php echo $corsi[$i][2]; ?></p>
            <a href="<?php echo $link?>" class="card-link">Vai al corso</a>
        </div>
    </div>


    <?php
        }
    ?>
</div>
</div>
    
  </body>
</html>