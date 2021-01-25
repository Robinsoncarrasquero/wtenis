<?php

session_start();
require_once '../conexion.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Rank_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../clases/Paginacion_cls.php';    

$estado=$_POST['estado'];
$rank_id=$_POST['rkid'];
$pagina= intval(substr($_POST['pagina'],4));

$objRank = new Rank();
$objRank->Find($rank_id);

$fechark=$objRank->getFecha();
$categoria=$objRank->getCategoria();
$sexo=$objRank->getSexo();

$strWhere=" WHERE  ";
if (strtoupper($estado)!="FVT"){
    $strWhere .=" atleta.estado='$estado' ";
}else{
    //$strWhere .=" atleta.estado!='$estado' ";
    $strWhere .=" atleta.estado!=' '";

}
$strWhere .=" && rank_id=$rank_id ";
$querycount = "SELECT count(*) as total  FROM atleta "
         ."INNER JOIN ranking ON atleta.atleta_id=ranking.atleta_id ".$strWhere
         ." ";


$Select = "SELECT atleta.atleta_id,atleta.sexo,atleta.cedula,atleta.estado,"
        . "atleta.nombres,atleta.apellidos,"
        . "DATE_FORMAT(atleta.fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,"
        . "ranking.rknacional,ranking.rkregional,ranking.rkestadal,"
        . "ranking.categoria,ranking.ranking_id,ranking.puntos,"
        . "DATE_FORMAT(ranking.fecha_ranking,'%d-%m-%Y') as fecha_ranking  FROM atleta "
         ."INNER JOIN ranking ON atleta.atleta_id=ranking.atleta_id ".$strWhere
         ."ORDER by ranking.rknacional,ranking.rkregional,ranking.rkestadal ";

        

//Buscamos los registros para la paginacion
//Paginacion mediante una clase
$objPaginacion = new Paginacion(8,$pagina);
$objPaginacion->setTotal_Registros($querycount);
$records=$objPaginacion->SelectRecords($Select);

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
                            //while($row = mysql_fetch_array($result) ){
                            foreach ($records as $row){

                                $ObjAfiliacion = new Afiliaciones();

                                $ObjAfiliacion->Find_Afiliacion_Atleta($row['atleta_id'], date("Y"));
                                
                                $ObjAtleta = new Atleta();
                                $ObjAtleta->Find($row['atleta_id']);
                                $ano_nacimiento= Funciones::ffecha_ano($ObjAtleta->getFechaNacimiento());
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
                                $linea .= '<td >Nac: '. $row['rknacional'].'<br>';
                                $linea .= 'Reg: '. $row['rkregional'].'<br>';
                                $linea .= 'Edo: '. $row['rkestadal'].'</td>';
//                                        $href="../Biografia/BioPlayerMenu.php?id=".$row['atleta_id'];
//                                        $lk="<a target='_blank' href='".$href."'</a>".$row['nombres'];
//                                        echo '<td >'. $lk.'</td>';
                                $linea .= '<td >' .$ObjAtleta->getNombres().'<br>';

//                                        $lk="<a target='_blank' href='".$href."'</a>".$row['apellidos'];
//                                        echo '<td >'. $lk.'</td>';
                                $linea .= ' ' .$ObjAtleta->getApellidos().'</td>';
//                                if ($categoria!=$categoria_natural){
//                                    $linea .= '<td >'.$row['fecha_nacimiento'].'<p class="glyphicon glyphicon-ok"<p>'.'</td>';
//                                    $np++;
//                                }else{
//                                    $linea .= '<td >'.$row['fecha_nacimiento'].'</td>';
//                                }    
                                 if (!$ObjAfiliacion->getPagado()){
                                    $linea .= '<td >'. $ObjAtleta->getEstado().'<p class="glyphicon glyphicon-ok"<p>'.'</td>';

                                }else{
                                    $linea .= '<td >'. $ObjAtleta->getEstado().'</td>';    
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
    $jsondata = array("Success" => True, "html"=>$lineaOut,"pagination"=>$objPaginacion->Paginacion());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados","pagination"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
