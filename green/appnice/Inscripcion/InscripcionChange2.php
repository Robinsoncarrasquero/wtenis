<?php
session_start();
require_once '../funciones/funcion_email.php';
require_once '../clases/Torneos_Inscritos_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../clases/Rank_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']){
    //Si el usuario no está logueado redireccionamos al login.
    header('Location:../sesion_cerrar.php');
    exit;
}

$datos = $_POST['data'];
$array_Datos=explode('-',$datos[1]['value']);
$torneoid=  $array_Datos[0]; // 
$atleta_id=$array_Datos[1];
$torneo_inscrito_id=  $array_Datos[2];
$categoria=  $array_Datos[3];

if (isset($_POST['chkeliminar']) || $_POST['chkeliminar']){   
    //Aqui eliminamos en las inscripciones que aun se encuentran activas antes de la fecha de cierre
    //de inscripcion. Una vez cerradas las inscripcionesse solo se permite retiro.
    if (isset($_POST['chkeliminar'])){
        // Borrar los selecionados o desincribir de torneo
        foreach($_POST['chkeliminar'] as $Datos){
            
            $array_Datos = explode (',', trim($Datos)); // convertimos un arreglo y extraemos la data
            $torneoid=  $array_Datos[0]; // 
            $atleta_id=$array_Datos[1];
            $torneo_inscrito_id=  $array_Datos[2];
            $categoria=  $array_Datos[3];

            $time=time();
            $fecha =date("Y-m-d", $time);

            $t_id = (int) $torneo_inscrito_id;
            $objTorneoInscrito = new TorneosInscritos();
            $objTorneoInscrito->Delete($t_id);
            if (!$objTorneoInscrito->Operacion_Exitosa()) {
                die("Error Inesperado eliminado la inscripcion ");
            }else{
                email_inscripcion("ELI", $torneoid, $atleta_id, $categoria);
            }
        }
        
        $jsondata = array("success" => true, "msg"=>'Eliminacion de Inscripcion exitosa');   

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata, JSON_FORCE_OBJECT);
        
        exit;
        
        
    }
    
    
        
    //Aqui se realiza las inscripciones. Este codigo elimina cualquier inscripcion relacionada 
    //y luego inserta un nuevo registro de inscripcion. 
    if (isset($_POST['chkinscribir'])) 
    {
        foreach($_POST['chkinscribir'] as $Datos)
        {
        
            
            
            $array_Datos = explode (',', trim($Datos)); // convertimos un arreglo y extraemos la data
            $torneoid=  $array_Datos[0]; // 
            $atleta_id=$array_Datos[1];
            $torneo_inscrito_id=  $array_Datos[2];
            //Codigo de torneo que es el codigo unico para que pueda validar el registro y no
            //permita inscripciones duplicadas
            $codigo=$array_Datos[5]; 
//            if ($torneo_inscrito_id==0){
//                $categoria= (isset($_POST[$torneoid]) ? trim($_POST[$torneoid]): "XX") ;
//            }
//            foreach ($_POST['chkmodalidad'.$torneoid] as $chkModalidad)
//            {
//               $modalidad.=$chkModalidad.';';
//            }
            $ITEM="M$torneoid";
            
           //Manejamos la modalidad de Juego (SS,DD,DM)
            if (isset($_POST[$ITEM])){
               
                foreach($_POST[$ITEM] as $valor){ 
                      $array_modalidad[]=$valor;
                }
                $modalidad=  implode(",", $array_modalidad);
                $array_modalidad=NULL;
                
            }else{
                $modalidad="SS";
            }
          
            $categoria= (isset($_POST[$torneoid]) ? trim($_POST[$torneoid]): "XX") ;
            $lacategoria=  substr($categoria, 0,2);
            
            //Buscamos el registro del atleta
            $objAtleta = new Atleta();
            $objAtleta->Fetch($atleta_id);
            $sexo=$objAtleta->getSexo();
       
            $time=time();
            $fecha =date("Y-m-d", $time);

            //Casting del tipo
            $t_id = (int) $torneo_inscrito_id;
                       
            //Ubicamos la ultima fecha de ranking publicada
            $disciplina="TDC";
            //Buscamos el ranking de la ultima fecha publica en la categoria del atleta  
            $recordUltimoRanking=Rank::Find_Last_Ranking($disciplina,$categoria,$sexo);
            $rknacional = 999;
            $franking = date("Y-m-d");
            $objRanking = new Ranking();
            if ($recordUltimoRanking){
                $objRanking->Find_Ranking_By_Fecha($objAtleta->getID(),$recordUltimoRanking['id']);
                if ($objRanking->Operacion_Exitosa()){
                    $rknacional =$objRanking->getRknacional();
                    $franking = $objRanking->getFechaRankingNacional();
                }
            }
            //Creamos la inscripcion
            $objInscripcion = new TorneosInscritos();
            $objInscripcion->Find_Atleta($torneoid,$objAtleta->getID());
            if (!$objInscripcion->Operacion_Exitosa()){
                $objInscripcion->setTorneo_id($torneoid);
                $objInscripcion->setAtleta_id($atleta_id);
                $objInscripcion->setRknacional($rknacional);
                $objInscripcion->setCategoria($categoria);
                $objInscripcion->setSexo($sexo);
                $objInscripcion->setFechaRanking($franking);
                $objInscripcion->setCodigo($codigo);
                $objInscripcion->setModalidad($modalidad);
                $objInscripcion->create(); 
                
            }else{
                $objInscripcion->setRknacional($rknacional);
                $objInscripcion->setCategoria($categoria);
                $objInscripcion->setFechaRanking($franking);
                $objInscripcion->setModalidad($modalidad);
                $objInscripcion->Update(); 
               
            }
            
            if (!$objInscripcion->Operacion_Exitosa()) {
                die('ERROR No pudo conectarse: ');
            }
            else{
                email_inscripcion("INS", $torneoid, $atleta_id, $categoria);
            }
            
        } 
        $jsondata = array("success" => true, "msg"=>'Inscripcion exitosa');   

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata, JSON_FORCE_OBJECT);
        
        exit;
        
        
    }
      //este funciona en el caso que el usuario haya presionado el bonto guardar pero no hizo
      //ningun cambio al formulario
      
      $jsondata = array("success" => false, "msg"=>'No hubo ningun cambio que realizar');   

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata, JSON_FORCE_OBJECT);
        
        exit;
}

?>