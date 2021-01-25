<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Categoria_cls.php';
require_once '../clases/Rank_cls.php';
/* 
 * Programa para buscar la data de una tabla que sea cargada para    
 * presentarla en un list box para su eleccion
 */

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}


//Tabla pedida en el post
$disciplina=$_POST['disciplina'];
$categoria=$_POST['categoria'];


$dato=array();
$array_jsondata = Rank::data_combo_list($disciplina,$categoria);
$datox = array("value"=>0,"texto"=>"SELECCIONE");
array_push($dato, $datox);
foreach ($array_jsondata as $value) {
    $datox = array("value"=>$value[value],"texto"=>$value[texto]);
    array_push($dato, $datox);
    
}
         
$jsondata =  array("tabla"=>$dato);
header('Content-type: application/json; charset=utf-8');
echo  json_encode($jsondata, JSON_FORCE_OBJECT);
