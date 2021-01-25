<?php

session_start();

require_once '../clases/Ranking_detalle_cls.php';
require_once '../clases/Ranking_detalle_codigo_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';

//mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
//mb_http_output('UTF-8');  


$hash=$_GET['rkdetail']; // Categoria

$ranking_id= $hash;

header('Content-Type: text/html; charset=utf-8');

$strTable =
'<div>
    <div class="table-responsive">
        <div  class="table">      
            <table class="table table-bordered table-condensed">
                <thead >
                    <tr class="table-head ">
                        <th><p class="glyphicon glyphicon-dashboard"<p></th>
                        <th>Codigo</th>
                        <th>Puntos</th>

                    </tr>
                </thead>
                <tbody>';
                

                $nr=0;
                // Buscamos los torneos vigentes

                //contador de pagos
                $np=0;
                $rsRankingDet=RankingDetalle::ReadByRanking($ranking_id);
                $array = array_values($rsRankingDet);
                //print_r($array);
                //ksort($array);
                //print_r($array);
               $search_array = array('first' => 1, 'second' => 4);
                if (array_key_exists('first', $search_array)) {
                    echo "The 'first' element is in the array";
                }
                //Trae los registros con la puntuacion del ranking ordenado para obtener los 6 mejores
                //puntos obtenidos nacionales
                $rsSortRankingDet=RankingDetalle::SortbyRanking(6);
               
                $array_Valida=[];
                foreach ($rsSortRankingDet as $row) {
                    $objRanking_Det_Codigo= new RankingDetalleCodigo();
                    $objRanking_Det_Codigo->Fetch($row['codigo']);
                    if ($objRanking_Det_Codigo->getTipo()!=NULL){
                         $array_Valida=[$objRanking_Det_Codigo->getCodigo()];
                        
                       
                        
                    }
                    
                   
                }
                foreach ($rsRankingDet as $row) {
                    $nr ++;
                    $strTable .= '<tr>';

                    $strTable .= '<td >' . $nr . '</td>';

                    $strTable .= '<td >' . $row['descripcion'] . '</td>';
                    $strTable .= '<td >' . $row['puntos'] . '</td>';


                    $strTable .= '</tr>';
                }

$strTable.=
                        '</tbody>    
                        </table>
                    </div>
                </div>
        </div>';

?>
<!doctype html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="../css/tenis_estilos.css">
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
       
    </head>
   <style >
            .loader{

                    background-image: url("../images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
           .title-table{
                background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
                color: <?php echo $_SESSION['color_jumbotron']?>;
            }
           .table-head{
                background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
                color: <?php echo $_SESSION['color_jumbotron']?>;
           
        }
    </style>
  
<body>
    
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Detalle de puntos</h2>
            
        </div>
    </div>
</div>
  
<div class="container"  > 
    <div class="row">
       
            <!-- Section de Calendario de Torneos -->
            <div class="col-md-12">  
             
                <div class="calendario2">

                </div>


                <div id="puntos">
                    <?php
                     echo $strTable;
                    ?>

                </div>

              </div>       
       
                        
                    
            
            
             <div id="results2">
            
            </div>

        
   </div> <!-- Fin de orw container Principal -->
    
  
</div>

   

</body>
