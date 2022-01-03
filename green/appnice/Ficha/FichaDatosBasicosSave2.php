<?php
session_start();
require_once __DIR__.'/../clases/Afiliaciones_cls.php';
require_once __DIR__.'/../clases/Atleta_cls.php';
require_once __DIR__.'/../clases/Afiliacion_cls.php';
require_once __DIR__.'/../clases/Empresa_cls.php';
require_once __DIR__.'/../funciones/funcion_email.php';
require_once __DIR__.'/../sql/ConexionPDO.php';



$ok = FALSE; 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $txt_id =$_POST['txt_id'];
    
    $txt_cedula = trim($_POST['txt_cedula']);
    $txt_nombres = $_POST['txt_nombres'];
    $txt_apellidos = $_POST['txt_apellidos'];
    $txt_sexo = $_POST['txt_sexo'];
    $txt_fechaNacimiento = $_POST['txt_fechaNacimiento'];
    $txt_biografia = '';
    $txt_cedularep = $_POST['txt_cedularep'];
    $txt_nombrerep = $_POST['txt_nombrerep'];
    $txt_direccion = $_POST['txt_direccion'];
    $txt_telefonos = $_POST['txt_telefonos'];
    $txt_email = $_POST['txt_email'];
    $txt_asociacion = $_POST['txt_asociacion'];
    $txt_disciplina = $_POST['txt_disciplina'];
    $txt_nacionalidad_id = $_POST['txt_nacionalidad'];
    $txt_lugar_nacimiento = $_POST['txt_lugar_nac'];
    $txt_lugar_trabajo = $_POST['txt_lugar_trabajo'];
    $txt_celular = $_POST['txt_celular'];
    $txt_talla = $_POST['txt_talla'];
    $txt_peso = $_POST['txt_peso'];
    $txt_inicio = $_POST['txt_inicio'];
    $txt_hand = $_POST['txt_hand'];
    $txt_nickname = $_POST['txt_nickname'];

    $msg='La Ficha no fue actualizada, intente nuevamente';
    $ok = false; 
    $obj = new Atleta();
    $obj->Find($txt_id);
    
    if ($obj->Operacion_Exitosa())
    {
        $obj->setCedula($txt_cedula);
        $obj->setNombres($txt_nombres);
        $obj->setApellidos($txt_apellidos);
        $obj->setSexo($txt_sexo);
        $obj->setFechaNacimiento($txt_fechaNacimiento);
        $obj->setBiografia($txt_biografia);
        $obj->setCedulaRepresentante($txt_cedularep);
        $obj->setNombreRepresentante($txt_nombrerep);
        $obj->setDireccion($txt_direccion);
        $obj->setTelefonos($txt_telefonos);
        $obj->setEmail($txt_email);
        $obj->setEstado($txt_asociacion);
        $obj->setNacionalidadID($txt_nacionalidad_id);
        $obj->setLugarNacimiento($txt_lugar_nacimiento);
        $obj->setLugarTrabajo($txt_lugar_trabajo);
        $obj->setCelular($txt_celular);
        $obj->setDisciplina($txt_disciplina);
        $obj->setFechaModificacion(date("Y-m-d H:i:s"));
        $obj->setTalla($txt_talla);
        $obj->setPeso($txt_peso);
        $obj->setInicio($txt_inicio);
        $obj->setHand($txt_hand);
        $obj->setNickName($txt_nickname);
              
        $obj->Update();
        $ok = true; 
        $msg='Ficha actualizada. Hemos enviado un correo de notificacion';
        $operacion = $obj->mensaje;
        //Instanciamos la clase empresa para obtener la empresa_id
        //de la asociacion registrada
        $objEmpresa = new Empresa();
        $objEmpresa->Fetch($txt_asociacion);
        if ($objEmpresa->Operacion_Exitosa()) {

            //Instanciamos la clase afiliacion para obtener los montos
            //de las afiliaciones por asociacion 
            $objAfiliacion = new Afiliacion();
            $objAfiliacion->Fetch($objEmpresa->get_Empresa_id()); //Busca la ultima afiliacion activa
            $monto_aso = $objAfiliacion->getAsociacion();
            $monto_fvt = $objAfiliacion->getFVT();
            $monto_sis = $objAfiliacion->getSistemaWeb();
            
            //Afiliacion del jugador
            $objAfiliaciones = new Afiliaciones();
            $objAfiliaciones->Find_Afiliacion_Atleta($obj->getID(),$objAfiliacion->getAno());
            if ($objAfiliaciones->Operacion_Exitosa()){
                $objAfiliaciones->setSexo($txt_sexo);
                $objAfiliaciones->setCategoria($obj->categoria_natural($objAfiliacion->getAno()));
                $objAfiliaciones->setModalidad($txt_disciplina);
                $objAfiliaciones->setAfiliacion_id($objAfiliacion->get_ID());
                $objAfiliaciones->Update();
            }
            
            //Datos para el correo
            $email_empresa = $objEmpresa->getEmail();
            $email = $obj->getEmail();
            $cedula=$obj->getCedula();
            $nombre_atleta = $obj->getNombres();
            $apellido_atleta = $obj->getApellidos();
            $banco = $objEmpresa->getBanco();
            $cuenta = $objEmpresa->getCuenta();
            $url = $objEmpresa->getURL();
            $nombre_empresa = $objEmpresa->getNombre();
            if ($email != NULL ) { // enviamos correo
                //Enviamos correo
                email_notificacion('FICHA',$cedula);
            }
        }
    
        $obj = NULL;
    }

    if (!$ok){
        $jsondata = array("Success" => false, "Mensaje"=>$msg);   
    } else {    
        $jsondata = array("Success" => true, "Mensaje"=>$msg);   
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);
    
}
?>

