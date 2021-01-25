<?php

session_start();
require_once '../conexion.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Rank_cls.php';
    

$estado=$_POST['estado'];
$rkid=$_POST['rkid'];

$objRank = new Rank();
$objRank->Find($rkid);

$fechark=$objRank->getFecha();
$categoria=$objRank->getCategoria();
$sexo=$objRank->getSexo();

header('Content-Type: text/html; charset=utf-8');
$strWhere=" WHERE ranking.categoria='$categoria'   && ranking.rknacional !='999' ";
if (strtoupper($estado)!="FVT"){
    $strWhere .=" && atleta.estado='$estado' && atleta.sexo='$sexo' ";
}else{
    $strWhere .=" && atleta.estado!='$estado' && atleta.sexo='$sexo' ";
}
 $strWhere .=" && fecha_ranking='$fechark' ";

$query = "SELECT atleta.atleta_id,atleta.sexo,atleta.cedula,atleta.estado,"
        . "atleta.nombres,atleta.apellidos,"
        . "DATE_FORMAT(atleta.fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,"
        . "ranking.rknacional,ranking.rkregional,ranking.rkestadal,"
        . "ranking.categoria,ranking.ranking_id,ranking.puntos,"
        . "DATE_FORMAT(ranking.fecha_ranking,'%d-%m-%Y') as fecha_ranking  FROM atleta "
         ."INNER JOIN ranking ON atleta.atleta_id=ranking.atleta_id ".$strWhere
         ."ORDER by ranking.rknacional,ranking.rkregional,ranking.rkestadal ";
mysql_query('SET NAMES "utf8"');   
$result = mysql_query($query);

if (!$result){
    die('Imposible conectarse error...');
}
$strTableHead =
'
            
                    <div class="table">
                        <table class="table">
                            
                                <tr class="table-head ">
                                    <th>Puntos</th>
                                    <th>Ranking</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                   
                                </tr>
                            
                            ';
                            $linea ="";
                           
                            $nr=0;
                            $np=0;
                            while($row = mysql_fetch_array($result) ){

                                $ObjAfiliacion = new Afiliaciones();

                                $ObjAfiliacion->Find_Afiliacion_Atleta($row['atleta_id'], date("Y"));

                                $ano_nacimiento= Funciones::ffecha_ano($row['fecha_nacimiento']);
                                $categoria_natural=  Funciones::categoria_natural($ano_nacimiento, date("Y"));
                                $nr ++;
                                $linea .= '<tr>';  

                                //$linea .= '<td >'. $nr.'</td>';    
                                $hash= $row['ranking_id'];
                                $href="rankingDetail.php?rkdetail=".$hash;
                                $lk='<button type="button" data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'.'<b class="badge">'. $row['puntos'].'</b></button>';
                                $lk='<a href="#"  data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'.'<span class="badge">'. $row['puntos'].'</span></a>';

                                $linea .= '<td >'.$lk.'</td>';

                                
//                                $linea .= '<td >'. $row['rknacional'].'</td>';
//                                $linea .= '<td >'. $row['rkregional'].'</td>';
//                                $linea .= '<td >'. $row['rkestadal'].'</td>';
                                $linea .= '<td >Nacional: '. $row['rknacional'].'<br>';
                                $linea .= 'Regional: '. $row['rkregional'].'<br>';
                                $linea .= 'Estadal: '. $row['rkestadal'].'</td>';
//                                        $href="../Biografia/BioPlayerMenu.php?id=".$row['atleta_id'];
//                                        $lk="<a target='_blank' href='".$href."'</a>".$row['nombres'];
//                                        echo '<td >'. $lk.'</td>';
                                $linea .= '<td >' .$row['nombres'].'<br>';

//                                        $lk="<a target='_blank' href='".$href."'</a>".$row['apellidos'];
//                                        echo '<td >'. $lk.'</td>';
                                $linea .= '' .$row['apellidos'].'</td>';
//                                if ($categoria!=$categoria_natural){
//                                    $linea .= '<td >'.$row['fecha_nacimiento'].'<p class="glyphicon glyphicon-ok"<p>'.'</td>';
//                                    $np++;
//                                }else{
//                                    $linea .= '<td >'.$row['fecha_nacimiento'].'</td>';
//                                }    
                                 if (!$ObjAfiliacion->getPagado()){
                                    $linea .= '<td >'. $row['estado'].'<p class="glyphicon glyphicon-ok"<p>'.'</td>';

                                }else{
                                    $linea .= '<td >'. $row['estado'].'</td>';    
                                }
                               

                                $linea .= '</tr>';
                                       
                                         
                                             
                            }
                           
$strTableFooter=
                        '  
                        </table>
            </div>
                    
                
            
        ';
 $lineaOut .= $strTableHead.$linea.$strTableFooter;

if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$lineaOut);   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
