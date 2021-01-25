<?php
session_start();
require_once '../clases/Noticias_cls.php';
require_once '../sql/ConexionPDO.php';

 if(isset($_SESSION['logueado']) and !$_SESSION['logueado'] && $_SESSION['niveluser']<9 ){
   header('Location: Login.php');
 }
 


$operacion=$_POST['operacion']; // Se permite 2 operaciones Save o Edit
$id=$_POST['id'];
   
$obj = new Noticias();
$obj->Fetch($id);
if ($obj->Operacion_Exitosa()){
    $obj->Delete($id);
    echo $obj->getMensaje();
}else{
    echo $obj->getMensaje();
}
 
    
?>



    
    

