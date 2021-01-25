<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


session_start();
// Deshabilitar todo reporte de errores 
error_reporting(0); 
//$usuarios = array(
//    array('nombre' => 'roberto', 'contrasena' => '1234'),
//    array('nombre' => 'jorge', 'contrasena' => '1234'),
//    array('nombre' => 'toni', 'contrasena' => '1234')
// );
 $usuarios = array();
// if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
//    echo 'We don\'t have mysqli Connection failed:';
//    exit;
//    
//} else {
//    echo 'Phew we have it!';
//}
 
?>

<!DOCTYPE html>
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <title> Ayuda Inscripcion </title>
 <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
 <a href="index.html "> <img id="Logo" src="images/logo.png"  ></a>
 <link rel="StyleSheet" href="css/inscribe.css" type="text/css">
 </head>
 <body>
 
        
       

 <div class="Box4Col">

   <h3>Ayuda de inscripcion para dispositivos mobiles</h3>

        <div id="Box4Col">
               <h4>PASO 1 Ir al Sistema Inscripcion</h4>
               <a href="screencast/pantalla1.png" target="_blank"><embed src="screencast/pantalla1.png" target="_blank" alt="inscripcion" width="400" height="300"></embed></a>
         </div>
        <div id="Box4Col">
               <h4>PASO 2 Ingresar con la cedula</h4>
               <a href="screencast/pantalla2.png" target="_blank"><embed src="screencast/pantalla2.png" target="_blank" alt="inscripcion" width=400" height="300"></embed></a>
        </div>
         <div id="Box4Col">
               <h4>PASO 3 Seleccionar Inscripcion </h4>
               <a href="screencast/pantalla3.png" target="_blank"><embed src="screencast/pantalla3.png" target="_blank" alt="inscripcion" width="400" height="300"></embed></a>
        </div>
        <div id="Box4Col">
               <h4>PASO 4 Incribir el Torneo</h4>
               <a href="screencast/pantalla4.png" target="_blank"><embed src="screencast/pantalla4.png" target="_blank" alt="inscripcion" width="400" height="300"></embed></a>
        </div>

 </div>
  
    
</html>
