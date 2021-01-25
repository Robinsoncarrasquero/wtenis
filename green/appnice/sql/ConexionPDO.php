<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define("MODO_DE_PRUEBA", "1");  // Esta variable define cuando tenemos la aplicacion 
                                //en modo_de_prueba para evitar el envio de correos(1=true 0=false)
define("MODO_DE_TEST", 1); // Modo de Test para apuntar al servidor de test o produccion
class Conexion
{
   


public function conectar()
{
       
    date_default_timezone_set('America/Caracas');
    error_reporting(0);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "atletasdb";
    if (MODO_DE_TEST==0){
        $servername = "localhost";
        $username = "gsscomve_robinad";
        $password = 'RO;bi%ns$on[2889';
        $dbname = "gsscomve_atletasdb";
        error_reporting(0);
    }
            
    
    return new PDO("mysql:host=$servername;dbname=$dbname",$username,$password , 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\'',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
}
    
}