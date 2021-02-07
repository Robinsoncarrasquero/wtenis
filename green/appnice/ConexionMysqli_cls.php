<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Esta clase sirve para conectarse via mysqli
 *
 * @author robinson
 */
class Conexion_mysqli{
    //put your code here

public $conn;

//Crea la conexion
public static function Conexion($MODO_DE_TEST){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "atletasdb";
    if ($MODO_DE_TEST==0){
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "dbname";
    }

    $conn =mysqli_connect($servername, $username, $password,$dbname);

    if (!$conn) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $conn->set_charset("utf8mb4");

    return  $conn;
}

//Ejecutar consulta
public static function mysqli_query($strSQL) {
    $conn=Conexion_mysqli::Conexion(MODO_DE_TEST);
    $results=$conn->query($strSQL);
    return $results;
}
//Cerrar la conexion
public static function mysqli_close($conn) {
    
    mysqli_close($conn);
    
}

public static function mysqli_num_rows($results){
    return mysqli_num_rows($results);
}

public static function  mysqli_fetch_assoc($result){
    return mysqli_fetch_assoc($result);
}

public static function mysqli_fetch_field($result){
    return $result->fetch_field() ;
}
public static function mysqli_fetch_array($sql){
    return mysqli_fetch_array($sql, MYSQLI_ASSOC);
}
    
    
}
