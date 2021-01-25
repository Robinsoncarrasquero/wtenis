<?php

require_once '../funciones/funcion_fecha.php';
require_once "../PDO_Pagination/PDO_Pagination.php";
require_once '../sql/ConexionPDO.php';
if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula =$_SESSION['cedula'];
    $email =$_SESSION['email'];
    $_SESSION['menuuser'] = $_SERVER['PHP_SELF'];
    $logueado=true;
       
 }else{
//    //Si el usuario no está logueado redireccionamos al login.
//    header('Location: sesion_inicio.php');
//    exit;
    $logueado=true;
 }


//Creamos el objeto de conexion en PDO
$objconection = new Conexion();
$connection = $objconection->conectar();
$pagination = new PDO_Pagination($connection);


$search = htmlspecialchars($_REQUEST["search"]);

$searchcategoria = htmlspecialchars($_REQUEST["searchcategoria"]);


$WHERE=" WHERE (ranking.categoria='16' || ranking.categoria='14') && ranking.rknacional !='999' ";
$WHERE=" WHERE (atleta.estado!='' && ranking.rknacional !='999') ";
$LIKE = "&& (atleta.estado LIKE '$search%' || ranking.categoria LIKE '%$search'  || atleta.apellidos LIKE '%$search%' ) ";



$SELECT = "SELECT atleta.sexo,atleta.cedula,atleta.estado,atleta.nombres,atleta.apellidos,"
        . "DATE_FORMAT(atleta.fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,"
        . "ranking.rknacional,ranking.rkregional,ranking.rkestadal,ranking.categoria,"
        . "CONCAT(ranking.categoria,'-',atleta.sexo) as categoriasexo,"
        . "DATE_FORMAT(ranking.fecha_ranking,'%d-%m%-%Y') as fecha_ranking FROM atleta "
         ."INNER JOIN ranking ON atleta.atleta_id=ranking.atleta_id ".$WHERE;
       
       
$ORDERBY="ORDER by categoriasexo,ranking.rknacional,ranking.rkregional,ranking.rkestadal, ranking.fecha_ranking ";
   
      

$table_name='atleta';
if(isset($_REQUEST["search"]) && $_REQUEST["search"] != "")
{
    
    
    
    $pagination->param = "&search=$search";
    $sql=$SELECT . $LIKE;
    $pagination->rowCount($sql);
    $pagination->config(20,20);
    //$sql = "SELECT * FROM atleta $WHERE  && (cedula LIKE '%$search%' || apellidos LIKE '%$search%' || nombres LIKE '%$search%')  ORDER BY apellidos ASC LIMIT $pagination->start_row, $pagination->max_rows";
    $sql = $SELECT . $LIKE . $ORDERBY ." LIMIT $pagination->start_row, $pagination->max_rows";
             
    $query = $connection->prepare($sql);
    $query->execute();
    $model = array();
    while($rows = $query->fetch())
    {
        $model[] = $rows;
    }
}
else
{
    
    
    $pagination->rowCount($SELECT);
    
    $pagination->config(20,20);
    $sql = "SELECT * FROM atleta $WHERE ORDER BY apellidos LIMIT $pagination->start_row, $pagination->max_rows";
    $QUERY = $SELECT . $ORDERBY ." ASC LIMIT $pagination->start_row, $pagination->max_rows";
    $query = $connection->prepare($QUERY);
    $query->execute();
    $model = array();
    while($rows = $query->fetch())
    {
        $model[] = $rows;
    }
}
?>
<!DOCTYPE HTML>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Lista de Atletas</title>
    
    </head>
    <body>


</form>

<center>
<h1>Ranking de Jugadores</h1>
<form method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
<label>Buscar: </label>
<input type="text" name="search" placeholder="PEREIRA, MIR, 16" value="<?php echo $search?>">
<input type="submit" value="Search"> <br>

<table cellpadding="8" cellmargin="6" border="1">
    <thead>
        
        <th>#</th>
        <th>Ranking <br> Nacional</th>
        <th>Ranking <br> Regional</th>
        <th>Ranking <br> Estadal</th>
        <th>Estado</th>
        <th>Apellidos</th>
        <th>Nombres</th>
        <th>Categoria</th>
        <th>Fecha <br> Nacimiento</th>
        <th>Fecha <br> Ranking</th>
    </thead>
              
    <?php
    $i=0;
    foreach($model as $row)
    {
        
        $ii=  $pagination->start_row +  ++$i;
        echo "<tr>";
        echo "<td>".$ii."</td>";
        echo "<td>".$row['rknacional']."</td>";
        echo "<td>".$row['rkregional']."</td>";
        echo "<td>".$row['rkestadal']."</td>";
        echo "<td>".$row['estado']."</td>";
        echo "<td>".$row['apellidos']."</td>";
        echo "<td>".$row['nombres']."</td>";
        echo "<td>".$row['categoriasexo']."</td>";
       
        echo "<td>".fecha_date_dmYYYY($row['fecha_nacimiento'])."</td>";
        echo "<td>".fecha_date_dmYYYY($row['fecha_ranking'])."</td>";
//        if ( $_SESSION['niveluser']==9){
//            echo "<td><a href='atletaH2H.php?atleta_id=".$row['atleta_id']. "'</a>h2h</td>";
//           
//        }
        echo "</tr>";
        echo "</div>";
    }
    ?>
</table>
                <style>
            /* CSS */
            h1,label {
               
              color:     #CC0000;
              padding-left: 10px;
              padding-right: 10px;
              margin-left: 1px;
              margin-right: 1px;
              border-radius: 3px;
              background:  #FFFFFF;
                
            }
            .btn
            {
              text-decoration: none;
              color:  #FFFFFF;
              padding-left: 10px;
              padding-right: 10px;
              margin-left: 1px;
              margin-right: 1px;
              border-radius: 3px;
              background: #7F83AD;
            }
            
            .btn:hover
            {
                background: #474C80;
            }
            .active
            {
                background:  #E7814A;
                
            }
            th 
            {
                background:    #7F83AD;
            }
            tr:nth-child(odd) {
            background-color:#f2f2f2;
}
            tr:nth-child(even) {
            background-color:#fbfbfb;
}
            /* CSS */
        </style>
<div>
    <?php 
      
        $pagination->pages("btn");
        
    ?>
    
</div>
    </center>
    
    </body>
</html>