<?php
session_start();
require_once '../funciones/funcion_fecha.php';
require_once "../PDO_Pagination/PDO_Pagination.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Afiliaciones_cls.php';

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}

if (isset($_SESSION['logueado']) && $_SESSION['niveluser']) {
    if (!($_SESSION['logueado']) && $_SESSION['niveluser']<9){
        header('Location: ../sesion_inicio.php');
        exit;
    }
}else{
    header('Location: ../sesion_inicio.php');
    exit;
}
 

$logueado=true;
//Creamos el objeto de conexion en PDO
$objconection = new Conexion();
$connection = $objconection->conectar();
$pagination = new PDO_Pagination($connection);

$search = null;
$asociacion=$_SESSION['asociacion'];
$WHERE ="WHERE niveluser=0 && estado='$asociacion' ";
if ($asociacion!='FVT'){
    $WHERE ="WHERE niveluser=0 && estado='$asociacion' ";
    
}else{
   $WHERE ="WHERE niveluser=0 "; 
}
$table_name='atleta';
if(isset($_REQUEST["search"]) && $_REQUEST["search"] != "")
{
    $WHERE ="WHERE niveluser=0 ";
    $search = htmlspecialchars($_REQUEST["search"]);
    $pagination->param = "&search=$search";
    $pagination->rowCount("SELECT * FROM atleta $WHERE && (cedula LIKE '%$search%' || nombres LIKE '%$search%' || apellidos LIKE '%$search%' )");
    $pagination->config(10,14);
    $sql = "SELECT * FROM atleta $WHERE  && (cedula LIKE '%$search%' || apellidos LIKE '%$search%' || nombres LIKE '%$search%') "
            . "ORDER BY apellidos ASC LIMIT $pagination->start_row, $pagination->max_rows";
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
    
    
    $pagination->rowCount("SELECT * FROM atleta $WHERE");
    
    $pagination->config(10,14);
    $sql = "SELECT * FROM atleta $WHERE ORDER BY apellidos LIMIT $pagination->start_row, $pagination->max_rows";
   
    $query = $connection->prepare($sql);
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
    <title>Atleta</title>    
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    <body>
<?php  
            //Menu de usuario
            include_once '../Template/Layout_NavBar_Admin.php';
            echo '<br><hr>';
?>

<div class="container-fluid">
    
<h1>Atleta</h1>
<form method="POST">
<label>Buscar: </label>
<input type="text" name="search" placeholder="Buscar" value="<?php echo $search ?>">
<input type="submit" value="Search"> <br><br>
<table  class="table-responsive table-bordered" >
    <tr>
        
        <th>#</th>
        <th>Estado</th>
        <th>Apellidos</th>
        <th>Nombres</th>
        <th>Cedula</th>
        <th>Sexo</th>
        <th>Fecha Nacimiento</th>
        <th>Telefono</th>
        <th>Asociacion</th>
        <th>Asociaciones</th>
        <th>Ficha</th>
        <?php 
        if ( $_SESSION['niveluser']>9){
           echo "<th>Eliminar</th> <th>Modificar</th> <th>Crear</th>";
        }
        ?>
       
    </tr>
    <?php
    $i=0;
    foreach($model as $row)
    {
        
        $ii=  $pagination->start_row +  ++$i;
        echo "<tr>";
        echo "<td>".$ii."</td>";
        echo "<td>".$row['estado']."</td>";
        echo "<td>".$row['apellidos']."</td>";
        echo "<td>".$row['nombres']."</td>";
        echo "<td>".$row['cedula']."</td>";
        echo "<td>".$row['sexo']."</td>";
        echo "<td>".fecha_date_dmYYYY($row['fecha_nacimiento'])."</td>";
        echo "<td>".$row['telefonos']."</td>";
        
        
        $atleta_id=$row['atleta_id'];
        $ano_afiliacion=date("Y");
        $ObjAfiliacion = new Afiliaciones();
        $ObjAfiliacion->Find_Afiliacion_Atleta($atleta_id, $ano_afiliacion);
        if ( $ObjAfiliacion->getFormalizacion()>0){
            
            
            echo "<td>Formalizada</td>";
            if ( $ObjAfiliacion->getPagado()>0){
                echo "<td>Procesada</td>";
            }else{
                echo "<td>Espera Lista</td>"; 
            }
            
         }else{
            echo "<td></td>"; 
            echo "<td></td>"; 
        }
        
        echo "<td><a target='_blank' href='../Ficha/FichaDatosBasicos.php?id=".$row['atleta_id']. "' </a>Ficha</td>";
       
        if ( $_SESSION['niveluser']>9){
            echo "<td><a href='atletaDelete.php?atleta_id=".$row['atleta_id']. "' </a>Eliminar</td>";
            //echo "<td><a href='atletaUpdate.php?atleta_id=".$row['atleta_id']. "' </a>Modificar</td>";
            echo "<td><a href='atletaCreate.php '</a>Crear</td>";
        }
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
    
        </div>
    
    </body>
</html>