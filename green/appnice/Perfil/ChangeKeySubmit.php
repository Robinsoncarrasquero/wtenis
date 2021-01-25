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
    
    
    if($_POST['password'] != $_POST['cpassword']) {
        $nr=1;
        $msg='La clave dada no coincide en ambos campos de entrada. Deben tener un minimo de 6 caracteres y un maximo de 12';
    }
    if(strlen($_POST['password'])<6 || strlen($_POST['password'])>12) {
        $nr=1;
        $msg='Debe Especificar una Clave identica con un minimo de 6 caracteres y un maximo de 12.';
    }
    if (!is_valid_password($_POST["password"])){
        $nr=1;
        $msg='La clave debe estar compuesta de forma alfanumerica y al final debe colocar al menos un numero';
    }
    $pwd=$_POST['password'];
    $cedula = ($_SESSION["cedula"]);
        
    //$usuario_clave = md5($usuario_clave); // encriptamos la nueva contraseña con md5
    if($nr==0 && $_POST['password'] === $_POST['cpassword']) {
        $sql = mysqli_query($conn,"UPDATE atleta SET contrasena='".$pwd."',clave_default='1'  WHERE cedula='".$cedula."'");
        if($sql>0) {
            email_notificacion("Clave", $cedula);
            $error_login=FALSE;
            $_SESSION['pwdpwd'] =  $pwd;
            $_SESSION['clave_default'] ="1";
            $nr=0;
            $msg='El Cambio de Clave se ha realizado exitosamente';
        }else{
                $error_login=TRUE;
                $msg="Error imposible establecer la Conexion con el sistema, intente mas tarde...";
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