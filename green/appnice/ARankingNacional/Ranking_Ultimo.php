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
require_once '../clases/Nacionalidad_cls.php';

$categoria=isset($_POST['categoria']) ? $_POST['categoria'] :'99';
$sexo=isset($_POST['sexo']) ? substr($_POST['sexo'],4,1) :'Z';

$disciplina='TDC';
$pagina=isset($_POST['pagina']) ? intval(substr($_POST['pagina'],4)) : 0;

$objRank = Rank::Find_Last_Ranking($disciplina,$categoria,$sexo);
$rank_id = $objRank['id'];

$strWhere=" WHERE  ";

$strWhere .=" atleta.estado!=' '";

$strWhere .=" && ranking.rank_id=$rank_id ";


$querycount = "SELECT count(*) as total  FROM atleta "
         ."INNER JOIN ranking ON atleta.atleta_id=ranking.atleta_id "
         . " WHERE atleta.estado != :estado "
         . " &&  ranking.rank_id = :rank_id "
         ." ";
$Array_Param=array(':estado' => ' ', ':rank_id' => $rank_id);


//Buscamos los registros para la paginacion
//Paginacion mediante una clase
$lotepaginacion=30;
$objPaginacion = new Paginacion($lotepaginacion,$pagina);
$objPaginacion->setTotal_Registros_Param($querycount,$Array_Param);

$SelectParam = " SELECT atleta.atleta_id,atleta.sexo,atleta.cedula,atleta.estado,"
         . " atleta.nombres,atleta.apellidos,"
         . " DATE_FORMAT(atleta.fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,"
         . " ranking.rknacional,ranking.rkregional,ranking.rkestadal,"
         . " ranking.categoria,ranking.ranking_id,ranking.puntos,"
         . " DATE_FORMAT(ranking.fecha_ranking,'%d-%m-%Y') as fecha_ranking  FROM atleta "
         . " INNER JOIN ranking ON atleta.atleta_id=ranking.atleta_id"
         . " WHERE atleta.estado != :estado "
         . " &&  ranking.rank_id = :rank_id "
          ." ORDER by ranking.rknacional,ranking.rkregional,ranking.rkestadal ";
         
$records=$objPaginacion->SelectRecordsParam($SelectParam,$Array_Param);
                            
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
    $nombre = $ObjAtleta->getApellidos();
    $lanacion = new Nacionalidad();
    $lanacion->Find($ObjAtleta->getNacionalidadID());
    $bandera= strtolower($lanacion->getPais());
    
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
    //$bandera=$banderas[rand(0,count($banderas)-1)];
    
    $banderas=
    [
        'ven','ven'
    ];
    $banderas=
    [
        $bandera
    ];
    
    $hash= Encrypter::encrypt($row['ranking_id']);
    $bandera=$banderas[rand(0,count($banderas)-1)];

    $linea .= '<tr>';  
        $linea .= "<td class='score-position'>".$row['rknacional'].".</td>";
        $linea .= "<td class='score-position'>".$row['rkregional'].".</td>";
        $linea .= "<td class='score-position'>".$row['rkestadal'].".</td>";
        $linea .= "<td><a href='single_player.php?ranking=$hash'>".$ObjAtleta->getNombreCorto().'</a></td>';
        $linea .= "<td><img src='images/flags/$bandera.png' alt='' /></td>";
        $linea .= "<td><a href='single_player.php?ranking=$hash'>". $row['puntos'].'</a></td>';
    $linea .= '</tr>';
                    
}

$linea_out=$tabla. $linea ;
if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$linea_out,"pagination"=>$objPaginacion->PaginacionSimple());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay ranking registrado","pagination"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
