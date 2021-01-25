<?php
require 'conexion.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//$conn = new mysqli($servername, $username, $password, "$dbname");
//$result = $conn->query("SELECT CompanyName, City, Country FROM Customers");
$conn = mysql_connect($servername, $username, $password); 
mysql_select_db('atletasdb',$conn);
$query = "select atleta.cedula,atleta.estado,atleta.nombres,atleta.apellidos,atleta.fecha_nacimiento,ranking.rknacional,ranking.categoria from atleta "
         ."INNER JOIN ranking ON atleta.atleta_id=ranking.atleta_id order by ranking.rknacional,ranking.categoria"; 
$result = mysql_query($query); 

$outp = "[";
while($rs = mysql_fetch_array($result) ){
    if ($outp != "[") {$outp .= ",";}
   
    $outp .= '{"Ranking":"'  . $rs["rknacional"] . '",';
    $outp .= '"Estado":"'  . $rs["estado"] . '",';
    $outp .= '"Nombre":"'   . $rs["nombres"] . '",';
    $outp .= '"Apellido":"'. $rs["apellidos"] . '",'; 
    $outp .= '"Cedula":"'. $rs["cedula"]     . '"}';
}
$outp .="]";


mysql_close($conn);

echo($outp);
?>

