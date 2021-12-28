<?php
session_start();
require_once '../clases/Rank_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Torneos_Inscritos_cls.php';
// Programa para eliminar un ranking completamente
// en la 3 tablas relacionadas
sleep(1);
$id=$_POST['id']; // Id del registro de la tabla Rank


$rsFileRank= new Rank();
$rsFileRank->Find($id);
$categoria=$rsFileRank->getCategoria();
$sexo=$rsFileRank->getSexo();
$disciplina=$rsFileRank->getDisciplina();
$rsFileRank->Delete($id);
$rsLastRanking=Rank::Find_Last_Ranking($disciplina,$categoria,$sexo);
$fechark= $rsLastRanking["fecha"] ;

$mensaje=TorneosInscritos::UpdateRankingByDate($disciplina,$fechark,$categoria,$sexo);
$jdata=array();

if ($rsFileRank->Operacion_Exitosa()){
    $jsondata = array("Success" => TRUE,"Mensaje"=>"Ranking eliminado  fecha $fechark sexo $sexo categoria $categoria "); 
}else{
    $jsondata = array("Success" => FALSE,  "Mensaje"=>"Error Ranking no pudo ser eliminado mensaje $mensaje fecha $fechark o no existe");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);


//Generamos un json de respuesta
//if ($rsFileRank->Operacion_Exitosa()){
//    $jsondata = array("Success" => TRUE,"Mensaje"=>"Ranking eliminado exitotamente"); 
//}else{
//    $jsondata = array("Success" => FALSE,  "Mensaje"=>"Error Ranking no pudo ser eliminado o no existe");
//}
//header('Content-type: application/json; charset=utf-8');
//echo json_encode($jsondata, JSON_FORCE_OBJECT);

   
