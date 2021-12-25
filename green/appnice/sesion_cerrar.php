<?php
session_start();

unset($_SESSION['usuario']);
unset($_SESSION['nombre']);
unset($_SESSION['cedula']);
unset($_SESSION['pwdpwd']);
unset($_SESSION['email']);
unset($_SESSION['atleta_id']);
unset($_SESSION['niveluser']);
unset($_SESSION['logueado']);
unset($_SESSION['deshabilitado']);
unset($_SESSION['afiliado']);
unset($_SESSION['empresa_id']);
unset($_SESSION['inscripcion']);
unset($_SESSION['renovacion']);

header('Location: sesion_inicio.php');
exit;    
//remove all session variables
// remove all session variables


// destroy the session 
//session_destroy();
$home = $_SESSION['home'];
if (isset($_SESSION['home'])){

    header('Location: '.$home);
    session_unset(); 
    exit();
}else{
    session_unset(); 
    header('Location: sesion_inicio.php');
    exit();
}
?>