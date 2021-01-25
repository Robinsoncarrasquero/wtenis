<?php 
session_start();
require_once '../sql/ConexionPDO.php';
require_once 'Estadisticas_cls.php';
require_once '../clases/Afiliacion_cls.php';

/* 
 * Programa para buscar la data de una tabla que sea cargada para    
 * presentarla en un list box para su eleccion
 */
if ($_SERVER['REQUEST_METHOD']!="POST"){
    header('Location: ../sesion_inicio.php');
    exit;
}

$ano=$_POST['ano'];
$disciplina=$_POST['disciplina'];
$opt=$_POST['opt'];
$proceso=$_POST['proceso'];
$glbempresa=$_POST['glbempresa'];

//Busca la afiliacion 
$objAfiliacion = new Afiliacion();
$objAfiliacion->Find($ano);
//Consulta Global de la FVT
if ($glbempresa=='glb'){    
    $ano_afiliacion=$objAfiliacion->getAno();
    $Afiliacion_id=null;

}else {
    $ano_afiliacion=null;
    $Afiliacion_id=$objAfiliacion->get_ID();
}

//Filtra la afiliaciones Federadas 
if ($glbempresa=='glb'){    
    switch ($opt) {
        case "pai":
            $rsdata = EstadisticasCls::GLBAfiliadosPorPais($disciplina,$ano_afiliacion,$proceso);
            break;
        case "reg":
            $rsdata = EstadisticasCls::GLBAfiliadosPorRegion($disciplina,$ano_afiliacion,$proceso);
            break;
        case "cat":
            $rsdata = EstadisticasCls::GLBAfiliadosPorCategoria($disciplina,$ano_afiliacion,$proceso);
            break;
        default:
            $rsdata = EstadisticasCls::GLBAfiliadosPorEstado($disciplina,$ano_afiliacion,$proceso);
            break;
        }
}else{
//Filtramos afiliaciones Transito    
    switch ($opt) {
        case "edo":
            $rsdata = EstadisticasCls::EmpresaAfiliadosPorEstado($disciplina,$Afiliacion_id,$proceso);
            break;
        case "cat":
            $rsdata = EstadisticasCls::EmpresaAfiliadosPorCategoria($disciplina,$Afiliacion_id,$proceso);
            break;
        
        default:
            //$rsdata = EstadisticasCls::EmpresaAfiliadosPorEstado($disciplina,$Afiliacion_id,$proceso);
            break;
    }
    
}
$jsondata = array();
foreach ($rsdata as $row){
    $jsondata['DataInfo'][] = $row;
}
header('Content-type: application/json; charset=utf-8');
echo  json_encode($jsondata, JSON_FORCE_OBJECT);
