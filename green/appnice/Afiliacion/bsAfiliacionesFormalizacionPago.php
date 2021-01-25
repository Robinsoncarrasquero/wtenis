<?php

require_once '../conexion.php';
require_once '../funciones/funcion_email.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
//Este programa permite la formalizacion de asociaciones y federacion


if ($_SERVER['REQUEST_METHOD'] != 'POST'){
     die('Error fatal No pudo conectarse: ');
}
 
$op=  $_POST['op']; //Operacion de usuario
$afiliaciones_id =$_POST['id'];
$chkMarcarPago=  $_POST['chkMarcarPago']; //Marcar o desmarcar Pago

//Formaliza las afiliaciones federacion y asociacion
if ($op=='formalizar' || $op=='federar'){
    
    //Se maneja las confirmaciones de pago de afiliados para el usuario administrador
    $objAfiliaciones = new Afiliaciones();
    $objAfiliaciones->Find($afiliaciones_id);

    if ($op == 'formalizar') {
        $objAfiliaciones->setFecha_Formalizacion(date('Y-m-d:h:s'));
        $objAfiliaciones->setFecha_Pago(date('Y-m-d:h:s'));
        $objAfiliaciones->setFormalizacion($chkMarcarPago);
    }

    if ($op=="federar"){
       $objAfiliaciones->setFecha_Pago (date('Y-m-d:h:s'));
       $objAfiliaciones->setPagado($chkMarcarPago);

    }
    $atleta_id = $objAfiliaciones->getAtleta_id();
    $objAfiliaciones->Update();
    
    $objAtleta = new Atleta();
    $objAtleta->Fetch($atleta_id);
   
    if ($objAfiliaciones->Operacion_Exitosa()) {
        //Asociacion Formalizar
        if ($op == "formalizar") {
            if ($chkMarcarPago == 1) {
                email_notificacion("AfiliacionFormalizada", $objAtleta->getCedula());
                $jsondata = array("Success" => True, "Mensaje" => $objAfiliaciones->getMensaje());
            } else {
                email_notificacion("AfiliacionNoFormalizada", $objAtleta->getCedula());
                $jsondata = array("Success" => True, "Mensaje" => $objAfiliaciones->getMensaje());
            }
        }
        //Formalizar Asociaciones
        if ($op == "federar") {
            if ($chkMarcarPago == 1) {
                email_notificacion("ServicioWebFormalizado", $objAtleta->getCedula());
                $jsondata = array("Success" => True, "Mensaje" => $objAfiliaciones->getMensaje());
            } else {
                email_notificacion("ServicioWebNoFormalizado", $objAtleta->getCedula());
                $jsondata = array("Success" => True, "Mensaje" => $objAfiliaciones->getMensaje());
            }
        }
    } else {
        $jsondata = array("Success" => False, "Mensaje" => $objAfiliaciones->getMensaje());
    }
}else{
     $jsondata = array("Success" => False, "Mensaje" => "No hay registro para su peticion");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

