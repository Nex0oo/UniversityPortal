<?php 
  ini_set ("display_errors", "On");
  ini_set("error_reporting", E_ALL);
  include_once ('../progetto/functions.php'); 

  $logged = null;
 

  session_start();


 

  $error_msg = '';

  $tipo = '';

  if (isset($_POST) && isset($_POST['email']) && isset($_POST['password']) &&isset($_POST['select'])) {

    

    $logged = login($_POST['email'], $_POST['password'], $_POST['select']);
   
    if (is_null($logged)) {

      $error_msg = '<div class="alert alert-danger" role="alert"> Credenziali errate! Riprovare login</div>';
      $tipo = '';
      echo $error_msg;
    } else {
      $tipo = $_POST['select'];
    }

  }

  
 

  if(isset($_SESSION['email'])) {
    $logged = $_SESSION['email'];
    $tipo = $_SESSION['tipo'];
  }
 

  if(isset($logged)) {
    $_SESSION['email'] = $logged;
    $_SESSION['tipo'] = $tipo;
    
  }
  
 
 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
  <?php 

  if (!isset($logged)) {


  
  ?>
    <section class="vh-100 bg-white">
        <div class="container py-5 h-100">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white shadow-lg" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-4 text-uppercase">Benvenuto su MyUni!</h2>

                                <p class="text-white-50 mb-4">Perfavore inserisci il tuo username e la tua password per fare il login!</p>

                                <div class="form-outline form-white mb-5">
                                   
                                    <input type="email" class="form-control p-2" id="inputemail2" placeholder="Email" name="email">
                                </div>

                                <div class="form-outline form-white mb-5">
                                    
                                    <input type="password" class="form-control p-2" id="inputPassword2" placeholder="Password" name="password">
                                </div>

                                <select class="form-select p-2" aria-label="Default select example" name="select">
                                    <option selected>Seleziona il ruolo per il login</option>
                                    <option value="Segreteria">Segreteria</option>
                                    <option value="Docente">Docente</option>
                                    <option value="Studente">Studente</option>
                                  </select>
                                
                                <div class="mt-5"><button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button></div>
                                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </section>

    

    <?php
      } else if (isset($logged)) {
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Studente'){
          include_once('../progetto/studente.php');
        } else if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Segreteria'){
          include_once('../progetto/segreteria.php');
        } else if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Docente'){
          include_once('../progetto/docente.php');
        }

        
      }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>