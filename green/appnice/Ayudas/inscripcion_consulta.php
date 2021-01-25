<?php

require 'conexion.php';
session_start();
//session_start();
// if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
//    $nombre = $_SESSION['nombre'];
//    $cedula = $_SESSION['cedula'];
// }else{
//    //Si el usuario no está logueado redireccionamos al login.
//    header('Location: sesion_inicio.php');
//    
//    exit;
// }
 

//variable post que se llena cuando seleccionan la option de torneo
 // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_query($conn, 'SET NAMES "utf8"');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$codigo_torneo=(isset($_GET['torneo'])) ? $_GET['torneo'] : '1G41216';


?>
<html> 
<head> 
<title>Listado de inscritos</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
 <script type="text/javascript" src="jquery-1.3.2.min.js"></script>
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
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<a href="sesion_usuario.php"> <img id="Logo" src="images/logoatem.jpg" width="350"  ></a>
<link rel="StyleSheet" href="css/inscribe.css" type="text/css">
</head>
<body>





<h2 align="center">LISTADO DE INSCRITOS</h2>
 <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
 <a href="index.html "> <img id="Logo" src="images/logo.png"  ></a>
 <link rel="StyleSheet" href="css/inscri.css" type="text/css">

 <!-- <legend>LISTA DE ATLETAS INSCRITOS EN TORNEO OFICIALES</legend> -->
 <form method="get" action ="inscripcion_Consulta.php"    >
    <select name="torneo"  onchange="submit()"  >
    <option value="0">Seleccione el Torneo --></option>
       
   <?php
   $I=0;
   $consulta_mysql = "SELECT * FROM torneo WHERE estatus='A' ORDER BY fecha DESC";
   $resultado = $conn->query($consulta_mysql);
    while($record = $resultado->fetch_assoc())
    {
        echo "<option value='".$record['codigo']."'" ;
        if ((isset($_GET['torneo'])) && ($_GET['torneo']==$record["codigo"]))
        {
         $codigo_torneo=$record["codigo"];
         echo " SELECTED ";
        }
        echo ">";
        echo $record["codigo"];
        echo "</option>";
     
    }
   
    ?>
       
   </select>
  
   

  <!-- Creamos la tabla con el encabezado -->
  
 <table margin-left="50%" width="60%" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="Exportar_a_Excel" style="border-collapse:collapse;">
  
  <th>CEDULA</th>
  <th>NOMBRE</th>
  <th>CODIGO</th>
  <th>TORNEO</th>
  <th>FECHA REGISTRO</th>
  <th>INSCRITO</th>
  
  
  
    <?php
       
      //consulta en la tabla de torneos activos para inscribirse
     
     if ((isset($_GET['torneo'])) )
     {
      
        
        $consulta_mysql = "SELECT * FROM torneo WHERE estatus='A' and codigo='".$codigo_torneo."'";
        $resultado = $conn->query($consulta_mysql);
        if ($resultado->num_rows > 0) 
        {

            while($filator = $resultado->fetch_assoc())
            {

                $torneo_id=$filator["torneo_id"];
                $nombre_torneo=$filator["nombre"];
                $estatus="INSCRITO";

                $consulta_mysql = "SELECT fecha_registro,atleta_id FROM torneoinscritos WHERE torneo_id=$torneo_id";
                $resultado_SQL_inscritos = $conn->query($consulta_mysql);
                while ($row = $resultado_SQL_inscritos->fetch_assoc())
                {
                    $atleta_id=$row["atleta_id"];
                    $fecha_registro= $row["fecha_registro"];


                    $consulta_mysql = "SELECT * FROM atleta WHERE atleta_id=$atleta_id";
                    $resultado_SQL_atleta = $conn->query($consulta_mysql);
                    while($fila = $resultado_SQL_atleta->fetch_assoc())
                    {
                        $cedula=$fila["cedula"];
                        $nombre= $fila["nombres"];
                        $apellido= $fila["apellidos"];
                        echo '<tr>';
                        echo "<td>$cedula</td>";
                        echo "<td>$nombre - $apellido</td>";
                        echo "<td>$codigo_torneo</td>";
                        echo "<td>$nombre_torneo</td>";

                        $estatus="Inscrito en torneo";
                        $chk="checked";
                        $disabled="disabled";

                        $dato=$torneo_id."A".$atleta_id;


                        echo "<td>$fecha_registro</td>";
                        echo "<td> <input  type=\"checkbox\"  name=\"chktorneo[]\" value=\"$dato\" $chk $disabled>";
                        echo "</td>";
                        echo '</tr>';

                    }
                }
            }
        }
    }
   
      ?>
  <br>
  
  </form>


    



</body>

</html>







 