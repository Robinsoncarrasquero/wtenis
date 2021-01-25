<?PHP
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_email.php';

//Programa para recuperar la clave olvidada

if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    $cedula=(isset($_POST['txt_cedula'])) ? $_POST['txt_cedula'] : null;
    $fechanac=(isset($_POST['txt_fechaNacimiento'])) ? $_POST['txt_fechaNacimiento'] : null;
    $cedula=mysql_escape_string($cedula);
    $time=time();
    $fecha =date("Y-m-d", $time);
    
    $conexion = mysql_connect($servername, $username, $password);
    mysql_select_db($dbname, $conexion);
    $cedula = trim($cedula);
    $sql = "SELECT contrasena,nombres,apellidos,email,estado,DATE_FORMAT(atleta.fecha_nacimiento, '%Y-%m-%d') as fechanac FROM atleta where cedula='".$cedula."'";
    $result = mysql_query($sql, $conexion) or die(mysql_error());
    $record = mysql_fetch_assoc($result);
    $time=date("h:i:sa"); // formato de hora 09:44:23am
    if (mysql_num_rows($result)){
        if ($record['email'] !=null){
       
            $nueva_clave = substr(md5($time),1,6); // encriptamos la nueva contraseña con md5
            $sql = mysql_query("UPDATE atleta SET contrasena='".$nueva_clave."' ,clave_default='1' WHERE cedula='".$cedula."'");
            if($sql>0) {
                email_notificacion("RecuperarClave", $cedula);
                $mensaje= 'La Clave fue enviada a su correo:'. $record['email'].'<a href="sesion_inicio.php">Presione para Seguir</a>';
                $error_login=true;
                //echo "0";
                $jsondata= array("Success"=>TRUE,"Mensaje"=>"La clave fue Reestablecida y Enviada a su Correo ".$record['email'],HTML=>"");
            }else{
               $mensaje="Error: No se pudo recuperar la contraseña reintente nuevamente!!";
               $error_login=true;
               //echo "1";
               $jsondata= array("Success"=>FALSE,"Mensaje"=>"Error: No se pudo recuperar la contraseña intente nuevamente!!",HTML=>"");  
            }
        }else{
            $afechanac = explode ('-', $fechanac); // campo del formulario
            $bfechanac = explode('-',$record['fechanac']); // campo de la bd
            if($afechanac[2] !=$bfechanac[2] || $afechanac[1]!=$bfechanac[1] || $afechanac[0]!=$bfechanac[0]){
               $mensaje="Error: No se pudo recuperar la fecha nacimiento errada";
               $error_login=true;
              // echo "1";
               $jsondata= array("Success"=>FALSE,"Mensaje"=>"Error: La fecha de nacimiento esta Errada",HTML=>"");  
            
            }else{
                $nueva_clave = substr(md5($time),1,6); // encriptamos la nueva contraseña con md5
                $sql = mysql_query("UPDATE atleta SET contrasena='".$cedula."' ,clave_default=NULL  WHERE cedula='".$cedula."'");
                if($sql>0) {
                    email_notificacion("RecuperarClave", $cedula);
                    $mensaje= 'La Clave fue reiniciada  exitosamente!!</a>';
                    $error_login=true;
                    //echo "2";
                    $jsondata= array("Success"=>TRUE,"Mensaje"=>"La clave fue Reiniciada, ahora su Clave es identica a su Cedula, ya puede ingresar..",HTML=>"");
                }else{
                  $mensaje="Error: no se pudieron actualizar los datos, intente mas tarde!!";
                   $error_login=true;
                  /// echo "1";
                   $jsondata= array("Success"=>FALSE,"Mensaje"=>"Error: No se pudo restablecer la clave, Error de conexion",HTML=>"");            
                }
            }
        }
    }else{
        $mensaje="Error: Usuario no existe, debe introducir un Usuario Valido!!";
        $error_login=true;
        ///echo "1";
        $jsondata= array("Success"=>FALSE,"Mensaje"=>"Error: Usuario incorrecto, debe introducir un usuario valido",HTML=>"");  
        
    }   
header("Content-type: application/json; charset=utf-8");
echo json_encode($jsondata,JSON_FORCE_OBJECT);       
}


?>
