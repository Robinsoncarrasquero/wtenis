

<?php 

// Deshabilitar todo reporte de errores 
error_reporting(0); 

// Errores de ejecucion simples 
error_reporting(E_ERROR | E_WARNING | E_PARSE); 

// Reportar E_NOTICE puede ser bueno tambien (para reportar variables 
// no inicializadas o capturar equivocaciones en nombres de variables ...) 
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); 

// Reportar todos los errores excepto E_NOTICE 
// Este es el valor predeterminado en php.ini 
error_reporting(E_ALL ^ E_NOTICE); 

// Reportar todos los errores de PHP (el valor de bits 63 puede ser usado en PHP 3) 
error_reporting(E_ALL); 

// Lo mismo que error_reporting(E_ALL); 
ini_set('error_reporting', E_ALL); 

?>

