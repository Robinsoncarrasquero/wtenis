<?php

require 'conexion.php';

session_start();
 if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: sesion_inicio.php');
    
    exit;
 }
 

//variable post que se llena cuando seleccionan la option de torneo
 // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_query($conn, 'SET NAMES "utf8"');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$codigo_torneo=(isset($_POST['torneo'])) ? $_POST['torneo'] : '1G21216';


 {
    $sql = "SELECT nombres, apellidos, cedula,sexo,torneo.codigo as tcodigo,torneo.nombre as tnombre,torneoinscritos.categoria as torneo FROM atleta
              INNER JOIN torneoinscritos on atleta.atleta_id=torneoinscritos.atleta_id 
              INNER JOIN torneo on torneoinscritos.torneo_id=torneo.torneo_id 
              where torneo.codigo='".$codigo_torneo."'";
    $stmt = $conn->query($sql);
    $rows = $stmt->fetch_array();
}
//printf($codigo_torneo);

?>
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>JQuery Excel</title>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="javascript">
$(document).ready(function() {
     $(".botonExcel").click(function(event) {
     $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
     $("#FormularioExportacion").submit();
});
});
</script>
<style type="text/css">
.botonExcel{cursor:pointer;}
</style>
</head>
<body>





<h2 align="center">LISTADO DE INSCRITOS</h2>
 
  <!-- Creamos la tabla con el encabezado -->
 
 <table id="Exportar_a_Excel" margin-left="50%" width="60%" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666"  style="border-collapse:collapse;">
 
  <th>CEDULA</th>
  <th>NOMBRE</th>
  <th>CODIGO</th>
  <th>TORNEO</th>
  
  
   <?php
    foreach ($rows as $row) 
    {
        $cedula=$rows["cedula"];
        $nombres=$rows["nombres"];
        $apellidos=$rows["apellidos"];
        $$codigo_torneo=$rows["tcodigo"];
        $nombre_torneo=$rows["tnombre"];

        echo '<tr>';
        echo "<td>$cedula</td>";
        echo "<td>$nombres - $apellidos</td>";
        echo "<td>$codigo_torneo</td>";
        echo "<td>$nombre_torneo</td>";
        echo '</tr>';

        }
  ?>
 </table>


<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<p>Exportar a Excel  <img src="export_to_excel.gif" class="botonExcel" /></p>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>

    



</body>

</html>







 