<?php
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../clases/Paginacion_cls.php';

$atleta_id= ($_POST['id']);
//El boton de paginacion viene en cero al inicio
$pagina= intval(substr($_POST['pagina'],4));

//Paginacion 
$objPaginacion = new Paginacion(5,$pagina);
$countRecord="SELECT COUNT(*) as total FROM ranking"
               . " WHERE atleta_id =$atleta_id ";
$objPaginacion->setTotal_Registros($countRecord);
$selectRecord="SELECT * FROM ranking"
               . " WHERE atleta_id =$atleta_id ORDER BY categoria,fecha_ranking DESC ";
$slq_order="  ";
$records=$objPaginacion->SelectRecords($selectRecord);

$strTableHead =
'
                    <div  class="table">      
                        <table class="table table-condensed table-responsive">
                            <thead >
                                <tr class="table-head ">
                                    <th>Fecha</th>
                                    <th>Cat</th>
                                    <th>Puntos</th>
                                    <th>Rk <br>Nac.</th>
                                    <th>Rk <br>Reg.</th>
                                    <th>Rk <br>Est.</th>
                                                                      
                                </tr>
                            </thead>
                            <tbody>';
                            $ObjAtleta = new Atleta();
                            $ObjAtleta->Find($atleta_id);
                            $ano_nacimiento= Funciones::ffecha_ano($ObjAtleta->getFechaNacimiento());
                            $categoria_natural=  Funciones::categoria_natural($ano_nacimiento, date("Y"));
                            $linea ="";
                            $nr=0;
                            $np=0;
                            foreach ($records as $row) {
                                $nr ++;
                                $linea .= '<tr>';  

                                $hash= $row['ranking_id'];
                                $href="rankingDetail.php?rkdetail=".$hash;
                                $lk='<button type="button" data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'.'<b class="badge">'. $row['puntos'].'</b></button>';
                                $pt='<a href="#"  data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'.'<span class="badge">'. $row['puntos'].'</span></a>';
                                
                                $fh='<a href="#"  data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'. date("Y-m-d",  date_timestamp_get(date_create($row['fecha_ranking']))).'</a>';
                                $linea .= '<td >'. $fh.'</td>';    
                                
                                $linea .= '<td >'. $row['categoria'].'</td>';
                                $linea .= '<td >'.$pt.'</td>';
                                $linea .= '<td >'. $row['rknacional'].'</td>';
                                $linea .= '<td >'. $row['rkregional'].'</td>';
                                $linea .= '<td >'. $row['rkestadal'].'</td>';
                                $linea .= '</tr>';
                                             
                            }
                           
$strTableFooter=
                    '</tbody>    
            </table>';

$lineaOut .= $strTableHead.$linea.$strTableFooter;

if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$lineaOut,"pagination"=>$objPaginacion->Paginacion());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados","pagination"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
