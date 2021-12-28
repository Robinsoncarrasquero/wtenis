<?php
require_once 'Configuracion_cls.php';
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
            $password = 'password';
            $dbname = "dbname";
        }
                
        try {
            $cnn =new PDO("$dbms:host=$servername;dbname=$dbname;port=$port", $username, $password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\'',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }   
                
        return $cnn;
        
    }
    
}