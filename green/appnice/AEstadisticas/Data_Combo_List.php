<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Categoria_cls.php';
require_once '../clases/Disciplina_cls.php';
require_once '../clases/Afiliacion_cls.php';
/* 
 * Programa para buscar la data de una tabla que sea cargada para    
 * presentarla en un list box para su eleccion
 */
if ($_SERVER['REQUEST_METHOD']!="POST"){
    header('Location: ../sesion_inicio.php');
    exit;
}

$empresa_id=$_SESSION['empresa_id'];
//Tabla pedida en el post
$tabla=$_POST['tabla'];
//$tabla_pedida
switch ($tabla) {
    case "ano":
        $array_data = Afiliacion::data_combo_list($empresa_id);
        $dato=array();
        foreach ($array_data as $value) {
            $datox = array("value"=>$value['value'],"texto"=>$value['texto']);
            array_push($dato, $datox);
        }
        $array_jsondata=$dato;
        break;
     case "categoria":
        $dato=array();
        $datox = array("value"=>0,"texto"=>"Seleccione");
        array_push($dato, $datox);
        $array_data = Categoria::data_combo_list();
        foreach ($array_data as $value) {
            $datox = array("value"=>$value['value'],"texto"=>$value['texto']);
            array_push($dato, $datox);
        }
        $array_jsondata=$dato;
        break;
     case "sexo":
        $array_jsondata=array();
        $datoF = array("value"=>'F',"texto"=>"Femenino");
        array_push($array_jsondata,$datoF);
        $datoM=array("value"=>'M',"texto"=>"Masculino");
        array_push($array_jsondata,$datoM);
        break;
    case "disciplina":
        $array_jsondata = Disciplina::data_combo_list();
        break;
    default:
        $array_jsondata =  array("value"=>"nada","texto"=>"vacio");
        break;
}
$jsondata =  array("tabla"=>$array_jsondata);
header('Content-type: application/json; charset=utf-8');
echo  json_encode($jsondata, JSON_FORCE_OBJECT);
