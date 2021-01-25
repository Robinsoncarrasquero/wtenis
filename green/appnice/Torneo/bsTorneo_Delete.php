<?php
session_start();
require_once '../clases/Torneos_cls.php';
require_once '../sql/ConexionPDO.php';

 if ($_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
 }



$id=$_POST['id'];
//$id=$_GET['id'];
   
$obj = new Torneo();
$obj->Delete($id);
if ($obj->Operacion_Exitosa()){
    $jsondata = array("Success" =>TRUE,"Mensaje"=>" Registro eliminado exitosamente");
}else{
    $jsondata = array("Success" =>FALSE,"Mensaje"=>" Error, Imposible eliminar, debido a que tiene inscripciones relacionadas");
}

header('Content-type: application/json; charset=utf-8');
echo  json_encode($jsondata, JSON_FORCE_OBJECT);
 
    
?>