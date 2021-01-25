<?php

session_start();
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
//Instanciamos el objeto empresa para traer los datos
sleep(1);
$objEmpresa = new Empresa();
$lstEmpresa =$objEmpresa->ReadAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <title>Asociaciones</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <meta title="Asociacion de la Federacion Venezolana de Tenis">
    
    <style >
            .loader{

                    background-image: url("../images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
           .title-table{
                background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
                color: <?php echo $_SESSION['color_jumbotron']?>;
            }
           .table-head{
                background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
                color: <?php echo $_SESSION['color_jumbotron']?>;
           
        }
    </style>
    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
    <div class="col-xs-12 ">
        <a target="" href=""> <img src="../images/logo/fvtlogo.png" class="img-responsive pull-left"></img></a>
    </div>

    <div class="col-xs-12 ">
        <h2>Lista de Asociaciones</h2>
    </div>
    
    


 <?PHP
//El script se utiliza de forma modal para presentar una lista de items en una tabla y editarlos.


//Para generar las miga de pan mediante una clase estatica

 {
  $panel=' <div class="panel panel-default ">
  <!-- Default panel contents -->
  <div class="panel-heading title-table">Funciones</div>
  <div class="panel-body ">
    <p>La Federaccion Venezolana de Tenis(FVT), esta conformada por las Asociaciones de cada Entidad Federal(Estado). Representada
    por un junta directiva encargada de gestionar y llevar a cabo los torneos del calendario de competencias.</p>
  </div>';
  echo $panel;
  echo '<div class="table-responsive">';
                  
   echo " <table class='table table-striped table-bordered table-condensed ' >";
        echo "<thead> ";
            echo '<tr class="table-head ">';
           
                echo "<th>Site</th>";
                echo "<th>Entidad</th>";
                echo "<th>Estado</th>";
                echo "<th>Asociacion</th>";
                echo "<th>Telefonos</th>";
           
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
          
            foreach ($lstEmpresa as $record) {
                echo"<tr>";
                echo "<td><a class='glyphicon glyphicon-home' href='".$record['url']."'></a></td>";
               // echo "<td><a href='#' class='edit-record'  data-id='$rowid'>EDITAR</a></td>";
                echo "<td>". strtoupper($record['entidad'])."</td>";
                echo "<td>".$record['estado']."</td>";
                echo "<td>".$record['asociacion']."</td>";
                echo "<td>".$record['telefonos']."</td>";
                echo "</tr>";
            }
           
        echo "</tbody>";
        
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
   
    
   
          
}

?>
</div>
</body>
</html>
