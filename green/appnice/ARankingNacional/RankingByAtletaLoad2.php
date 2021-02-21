<?php
session_start();
//require_once '../conexion.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../clases/Paginacion_cls.php';
require_once '../funciones/bsTemplate.php';

$atleta_id =Encrypter::decrypt($_POST['id']);

//El boton de paginacion viene en cero al inicio
$pagina= intval(substr($_POST['pagina'],4));

//Paginacion 
$objPaginacion = new Paginacion(4,$pagina);

$querycoun="SELECT COUNT(*) as total FROM ranking"
. " WHERE atleta_id = :atleta_id ";

$Array_Param=array(':atleta_id' => $atleta_id);
$objPaginacion->setTotal_Registros_Param($querycoun,$Array_Param);

$slq_order="  ";

$SelectParam="SELECT * FROM ranking "
. " WHERE atleta_id = :atleta_id "
. " ORDER BY categoria,fecha_ranking DESC ";

$records=$objPaginacion->SelectRecordsParam($SelectParam,$Array_Param);

//Main content
$main = [];
$dmain =["opcion"=>"Ranking","icono"=>"icon_genius","href"=>""];
array_push($main, $dmain);
$main_content=  bsTemplate::main_content('Ranking',$main);

$thead = [];
$thead +=["Fecha"=>"glyphicon glyphicon-time"];
$thead +=["Cat"=>"glyphicon glyphicon-signal"];
$thead +=["Pts"=>"glyphicon glyphicon-cog"];
$thead +=["Rkn"=>"glyphicon glyphicon-star "];
$thead +=["Rkr"=>"glyphicon glyphicon-star"];
$thead +=["Rke"=>"glyphicon glyphicon-star"];
$table_head= bsTemplate::table_head("Mis Ranking",$thead);

$table_footer='
                   </tbody>
                </table>
            </section>
        </div>
    </div>';


$linea ="";
$nr=0;
$np=0;

foreach ($records as $row) {
    $nr ++;
    $linea .= '<tr class="small">';  

    $hash= $row['ranking_id'];
    $href="rankingDetail.php?rkdetail=".$hash;
    $lk='<button type="button" data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'.'<b class="badge">'. $row['puntos'].'</b></button>';
    $pt='<a href="#"  data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'.'<i class="badge">'. $row['puntos'].'</i></a>';
    
    $fh='<i href="#"  data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'.
    date_format(date_create($row['fecha_ranking']),"d-m-y").'</i>';
     
    $linea .= '<td  class="small" >'. $fh.'</td>';    
    
    $linea .= '<td class="small">'. $row['categoria'].'</td>';
    $linea .= '<td class="small" >'.$pt.'</td>';
    $linea .= '<td class="small">'. $row['rknacional'].'</td>';
    $linea .= '<td class="small">'. $row['rkregional'].'</td>';
    $linea .= '<td class="small">'. $row['rkestadal'].'</td>';
    $linea .= '</tr>';
    $table_data =$linea;

                    
}

$lineaOut .= $main_content . $table_head . $table_data . $table_footer;
if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$lineaOut,"pagination"=>$objPaginacion->Paginacion());   

} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados","pagination"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
