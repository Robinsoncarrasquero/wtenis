<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Rank_cls.php';
require_once '../funciones/funcion_archivos.php';
sleep(1);

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
    header('Location: ../sesion_inicio.php');
    exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<10){
   header('Location: ../sesion_inicio.php');
   exit;
}
$disciplina_Filtro=$_POST['cmbdisciplina']; //disciplina

$sexo_Filtro=$_POST['cmbsexo']; //sexo
$fecha_rk=  $_POST['fecha_rk']; //Fecha Ranking

$categoria_Filtro=$_POST['cmbcategoria']; //categoria

$disciplina_Filtro=$_POST['cmbdisciplina']; //disciplina

$sexo_Filtro=$_POST['cmbsexo']; //sexo

$posicion_array=0;
$carpetaAdjunta="../FILE_RANKING/"; 

$nuevo_nombre=$disciplina_Filtro."_".$fecha_rk."_".$categoria_Filtro.$sexo_Filtro.".xls";
$nombreArchivo=$_FILES['franking']['name'][$posicion_array];
$nombreTemporal=$_FILES['franking']['tmp_name'][$posicion_array];
$tipoArchivo=$_FILES['franking']['type'][$posicion_array];
$rutaArchivo=$carpetaAdjunta.$nuevo_nombre;

if (move_uploaded_file($nombreTemporal,$rutaArchivo)){
    $objfs = new Rank();
    $objfs->setFecha($fecha_rk);
    $objfs->setCategoria($categoria_Filtro);
    $objfs->setSexo($sexo_Filtro);
    $objfs->setFileName($nuevo_nombre);
    $objfs->setFileType($tipoArchivo);
    $objfs->setCarpeta($carpetaAdjunta);
    $objfs->setDisciplina($disciplina_Filtro);
    $objfs->Create();
    if (!$objfs->Operacion_Exitosa()){
       $objfs->Update();
    }
    if ($objfs->Operacion_Exitosa()){
        $jsondata = array("Success" =>TRUE,"Mensaje"=>$nuevo_nombre." ".$objfs->getMensaje());
    }  else {
       $jsondata = array("Success" =>FALSE,"Mensaje"=>"Este Archivo no se puede subir ".$nuevo_nombre." ".$objfs->getMensaje());
    }
    
}else{
      $jsondata = array("Success" =>FALSE,"Mensaje"=>"Sorry, No hay archivos para subir");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);


