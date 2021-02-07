<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('MODO_DE_PRUEBA')) {
    define("MODO_DE_PRUEBA", "1");  // Esta variable define cuando tenemos la aplicacion 
    //en modo_de_prueba para evitar el envio de correos(1=true 0=false)
}
if (!defined('MODO_DE_TEST')) {
    define("MODO_DE_TEST", 1); // Modo de Test para apuntar al servidor de test o produccion
}
date_default_timezone_set('America/Caracas');

error_reporting(1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atletasdb";
if (MODO_DE_TEST==0){
    $servername = "localhost";
    $username = "usename";
    $password = 'password';
    $dbname = "dbname";
    error_reporting(0);
}


// $au =  mysqli_connect($servername, $username, $password);
// $conn=mysqli_select_db($dbname,$au);
// mysqli_set_charset($conn,"utf8mb4");

    $conn =mysqli_connect($servername, $username, $password,$dbname);

    if (!$conn) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
        exit;
    }
    $conn->set_charset("utf8mb4");

    //return  $conn;

?>
