<?php


session_start();
require '../vendor/autoload.php';
require_once __DIR__.'/appnice/clases/Atleta_cls.php';
require_once __DIR__.'/appnice/clases/AbstractCrud_cls.php';
require_once __DIR__.'/appnice/clases/Visita_cls.php';
require_once __DIR__.'/appnice/clases/Empresa_cls.php';
require_once __DIR__.'/appnice/clases/Afiliaciones_cls.php';
require_once __DIR__.'/appnice/clases/Empresa_cls.php';
require_once __DIR__.'/appnice/clases/Funciones_cls.php';
require_once __DIR__.'/appnice/sql/ConexionPDO.php';


date_default_timezone_set('America/La_Paz');
$error_login = false; 
$msg='ERROR: El Usuario suministrado es incorrecto o el Password es invalido!</br>Ingrese una clave usuario y clave valida';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dotenv = Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    $usuario = addslashes($_POST['name_login']);
    $contrasena = addslashes($_POST['password_login']);
    $objUser = new Atleta();
    $objUser->Fetch(0,$usuario);
    if ($objUser->Operacion_Exitosa() && $objUser->getContrasena()==$contrasena){
                 
      $_SESSION['logueado'] = true;
      $_SESSION['usuario']= $usuario;
      $_SESSION['nombre'] = $objUser->getNombres();
      $_SESSION['Apellido'] = $objUser->getApellidos();
      $_SESSION['cedula'] = $objUser->getCedula();
      $_SESSION['sexo'] = $objUser->getSexo();
      $_SESSION['pwdpwd'] = $contrasena;
      $_SESSION['atleta_id'] = $objUser->getID();
      $_SESSION['niveluser'] = $objUser->getNiveluser();
      $_SESSION['tiempo_inicio'] = time();
      $_SESSION['clave_default'] = $objUser->getClaveDefault();
      $_SESSION['email'] = $objUser->getEmail();
      $_SESSION['ano_afiliacion']=date("Y");
      
      $_SESSION['estado'] = $objUser->getEstado();
      $_SESSION['asociacion']=$objUser->getEstado();
      $_SESSION['email_empresa'] = NULL;
      $_SESSION['email_envio'] = NULL;
      $_SESSION['afiliado'] = 0;

      //$_SESSION['home'] = 'bsindex.php?s1='.strtolower($objUser->getEstado());
      $_SESSION['empresa_id'] = 0;
      $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
      $config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
      $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
      $_SESSION['home'] = $config['base_url'].'index.php';
      //Datos de la Entidad o Asociacion Nacional
      $objEmpresa = new Empresa();
      $objEmpresa->Fetch($objUser->getEstado());
      $_SESSION['empresa_id'] = $objEmpresa->get_Empresa_id() ;
      $_SESSION['empresa_nombre']=$objEmpresa->getNombre();
      $_SESSION['asociacion']=$objEmpresa->getEstado();
      $_SESSION['email_empresa'] = $objEmpresa->getEmail();
     // $_SESSION['email_envio'] = $objEmpresa->getEmail_Envio();
      $_SESSION['afiliado'] = 1; //Indica que el user es una afiliado de la asociacion
      //$_SESSION['home']=MODO_DE_PRUEBA ? 'bsindex.php?s1='.strtolower($objUser->getEstado()) : $objEmpresa->getURL();
      
      
      //Varibles reseteo
      $_SESSION['ano_afiliacion']=date("Y");
      $_SESSION['url_fotos']="slide/" .strtolower($objUser->getEstado());
      $_SESSION['url_fotos_portal']="uploadFotos/portal/" .strtolower($objUser->getEstado()).'/';
      $_SESSION['url_foto_perfil']="uploadFotos/perfil/";
      $_SESSION['url_fotos_torneos']="uploadFotos/torneos/";
      $_SESSION['url_logo']="images/logo/" .strtolower($objUser->getEstado());
      $_SESSION['color_jumbotron']=$objEmpresa->getColorJumbotron();
      $_SESSION['bgcolor_jumbotron']=$objEmpresa->getbgColorJumbotron();
      $_SESSION['bgcolor_navbar']=$objEmpresa->getColorNavbar();
      $_SESSION['favicon']="images/logo/" .strtolower($objUser->getEstado()).'/favico.ico';
      
      //Validamos si el afiliado ha formalizado su membresia
      $objAfiliacion = new Afiliaciones();
      $objAfiliacion->Find_Afiliacion_Atleta($objUser->getID(),date("Y"));
      if ($objAfiliacion->getPagado()> 0) {
          $_SESSION['deshabilitado'] = FALSE; //Habilitado para imprimir o enviar correo
      } else {
          $_SESSION['deshabilitado'] = TRUE; //Habilitado para imprimir o enviar correo
      }
      
      //Determinar la IP del usuario
      $myip= Funciones::getRealIP(); 
      //Registrar la visita
      $objVisitas = new Visita($myip,$usuario,$objUser->getID(),$objUser->getNombreCorto());
      $objVisitas->Create();
      $error_login = true; 
    }else{
        $error_login = false; 
    }

}


$jsondata = array("Success" => $error_login, "msg"=>$msg);   

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);


?>