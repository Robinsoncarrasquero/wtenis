<?php
session_start();
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Rank_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../clases/Paginacion_cls.php';    
require_once '../clases/Encriptar_cls.php';    
error_reporting(1);
echo 'hola venezuela';
$categoria='16';
$sexo='M';

$disciplina='TDC';
$pagina=isset($_POST['pagina']) ? intval(substr($_POST['pagina'],4)) : 0;

$objRank = Rank::Find_Last_Ranking($disciplina,$categoria,$sexo);
$rank_id = $objRank['id'];

$strWhere=" WHERE  ";

$strWhere .=" atleta.estado!=' '";

$strWhere .=" && ranking.rank_id=$rank_id ";
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
$objPaginacion = new Paginacion(20,$pagina);
$objPaginacion->setTotal_Registros($querycount);
$records=$objPaginacion->SelectRecords($Select);
                            
$linea =" ";

$nr=0;
$np=0;
$tabla='<tr class="top-scrore-table">
<td class="score-position">POS.</td><td>Jugadores</td><td>NAT.</td><td>POINTS</td></tr>';
if ($sexo='M'){
    $tabla='<table class="tab-score">
    <tr class="top-scrore-table"><td class="score-position">POS.</td><td class="score-position">REG.</td><td class="score-position">EST.</td><td>PLAYERS</td><td>NAT.</td><td>POINTS</td></tr>';
}else{
    $tabla='<table class="tab-score">
    <tr class="top-scrore-table"><td class="score-position">POS.</td><td class="score-position">REG.</td><td class="score-position">EST.</td><td>PLAYERS</td><td>NAT.</td><td>POINTS</td></tr>';
}

foreach ($records as $row){

    $ObjAtleta = new Atleta();
    $ObjAtleta->Find($row['atleta_id']);
    $nr ++;
    $hash= Encrypter::encrypt($row['atleta_id']);
    $href="rankingDetail.php?rkdetail=".$hash;
    $banderas=
    [
        'ven','usa','uk','spain','serbia','jordan','ven',
        'japan','ven','italy','germany','france','ven',
        'denmark','ven','czech','canada','bulgaria','ven',
        'brazil','argentina','ven','ven'
    ];
    $bandera=$banderas[rand(0,count($banderas)-1)];
    
    $banderas=
    [
        'ven','ven'
    ];
    //$bandera=$banderas[rand(0,count($banderas)-1)];
    $linea .= '<tr>';  
        $linea .= "<td class='score-position'>".$row['rknacional'].".</td>";
        $linea .= "<td class='score-position'>".$row['rkregional'].".</td>";
        $linea .= "<td class='score-position'>".$row['rkestadal'].".</td>";
        $linea .= "<td><a href='#single_player.php?id=$hash'>".$ObjAtleta->getNombreCorto().'</a></td>';
        $linea .= "<td><img src='images/flags/$bandera.png' alt='' /></td>";
        $linea .= '<td>'.$row['puntos'].'</td>';
    $linea .= '</tr>';
    
    // $linea .= '<td >'. $row['rknacional'].'</td>';
    // $linea .= '<td >'. $row['rkregional'].'</td>';
    // $linea .= '<td >'. $row['rkestadal'].'</td>';
                    
}



$linea_out=$tabla. $linea ;
if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$linea_out,"pagination"=>$objPaginacion->PaginacionSimple());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados","pagination"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
