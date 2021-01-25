<?php
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_email.php';
    
   

 if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula =$_SESSION['cedula'];
    $menuuser= $_SESSION['menuuser'];
  
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    $msg="<div style='color:red;margin-top:100;margin-left: 200px' ><h1 >ACCESO DENEGADO, USUARIO NO AUTORIZADO</h1></div> ";
//    for($i=0;$i<4;$i++){
//     echo $msg; }
     //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_cerrar.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')    { // comprobamos que venga mediante post
        if($_POST['password'] ==null && $_POST['cpassword']==null) {
          header('Location: ../sesion_cerrar.php');   
        }
       $pwd = $_POST["password"];

        //$usuario_clave = md5($usuario_clave); // encriptamos la nueva contraseña con md5
        if($_POST['password'] === $_POST['cpassword']) {
            $sql = mysql_query("UPDATE atleta SET contrasena='".$pwd."',clave_default='1'  WHERE cedula='".$cedula."'");
            if($sql>0) {
                email_notificacion("Clave", $cedula);
                $error_login=FALSE;
                $_SESSION['pwdpwd'] =  $pwd;
                $_SESSION['clave_default'] ="1";
                echo "0";


            }else{
                 $error_login=TRUE;
                echo "Error imposible establecer la Conexion, intente mas tarde...";
           
            }
        }else{
           echo "1";
        }
    }

 
     
?>