<?php
require_once "PDO_Pagination/PDO_Pagination.php";
require_once 'sql/ConexionPDO.php';

session_start();
 if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: sesion_inicio.php');
    exit;
 }

$objconection = new Conexion();
$connection = $objconection->conectar();
$pagination = new PDO_Pagination($connection);

$search = null;
if(isset($_REQUEST["search"]) && $_REQUEST["search"] != "")
{
    $search = htmlspecialchars($_REQUEST["search"]);
    $pagination->param = "&search=$search";
    $pagination->rowCount("SELECT * FROM torneo WHERE estatus ='A' && (nombre LIKE '%$search%' OR codigo LIKE '%$search%' )");
    $pagination->config(3,5);
    $sql = "SELECT * FROM torneo WHERE estatus ='A' && (codigo LIKE '%$search%' OR nombre LIKE '%$search%')  ORDER BY torneo_id ASC LIMIT $pagination->start_row, $pagination->max_rows";
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
    $pagination->rowCount("SELECT * FROM torneo WHERE estatus ='A'");
    $pagination->config(3, 5);
    $sql = "SELECT * FROM torneo WHERE estatus ='A' ORDER BY fechacierre DESC LIMIT $pagination->start_row, $pagination->max_rows";
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
    <meta charset="UTF-8">
    <title>Lista de Torneos</title>
    </head>
    <body>
<h1>Lista de Torneos</h1>
<form method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
Buscar: 
<input type="text" name="search" placeholder="Buscar" value="<?php echo $search ?>">
<input type="submit" value="Search">
</form>
<br><br>
    <center>
<table cellpadding="10" cellmargin="5" border="1">
    <tr>
        <th>Torneo</th>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Fecha Cierre</th>
        <th>Fecha de Retiros</th>
        <th>Retirados</th>
        <th>Inscritos</th>
    </tr>
    <?php
    foreach($model as $row)
    {
        echo "<tr>";
        echo "<td>".$row['torneo_id']."</td>";
        echo "<td>".$row['codigo']."</td>";
        echo "<td>".$row['nombre']."</td>";
        echo "<td>".$row['fechacierre']."</td>";
        echo "<td>".$row['fecharetiros']."</td>";
         
        echo "<td><a href='torneos_consulta_atletas_inscritos.php?torneo=".$row['codigo']."&estatus=retiro"."'target='_blank'</a>Ver</td>";
        echo "<td><a href='torneos_consulta_atletas_inscritos.php?torneo=".$row['codigo']. "' target='_blank'</a>Ver</td>";
        
        echo "</tr>";
    }
    ?>
</table>
        <br>
        <br>
        <style>
            /* CSS */
            .btn
            {
              text-decoration: none;
              color: #FFFFFF;
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
                background: #E7814A;
            }
            /* CSS */
        </style>
<div>
    <?php
    echo '<p id="menuuop1"> <a href="sesion_cerrar.php">Cerrar sesion </a> </p>';
    if($_SESSION['niveluser']>8){
        echo '<p id="menuuop1"> <a href="'.'sesion_usuario_admin.php">Menu</a> </p>';
    }else{
        echo '<p id="menuuop1"> <a href="'.'sesion_usuario.php">Menu</a> </p>';
    }
    ?>
<?php
$pagination->pages("btn");
 
?>
</div>
    </center>
    
    </body>
</html>