<?php
session_start();
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';

 
if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}


$operacion=$_POST['operacion']; // Se permite 2 operaciones Save o Edit
$id=$_POST['id'];
   
$obj = new Empresa();
$obj->Fetch($id);
if ($obj->Operacion_Exitosa()){
    $obj->Delete($id);
    echo $obj->getMensaje();
}else{
    echo $obj->getMensaje();
}
 
    
?>



    
    

