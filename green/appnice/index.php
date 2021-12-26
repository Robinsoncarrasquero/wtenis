<?php

session_start();
 
if (!isset($_SESSION['logueado'])){
    header('Location: sesion_usuario.php');
    exit;
}

$home = $_SESSION['home'];
if (isset($_SESSION['home'])){

    header('Location: '.$home);
    
    exit();
}else{
    header('Location: sesion_inicio.php');
    exit();
}


?>
