<?php
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';


/* 
 * Programa para actualizar el campo que indica el estado de verificacion 
 * de datos para posteriormente sean exportados en un archivo para el sistema de 
 * afiliaciones interno
 */


$asociacion=$_SESSION['estado'];


//Buscamos la Empresa
$objEmpresa = new Empresa();
$objEmpresa->Fetch($asociacion);

//Buscado la ultima afiliacion de la empresa
$rsAfiliacion = new Afiliacion();
$rsAfiliacion->Fetch($objEmpresa->get_Empresa_id());

$ano_afiliacion= $rsAfiliacion->getAno();
$afiliacion_id=$rsAfiliacion->get_ID();
//Marca el registro como verificado
//


$rsAtletas = Atleta::ReadAll($estado);
foreach ($rsAtletas as $record) {
    $atleta_id=$record['atleta_id'];
    $objAtleta= new Atleta();
    $objAtleta->Find($atleta_id);
    $objAfiliacion_atleta = new Afiliaciones();
    $objAfiliacion_atleta->Find_Afiliacion_Atleta($atleta_id,$ano_afiliacion);
    if (!$objAfiliacion_atleta->Operacion_Exitosa()) {
        $objAfiliacion_atleta->setAtleta_id($atleta_id);
        $objAfiliacion_atleta->setAno($ano_afiliacion);
        $objAfiliacion_atleta->setAfiliacion_id($afiliacion_id);
        $objAfiliacion_atleta->setCategoria($objAtleta->Categoria_Afiliacion($ano_afiliacion));
        $objAfiliacion_atleta->setSexo($objAtleta->getSexo());
        $objAfiliacion_atleta->setAceptado(1);
        $objAfiliacion_atleta->setAfiliarme(1);
        $objAfiliacion_atleta->create();

    }
}
$jsondata = array("Sucess" => False,"Mensaje"=>$objAfiliacion_atleta->getMensaje());

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);