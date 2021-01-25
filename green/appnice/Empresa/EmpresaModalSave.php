<?php
session_start();
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';



 if ($_SESSION['niveluser']!=9){
     header('Location: ..sesion_inicio.php');
 }



$operacion="Save";

header('Content-type: application/json; charset=utf-8');
//$someJSON = '[{"name":"Jonathan Suh","gender":"male"},{"name":"William Philbin","gender":"male"},{"name":"Allison McKinnery","gender":"female"}]';
$dataArray=$_POST['data'];
//print_r($dataArray);   
// Convert JSON string to Array
//$dataArray = json_decode($data,true);
//print_r($dataArray);   
$txt_nombre=$dataArray[0]["value"];
$txt_direccion=$dataArray[1]["value"];
$txt_descripcion=$dataArray[2]["value"];
$txt_telefonos=$dataArray[3]["value"];
$txt_email=$dataArray[4]["value"];
$txt_twitter=$dataArray[5]["value"];
$txt_id=$dataArray[6]["value"];
$txt_estado=$dataArray[7]["value"];
$txt_colorjumbotron=$dataArray[8]["value"];
$txt_colorNavbar=$dataArray[9]["value"];
//echo '<pre>';
//    var_dump($dataArray);
//echo '</pre>';

//Instanciamos el objeto empresa para traer los datos

$objEmpresa = new Empresa();
$objEmpresa->Fetch($txt_estado);
$objEmpresa->setNombre($txt_nombre);
$objEmpresa->setDireccion($txt_direccion);
$objEmpresa->setDescripcion($txt_descripcion);
$objEmpresa->setTelefonos($txt_telefonos);
$objEmpresa->setEmail($txt_email);
$objEmpresa->setTwitter($txt_twitter);
$objEmpresa->setColorJumbotron($txt_colorjumbotron);
$objEmpresa->setColorNavbar($txt_colorNavbar);
$objEmpresa->Update();


if ($objEmpresa->Operacion_Exitosa()){
    echo json_encode(array("status" => "OK"));
}else{
    echo json_encode(array("status" => "FAIL","error" => $objEmpresa->getMensaje()));
} 
$objEmpresa= NULL;
 
    
?>
 

    
    

