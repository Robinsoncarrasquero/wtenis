<?php
//Programa para agregar un jugador a la lista de aceptacion
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../clases/Torneos_Inscritos_cls.php';
require_once '../clases/Torneos_cls.php';
require_once '../sql/ConexionPDO.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
       
    //Obtenemos los datos de los input
    $torneo_id = trim($_POST["torneo_id"]);
    $categoria = trim($_POST["categoria"]);
    $sexo = trim($_POST['sexo']);
    $cedula = htmlspecialchars($_POST["cedula"]);
    
//    $torneo_id = 273;
//    $categoria = "18";
//    $sexo = "F";
//    $cedula = "28472989";
    
    $objAtleta = new Atleta();
    $objAtleta->Fetch(0, $cedula);
    $nombre = $objAtleta->getNombres();
    $apellido=$objAtleta->getApellidos();
    $cedula=$objAtleta->getCedula();
    $atleta_id= $objAtleta->getID();
    
    $objRanking_atleta = new Ranking();
    $objRanking_atleta->Find($atleta_id,$categoria);
    
    $ranking_atleta= $objRanking_atleta->getRknacional()==0 ? 999 : $objRanking_atleta->getRknacional();
    $ranking_fecha = $objRanking_atleta->getFechaRankingNacional()==0 ? date('Y-m-d') : $objRanking_atleta->getFechaRankingNacional();
    $objTorneo = new Torneo();
    $objTorneo->Fetch($torneo_id);
    $torneo_name=$objTorneo->getCodigo();
    $objTorneoInscritos = new TorneosInscritos();
    $objTorneoInscritos->Find_Atleta($torneo_id, $atleta_id);
    if ($objTorneoInscritos->Operacion_Exitosa()){
       //Guardamos los datos en un array
        $datos = array(
        'estado' => 'no',
        'nombre' => $nombre, 
        'apellido' => $apellido, 
        'cedula' => $cedula,
        'torneo_id' => $torneo_id,
        'mensaje' => $objTorneoInscritos->getMensaje()
        );
        
           
    }else{
        
        $objTorneoInscritos->setAtleta_id($atleta_id);
        $objTorneoInscritos->setTorneo_id($torneo_id);
        $objTorneoInscritos->setCategoria($categoria);
        $objTorneoInscritos->setSexo($sexo);
        $objTorneoInscritos->setDobles(0);
        $objTorneoInscritos->setSingles(0);
        $objTorneoInscritos->setPagado(0);
        $objTorneoInscritos->setRknacional($ranking_atleta);
        $objTorneoInscritos->setFechaRanking($ranking_fecha);
        $objTorneoInscritos->create();
        
        //Guardamos los datos en un array
        $datos = array(
        'estado' => 'ok',
        'nombre' => $nombre, 
        'apellido' => $apellido, 
        'cedula' => $cedula,
        'torneo_id' => $torneo_id,
        'mensaje' => $objTorneoInscritos->getMensaje()
        );
        
        
    }
    //Seteamos el header de "content-type" como "JSON" para que jQuery lo reconozca como tal
    header('Content-Type: application/json');
        
    //Devolvemos el array pasado a JSON como objeto
    echo json_encode($datos, JSON_FORCE_OBJECT);
            
    
   
   
    
}



?>
