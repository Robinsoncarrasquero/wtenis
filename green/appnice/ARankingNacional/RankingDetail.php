<?php
session_start();
require_once '../clases/Ranking_detalle_cls.php';
require_once '../clases/Ranking_detalle_codigo_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Atleta_cls.php';

$ranking_id=$_POST['rkid'];//54633;
$atleta_id= $_POST['id']; // 2690;
//var_dump(array($ranking_id,$atleta_id));
//Datos del Ranking
$objRanking = new Ranking();
$objRanking->Fetch($ranking_id);

//Datos del atleta
$objAtleta = new Atleta();
$objAtleta->Find($atleta_id);

header('Content-Type: text/html; charset=utf-8');

$strTable =
'


            <table class="table table-condensed  table-striped  table-responsive">
                <thead >
                    <tr class="small italic table-head">
                        <th>#</th>
                        <th>Competencias</th>
                        <th>Puntos</th>
                        <th>Base</th>
                        <th>Total</th>
                        <th>*</th>
                        
                     </tr>
                </thead>
                <tbody>';
                $nr=0;
                $np=0;
                $rsRankingDet=RankingDetalle::ReadByRanking($ranking_id);
                $arrayRankingPrimeros6=primeros6rk($rsRankingDet);
                $arrayincluyeOtros=array('IN'=>'IN','NN'=>'NN');
                //var_dump($arrayRankingPrimeros6);
                foreach ($rsRankingDet as $row) {
                    $objRankingDetalleCodigo = new RankingDetalleCodigo();
                    $objRankingDetalleCodigo->Fetch($row['codigo']);
                    //if (array_key_exists($row['codigo'],$arrayRankingPrimeros6))
                    //  || $objRankingDetalleCodigo->getTipo()=="IN" 
                    //  || $objRankingDetalleCodigo->getTipo()=="TT" || $objRankingDetalleCodigo->getTipo()=="PE")
                    {
                        $nr ++;
                        if($objRankingDetalleCodigo->getTipo()!='TT'){
                            $strTable .= '<tr class=" small italic">';  
                        }else{
                            $strTable .= '<tr class=" small italic text text-danger">';
                        }
                        $strTable .= '<td >' . $nr . '</td>';
                        if($objRankingDetalleCodigo->getTipo()!='TT'){
                            $strTable .= '<td class="small italic text text-capitalize">' . ($objRankingDetalleCodigo->getDescripcion()) . '</td>';
                        }else{
                            $strTable .= '<td class="small italic text text-capitalize" >' .$objRankingDetalleCodigo->getDescripcion() . '</td>';
                        }    
                        $strTable .= '<td class="small " >' . $row['puntos'] . '</td>';
                        
                        $base=   $objRankingDetalleCodigo->getBase();
                        $strTable .= '<td class="small ">' .   $base  . '</td>';
                        
                        $ganado= (intval($row['puntos']) / 100 * intval($objRankingDetalleCodigo->getBase())); 
                        $strTable .= '<td class="small ">' . $ganado . '</td>';
           
                        if (array_key_exists($objRankingDetalleCodigo->getTipo(), $arrayincluyeOtros) ){
                           $strTable .= '<td class="small"><span class="glyphicon glyphicon-asterisk"></span>'. '</td>';
                        }elseif (array_key_exists($row['codigo'],$arrayRankingPrimeros6)){
                            if (strrpos($row['codigo'], "S")){
                                $strTable .= '<td class="small"><span class="glyphicon glyphicon-ok"></span>'. '</td>';
                            }else{
                                $strTable .= '<td class="small"><span class="glyphicon glyphicon-ok-circle"></span>'. '</td>';
                            }
                        }else{
                            $strTable .="<td></td> ";
                        }    
                        
                        $strTable .= '</tr>';
                    }
                }

$strTable.=
                '</tbody>    
            </table>
        </div>';

if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$strTable,"Puntos"=>$objRanking->getPuntos(),"Nombre"=>$objAtleta->getNombreCorto(),"Sexo"=>$objAtleta->getSexo());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados","Puntos"=>0,"Nombre"=>$objAtleta->getNombreCorto());
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);


function primeros6rk($rsData){
    $objRankingDetalleCodigo = new RankingDetalleCodigo();
                    
    array_sort_by($rsData,'puntos',SORT_DESC);
    $rsArraySingles=[];
    $rsArrayDobles=[];
    $rsArrayOtros=[];
    $mijsonsingle='';$mijsondoble='';$mijsonotros='';
    $dsingle = []; $ddoble=[];$dotros=[];
    $arrayexcluyecodigos=array('IN'=>'IN','TT'=>'TT','NN'=>'NN');
    $arrayincluyecodigos=array('IN'=>'IN','NN'=>'NN');
    foreach($rsData as $data){
        $objRankingDetalleCodigo->Fetch($data['codigo']);
        //Filtra los singles
        if (!array_key_exists($objRankingDetalleCodigo->getTipo(),$arrayexcluyecodigos) && strrpos($data['codigo'], "S")>0 && count($rsArraySingles)<6){
              if (count($rsArraySingles)<>0){
                $mijsonsingle .=',"'.$data['codigo'].'":'.$data['puntos'];
              }else{
                $mijsonsingle ='{"'.$data['codigo'].'":'.$data['puntos'];
                  
              }
              array_push($rsArraySingles, [
                $data['codigo']   => $data['puntos'],
              ]);
              $dsingle += [ $data['codigo'] => $data['puntos'] ];
        }
        //Filtra los dobles
        if (!array_key_exists($objRankingDetalleCodigo->getTipo(),$arrayexcluyecodigos) && strrpos($data['codigo'], "D")>0 && count($rsArrayDobles)<6){
            if (count($rsArrayDobles)<>0){
                $mijsondoble .=',"'.$data['codigo'].'":'.$data['puntos'];
              }else{
                $mijsondoble ='{"'.$data['codigo'].'":'.$data['puntos'];
            }
            array_push($rsArrayDobles, [
                $data['codigo']   => $data['puntos'],
            ]);
            $ddoble += [ $data['codigo'] => $data['puntos'] ];
        }
        //Incluye los Obligatorios
        if (array_key_exists($objRankingDetalleCodigo->getTipo(), $arrayincluyecodigos) ){
            if (count($rsArrayOtros)<>0){
              $mijsonotros .=',"'.$data['codigo'].'":'.$data['puntos'];
            }else{
              $mijsonotros ='{"'.$data['codigo'].'":'.$data['puntos'];
                
            }
            array_push($rsArrayOtros, [
              $data['codigo']   => $data['puntos'],
            ]);
            $dotros += [ $data['codigo'] => $data['puntos'] ];
      }
    }
    $mijsonsingle .='}';
    $mijsondoble .='}';
    return array_merge($dsingle,$ddoble,$dotros);


}
//Ordena un Array Segun la columna que se desee
function array_sort_by(&$arrIni, $col, $order = SORT_ASC)
{
    $arrAux = array();
    foreach ($arrIni as $key=> $row)
    {
        $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
        $arrAux[$key] = strtolower($arrAux[$key]);
    }
    array_multisort($arrAux, $order, $arrIni);
}
