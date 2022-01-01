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

$td='';
foreach ($Empresas as $key => $empresa) {
    //Buscamos la Empresa
    $objAfiliacion = new Afiliacion();
    $objAfiliacion->findAfiliacion($empresa['empresa_id'],$periodo);

    $objAfiliacion->setAno($periodo);
    $objAfiliacion->setFVT($tarifa);
    
    $objAfiliacion->setAsociacion(0);
    $objAfiliacion->setSistemaWeb(0);
    $objAfiliacion->setEmpresa_id($empresa['empresa_id']);
    $objAfiliacion->setFechaDesde(date_format($objeto_fecha_desde, 'Y-m-d'));
    $objAfiliacion->setFechaHasta(date_format($objeto_fecha_hasta, 'Y-m-d'));
    $objAfiliacion->setMoneda($moneda);
    $objAfiliacion->setCiclo(1);
    if ($objAfiliacion->Operacion_Exitosa()){
        $objAfiliacion->Update();
    }else{
        $objAfiliacion->create();
    }
    $td .= '<tr><td >'.$empresa['nombre'].'</td>
    <td>'.date_format($objeto_fecha_desde, 'Y-m-d').'</td>
    <td>'.date_format($objeto_fecha_hasta, 'Y-m-d').'</td>
    </tr>';
    $nr++;
}

$table = '
<table class="table table-dark">
    <thead>
    <th scope="col">Asociaciones</th>
    <th scope="col">Fecha Dsde</th>
    <th scope="col">Fecha Hasta</th>
    </thead>
    <body>'
    .$td.
    '</body>
    </table >';
if ($nr>0){
    $mensaje='<p>Procesada la afiliacion anual exitosamente</p>';

}else{
    $mensaje='<p>No hay datos para procesar</p>';

}

if ($nr>0){
    $jsondata = array("success" => True, "html"=>$table,'msg'=>$mensaje,"pagination"=>"");   
} else {    
    $jsondata = array("success" => False, "html"=>"Errors no fue generada la afiliacion",'msg'=>$mensaje,"pagination"=>"");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
exit;



