<?php
require_once '../sql/ConexionPDO.php';
require_once '../clases/AfiliacionesXML_cls.php';
/* 
 * Programa para actualizar el campo que indica el estado de verificacion 
 * de datos para posteriormente sean exportados en un archivo para el sistema de 
 * afiliaciones interno
 */

$atleta_id=$_POST['id'];

$chkVerificado=$_POST['chkOK']; //Parametro de marcacion o desmarcacion segun el caso

$proceso=$_POST['proceso'] ; //Nos indica si es exportacion o verificacion

//Marca el registro como verificado
//
if ($proceso=="Verificado"){
    $objXML = new AfiliacionesXML();
    $objXML->Fetch($atleta_id);
    if ($objXML->Operacion_Exitosa()) {
        $objXML->setVerificado($chkVerificado);
        $objXML->Update();
        if ($objXML->Operacion_Exitosa()) {
            $jsondata = array("Sucess" => True,"mensaje"=>$objXML->getMensaje());
        } else {
            $jsondata = array("Sucess" => False,"mensaje"=>$objXML->getMensaje());
        }
    } else {
        $objXML->setAtleta_id($atleta_id);
        $objXML->setVerificado($chkVerificado);
        $objXML->create();
        if ($objXML->Operacion_Exitosa()) {
            $jsondata = array("Sucess" => True,"Mensaje"=>$objXML->getMensaje());
        } else {
            $jsondata = array("Sucess" => False,"Mensaje"=>$objXML->getMensaje());
        }
    }
}

//Marca el registro como exportado
//para no permitir envios nuevamente.
if ($proceso=="Exportado"){
    $objXML = new AfiliacionesXML();
    $objXML->Fetch($atleta_id);
    if ($objXML->Operacion_Exitosa()) {
        $objXML->setExportado($chkVerificado);
        $objXML->Update();
        if ($objXML->Operacion_Exitosa()) {
            $jsondata = array("Sucess" => True,"Mensaje"=>$objXML->getMensaje());
        } else {
            $jsondata = array("Sucess" => False,"Mensaje"=>$objXML->getMensaje());
        }
    }
    
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);



