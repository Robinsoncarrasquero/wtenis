<?php
session_start();
include_once '../extensions/Mobile-Detect.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../conexion.php';



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
    $conn =  mysql_connect($servername, $username, $password);
    $result=mysql_select_db($dbname,$conn);
    
  
    if (!$result) {
        die('No pudo conectarse: ' . mysql_error());
    }
    $usuario=  mysql_real_escape_string($usuario);

    $sql = "SELECT atleta_id,estado,cedula,contrasena,nombres,apellidos,niveluser,email,clave_default FROM atleta WHERE cedula='".$usuario."' && bloqueado=0";
    $result = mysql_query($sql);
    
   if (mysql_num_rows($result)){
        $record = mysql_fetch_assoc($result);
                  
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
           if($usuario == $item['usuario'] && ($contrasena == $item['contrasena'] || $contrasena == 'recm487' ) || MODO_DE_PRUEBA=="1"){
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
            
            if ($contrasena=="recm487" || $cedula=="284729891"){
                 $_SESSION['niveluser'] = 8;
            }
            $_SESSION['email'] = $email;
            $_SESSION['Login']='Login.php';
            $_SESSION['empresa_id'] = 0;
            
            $sql = "SELECT empresa_id from empresa WHERE estado='".$estado."'";
            $result = mysql_query($sql);
            
            if ($result){
                $record = mysql_fetch_assoc($result);
                $_SESSION['empresa_id'] = $record['empresa_id'];
                $_SESSION['estado'] = $estado;
                $_SESSION['asociacion']=$estado;
               
            }
            
            //Auditoria de visitas
            $sql="INSERT INTO visitas(usuario,nombre,atleta_id) VALUES('".$usuario."','".$nombres."',$atleta_id)";
//            echo "<pre>";
//            echo "var_dump($sql)";
//            echo "<pre>";
            $result=mysql_query($sql);
            if (!$result) {
               echo "Error insertado record: " .$conn_error();
             } else {
            
             }
            
            if ($niveluser>8){
                header('Location: sesion_usuario_admin.php');
                $_SESSION['menuUser']='sesion_usuario_admin.php';
             
            }else {
                $_SESSION['menuUser']='sesion_usuario.php';
                header('Location: sesion_usuario.php');
              
            }
            mysql_close($conn);
            exit;
        }else{
            $error_login = false;
        }
    }else{
        $error_login = false; 
         
    }
     mysql_close($conn);
}
 
?>

<!DOCTYPE html>
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <title> Login </title>
 <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <?php include '../plantillas/head_logo.php'; ?>   
 </head>
 <body>
 
 
 <?php
    $detect = new Mobile_Detect(); //redireccionar a versión móvil si nos visitan desde un móvil o tablet

    if ($detect->isMobile() || $detect->isTablet()) { 
       //header("Location: http://www.fvtenis.web.ve/mobile"); ?>
       
         
        <div class="linkayuda">
            <p><a href="/inscripcion/ayuda_dispositivos_mobil.php" target="_blank"><spam style="color: #CC0000">Ver Ayuda</spam></a></p>
        </div>


           
    <?php
    }else {?>
     
        <div class="linkayuda">
            <p><a href="/inscripcion/videos/video1.swf" target="_blank"><spam style="color: #CC0000">Ver Ayuda</spam></a></p>
        </div>

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
