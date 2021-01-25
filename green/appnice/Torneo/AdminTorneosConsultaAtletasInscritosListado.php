<?PHP
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_excepciones.php';
require_once '../clases/Encriptar_cls.php';

if(!isset($_SESSION['niveluser']) || !isset($_SESSION['logueado'])){
  header("Location:../sesion_inicio.php");
  exit;

}
if(($_SESSION['niveluser'])<8 || !($_SESSION['logueado'])){
  header("Location:../sesion_inicio.php");
  exit;
}
header('Content-Type: text/html; charset=utf-8');
$codigo_torneo=(isset($_GET['t'])) ? $_GET['t'] : NULL;
$categoria=(isset($_GET['radioCategoria'])) ? $_GET['radioCategoria'] : NULL;
$sexo=(isset($_GET['radioSexo'])) ? $_GET['radioSexo'] : NULL;
$estatus=$_GET["radioEstatus"];
$chkpagado=0;
if ($codigo_torneo!=null)
{ 
    $codigo_torneo=strtoupper($codigo_torneo);
    $codigo_torneo=mysql_real_escape_string($codigo_torneo);
    $categoria=  strtoupper($categoria);
    $categoria=mysql_real_escape_string($categoria);
    $sexo=  strtoupper($sexo);
    $sexo=mysql_real_escape_string($sexo);
    $estatus=mysql_real_escape_string($estatus);
    
    //Obtenemos los registros desde MySQL
    //Ahora procedemos a extraer los registros de nuestra base de datos, 
    //en este caso solo obtenemos el nombre, dirección y telefono de la tabla empresa de nuestra base de datos.
    $conexion = mysql_connect($servername, $username, $password);
    mysql_select_db($dbname,$conexion);
    //mysql_query('SET NAMES "utf8"');
    //mysqli_query($conexion, 'SET NAMES "utf8"');
    //$codigo_torneo = mysql1_real_escape_string($conexion, $codigo_torneo);
    //$categoria = mysql1_real_escape_string($conexion, $categoria);
   
    $categoria = trim($categoria);
    $codigo_torneo = trim($codigo_torneo);
    $sql = "SELECT torneo.categoria as categoria,torneo.tipo as grado,torneo.numero as numero,torneo.entidad as entidad,torneo.ano as ano,tipo_torneo,nombre as nombre_torneo FROM torneo where codigo='".$codigo_torneo."'";
    $result = mysql_query($sql, $conexion) or die(mysql_error());
    mysql_query('SET NAMES "utf8"');
    $record = mysql_fetch_assoc($result);
    $nombre_torneo=$record['nombre_torneo'];
    
    
    $queEmp = "SELECT atleta.atleta_id,atleta.estado,atleta.nombres, atleta.apellidos, atleta.cedula,"
            . "DATE_FORMAT(atleta.fecha_nacimiento, '%d-%m-%Y') as fechanac,"
        ."torneoinscritos.categoria as categoria, CONCAT(torneoinscritos.categoria,'-',torneoinscritos.sexo) as Categoria_Sexo,"
        . "torneoinscritos.fecha_registro,torneoinscritos.fecha_ranking,"
        . "torneoinscritos.pagado,torneo.fecha_fin_torneo,torneo.empresa_id,"
        . "torneoinscritos.afiliado,torneoinscritos.modalidad,"
        . "torneoinscritos.rknacional as elranking,torneoinscritos.estatus as estatus "
        . " FROM atleta "
        . "INNER JOIN torneoinscritos on atleta.atleta_id=torneoinscritos.atleta_id "
        . "INNER JOIN torneo on torneoinscritos.torneo_id=torneo.torneo_id "
        . "WHERE torneo.codigo='".$codigo_torneo."' " ;
    if ($estatus!=null){
        $queEmp .=" AND torneoinscritos.estatus='". $estatus."'";
    }
    if ($sexo!=null){
      $queEmp.=" AND atleta.sexo='".$sexo."'";
    }
    if ($categoria!=null) {
         $queEmp.=" AND torneoinscritos.categoria='".$categoria."' ";
    }
    $chk=" ";
    $chkpagado=1;
    $titPagado=" ";
    if ($_GET['chkpagaron']) {
         $queEmp.=" AND torneoinscritos.pagado=1 ";
          $chk="checked";
          $chkpagado=0;
          $titPagado="FORMALIZADOS";
    }
    
    
    $queEmp.=" ORDER BY Categoria_Sexo,elranking";
    
    $resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
    mysql_query('SET NAMES "utf8"');
    $totEmp = mysql_num_rows($resEmp);
     
     switch ($sexo){
        case "F":
            $txttit2= "Categoria(".$categoria." Femenino)";
            break;
        case "M":
            $txttit2= "Categoria(".$categoria." Masculino)";
            break;
        default :
            $txttit2= "";
     }
    $txtsistit = " ";
    if ($estatus!=null){
        $txttit  = "<b>LISTA DE ATLETAS RETIRADOS $titPagado </b>";     
        
    } else{
        $txttit  = "<b>LISTA DE ATLETAS INSCRITOS $titPagado </b>";
           
    }
    $txttit  .="<br><br>Torneo:".$nombre_torneo;
    $txttit2 .="<br>Ano: ".$record['ano']."<br>Numero: ".$record['numero']." Grado: ".$record['grado']." Categoria: ".$record['categoria']."<br> Entidad: ".$record['entidad'];
 
    
    ?>
<head>
	
    
    <title>Listado de Jugadores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <a > <img id="Logo" src="../images/logo/fvtlogo.png" width="200"  ></a>-->
    

    <style >
           
        .loader{
                background-image: url("../images/ajax-loader.gif");
                background-repeat: no-repeat;
                background-position: center;
                height: 100px;
            }
            .title-table{
                background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
                color: <?php echo $_SESSION['color_jumbotron'] ?>;
            }
            .table-head{
                background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
                color: <?php echo $_SESSION['color_jumbotron'] ?>;

            }
        
 
        @media (max-width: 320px) {
           .texto { font-size: 2em; }
        }
        .table-head { font-size: 12px; }
        td{
            font-size: 10px;
        }
       
       

       
    </style>
    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery/1.15.0/lib/jquery-1.11.1.js"></script>
  </head>
   
    
<body>
    <div class="container" >
           
         <!-- Creamos la tabla con el encabezado -->
         <div class="col-xs-12">
         <a> <img width="200" id="Logo" src="../images/logo/fvtlogo.png"></a>
         </div>
         <div class="col-xs-12">
            <h5> <?php echo $txttit ?>  </h5> 
            <h5> <?php echo $txttit2 ?>  </h5> 
         </div>
         <div class="row col-xs-12">
             <button class="btn btn-link glyphicon glyphicon-backward"   id="btn-back" ></buttom>
           
         </div>
    </div>
    <div class="container">
         <?php
            /*
            echo "<div class='col-md-12'>";
            echo "<a href='Torneo_XML.php?torneo=".$codigo_torneo."' target='_blank'</a>GENERAR XML";
            echo "</div>";
            */
          ?>     
        
        
            <div class="col-xs-12">
              <div class="table-torneo ">
               <table class="table  table-condensed">
                <thead >
                    <tr class="table-head">
           
                        <th>#</th>
                        <?php
                        if ($_SESSION['niveluser']>0){
                         echo '<th>Cedula</th>';
                        }
                        ?>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cat.</th>
                        <th>Rk</th>
                        <th>Ent.</th>
                        <th>Fecha Nac</th>
                        <th>Fecha Rk</th>
                        <th>Modal</th>
                        <th>Fecha Reg</th>
                        <th>Confirmado</th>
                        
                    </tr>
             </thead>
             <tbody>
            <?php
            $ixx = 0;
            $ano_afiliacion=date("Y");
           
           
            while($datatmp = mysql_fetch_assoc($resEmp)) {
                
                $atleta_id=$datatmp['atleta_id'];
                $fecha_fin_torneo=$datatmp['fecha_fin_torneo'];
                $empresa_id=$datatmp['empresa_id'];
                
                
                if (($estatus==$datatmp['estatus']))
                {
                
                    $ixx++;
                    echo "<tr >";
                    echo "<td>$ixx</td>";
                    
                    if ($_SESSION['niveluser']>0){
                      echo "<td>".$datatmp['cedula']."</td>";
                    }
                  
                    echo "<td>".$datatmp['nombres']."</td>";
                    echo "<td>".$datatmp['apellidos']."</td>";
                   
                    echo "<td>".$datatmp['Categoria_Sexo']."</td>";
                    if ($datatmp['elranking']=='999'){
                        echo "<td>0</td>";
                    }else{
                        echo "<td>".$datatmp['elranking']."</td>";
                    }
                    echo "<td>".$datatmp['estado']."</td>";
                    echo "<td>".$datatmp['fechanac']."</td>";
                    if ($datatmp['elranking']=='999'){
                        echo "<td></td>";
                    }else{
                        echo "<td>".$datatmp['fecha_ranking']."</td>";
                    }
                    echo "<td>".$datatmp['modalidad']."</td>";
                    echo "<td>".$datatmp['fecha_registro']."</td>";

                    if ($datatmp['estatus']=="Retiro"){
                        echo '<th><p class="glyphicon glyphicon-thumbs-down"<p></th>';
                    }else{
                        if ($datatmp['pagado']>0){
                            echo '<th><p class=" glyphicon glyphicon-thumbs-up"<p></th>';
                        }else{
                              echo "<td></td>";
                         }
                    }
                    
                    echo "</tr>";
                }
            }
           ?>
            </tbody>
            </table>
           
         </div>
        </div>
        
    

</div>
<script src="js/Torneos.js"></script>
        
</body>
</html>
<?php
       
}

    
    
    
else {
    $error_login=true;
    $mensaje="NO HAY DATOS PARA LA INFORMACION SOLICITADA";
//    $menususer=$_SESSION['menuuser'];
//      header("Location: $menususer ");
    exit;
   
}

?>

