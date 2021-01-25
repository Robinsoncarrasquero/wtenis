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

$atleta_id=$_POST['id'];

$chkOK=$_POST['chkOK']; //Parametro de marcacion o desmarcacion segun el caso

$proceso=$_POST['proceso'] ; //Nos indica si es exportacion o verificacion


$objAtleta = new Atleta();
$objAtleta->Fetch($atleta_id);

//Buscamos la Empresa
$objEmpresa = new Empresa();
$objEmpresa->Fetch($objAtleta->getEstado());

//Buscado la ultima afiliacion de la empresa
$rsAfiliacion = new Afiliacion();
$rsAfiliacion->Fetch($objEmpresa->get_Empresa_id());

$ano_afiliacion= $rsAfiliacion->getAno();
$afiliacion_id=$rsAfiliacion->get_ID();
//Marca el registro como verificado
//

$objAfiliacion_atleta = new Afiliaciones();
$objAfiliacion_atleta->Find_Afiliacion_Atleta($atleta_id,$ano_afiliacion);
if (!$objAfiliacion_atleta->Operacion_Exitosa()) {
    $objAfiliacion_atleta->setAtleta_id($atleta_id);
    $objAfiliacion_atleta->setAno($ano_afiliacion);
    $objAfiliacion_atleta->setAfiliacion_id($afiliacion_id);
    $objAfiliacion_atleta->setCategoria($objAtleta->Categoria_Afiliacion($ano_afiliacion));
    $objAfiliacion_atleta->setSexo($objAtleta->getSexo());
    $objAfiliacion_atleta->create();

}
 $jsondata = array("Success" => False,"Mensaje"=>$objAfiliacion_atleta->getMensaje());
if ($objAfiliacion_atleta->Operacion_Exitosa()){
    
    if ($chkOK==0){
        $texto="Desprocesado";
    }else{
        $texto="Procesado";
    }
    if ($proceso=="op0"){
        $objAfiliacion_atleta->setAceptado($chkOK);
        $objAfiliacion_atleta->setAfiliarme($chkOK);
       
        $jsondata = array("Success" => True,"Mensaje"=>$texto." Afiliacion/Renovacion...");
    }
    if ($proceso=="op1"){
        $objAfiliacion_atleta->setFormalizacion($chkOK);
        $jsondata = array("Success" => True,"Mensaje"=>$texto." Formalizar...");
    }
    if ($proceso=="op2"){
        $objAfiliacion_atleta->setPagado($chkOK);
        $jsondata = array("Success" => True,"Mensaje"=>$texto." Federar...");

    }
     if ($proceso=="op3"){
        $objAfiliacion_atleta->setExonerado($chkOK);
        $jsondata = array("Success" => True,"Mensaje"=>$texto." Exonerar...");

    }
    $objAfiliacion_atleta->setFecha_Formalizacion(date('Y-m-d:h:s'));
    $objAfiliacion_atleta->setFecha_Pago(date('Y-m-d:h:s'));
    $objAfiliacion_atleta->Update();
    if (!$objAfiliacion_atleta->Operacion_Exitosa()) {
        $jsondata = array("Success" => False,"Mensaje"=>$objAfiliacion_atleta->getMensaje());
    }
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);