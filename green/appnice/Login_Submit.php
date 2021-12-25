<?php

use RedBeanPHP\Util\Dump;

session_start();
require_once 'conexion.php';
require_once 'funciones/funciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // $dotenv = Dotenv\Dotenv::createImmutable('../');
    // $dotenv->load();

    $usuario = addslashes($_POST['usuario']);
    $contrasena = addslashes($_POST['contrasena']);

    $conn = mysqli_connect ($servername, $username, $password);
    $conn =mysqli_connect($servername, $username, $password,$dbname);
    //$result=mysqli_select_db($dbname,$conn);
    $result=$mysqli->select_db($dbname);

    if (!$result) {
       echo "2"; //Not avalaible
       die('No pudo conectarse: ' . mysqli_error($conn));
    }
    $usuario=  mysqli_real_escape_string($conn,$usuario);

    $sql = "SELECT atleta_id,estado,sexo,cedula,contrasena,nombres,apellidos,niveluser,email,clave_default FROM atleta WHERE cedula='".$usuario."' && bloqueado=0";
    $result = mysqli_query($conn,$sql);

   if (mysqli_num_rows($result)){
        $record = mysqli_fetch_assoc($result);
        $atleta_id=$record["atleta_id"];
        $cedula=$record["cedula"];
        $atleta_id=$record["atleta_id"];
        $nombres= trim($record["nombres"]);
        $apellidos= trim($record["apellidos"]);
        $sexo=$record["sexo"];
        $niveluser= $record["niveluser"];
        $email=$record["email"];
        $estado= $record["estado"];
        $clave_default=$record['clave_default'];
        $array_usuarios=   array(array('usuario'=>$record['cedula'],'contrasena'=>$record['contrasena']));

        //Creamos una variable para verificar si el usuario con ese nombre y contraseña existe.
        $usuario_encontrado = false;
        foreach($array_usuarios as $item){
           //Si encuentra al usuario con ese nombre y contraseña sete la variable $usuario_encontrado a true y rompe el bucle para no seguir buscando.
           if($usuario === $item['usuario'] && ($contrasena === $item['contrasena'])){
              $usuario_encontrado = true;

              break;
            }
        }
             //Verifica si dentro del bucle se ha encontrado el usuario.
        if($usuario_encontrado){
            $_SESSION['logueado'] = true;
            $_SESSION['usuario']= $usuario;
            $_SESSION['nombre'] = $nombres;
            $_SESSION['Apellido'] = $apellidos;
            $_SESSION['cedula'] = $cedula;
            $_SESSION['sexo'] = $sexo;
            $_SESSION['pwdpwd'] = $contrasena;
            $_SESSION['atleta_id'] = $atleta_id;
            $_SESSION['niveluser'] = $niveluser;
            $_SESSION['tiempo_inicio'] = time();
            $_SESSION['clave_default'] = $clave_default;


            $_SESSION['email'] = $email;

            $_SESSION['ano_afiliacion']=date("Y");

            //Varibales de control global
            $_SESSION['estado'] = $estado;
            $_SESSION['asociacion']=$estado;
            $_SESSION['email_empresa'] = NULL;
            $_SESSION['email_envio'] = NULL;
            $_SESSION['afiliado'] = 0;
            $sql = "SELECT colorNavbar,colorjumbotron,bgcolorjumbotron,url,estado,empresa_id,nombre,email,email_envio from empresa WHERE estado='$estado'";
            $result2=mysqli_query($conn,$sql);
            $record = mysqli_fetch_assoc($result2);
            //Chequeamos si esta afiliado
            //$_SESSION['home'] = 'bsindex.php?s1='.strtolower($_SESSION['asociacion']);
            $_SESSION['empresa_id'] = 0;


            if ($record){

                $_SESSION['empresa_id'] = $record['empresa_id'];
                $_SESSION['empresa_nombre']=$record['nombre'];
                $_SESSION['asociacion']=$record['estado'];
                $_SESSION['email_empresa'] = $record['email'];
                $_SESSION['email_envio'] = $record['email_envio'];
                $_SESSION['afiliado'] = 1; //Indica que el user es una afiliado de la asociacion

                $_SESSION['home']=MODO_DE_PRUEBA ? 'bsindex.php?s1='.strtolower($_SESSION['asociacion']) : $record['url'];
            }

             //Varibles reseteo
            $_SESSION['ano_afiliacion']=date("Y");
            $_SESSION['url_fotos']="slide/" .strtolower($_SESSION['asociacion']);
            $_SESSION['url_fotos_portal']="uploadFotos/portal/" .strtolower($_SESSION['asociacion']).'/';
            $_SESSION['url_foto_perfil']="uploadFotos/perfil/";
            $_SESSION['url_fotos_torneos']="uploadFotos/torneos/";
            $_SESSION['url_logo']="images/logo/" .strtolower($_SESSION['asociacion']);
            $_SESSION['color_jumbotron']=$record['colorjumbotron'];
            $_SESSION['bgcolor_jumbotron']=$record['bgcolorjumbotron'];
            $_SESSION['bgcolor_navbar']=$record['colorNavbar'];
            $_SESSION['favicon']="images/logo/" .strtolower($_SESSION['asociacion']).'/favico.ico';


            //Determinamos Afiliacion activa del periodo
            $sql = "SELECT afiliacion_id FROM afiliacion WHERE fecha_desde<=now() && fecha_hasta>=now() && empresa_id=". $_SESSION['empresa_id'];
            $result = mysqli_query($conn,$sql);
            $rsAfiliacion = mysqli_fetch_array($result);
            $afiliacion_id=$rsAfiliacion['afiliacion_id'];

            //Determinamos que el afiliado haya formalizado su pago
            //$sql = "SELECT pagado,aceptado FROM afiliaciones WHERE  atleta_id=$atleta_id && afiliacion_id=".$afiliacion_id;
             $ano_afiliacion = date ("Y");
            //Determinamos que el afiliado haya formalizado su pago
            $sql = "SELECT pagado,aceptado,afiliaciones_id FROM afiliaciones WHERE  atleta_id=$atleta_id && ano=".$ano_afiliacion;

            $result = mysqli_query($conn,$sql);
            $rsAfiliados = mysqli_fetch_array($result);

            if ($rsAfiliados['pagado'] > 0) {
                $_SESSION['deshabilitado'] = FALSE; //Habilitado para imprimir o enviar correo
                $_SESSION['SWEB']=1; //Nos indica que tomo el servicio web
                $_SESSION['aceptado'] = 1;

            } else {
                $_SESSION['deshabilitado'] = TRUE; //Habilitado para imprimir o enviar correo
                $_SESSION['SWEB']=0; //Nos indica que la toma del servicio web
                $_SESSION['aceptado'] = 0;
            }
            $myip= getRealIP(); // ip desde donde el usuario ve la pagina
            //Auditoria de visitas
            $sql="INSERT INTO visitas(usuario,nombre,atleta_id,ip) VALUES('".$usuario."','".$nombres."',$atleta_id,'".$myip."')";
            $result=mysqli_query($conn,$sql);
            //Contamos cuantos afiliados tenemos para determinar un minimo de afiliados para permitir
            $result=mysqli_query($conn,"SELECT count(*) as total FROM afiliaciones   WHERE formalizacion>0 && afiliacion_id=$afiliacion_id");
            $rsTotal = mysqli_fetch_array($result);
            $formalizadas= $rsTotal['total'];

            $result=mysqli_query($conn,"SELECT count(*) as total FROM afiliaciones   WHERE pagado>0 && afiliacion_id=$afiliacion_id");
            $rsTotal = mysqli_fetch_array($result);
            $pagados= $rsTotal['total'];

            $_SESSION['total']=$rsTotal['total']*0.5;
            $minimo=$formalizadas*0.5;
            $minimo=1;


            mysqli_close($conn);

            //echo "found";
            echo "0"; //  Good

        }else{
            $error_login = false;
             echo "1"; //  Invalid key
        }
    }else{
        $error_login = false;
        echo "1"; //  Invalid key
    }
     mysqli_close($conn);
}

?>
