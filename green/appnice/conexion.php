<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("MODO_DE_PRUEBA", "1");  // Esta variable define cuando tenemos la aplicacion 
//                              //en modo_de_prueba parra y evitar el envio de correos(1=true 0=false)
define("MODO_DE_TEST", 1); // Modo de Test para apuntar al servidor de test o produccion
date_default_timezone_set('America/Caracas');

error_reporting(0);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atletasdb";
if (MODO_DE_TEST==0){
    $servername = "localhost";
    $username = "username";
    $password = 'password';
    $dbname = "basededatos";
    error_reporting(0);
}

// $conn =  mysql_connect($servername, $username, $password);
// $result=mysql_select_db($dbname,$conn);
// mysql_set_charset("utf8mb4");



?>
