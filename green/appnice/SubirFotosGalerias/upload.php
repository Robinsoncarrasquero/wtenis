<?php
session_start();
require_once '../funciones/Imagenes_cls.php';

/* 
 *Este programa cargas las imagenes en una carpeta especificada
 * Funciona con Bootstrap File Input Example
 */
if ($_SESSION['niveluser']>0){
    header("location : ../Login.php");
}
$torneo_id=$_POST['forder_id'];


//$folder="../".$_SESSION['url_fotos_torneos'];
$folder="../uploadFotos/torneos/$torneo_id/";
$json=Imagenes::load_img($folder,0,0);



    



