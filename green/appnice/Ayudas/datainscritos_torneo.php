<?php
require 'conexion.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//$por_post = ($_SERVER['REQUEST_METHOD'] == 'POST');
$codigo_torneo=(isset($_GET['torneo'])) ? $_GET['torneo'] : null;
$categoria=(isset($_GET['categoria'])) ? $_GET['categoria'] : null;
$sexo=(isset($_GET['sexo'])) ? $_GET['sexo'] : null;


//$codigo_torneo="4G41418";$sexo="";$categoria="";
$where="WHERE torneo.codigo='".$codigo_torneo."' ";
if (strlen($sexo)>0){
    $where .=" AND atleta.sexo='".$sexo."' ";
}
if(strlen($categoria)>0){
    $where=" AND torneoinscritos.categoria='".$categoria."' " ;
}
$orderby=" ORDER BY torneo.categoria,atleta.sexo,ranking.rknacional";

$sql = "SELECT atleta.estado,atleta.nombres, atleta.apellidos, atleta.cedula,atleta.sexo,DATE_FORMAT(atleta.fecha_nacimiento, '%d-%m-%Y') as fechanac,"
            ."torneo.nombre as nombretorneo,torneoinscritos.categoria ,torneoinscritos.fecha_registro,"
            ."ranking.rknacional,ranking.rkregional,ranking.rkestadal FROM atleta "
            . "INNER JOIN torneoinscritos on atleta.atleta_id=torneoinscritos.atleta_id "
            . "INNER JOIN ranking on torneoinscritos.atleta_id =ranking.atleta_id AND torneoinscritos.categoria=ranking.categoria "
            . "INNER JOIN torneo on torneoinscritos.torneo_id=torneo.torneo_id "
            . $where 
            . $orderby;
           

$result = mysql_query($sql); 

$outp = "[";
while($rs = mysql_fetch_array($result) ){
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"Categoria":"'  . $rs["categoria"] . '",';
    $outp .= '"Ranking":"'  . $rs["rknacional"] . '",';
    $outp .= '"Estado":"'  . $rs["estado"] . '",';
    $outp .= '"Nombre":"'   . $rs["nombres"] . '",';
    $outp .= '"Apellido":"'. $rs["apellidos"] . '",'; 
    $outp .= '"Cedula":"'. $rs["cedula"]     . '",';
    $outp .= '"FechaNacimiento":"'. $rs["fechanac"]  . '",';
    $outp .= '"Inscripcion":"'. $rs["fecha_registro"]. '"}';
    
}
$outp .="]";


mysql_close($conn);

echo($outp);
?>

