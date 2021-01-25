<?php
require 'conexion.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



 if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
 
    echo 'We don\'t have mysqli habilitado conexion con error';
} else 
{
    echo 'mysqli habilitado en el servidor  !';
}



?>
