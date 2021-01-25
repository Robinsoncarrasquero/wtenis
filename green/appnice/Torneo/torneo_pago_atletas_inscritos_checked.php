<?php
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php'; 
require_once '../clases/Torneos_Inscritos_cls.php'; 
require_once '../funciones/funcion_email.php';
   
$chkPago=  $_POST['chkPago'];
$array_datos =  explode('-',$_POST['id']);
$torneo_inscrito_id =$array_datos[0];
$cedula=$array_datos[1];
$nombretorneo=$_POST['torneo'];

//Objeto Torneos Inscritos
$objTI = new TorneosInscritos();
$objTI->Fetch($torneo_inscrito_id);
if ($objTI->Operacion_Exitosa()){
    $objTI->setPagado($chkPago);
    $objTI->Update();
    $objTI->getMensaje();
    
    //Objeto Atleta
    $objAtleta = new Atleta();
    $objAtleta->Fetch(0,$cedula);
    if ($chkPago==1){
        email_notificacion("PagoConfirmado",$cedula,$nombretorneo);
        $jsondata = array("Success" =>TRUE,"Accion"=>"Procesado","Mensaje"=>"Pago Procesado de ".$objAtleta->getNombreCompleto());
    }else{
         email_notificacion("PagoNoConfirmado",$cedula,$nombretorneo);  
        $jsondata = array("Success" =>TRUE,"Accion"=>"Desprocesado","Mensaje"=>"Pago Desprocesado de ".$objAtleta->getNombreCompleto());
    } 
      
}else{
    $jsondata = array("Success" =>FALSE,"Mensaje"=>"Error no fue posible procesar la solicitud");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
mysql_close($conn);
?>