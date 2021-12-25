<?php
session_start();
require_once 'sql/ConexionPDO.php';
require_once 'clases/Atleta_cls.php';


if (isset($_SESSION['renovacion'])){
    unset($_SESSION['renovacion']);
    if (isset($_SESSION['logueado']) && $_SESSION['logueado']) {
        header('Location: Afiliacion/AfiliacionWebAfiliacion.php');
        exit;
   }
}
if (isset($_SESSION['inscripcion'])){
    unset($_SESSION['inscripcion']);
    if (isset($_SESSION['logueado']) && $_SESSION['logueado']) {
        header('Location: Inscripcion/Inscripcion.php');
        exit;
   }
}

if ($_SESSION['niveluser']==0){
    $atleta_id=  htmlspecialchars($_SESSION['atleta_id']);
    $objAtleta= new Atleta();
    $objAtleta->Find($atleta_id);
    if ($objAtleta->Operacion_Exitosa()){
        if ($objAtleta->edad()<19){
             if ($objAtleta->getLugarNacimiento()==NULL 
                || $objAtleta->getCelular()==NULL 
                || $objAtleta->getCedulaRepresentante()==NULL 
                || $objAtleta->getNombreRepresentante()==NULL 
                || $objAtleta->getDireccion()==NULL){
                $_SESSION['datos_completos']=FALSE;
               
                header('Location: Ficha/FichaDatosBasicos2.php');
                exit;
            }  
        }
    }  

    header('Location: MisTorneos/MisTorneos.php');
    exit;
}else{
    header('Location: bsPanel.php');
   exit;
}

?>
<!--
 