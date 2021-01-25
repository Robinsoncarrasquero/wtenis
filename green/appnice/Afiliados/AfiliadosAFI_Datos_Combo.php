<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Categoria_cls.php';
require_once '../clases/Disciplina_cls.php';
/* 
 * Programa para crear actualizar el campo que indica el estado de verificacion 
 * de datos para posteriormente sean exportados en un archivo para el sistema de 
 * afiliaciones interno
 */

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}
$empresa_id=$_SESSION['empresa_id'];

//Tabla pedida en el post
$tabla_pedida=$_POST['tabla'];
//$tabla_pedida="categoria";
switch ($tabla_pedida) {
        case "afiliacion":
        $array_jsondata = Afiliacion::data_combo_list($empresa_id);
        break;
    case "categoria":
        $array_jsondata = Categoria::data_combo_list();
        $dato = array("value"=>'TD',"texto"=>"Todas");
        array_push($array_jsondata,$dato);
        break;
    case "empresa":
        $array_jsondata = Empresa::data_combo_list();
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

