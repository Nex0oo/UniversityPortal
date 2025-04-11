<?php
  include_once ('../progetto/functions.php');
  echo ("Logout");
  session_start();
    function logout(){

        unset($_SESSION['email']);
        unset($_SESSION['tipo']);
        header('Location: index.php');
    };

    logout()

?>