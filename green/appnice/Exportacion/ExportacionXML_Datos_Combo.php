<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/AfiliacionesXML_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliacion_cls.php';
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

//Tomamos la empresa actual que es la Principal Jerarquica(FVT)
$empresa_id=$_SESSION['empresa_id'];

//Instanciamos la clase empresa para obtener la empresa_id
//de la asociacion registrada
$objEmpresa= new Empresa();
$objEmpresa->Find($empresa_id);
if ($objEmpresa->Operacion_Exitosa()){
    $objAfiliacion = new Afiliacion();
    $objAfiliacion->Fetch($objEmpresa->get_Empresa_id());
    $monto_aso=$objAfiliacion->getAsociacion();
    $monto_fvt=$objAfiliacion->getFVT();
    $monto_sis=$objAfiliacion->getSistemaWeb();

    //Aqui colocamos el ano de afiliacion que cambiara cada ano
    $ano_afiliacion=$objAfiliacion->getAno();
    $Afiliacion_id=$objAfiliacion->get_ID();
}
if ($_SESSION['niveluser']>9){
    $empresa_id=0; //Empresa 0 para representar que son todas las
}
$rsAfiliacion_empresa = Afiliacion::ReadByCiclo($empresa_id, $ano_afiliacion, 1);
$array_empresa=array();
foreach ($rsAfiliacion_empresa as $datatmp){
    $rsEmpresa = new Empresa();
    $rsEmpresa->Find($datatmp['empresa_id']);
    $nr ++;
    //echo  '<option value="'.$datatmp['afiliacion_id'].'">'.$datatmp['sistemawebciclocobro']."-- ".$rsEmpresa->getEstado().'</option>';
    $dato = array("id"=>$datatmp['afiliacion_id'],"estado"=>$rsEmpresa->getEstado());
    array_push($array_empresa,$dato);
}


$rsFileXML = AfiliacionesXML::FileXML();
$array_filexml=array();

$i=0;
foreach ($rsFileXML as $value) {
    $i++;
    $dato = array("id"=>$i,"texto"=>$value);
    array_push($array_filexml,$dato);
  
    
}


$jsondata = array("Empresa"=>$array_empresa,"XML"=>$array_filexml);
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);


