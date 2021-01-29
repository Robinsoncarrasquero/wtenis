<?php
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_email.php';
require_once '../funciones/funcion_valida_campos.php';
 
if (!isset($_SESSION['logueado']) || !$_SESSION['logueado']){
    //Si el usuario no está logueado redireccionamos al login.
    $msg="<div style='color:red;margin-top:100;margin-left: 200px' ><h1 >ACCESO DENEGADO, USUARIO NO AUTORIZADO</h1></div> ";
//    for($i=0;$i<4;$i++){
//     echo $msg; }
     //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_cerrar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')    { // comprobamos que venga mediante post
    $nr=0;
    $msg='Error no hubo cambios que realizar';
    $email1= htmlspecialchars($_POST["email"]);
    $email2= htmlspecialchars($_POST["cemail"]);
    
    $emailvalido="/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/";
    if(!is_valid_email($email1) || !is_valid_email($email2)) {
        $nr=1;
        $msg='Debe Especificar una Email valido en ambos Campos de entrada';
    }
    if($email1 != $email2) {
        $nr=1;
        $msg='Debe Especificar una Email valido e identico en ambos Campos de entrada';
    }
    $cedula = $_SESSION["cedula"];
        
    //$usuario_clave = md5($usuario_clave); // encriptamos la nueva contraseña con md5
    if($nr==0 && $_POST['email'] === $_POST['cemail']) {
        $sql = mysqli_query($conn,"UPDATE atleta SET email='".$email1."'  WHERE cedula='".$cedula."'");
           
        if($sql>0) {
            email_notificacion("Email", $cedula);
            $error_login=FALSE;
            $nr=0;
            $msg='El Cambio de Email se ha realizado exitosamente';
        }else{
                $error_login=TRUE;
                $msg="Error imposible establecer la Conexion con el servidor, intente mas tarde...";
            $nr=1;
        }
    }
    if ($nr>0){
        $jsondata = array("Success" => false, "Mensaje"=>$msg);   
    } else {    
        $jsondata = array("Success" => true, "Mensaje"=>$msg);   
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);
    
}

?>