<?php

require_once '../sql/ConexionPDO.php';

// define("MODO_DE_PRUEBA", "1");  // Esta variable define cuando tenemos la aplicacion 
// //                              //en modo_de_prueba parra y evitar el envio de correos(1=true 0=false)
// define("MODO_DE_TEST", 1); // Modo de Test para apuntar al servidor de test o produccion
date_default_timezone_set('America/Caracas');

$configuracion = new Configuracion();

$servername = $configuracion->servername;
$username = $configuracion->username;
$password = $configuracion->password;
$dbname = $configuracion->dbname;
$dbms = $configuracion->dbms;
$port = $configuracion->port;

if (MODO_DE_TEST==0){
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "dbname";
    error_reporting(0);
}

$conn =mysqli_connect($servername, $username, $password,$dbname);

if (!$conn) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$conn->set_charset("utf8mb4");


//echo "Éxito: Se realizó una conexión apropiada a MySQL! La base de datos mi_bd es genial." . PHP_EOL;
//echo "Información del host: " . mysqli_get_host_info($conn) . PHP_EOL;
?>
