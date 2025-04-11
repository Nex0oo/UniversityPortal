<?php
    include_once ('../progetto/functions.php');
    $cdl = $_GET['cdl'];
    $giorno = $_GET['giorno'];
    $insegnamento = $_GET['insegnamento'];
    session_start();
    $matricola = $_SESSION['matricola1'];
    $msg = iscrivi_appello($matricola, $giorno, $cdl, $insegnamento);
    header("location: http://localhost/progetto/index.php");
?>