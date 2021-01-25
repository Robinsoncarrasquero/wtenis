<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Categoria_cls.php';
require_once '../clases/Disciplina_cls.php';
/* 
 * Programa para buscar la data de una tabla que sea cargada para    
 * presentarla en un list box para su eleccion
 */


//Tabla pedida en el post
$tabla_pedida=$_POST['tabla'];
//$tabla_pedida
switch ($tabla_pedida) {
    case "categoria":
        $dato=array();
        $datox = array("value"=>0,"texto"=>"Seleccione");
        array_push($dato, $datox);
        $array_data = Categoria::data_combo_list();
        foreach ($array_data as $value) {
            $datox = array("value"=>$value[value],"texto"=>$value[texto]);
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
        $array_jsondata =  array("value"=>"nada","texto"=>"Vacio");
        break;
}
$jsondata =  array("tabla"=>$array_jsondata);
header('Content-type: application/json; charset=utf-8');
echo  json_encode($jsondata, JSON_FORCE_OBJECT);
