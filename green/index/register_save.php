<?php
session_start();
require_once __DIR__.'/appnice/clases/Afiliaciones_cls.php';
require_once __DIR__.'/appnice/clases/Atleta_cls.php';
require_once __DIR__.'/appnice/clases/Afiliacion_cls.php';
require_once __DIR__.'/appnice/clases/Empresa_cls.php';
require_once __DIR__.'/appnice/funciones/funcion_email.php';
require_once __DIR__.'/appnice/sql/ConexionPDO.php';
require_once __DIR__.'/appnice/conexion.php';
require_once __DIR__.'/appnice/clases/Nacionalidad_cls.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
            
            $_SESSION['empresa_id']=$objEmpresa->get_Empresa_id();
            $_SESSION['email_empresa']=$objEmpresa->getEmail();
            $_SESSION['email_envio']=$objEmpresa->getEmail_Envio();
    
            //Notificaccion via email
            if ($obj->getEmail() !=NULL){ // enviamos correo
               email_notificacion("Pre-Afiliacion", $obj->getCedula());
            }

        }
        $msg="Registro realizado exitosamente en este Sistema. Se le ha enviado un correo de confirmacion para culminar el proceso";
        $html="<p>Registrado exitosamente en este Sistema</p>";
    }else{
        $msg="Error: Afiliado ya se encuentra registrado en este Sistema, ingrese por la opcion Login";
        $html="<p>Error : ".$obj->mensaje."</p>";
    }

    $obj= NULL;
    $jsondata = array("Success" => $ok, "msg"=>$msg,"html"=>$html);
   
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);
    exit;
}
