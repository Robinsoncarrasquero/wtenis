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
            $username = "algunapersona";
            $password = 'secret';
            $dbname = "database";
            error_reporting(0);
        }
        
        // if (MODO_DE_TEST==0){
        //     $servername = "46.105.189.131";
        //     $username = "jugador";
        //     $password = '@@123jugador1234';
        //     $dbname = "eljugador";
        //     error_reporting(1);
        // }        
        $port="3306";
        try {
            $cnn =new PDO("mysql:host=$servername;dbname=$dbname;port=3306", $username, $password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\'',
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        
            // foreach($cnn->query('SELECT cedula FROM empleado WHERE atleta_id=487 ') as $fila) {
            //     print_r($fila);
            // }
            
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }   
                
        return $cnn;
        
    }
    
}

