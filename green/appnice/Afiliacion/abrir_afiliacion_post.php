<?php
session_start();
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/AfiliacionesXML_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Paginacion_cls.php';


$periodo=$_POST['periodo']; //periodo

$moneda=$_POST['moneda']; //moneda

$tarifa=$_POST['tarifa']; //tarifa

//$cadena_fecha_mysql = "2015-08-24";

$objeto_fecha_desde = DateTime::createFromFormat('Y-m-d', $periodo."-01-01");
$objeto_fecha_hasta = DateTime::createFromFormat('Y-m-d', $periodo."-12-31");


$Empresas = Empresa::ReadAll();
$nr=0;

foreach ($Empresas as $key => $value) {
    //Buscamos la Empresa
    $objAfiliacion = new Afiliacion();
    $objAfiliacion->findAfiliacion($value['empresa_id'],$periodo);

    $objAfiliacion->setAno($periodo);
    $objAfiliacion->setFVT($tarifa);
    
    $objAfiliacion->setAsociacion(0);
    $objAfiliacion->setSistemaWeb(0);
    $objAfiliacion->setEmpresa_id($value['empresa_id']);
    $objAfiliacion->setFechaDesde(date_format($objeto_fecha_desde, 'Y-m-d'));
    $objAfiliacion->setFechaHasta(date_format($objeto_fecha_hasta, 'Y-m-d'));
    $objAfiliacion->setMoneda($moneda);
    if ($objAfiliacion->Operacion_Exitosa()){
        $objAfiliacion->Update();
    }else{
        $objAfiliacion->create();
    }
    $nr++;
}

$mensaje='<p>Procesadas la afiliacion anual';

if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$mensaje,"pagination"=>"");   
} else {    
    $jsondata = array("Success" => False, "html"=>"No fue efectuada la afiliacion","pagination"=>"");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
exit;



