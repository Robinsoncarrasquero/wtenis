<?php
session_start();
require_once __DIR__.'/appnice/clases/Afiliaciones_cls.php';
require_once __DIR__.'/appnice/clases/Atleta_cls.php';
require_once __DIR__.'/appnice/clases/Afiliacion_cls.php';
require_once __DIR__.'/appnice/clases/Empresa_cls.php';
require_once __DIR__.'/appnice/clases/Torneos_cls.php';

//require_once __DIR__.'/appnice/funciones/funcion_email.php';
require_once __DIR__.'/appnice/clases/Notificaciones_cls.php';
require_once __DIR__.'/appnice/sql/ConexionPDO.php';
require_once __DIR__.'/appnice/clases/Nacionalidad_cls.php';


$dataprueba=false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    	
    if ($dataprueba){
        
        $txt_cedula ="V10109X11";
        $txt_nombres="prueba" ;
        $txt_apellidos="PRUEBA";;
        $txt_password="SECRET1234";
        $txt_confirm_password="SECRET1234";
        $txt_email="X@X.COM";
        $txt_sexo='F';
        $txt_fechaNacimiento="2010-04-06";
        $txt_biografia='';
        $txt_direccion="ccs";
        $txt_telefonos="412121212";
        $txt_asociacion="ANZ";
        $txt_nacionalidad_id =1;
        $txt_disciplina = "TDC";
        $txt_celular="4141414141";
        $txt_lugar_trabajo="CCC";
    }else{

    
        $txt_cedula = htmlentities(trim($_POST['txt_cedula']));
        $txt_nombres=htmlentities($_POST['txt_nombre']);
        $txt_apellidos= htmlentities($_POST['txt_apellido']);
        $txt_password=$_POST['password'];
        $txt_confirm_password=$_POST['confirm_password'];
        $txt_email=htmlentities($_POST['email']);
        $txt_sexo=htmlentities($_POST['txt_sexo']);
        $txt_fechaNacimiento=$_POST['txt_fecha_nac'];
        $txt_biografia='';

        
        // $txt_cedularep=$_POST['txt_cedularep'];
        // $txt_nombrerep=$_POST['txt_nombrerep'];
        $txt_direccion=htmlentities($_POST['txt_direccion']);
        $txt_telefonos=htmlentities($_POST['txt_telefonos']);
        $txt_asociacion=htmlentities($_POST['txt_asociacion']);
        $txt_nacionalidad_id = htmlentities($_POST['txt_nacionalidad']);
        $txt_disciplina = htmlentities($_POST['txt_disciplina']);
        //$txt_lugar_nac=$_POST['txt_lugar_nac'];
        $txt_celular=htmlentities($_POST['txt_celular']);
        $txt_lugar_trabajo=htmlentities($_POST['txt_lugar_trabajo']);
    
    }   
    $obj = new Atleta();
    $obj->setCedula($txt_cedula);
    $obj->setNombres($txt_nombres);
    $obj->setApellidos($txt_apellidos);
    $obj->setSexo($txt_sexo);
    $obj->setFechaNacimiento($txt_fechaNacimiento);
    $obj->setBiografia($txt_biografia);
    // $obj->setCedulaRepresentante($txt_cedularep);
    // $obj->setNombreRepresentante($txt_nombrerep);
    $obj->setDireccion($txt_direccion);
    $obj->setTelefonos($txt_telefonos);
    $obj->setEmail($txt_email);
    $obj->setEstado($txt_asociacion);
    $obj->setNacionalidadID($txt_nacionalidad_id);
    $obj->setCategoria(2);
    $obj->setDisciplina($txt_disciplina);
    $obj->setCelular($txt_celular);
    //$obj->setLugarNacimiento($txt_lugar_nac);
    $obj->setLugarTrabajo($txt_lugar_trabajo);
    $obj->setContrasena($txt_password);
    $obj->setClaveDefault(1);
    $html="<br>Procesado</br>";
    $obj->create();
    $operacion=$obj->mensaje;
    $ok=FALSE;
    if ($obj->Operacion_Exitosa()){
        $ok=TRUE;
            //Instanciamos la clase empresa para obtener la empresa_id
        //de la asociacion registrada
        $objEmpresa= new Empresa();
        $objEmpresa->Fetch($txt_asociacion);
        if ($objEmpresa->Operacion_Exitosa()){
            
            //Afiliaciones para obtener los montos
            $objAfiliacion = new Afiliacion();
            $objAfiliacion->Fetch($objEmpresa->get_Empresa_id());
            
            $objAfiliaciones = new Afiliaciones();
            $objAfiliaciones->setAno($objAfiliacion->getAno());
            $objAfiliaciones->setAtleta_id($obj->getID());
            $objAfiliaciones->setSexo($obj->getSexo());
            $objAfiliaciones->setCategoria($obj->categoria_natural($objAfiliacion->getAno()));
            $objAfiliaciones->setAsociacion($objAfiliacion->getAsociacion());
            $objAfiliaciones->setFVT($objAfiliacion->getFVT());
            $objAfiliaciones->setModalidad($txt_disciplina);
            $objAfiliaciones->setAfiliacion_id($objAfiliacion->get_ID());
            $objAfiliaciones->setAceptado(1);
            $objAfiliaciones->setAfiliarme(1);
            $objAfiliaciones->create();
            
            //Datos para el correo
            
                
            $notificaciones = new Notificaciones();
            //Notificaccion via email
            if ($obj->getEmail() !=NULL){
                if ($notificaciones->email_notificacion($obj,$objEmpresa,"Pre-Afiliacion")){
                    $error_login=true;
                    $jsondata= array("success"=>TRUE,"msg"=>"La clave fue re-establecida y enviada al correo ".$obj->getEmail(),'HTML'=>"");
                }else{
                    $mensaje="Error de Conexion. No se pudo enviar el correo con la nueva contraseña, reintente nuevamente!!";
                    $error_login=true;
                    $jsondata= array("success"=>FALSE,"msg"=>"Error de Conexion. No se pudo enviar el correo con la nueva contraseña, reintente nuevamente!!",'HTML'=>"");  
               }
            }

        }
        $msg="</br>Registro realizado exitosamente. Seras direccionado para ingresa y culminar el proceso</br></br><p>El usuario es la cedula</p></br>";
        $html="<p>Registrado exitosamente en este Sistema</p>";
    }else{
        $msg="</br><span>Error: Afiliado ya se encuentra registrado en este Sistema, ingrese por la opcion Login</span></br>";
        $html="<p>Error : ".$obj->mensaje."</p>";
    }

    $obj= NULL;
    $jsondata = array("Success" => $ok, "msg"=>$msg,"html"=>$html);
   
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);
    exit;
}
