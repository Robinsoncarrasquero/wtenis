<?php

session_start();



require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Ranking_cls.php';
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




$atleta_id=$_SESSION['atleta_id']; // Atletaid
//Ano de afiliacion = actual + 1
$ano_afiliacion = date ("Y");
//Verificamos afiliacion para poder emitir la tarjeta
$objAfiliado = new Afiliaciones();
$objAfiliado->Find_Afiliacion_Atleta($atleta_id,$ano_afiliacion);


//$atleta_id=487;
//print_r($id);
   
//Buscamos el jugador
$objAtleta = new Atleta();
$objAtleta->Fetch($atleta_id);
$categoria=$objAtleta->Categoria_Natural(date("Y"));

$objRanking = new Ranking();
$objRanking->Find($atleta_id, $categoria);
if ($objRanking->getRknacional()>0){
    $ranking= ($objRanking->getRknacional()==999 ? 'S/R': $objRanking->getRknacional());
}else{
   $ranking='S/R'; 
}
//Aqui buscamos directamente la carta de la fvt que fue generalizada para todo el mundo
//y por tanto se bloquea por estado y se deja una unica.. por problemas de diseno se dejara asi.
$obj = new Empresa();

$obj->Fetch('FVT');
$lacarta=$obj->getCartaFederativa(); // La constancia



//use Dompdf\Dompdf;
//use Dompdf\Options;
$dompdf = new Dompdf();
//sleep(1); // delay para mostrar el ajax loader imagen
//print_r('paso 3')  ;

//    echo 'paso 4'   ;
if ($objAfiliado->getPagado() > 0) {


    $cedula = $objAtleta->getCedula();
    $nombre = $objAtleta->getApellidos() . ' ' . $objAtleta->getNombres();

    $dias = date('d');
    $mes = number_format(date('m'));
    $ano = date('Y');
    if ($objAtleta->getSexo() == 'F') {
        $atleta_titulo = "la atleta";
        $jugador = "Jugadora Activa";
    } else {
        $atleta_titulo = "el atleta";
        $jugador = "Jugador Activo";
    }

    $mi_estado = fun_Estado(trim($objAtleta->getEstado()));
    $buscar = array("@@CEDULA", "@@ATLETA", "@@NOMBRE", "@@RANKING", "@@CATEGORIA", "@@DIAS", "@@MES", "@@ANO", "@@ESTADO", "@@JUGADOR");
    $mudar = array($cedula, $atleta_titulo, $nombre, $ranking, $categoria, $dias, fun_Mes_Literal($mes), $ano, $mi_estado, $jugador);

    $newcarta = str_replace($buscar, $mudar, $lacarta, $contador);
    print_r($newcarta)  ;
//}else{
//    $mi_estado = fun_Estado(trim($objAtleta->getEstado()));
//    $buscar = array("@@CEDULA", "@@ATLETA", "@@NOMBRE", "@@RANKING", "@@CATEGORIA", "@@DIAS", "@@MES", "@@ANO", "@@ESTADO", "@@JUGADOR");
//    $mudar = array("NO AFILIADO", "NO AFILIADO", "NO AFILIADO", "NO AFILIADO", "NO AFILIADO", 0, fun_Mes_Literal($mes), $ano, "NO AFILIADO", "NO AFILIADO");
//
//    $newcarta = str_replace($buscar, $mudar, $lacarta, $contador);
//
//}


$str='
            <div  class ="cartas">
                <span class="carta">'.$newcarta.'</span>

            </div>';

// instantiate and use the dompdf class
 
 //$dompdf->set_option('defaultFont', 'Courier');
 $dompdf->loadHtml($newcarta);

 // (Optional) Setup the paper size and orientation
 $dompdf->setPaper('letter', 'portrait');

 // Render the HTML as PDF
 $dompdf->render();

 // Output the generated PDF to Browser
 $dompdf->stream('Constancia_Federado_' . $nombre);



 $obj = NULL;

}
?>

<html>
    <head> 
        <meta charset="utf-8" >
<!--        <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="css/tenis_estilos.css">
        <link rel="alternate stylesheet" type="text/css" href="../css/printweb.css" media="screen"
 title="Estilo para impresión" />
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
           
    </head>
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
                // Use as-is
        
       
    </style>
<body>
<!--   <div class="container">
        <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li class="active">Noticia</li>
        </ol>
   </div>-->
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
           
           
            $('.breadcrumb').click( function(e)  {
                e.preventDefault();
                //Cuando data-id es cero representa un nuevo registro y update debe ser mayor> 0 
                var url = window.history.back(); ;
                    
                        
                if(url) {
                    // # open in new window if "_blank" used
                    if(target == '_blank') { 
                        window.open(url, target);
                    } else {
                        window.location = url;
                    }
                }          
            }
        
            );
          
        
        
        
        </script>
    
    
</body>


</html>

