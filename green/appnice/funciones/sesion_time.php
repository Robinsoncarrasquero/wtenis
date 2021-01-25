<?php


$timeout = 600; //tiempo en segundos

if(isset($_SESSION['tiempo_inicio'])){
    $vida_session = time() - $_SESSION['tiempo_inicio'];
    if($vida_session > $timeout){
        // remove all session variables
            session_unset(); 

            // destroy the session 
            session_destroy(); 

        header("Location: sesion_inicio.php"); 

    }
}
$_SESSION['tiempo_inicio'] = time();
?>

