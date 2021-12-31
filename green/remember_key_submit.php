<?PHP
session_start();
//require_once __DIR__.'/appnice/funciones/funcion_email.php';
require_once __DIR__.'/appnice/conexion.php';
require_once __DIR__.'/appnice/ConexionMysqli_cls.php';
require_once __DIR__.'/appnice/clases/Notificaciones_cls.php';
require_once __DIR__.'/appnice/clases/Empresa_cls.php';
require_once __DIR__.'/appnice/clases/Atleta_cls.php';
require_once __DIR__.'/appnice/sql/ConexionPDO.php';

//Programa para recuperar la clave olvidada

if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    $cedula=(isset($_POST['name_login'])) ? $_POST['name_login'] : null;
    //$fechanac=(isset($_POST['txt_fechaNacimiento'])) ? $_POST['txt_fechaNacimiento'] : null;
    //$cedula=mysqli_escape_string($conn,$cedula);
    //$time=time();
    //$fecha =date("Y-m-d", $time);
    
    $conexion = mysqli_connect($servername, $username, $password);
    mysqli_select_db($dbname, $conexion);
    $cedula = trim($cedula);
    $sql = "SELECT contrasena,nombres,apellidos,email,estado,DATE_FORMAT(atleta.fecha_nacimiento, '%Y-%m-%d') as fechanac FROM atleta where cedula='".$cedula."'";
    $result = mysqli_query($conn,$sql) or die(mysqli_error($conexion));
    $record = mysqli_fetch_assoc($result);
    $time=date("h:i:sa"); // formato de hora 09:44:23am
    if (mysqli_num_rows($result)){
        if ($record['email'] !=null){
       
            $nueva_clave = substr(md5($time),1,6); // encriptamos la nueva contraseña con md5
            $sql = mysqli_query($conn,"UPDATE atleta SET contrasena='".$nueva_clave."' ,clave_default='1' WHERE cedula='".$cedula."'");
            if($sql>0) {
                //Notificaccion via email
                $Atleta = new Atleta();
                $Atleta->Find_Cedula($cedula);
                $Empresa = new Empresa();
                $Empresa->Find_entidad($Atleta->getEstado());

                $notificaciones = new Notificaciones();
                $notificaciones->email_notificacion($Atleta,$Empresa,"RecuperarClave");

            //    email_notificacion("RecuperarClave", $cedula);
                $mensaje= 'La Clave fue enviada a su correo:'. $record['email'].'<a href="sesion_inicio.php">Presione para Seguir</a>';
                $error_login=true;
                //echo "0";
                $jsondata= array("success"=>TRUE,"msg"=>"La clave fue re-establecida y enviada al correo <spa>".$record['email'].'</span>','HTML'=>"");
            }else{
               $mensaje="Error: No se pudo recuperar la contraseña reintente nuevamente!!";
               $error_login=true;
               //echo "1";
               $jsondata= array("success"=>FALSE,"msg"=>"Error: No se pudo recuperar la contraseña intente nuevamente!!",'HTML'=>"");  
            }
        }else{
            $mensaje="Error: Usted no poseee un correo registrado !!";
            $error_login=true;
            /// echo "1";
            $jsondata= array("success"=>FALSE,"msg"=>"Error: Usted no poseee un correo registrado",'HTML'=>"");            
        }
        
        
    }else{
        $mensaje="Error: Usuario no existe, debe introducir un Usuario Valido!!";
        $error_login=true;
        ///echo "1";
        $jsondata= array("success"=>FALSE,"msg"=>"Error: Usuario incorrecto, debe introducir un usuario valido",'HTML'=>"");  
        
    }   
header("Content-type: application/json; charset=utf-8");
echo json_encode($jsondata,JSON_FORCE_OBJECT);       
}


?>
