<?php
require_once '../clases/Atleta_cls.php';
include_once '../funciones/funciones_bootstrap.php';
require_once '../clases/Noticias_cls.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Html_cls.php';

if (isset($_GET['s1'])){
    $asociacion=htmlspecialchars($_GET['s1']);
    $host =htmlspecialchars($_SERVER['HTTP_HOST']); //   localhost 
    $servername=$asociacion.".".$host;
    $serveNameArray=explode(".",$servername);
    $sn=strtoupper($serveNameArray[0]);
     $_SESSION['asociacion']=$sn;
}else{
    //Viene la URL virtual directamente del browser
    $serverName =htmlspecialchars($_SERVER['SERVER_NAME']); //   localhost 
    $serveNameArray=explode(".",$serverName);
    $sn=strtoupper($serveNameArray[0]);
    $_SESSION['asociacion']=$sn; // ASOCIACION 

}

$objEmpresa = new Empresa();
$objEmpresa->Fetch($_SESSION['asociacion']);
$_SESSION['empresa_id']=$objEmpresa->get_Empresa_id();
$_SESSION['empresa_nombre']=$objEmpresa->getNombre();
$_SESSION['home']='bsindex.php?s1='.strtolower($_SESSION['asociacion']);

if (!$objEmpresa->Operacion_Exitosa()) {
    $_SESSION['asociacion']='fvt'; // ASOCIACION 
    $objEmpresa->Fetch($_SESSION['asociacion']);
    $_SESSION['empresa_id']=$objEmpresa->get_Empresa_id();
}
$_SESSION['ano_afiliacion']=date("Y");
$_SESSION['url_fotos']="slide/" .strtolower($_SESSION['asociacion']);
$_SESSION['url_fotos_portal']="uploadFotos/portal/" .strtolower($_SESSION['asociacion']).'/';
$_SESSION['url_foto_perfil']="uploadFotos/perfil/";
$_SESSION['url_fotos_torneos']="uploadFotos/torneos/";
$_SESSION['url_logo']="images/logo/" .strtolower($_SESSION['asociacion']);
$_SESSION['color_jumbotron']=$objEmpresa->getColorJumbotron();
$_SESSION['bgcolor_jumbotron']=$objEmpresa->getbgColorJumbotron();
$_SESSION['bgcolor_navbar']=$objEmpresa->getColorNavbar();
$_SESSION['favicon']="images/logo/" .strtolower($_SESSION['asociacion']).'/favico.ico';


    
   $asociacion= $_SESSION['urlhome'];


echo '
<header>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarmenu" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">'. $objEmpresa->getAsociacion().'></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="#">'. $objEmpresa->getAsociacion().'</a>
        </div>
        <div id="navbarmenu" class="collapse navbar-collapse">
          <ul class="nav navbar-nav ">
<!--            <li class="active "><a href="#"  ><span class="glyphicon glyphicon-home"></span></a></li>-->
            <li><a href="#calendario">Calendario</a></li>
            <li><a href="#contact">Contacto</a></li>
            <li><a href="../Preafiliacion/Preafiliacion.php" target="_blank">Pre-Afiliacion</a></li>
            <li><a href="../ARankingNacional/RankingByDate.php" target="_blank">Ranking</a></li>
            <li><a href="#banco">Datos Banco</a></li>
            <li><a href="../Asociaciones/Asociaciones.php" >Asociaciones</a></li>
          </ul>';
        
            
               
        echo'
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">';
                   
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                       echo ' <li><a href="bsPanel.php">Inicio</a></li>';
                       echo ' <li><a href="sesion_cerrar.php"><span class="glyphicon glyphicon-log-out"></span>Cerrar</a></li>';
                    }else{
                       echo '<li><a  href="Login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                    }

                    
        echo 
            '</ul>
                </li>
            </ul>
        </div>
      </div>
        
    </nav>
    
   
</header>';
