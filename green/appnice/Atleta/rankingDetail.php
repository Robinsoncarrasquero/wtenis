<?php
session_start();
require_once '../clases/Ranking_detalle_cls.php';
require_once '../clases/Ranking_detalle_codigo_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Atleta_cls.php';

//mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
//mb_http_output('UTF-8');  

$ranking_id=$_POST['rkid']; // Categoria
$atleta_id=$_POST['id']; // atleta_id

//Datos del Ranking
$objRanking = new Ranking();
$objRanking->Fetch($ranking_id);

//Datos del atleta
$objAtleta = new Atleta();
$objAtleta->Find($atleta_id);

header('Content-Type: text/html; charset=utf-8');

$strTable =
'<div>
    
    <div class="table-responsive">
        <div  class="table">      
            <table class="table table-bordered table-condensed">
                <thead >
                    <tr class="table-head ">
                        <th><p class="glyphicon glyphicon-dashboard"<p></th>
                        <th>Descripcion</th>
                        <th>Puntos</th>
                        <th>Base</th>
                        <th>Total</th>
                     </tr>
                </thead>
                <tbody>';
                $nr=0;
                // Buscamos los torneos vigentes
                //contador de pagos
                $np=0;
                $rsRankingDet=RankingDetalle::ReadByRanking($ranking_id);
                foreach ($rsRankingDet as $row) {
                    $objRankingDetalleCodigo = new RankingDetalleCodigo();
                    $objRankingDetalleCodigo->Fetch($row['codigo']);
                    $nr ++;
                    $strTable .= '<tr>';
                    $strTable .= '<td >' . $nr . '</td>';
                    $strTable .= '<td >' . $objRankingDetalleCodigo->getDescripcion() . '</td>';
                    $strTable .= '<td >' . $row['puntos'] . '</td>';
                    $strTable .= '<td >' . $objRankingDetalleCodigo->getBase() . '</td>';
                    $strTable .= '<td >' . $row['puntos']*$objRankingDetalleCodigo->getBase()/100 . '</td>';
                    $strTable .= '</tr>';
                }

$strTable.=
                        '</tbody>    
                        </table>
                    </div>
                </div>
        </div>';

if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$strTable,"Puntos"=>$objRanking->getPuntos(),"Nombre"=>$objAtleta->getNombreCompleto());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados","Puntos"=>0,"Nombre"=>$objAtleta->getNombreCompleto());
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
