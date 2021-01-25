<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Categoria_cls.php';
require_once '../clases/Disciplina_cls.php';
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
$tabla_pedida=$_POST['tabla'];
//$tabla_pedida
switch ($tabla_pedida) {
    case "categoria":
        $array_jsondata = Categoria::data_combo_list();
        $dato = array("value"=>'TD',"texto"=>"Todas");
        array_push($array_jsondata,$dato);
        break;
    case "empresa":
        if ($_SESSION['niveluser']>9){
           $array_jsondata = Empresa::data_combo_list();
        }else{
        
        $array_jsondata = array();
        $dato = array("value"=>$_SESSION['empresa_id'],"texto"=>$_SESSION['estado']);
        array_push($array_jsondata,$dato);
        }
        
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

