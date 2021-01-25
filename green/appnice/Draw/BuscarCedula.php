<?php
//Pograma para buscar una cedula y devolver un on objeto json con los datos basicos
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
       
    //Obtenemos los datos de los input
   
    $cedula = htmlspecialchars($_POST["cedula"]);
    
    $objAtleta = new Atleta();
    $objAtleta->Fetch(0, $cedula);
    $nombre = $objAtleta->getNombres();
    $apellido=$objAtleta->getApellidos();
    $cedula=$objAtleta->getCedula();
    $atleta_id= $objAtleta->getID();
    //Seteamos el header de "content-type" como "JSON" para que jQuery lo reconozca como tal
    header('Content-Type: application/json');
    //Guardamos los datos en un array
    $datos = array(
    'estado' => 'ok',
    'nombre' => $nombre, 
    'apellido' => $apellido, 
    'cedula' => $cedula,
    'atleta_id' => $atleta_id,
    'sexo' => $cedula,
   
            
    );
    //Devolvemos el array pasado a JSON como objeto
    echo json_encode($datos, JSON_FORCE_OBJECT);
}



?>
