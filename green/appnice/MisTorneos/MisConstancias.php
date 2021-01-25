<?php
session_start();
require_once '../clases/Torneos_cls.php';
require_once '../clases/Torneos_Inscritos_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../funciones/funcion_fecha.php';
require_once '../funciones/funcion_estados.php';
require_once '../sql/ConexionPDO.php';
require_once '../dompdf/autoload.inc.php';


// Notificar todos los errores excepto E_NOTICE
//error_reporting(E_ALL ^ E_NOTICE);
// Le decimos a PHP que usaremos cadenas UTF-8 hasta el final del script
//mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
//mb_http_output('UTF-8');  


//sleep(1); // delay para mostrar el ajax loader imagen


$torneo_id=$_GET['torneo_id']; // Torneo
$atleta_id=$_SESSION['atleta_id']; // Atletaid
//$atleta_id=487;
//print_r($id);

    $objAtleta = new Atleta();
    $objAtleta->Fetch($atleta_id);
     
    //Buscamos la carta de la fvt
    $objEmpresa = new Empresa();
    $obj->Fetch($_SESSION['asociacion']);
    $lacarta=$objEmpresa->getConstancia(); // La constancia
   
    $objTorneo = new Torneo();
    $objTorneo->Fetch($torneo_id);
    
    $objMisTorneos = new TorneosInscritos();
    $objMisTorneos->Find_Atleta($torneo_id, $atleta_id);
    
    if ($objMisTorneos->Operacion_Exitosa()){
    
        $cedula = $objAtleta->getCedula();
        $nombre=$objAtleta->getApellidos().' '.$objAtleta->getNombres();
        $nombre_torneo=$objTorneo->getNombre();
        $fecha_desde= date_format(date_create($objTorneo->getFechaInicioTorneo()),'d-m-Y');
        $fecha_hasta =  date_format(date_create($objTorneo->getFechaFinTorneo()),'d-m-Y');
        $dias = date('d');
        $mes = number_format(date('m'));
        $ano = date('Y');
        if ($objAtleta->getSexo()=='F'){
            $atleta_titulo="la atleta";
        }else{
            $atleta_titulo="el atleta";
        }

        $mi_estado= fun_Estado(trim($objAtleta->getEstado()));
        $buscar = array("@@CEDULA", "@@ATLETA", "@@NOMBRE", "@@TORNEO","@@FECHA_DESDE","@@FECHA_HASTA","@@DIAS","@@MES","@@ANO","@@ESTADO");
        $mudar   = array($cedula, $atleta_titulo,$nombre,$nombre_torneo, $fecha_desde,$fecha_hasta,$dias, fun_Mes_Literal($mes),$ano,$mi_estado);
        $newcarta = str_replace($buscar, $mudar, $lacarta,$contador);

    }else{
        $mi_estado= fun_Estado($objAtleta->getEstado());
        $buscar = array("@@CEDULA", "@@ATLETA", "@@NOMBRE", "@@TORNEO","@@FECHA_DESDE","@@FECHA_HASTA","@@DIAS","@@MES","@@ANO","@@ESTADO");
        $mudar   = array($cedula, $atleta_titulo,'USTED NO ASISTIO EN ESTE TORNEO', $fecha_desde,$fecha_hasta,$dias, fun_Mes_Literal($mes),$ano,$mi_estado);
        $newcarta = str_replace($buscar, $mudar, $lacarta,$contador);
    }
     $str='
            <div  class ="cartas">
                <span class="carta">'.$newcarta.'</span>

            </div>';
     
       // instantiate and use the dompdf class
     use Dompdf\Dompdf;
     use Dompdf\Options;
       $dompdf = new Dompdf();
       //$dompdf->set_option('defaultFont', 'Courier');
       $dompdf->loadHtml($newcarta);

       // (Optional) Setup the paper size and orientation
       $dompdf->setPaper('letter', 'portrait');

       // Render the HTML as PDF
       $dompdf->render();

       // Output the generated PDF to Browser
       $dompdf->stream('Constancia_'.$nombre_torneo);



$obj = NULL;
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <link rel="stylesheet" href="css/tenis_estilos.css">
        <link rel="alternate stylesheet" type="text/css" href="../css/printweb.css" media="screen"
        title="Estilo para impresión" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <style>
        body { font-family: sans-serif; }
        nav.navbar {
            background-color:  #000;
        }
        .jumbotron{
            background:   #67b168;
        }
        iframe{
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-md-offset-2">

                    <?PHP

                    echo $str;

                    ?>

                    <div class="listNoticia"></div>
                    <div id="results"></div>

            </div>

        </div>
              
</div>
    
    

        
<script>
    $('.breadcrumb').click( function(e){
        e.preventDefault();
        var url = window.history.back(); ;
        if(url) {
            // # open in new window if "_blank" used
            if(target == '_blank') { 
                window.open(url, target);
            } else {
                window.location = url;
            }
        }          
    });

</script>
    
    
</body>


</html>

