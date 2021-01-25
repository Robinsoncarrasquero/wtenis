<?php
require 'conexion.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$servername = "localhost";
$username = "tenismir_robinad";
$password = "2015robinson";
$dbname = "tenismir_atletasdb";

$conn =  mysql_connect($servername, $username, $password);
$result=mysql_select_db($dbname,$conn);
//mysql_query($conn, 'SET NAMES "utf8"');

if (!$result) {
    die('No pudo conectarse: ' . mysql_error());
}
echo 'Conectado satisfactoriamente';
mysql_close($conn);

// if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
//    echo 'We don\'t have mysqli!!!';
//} else {
//    echo 'Phew we have it!';
//}
?>
