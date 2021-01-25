<?php
session_start();
require_once '../conexion.php';
//require_once '../clases/Bootstrap_Class_cls.php';
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Encriptar_cls.php';

if (!isset($_SESSION['logueado']) || !isset($_SESSION['niveluser'])) {
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../Login.php');
    exit;
}
if ($_SESSION['niveluser']>0){
    header('Location: ../sesion_inicio.php');
    exit;
}

$nombre = $_SESSION['nombre'];
$cedula = $_SESSION['cedula'];
   
//Validamos que la afiliacion sea confirmada
$atleta_id=$_SESSION['atleta_id'];
 
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Retiros</title>
    <link rel="stylesheet" href="../css/master_page.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style >
        .loader{
            background-image: url("../images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 100px;
        }
        
        .table-head{
            background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
            color:<?php echo $_SESSION['color_jumbotron'] ?>;
        };
    </style>

</head>
<body>
<?php  

echo '<div class="container-fluid">';
    //Menu de usuario
    include_once '../Template/Layout_NavBar_User.php';
    //Presentar un Usuario
    echo '<br>';
    echo '<div class="col-xs-12">';
    echo '<hr>';
    echo '<h2>Retiros</h2>';
    echo '<h6 class="titulo-name" >Bienvenido :'.$_SESSION['nombre'].'</h6>';
    echo '</div>'; 

    echo '<div class="col-xs-12 col-sm-8">';
    $strhead='
   
    <form action="bsInscripcionChange.php" method="post" >
        <div class="table">
            <table class="table">
                <thead >
                    <tr class="table-head ">
                        <th>Status</th>
                        <th>Retirar</th>
                        <th>Grado</th>
                        <th>Categoria</th>
                        <th>Fecha Retiro</th>
                        <th>Torneo</th>
                        
                    </tr>
                </thead>';

    echo $strhead;
  
    $record_encontrados=0;
   
    $consulta_mysql = "SELECT * FROM atleta WHERE atleta_id=".$atleta_id;
    //$result_atleta = $conn>query($consulta_mysql); mysqli
    //while($fila = $result_atleta->fetch_assoc()) mysqli
    $result_atleta = mysql_query($consulta_mysql);
    while ($fila = mysql_fetch_assoc($result_atleta )) 
                
    {
      $atleta_id=$fila["atleta_id"];
      $cedula=$fila["cedula"];
      $nombre= $fila["nombres"];
      $apellido= $fila["apellidos"];
     
     
//       
      //consulta en la tabla de torneos activos para inscribirse
      $consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A' order by fechacierre desc";
      //$resultado_SQL_torneo = $conn>query($consulta_mysql2); mysqli
//      $resultado_SQL_torneo = mysql_query($consulta_mysql2);mysqli
//      while($filator = $resultado_SQL_torneo->fetch_assoc()) mysqli
      $result_torneo = mysql_query($consulta_mysql2);
      while($filator = mysql_fetch_assoc($result_torneo)){
        $torneo_id=$filator["torneo_id"];
        $codigo_torneo=$filator["codigo"];
        $grado_torneo=$filator["tipo"];
        $nombre_torneo=$filator["nombre"];
        $categoria_torneo=trim($filator["categoria"]);
        $fechadecierre= $filator["fechacierre"]; //fecha que se presenta en la pantalla
        $fechadeiniciotorneo= $filator["fecha_inicio_torneo"]; //fecha que se presenta en la pantalla
        $fechaderetiros= $filator["fecharetiros"]; //fecha que se presenta en la pantalla
        $entidad=$filator["entidad"];
        
      
        $estatus="Inscrito";
        $date_hoy=date_create(); // fecha del servidor 
        $fecha_hoy= date_timestamp_get($date_hoy);
        $date_bd = date_create($filator["fechacierre"]); // fecha cierre de la bd
        date_add($date_bd,date_interval_create_from_date_string("0 days"));
        $fecha_cierre =date_timestamp_get($date_bd);
        
        $date_bd= date_create($filator["fecharetiros"]); // fecha inicio de la bd
        $fechaRetiros =date_timestamp_get($date_bd);
        
        $dias_diferencia=intval(($fecha_hoy-$fecha_cierre)/86400);
        
//        echo'<pre>';
//        var_dump($fecha_hoy).'</br>';
//        var_dump($fecha_cierre).'</br>';
//        echo '</pre>';
        //if ( $fecha_hoy<>$fecha_cierre  ){
        if ( $fecha_hoy>$fecha_cierre &&  $fecha_hoy <=$fechaRetiros ){
            
            //Busca el estado que oferta los torneos 
            {
               $sql2 = "SELECT estado FROM empresa WHERE  empresa_id=".$filator["empresa_id"];
               $result2 = mysql_query($sql2);
               $row = mysql_fetch_array($result2);
                if ($row){
                    $asociacion=$row["estado"];
                }else{
                    $asociacion="N/A";
                }

            }
           
            $consulta_mysql = "SELECT categoria,torneoinscrito_id,estatus FROM torneoinscritos "
                    . "WHERE torneo_id=$torneo_id AND atleta_id=$atleta_id ";
            $result = mysql_query($consulta_mysql);

            $row = mysql_fetch_array($result);

            if ($row){
                $record_encontrados ++;
                $flaginscrito=TRUE;
               
                $categoriainscrita=$row["categoria"];
                $torneo_inscrito_id=$row["torneoinscrito_id"];
                $estatus="Inscrito(a)";
                $chk="checked";
                $chkinscribe="disabled";
                $chkdesinscribe=" ";
                $chk="  ";
                $chkretiro=" ";
                if ($row["estatus"]=="Retiro"){
                    $estatus="Retiro(a)";
                    $chk="checked ";
                    $chkretiro="disabled";
                     
                }
                $tachado=" ";
                //LLENAMOS LA LINEA CON LOS DATOS
                
               switch ($row["estatus"]) {
                case "Retiro":
                    echo '<tr class=" " >';
                    echo '<td><p class="glyphicon glyphicon-thumbs-down"></p></td>  ';
                    break;
                default:
                     echo '<tr class=" "  >  ';
                     echo '<td><p class="glyphicon glyphicon-thumbs-up"></p></td>  ';
                    break;
                }
           
                //LLENAMOS LA LINEA CON LOS DATOS
                $dato=$torneo_id.",".$atleta_id.",".$torneo_inscrito_id.",".$categoriainscrita.",RET";
                
                echo "<td> <input  type=\"checkbox\"  name=\"chkretirar[]\" value=\"$dato\" $chk $chkretiro ></td>";
                echo "<td >$grado_torneo</td>";
                echo "<td>";
                echo "<select disabled name='".$torneo_id."'>";
                echo "<option selected value='$categoriainscrita'>$categoriainscrita</option>";
                echo '</select>';
                echo "</td>";
                echo "<td>$fechaderetiros</td>";
                echo "<td>$nombre_torneo</td>";
//                echo "<td>$entidad</td>";
                
//                echo "<td>$fechadecierre</td>";
//                echo "<td>$fechaderetiros</td>";

              
                //echo "<td> <input hidden=  type=\"checkbox\"  name=\"chkinscribir[]\" value=\"$dato\" $chk $chkinscribe>";
//                  echo "<td>$estatus</td>";
//                echo "<td><a href='../Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?torneo=".$codigo_torneo. "&estatus=retiro". "' target='_blank'</a>Ver</td>";

                echo '</tr>';
            }
            

        }
    }
       
}
//mysqli_close($conn);mysqli
mysql_close($conn);
echo            "</table>";
echo "      </div>";


//Div-end Side Left

 if ($record_encontrados>0 and $status="Retirado"){
    echo '<div class="col-xs-12">
            <input  type="submit" name="btnProcesar" value="Guardar" class="btn btn-primary" > 

           </div>';
   }else{
      echo '<h5 class="alert alert-warning">'.Bootstrap_Class::texto("Mensaje :").
              ' No tiene torneos disponibles para retirar.</h5>';

   }
echo "  </form>";

//Div-end site Left
echo "</div>";


 //Div side right
 echo '<div class="col-xs-12 col-sm-4">';
    echo '<div class="notas-lef">';
    echo '<h5 class="alert alert-info">'.Bootstrap_Class::texto("Retiro:")
            .'<br><br>'
            . 'Puede retirar los torneos cerrados en los plazos establecidos. Vencida la fecha,'
            .'el jugador podr&iacutea estar sujeto a sanciones de acuerdo al Reglamento.</h5>';
    //Div-end notas-left
    echo "</div> ";
 
 //Div-end side right
 echo "</div> "; 
 
?>
 

<script>
//var myVar = setInterval(myTimer, 1000);

function myTimer() {
    var d = new Date();
    document.getElementById("hora").innerHTML = "Fecha: "+ myfecha(0)+" - "+"Hora: " + d.toLocaleTimeString();
    //document.getElementById("hora").innerHTML = myfecha()+"</br>"+d.toDateString() +"</br>"+"HORA: " + d.toLocaleTimeString();
}
function myfecha(conMeses){
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var f=new Date();
    if (conMeses===1){
        return  (f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    }else{
//        return (f.getUTCFullYear() +"/" + f.getUTCMonth()+"/" + f.getUTCDay());
        return  (f.getDate()+ "/" + (f.getMonth()+1) +  "/" + f.getFullYear());
    }
}

$(".apuntar").click(function(e){
    e.preventDefault();

    
    };
)
</script>
</body>

</html>







 