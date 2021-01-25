<?php

session_start();
require_once '../conexion.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Rank_cls.php';
    
//mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
//mb_http_output('UTF-8');  



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

$query = "SELECT atleta.atleta_id,atleta.sexo,atleta.cedula,atleta.estado,atleta.nombres,atleta.apellidos,DATE_FORMAT(atleta.fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,"
        . "ranking.rknacional,ranking.rkregional,ranking.rkestadal,ranking.categoria,ranking.ranking_id,ranking.puntos,DATE_FORMAT(ranking.fecha_ranking,'%d-%m-%Y') as fecha_ranking  FROM atleta "
         ."INNER JOIN ranking ON atleta.atleta_id=ranking.atleta_id ".$strWhere
         ."ORDER by ranking.rknacional,ranking.rkregional,ranking.rkestadal ";
mysql_query('SET NAMES "utf8"');   
$result = mysql_query($query);

if (!$result){
    die('Imposible conectarse error...');
}
$strTable =
'<div class="col-xs-12 col-md-12">
    <div class="table-responsive">
                <div class="table-responsive">
                    <div  class="table">      
                        <table class="table table-bordered table-condensed">
                            <thead >
                                <tr class="table-head ">
                                    <th><p class="glyphicon glyphicon-dashboard"<p></th>
                                    <th>Puntos</th>
                                    <th>Estado</th>
                                    <th>Rk Nac.</th>
                                    <th>Rk Reg.</th>
                                    <th>Rk Est.</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>F.Nac.</th>
                                   
                                </tr>
                            </thead>
                            <tbody>';
                            echo   $strTable ;
                           
                                $nr=0;
                                // Buscamos los torneos vigentes
                                
                                //contador de pagos
                                $np=0;
                                while($row = mysql_fetch_array($result) ){
                               
                                        $ObjAfiliacion = new Afiliaciones();

                                        $ObjAfiliacion->Find_Afiliacion_Atleta($row['atleta_id'], date("Y"));
                                        
                                        $ano_nacimiento= Funciones::ffecha_ano($row['fecha_nacimiento']);
                                        $categoria_natural=  Funciones::categoria_natural($ano_nacimiento, date("Y"));
                                       
//                                        if($categoria===$categoria_natural){
//                                            $nr ++;
//                                        }
                                        $nr ++;
                                        echo '<tr>';  
                                       
                                        echo '<td >'. $nr.'</td>';    
                                        $hash= $row['ranking_id'];
                                        $href="rankingDetail.php?rkdetail=".$hash;
                                        $lk='<button type="button" data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'.'<b class="badge">'. $row['puntos'].'</b></button>';
                                       $lk='<a href="#"  data-toggle="modal" data-target="#myModal" data-id="'.$row['atleta_id'].'" data-whatever="'.$hash.'">'.'<span class="badge">'. $row['puntos'].'</span></a>';
                                       
                                        echo '<td >'.$lk.'</td>';
                                        
                                        if (!$ObjAfiliacion->getPagado()){
                                           echo '<td >'. $row['estado'].'<p class="glyphicon glyphicon-ok"<p>'.'</td>';
                                          
                                        }else{
                                            echo '<td >'. $row['estado'].'</td>';    
                                        }
                                        
                                        echo '<td >'. $row['rknacional'].'</td>';
                                        echo '<td >'. $row['rkregional'].'</td>';
                                        echo '<td >'. $row['rkestadal'].'</td>';
                                      
//                                        $href="../Biografia/BioPlayerMenu.php?id=".$row['atleta_id'];
//                                        $lk="<a target='_blank' href='".$href."'</a>".$row['nombres'];
//                                        echo '<td >'. $lk.'</td>';
                                        echo '<td >' .$row['nombres'].'</td>';
                                                                              
//                                        $lk="<a target='_blank' href='".$href."'</a>".$row['apellidos'];
//                                        echo '<td >'. $lk.'</td>';
                                        echo '<td >' .$row['apellidos'].'</td>';
                                        if ($categoria!=$categoria_natural){
                                            echo '<td >'.$row['fecha_nacimiento'].'<p class="glyphicon glyphicon-ok"<p>'.'</td>';
                                            $np++;
                                        }else{
                                            echo '<td >'.$row['fecha_nacimiento'].'</td>';
                                        }     
                                       
                                        echo '</tr>';
                                       
                                         
                                             
                                }
                           
$strTable=
                        '</tbody>    
                        </table>
                    </div>
                </div>
            </table>
        </div>';
echo $strTable;
