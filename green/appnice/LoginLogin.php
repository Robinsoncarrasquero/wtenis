<?php
session_start();
require_once 'sql/ConexionPDO.php';
require_once 'clases/Atleta_cls.php';
include_once 'extensions/Mobile-Detect.php';

 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $cedula=$_POST['user'];
    $pwd=$_POST['password'];
    $objUser = new Atleta();
    
    $objUser->ReadById(0, $cedula);

   if ($objUser->operacionExitosa()){
       
                  
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
           if($usuario == $item['usuario'] && ($contrasena == $item['contrasena'] ) || MODO_DE_PRUEBA=="1"){
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
            $_SESSION['empresa_id'] = 0;
            
            $sql = "SELECT empresa_id,email,email_envio from empresa WHERE estado='".$estado."'";
            $result = mysql_query($sql);
            
            if ($result){
                $record = mysql_fetch_assoc($result);
                $_SESSION['empresa_id'] = $record['empresa_id'];
                $_SESSION['estado'] = $estado;
                $_SESSION['asociacion']=$estado;
                $_SESSION['email_empresa'] = $record['email'];
                $_SESSION['email_envio'] = $record['email_envio'];
               
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
        echo "Logueado" ;
    }else{
        echo "Error" ;
         
    }
    $objUser = new Atleta();
   
}
 
?>


