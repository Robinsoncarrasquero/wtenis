<?php 
$con = mysql_connect('localhost','root',''); 
mysql_select_db('atletasdb',$con);
$pag = intval($_GET['p']); 
$query = sprintf( "select atleta.cedula,atleta.nombres,atleta.apellidos,atleta.fecha_nacimiento,ranking.rknacional from atleta INNER JOIN ranking ON atleta.atleta_id=ranking.atleta_id order by atleta.cedula limit %d offset %d ", 100, ($pag-1)*100); 
$result = mysql_query($query); 
$arr = array(); 
while ($row = mysql_fetch_assoc($result)) 
{ 
    
    
    $arr[] = $row['cedula'];
    $arr[] = $row['nombres'];
    $arr[] = $row['apellidos'];
    $arr[] = $row['fecha_nacimiento']   ;   
    $arr[] = $row['rknacional'];
    
        
} 
header('Content-Type: application/json'); 
echo json_encode($arr); 
mysql_close($con); 
?> 