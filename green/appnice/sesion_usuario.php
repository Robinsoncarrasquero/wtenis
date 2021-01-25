<?php
session_start();

if (isset($_SESSION['renovacion'])){
    unset($_SESSION['renovacion']);
    if (isset($_SESSION['logueado']) && $_SESSION['logueado']) {
        header('Location: Afiliacion/bsAfiliacionWebAfiliacion.php');
        exit;
   }
}
if (isset($_SESSION['inscripcion'])){
    if (isset($_SESSION['logueado']) && $_SESSION['logueado']) {
        header('Location: Inscripcion/bsInscripcion.php');
        exit;
   }
}

header('Location: bsPanel.php');
exit;

?>
<!--
 