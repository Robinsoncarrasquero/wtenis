<?php

session_start();

require_once 'clases/Atleta_cls.php';
require_once "clases/Torneos_cls.php";
require_once "clases/Torneos_Inscritos_cls.php";
require_once 'funciones/funcion_fecha.php';
require_once 'funciones/funciones.php';
require_once 'sql/ConexionPDO.php';
require_once 'dompdf/autoload.inc.php';



$torneo_id =$_GET['tid']; 
$categoria_id=$_GET['catid']; // Categoria



switch ($categoria_id) {
    case 1:
        $categoria='12';
        $sexo="F";
        break;
    case 2:
        $categoria='12';
        $sexo="M";
        break;
    case 3:
        $categoria='14';
        $sexo="F";
        break;
    case 4:
        $categoria='14';
        $sexo="M";
        break;
    case 5:
        $categoria='16';
        $sexo="F";
        break;
    case 6:
        $categoria='16';
        $sexo="M";
        break;
    case 7:
        $categoria='18';
        $sexo="F";
        break;
    case 8:
        $categoria='18';
        $sexo="M";
        break;
    case 9:
        $categoria='PN';
        $sexo="F";
        break;
    case 10:
        $categoria='PN';
        $sexo="M";
        break;
    case 11:
        $categoria='PV';
        $sexo="F";
        break;
    case 12:
        $categoria='PV';
        $sexo="M";
        break;
    default:
        break;
}

$objTorneo = new Torneo();
$objTorneo->Fetch($torneo_id);
$la_categoria=$objTorneo->getCategoria();
$jugadores=  TorneosInscritos::Count_Categoria($torneo_id, $categoria, $sexo);

//sleep(1);
$nombre_empresa=$_SESSION['empresa_nombre'];
$strHTML='<html>
    <head> 
        <meta charset="utf-8" >
      

        <link rel="stylesheet" href="css/dompdf.css" media="print" type="text/css">

    </head>
    
<body>';

$strHTML='<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="css/tenis_estilos.css" >
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dompdf.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
           
    </head> <body>';

$strTable= $strHTML . ' 
                <div class="encabezado">
                    <h4>'.$nombre_empresa.'</h4>
                    <h4>RESUMEN DE PUNTUACION</h4>
                </div>
                <div>
                    <p><b>TORNEO:</b> '.$objTorneo->getNombre().'<b> GRADO:</b> '.$objTorneo->getTipo(). '<b> CATEGORIA:</b> '.$categoria.'-'.$sexo.'
                    <b>JUGADORES:</b> '.$jugadores.'<b> SEDE: </b>'.$_SESSION['asociacion'].'</p>
                    <p><b>FECHA INICIO:</b> '.$objTorneo->getFechaInicioTorneo().'<b> FECHA FINAL:</b> '.$objTorneo->getFechaFinTorneo().'<b> ARBITRO:</b> '.$objTorneo->getNombre().'</p> 
                    
                </div>';
                    
                 

$strTable .=
'<div " >
           
                  
                        <table class="table table-condensed">
                            <thead >
                                <tr class="table-head ">
                                    <th>#</th>
                                    
                                    <th>Cedula</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                  
                                    <th>Fec.Nac.</th>
                                   
                                    <th>Estado</th>
                                    <th>Singles</th>
                                    <th>Dobles</th>
                                    <th>Penalidad</th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>';
//                            echo   $strTable ;
                           
                                $nr=0;
                                // Buscamos los torneos vigentes
                                
                                $rsColeccion_Torneos=  TorneosInscritos::Read_Puntos($torneo_id, 0, $categoria,$sexo);
                                
                                
                                foreach ($rsColeccion_Torneos as $row) {
                                   if ($row['pagado']>0){
                                        $nr ++;
                                        
                                        $strTable .= '<tr>';  
                                        $strTable .= '<td >'. $nr.'</td>';
                                        $strTable .= '<td >'. $row['cedula'].'</td>';
                                        $strTable .= '<td >'. $row['nombres'].'</td>';
                                        $strTable .= '<td >'. $row['apellidos'].'</td>';
                                      
                                       $strTable .= '<td >'. $row['fecha_nacimiento'].'</td>';
                                       
                                        $strTable .= '<td >'. $row['estado'].'</td>';
                                        $strTable .= '<td> '. $row['singles']. '</td>';
                                        $strTable .= '<td> '. $row['dobles']. '</td>';
                                        $strTable .= '<td> '. $row['penalidad']. '</td>';
                                        
                                        $strTable .= '</tr>';
                        
                                    }
                                }
                           
$strTable .=
                            '</tbody>    
                        </table>
                   
                
        </div>';

$strTable .='</body>'
        . '</html>';
use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();
$dompdf->set_option('defaultFont', 'Courier');
$dompdf->loadHtml($strTable);

// (Optional) Setup the paper size and orientation
// $dompdf->setPaper('letter', 'portrait');
$dompdf->set_paper('A4', 'portrait');
// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('ListadoPuntos_'.$objTorneo->getNombre().$categoria.$sexo);
?>      
<!DOCTYPE HTML>
<html>
    <head> 
        <meta charset="utf-8" >
      

        <link rel="stylesheet" href="css/dompdf.css">

    </head>
    
<body>

                
<?PHP

    echo $strTable;

?>
                    

<script type="text/php">
  
  </script>  
        
    
    
</body>


</html>
        


