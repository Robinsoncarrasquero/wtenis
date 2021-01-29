<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Rank_cls.php';
/* 
 * Programa para buscar la data de una tabla que sea cargada para    
 * presentarla en un list box para su eleccion
 */


//Tabla pedida en el post
$disciplina=$_POST['disciplina'];
$categoria=$_POST['categoria'];
$sexo=$_POST['sexo'];


$dato=array();
$array_jsondata = Rank::data_combo_list($disciplina,$categoria,$sexo);
$datox = array("value"=>0,"texto"=>"Seleccione");
array_push($dato, $datox);
foreach ($array_jsondata as $value) {
    $datox = array("value"=>$value['value'],"texto"=>$value['texto']);
    array_push($dato, $datox);
    
}
if (count($array_jsondata)>0){
    $jsondata =  array("tabla"=>$dato);
}else{
   $dato=array();
   $datox = array("value"=>0,"texto"=>"Ninguno");
   array_push($dato, $datox);
    
}

$jsondata =  array("tabla"=>$dato);
header('Content-type: application/json; charset=utf-8');
echo  json_encode($jsondata, JSON_FORCE_OBJECT);
