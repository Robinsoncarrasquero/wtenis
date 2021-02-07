<?PHP
session_start();
require_once '../conexion.php';
require_once '../funciones/funciones.php';
require_once '../clases/Bootstrap2_cls.php';

 if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    $logueado=false;
   // header('Location: sesion_inicio.php');
    
 }


header('Content-Type: text/html; charset=utf-8');


$codigo_torneo=(isset($_GET['t'])) ? $_GET['t'] : null;
$categoria=(isset($_GET['categoria'])) ? $_GET['categoria'] : null;
$sexo=(isset($_GET['sexo'])) ? $_GET['sexo'] : null;
$estatus=(isset($_GET['estatus'])) ? $_GET['estatus'] : null; // Inscrito o Retirado

if ($codigo_torneo!=null)
{ 
    $codigo_torneo=strtoupper($codigo_torneo);
    $codigo_torneo=mysqli_real_escape_string($conn,$codigo_torneo);
    $categoria=  strtoupper($categoria);
    $categoria=mysqli_real_escape_string($conn,$categoria);
    $sexo=  strtoupper($sexo);
    $sexo=mysqli_real_escape_string($conn,$sexo);
    $estatus=mysqli_real_escape_string($conn,$estatus);
    
    $conexion = mysqli_connect($servername, $username, $password);
    mysqli_select_db($conexion,$dbname);
    mysqli_query($conexion,'SET NAMES "utf8"');
    
    $categoria = trim($categoria);
    $codigo_torneo = trim($codigo_torneo);
    $sql = "SELECT torneo.categoria as categoria,torneo.tipo as grado,torneo.numero as numero,torneo.entidad as entidad,torneo.ano as ano,tipo_torneo,nombre as nombre_torneo FROM torneo where codigo='".$codigo_torneo."'";
    $result = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
    mysqli_query($conexion,'SET NAMES "utf8"');
    $record = mysqli_fetch_assoc($result);
    $nombre_torneo=$record['nombre_torneo'];
    
    $strRanking="torneoinscritos.rknacional as elranking ";
    
    
    $queEmp = "SELECT atleta.atleta_id,atleta.estado,atleta.nombres, atleta.apellidos, atleta.cedula,"
            . "DATE_FORMAT(atleta.fecha_nacimiento, '%d-%m-%Y') as fechanac,"
        ."torneoinscritos.torneoinscrito_id,torneoinscritos.categoria as categoria, CONCAT(torneoinscritos.categoria,'-',torneoinscritos.sexo) as Categoria_Sexo,"
            . "torneoinscritos.fecha_registro,torneoinscritos.fecha_ranking,"
            . "torneoinscritos.pagado,torneo.fecha_fin_torneo,torneo.empresa_id,"
            . "torneoinscritos.afiliado,torneoinscritos.modalidad,"
        .'torneoinscritos.rknacional as elranking '
        ."FROM atleta  "
        . "INNER JOIN torneoinscritos on atleta.atleta_id=torneoinscritos.atleta_id "
        . "INNER JOIN torneo on torneoinscritos.torneo_id=torneo.torneo_id "
        . "WHERE torneo.codigo='$codigo_torneo' " ;
    if ($estatus!=null){
        $queEmp .=" AND torneoinscritos.estatus='". $estatus."'";
    }
    if ($sexo!=null){
      $queEmp.=" AND atleta.sexo='".$sexo."'";
    }
    if ($categoria!=null) {
         $queEmp.=" AND torneoinscritos.categoria='".$categoria."' ";
    }
    
    $resEmp = mysqli_query($conexion, $queEmp) or die(mysqli_error($conexion));
    $totEmp = mysqli_num_rows($resEmp);
    
     switch ($sexo){
        case "F":
            $txttit2= "Categoria(".$categoria." FEM.)";
            break;
        case "M":
            $txttit2= "Categoria(".$categoria." MAS.)";
            break;
        default :
            $txttit2= "";
     }
    $txtsistit = "SISTEMA DE GESTION DE TENIS DE CAMPO\n";
    if ($estatus!=null){
        $txttit  = "Atletas Retirados : $nombre_torneo($codigo_torneo) $txttit2";       
    } else{
        $txttit  = "Atletas inscritos : $nombre_torneo($codigo_torneo) $txttit2";
    }
    
    ?>
 <!DOCTYPE HTML>
    <html>
    <head>
    <title>Firma y Pagos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/master_page.css">
    <link rel="StyleSheet" href="../css/inscribe.css" type="text/css">
    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>  
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    
    <style>
            .loader{

            background-image: url("images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 100px;
        }
        nav.navbar {
            background-color:    #000;
        }
        .jumbotron{
           background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
           color: <?php echo $_SESSION['color_jumbotron']?>;
        }
        
               
        .table-head{
            background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
            color:<?php echo $_SESSION['color_jumbotron'] ?>;
        };
            
    </style>
    
    </head>
    
    <body>
        <div class="container">
    
    <?PHP
        
         //Presentar los iconos de la pagina
    
    Bootstrap::master_page();
   
   //Para generar las miga de pan mediante una clase estatica
   $arrayNiveles=array(
       array('nivel'=>1,'titulo'=>'Inicio','url'=>'../bsPanel.php','clase'=>' '),
       array('nivel'=>2,'titulo'=>'Torneos','url'=>'../Torneo/bsTorneo_Read.php','clase'=>' '),
       array('nivel'=>3,'titulo'=>'Firma','url'=>'','clase'=>'active '),
       );
        
    echo '<div class="col-xs-12">';
      // echo Bootstrap::breadCrum($arrayNiveles) ;
    echo '</div>';
        //Conectamo
    
                              
    //Conectamo
       
     //Presentar un Usuario
    echo '<div class="col-xs-12">';
    
    echo '<h6 class="titulo-name" >Bienvenido :'.$_SESSION['nombre'].'</h6>';
   
    echo '</div>'; //Container    
 
?>
        
        <div class="col-xs-12 text-center">
            <h6 class="titulo-name">Procesando los pagos</h6>
            <h6 id="torneoname" class="titulo-name"><?php echo $nombre_torneo ?></h6>
            <h6 id="mensaje"></h6>
        </div>
        <hr>
        <div class="col-xs-12"> 
        <div class="table">
            
            <table class="table table-responsive table-striped table-bordered table-condensed">
             <thead>
             <th>#</th>
             <th>Nombres</th>
             <th>Apellidos</th>
             <th>Fecha Nac.</th>
             <th>Categoria</th>
             <th>Ranking</th>
             <th>Fecha Rank.</th>
             <th>Asociacion</th>
             <th>Fecha Reg.</th>
             <th>Pago</th>
<!--             <th>Imprimir</th>-->
            </thead>
            <tbody>
           
            <?php 
            
            $ixx = 0;
    
            while($datatmp = mysqli_fetch_assoc($resEmp)) {
                $ixx++;

               $rowid=$datatmp['torneoinscrito_id'];
               
                if($datatmp['pagado']==1){
                    echo "<tr id=$rowid>";  
                }else{
                    echo "<tr id=$rowid>";  
                 } 
                 $cedula=$datatmp['cedula'];
               echo "<td>$ixx</td>";

               echo "<td>".$datatmp['nombres']."</td>";
               echo "<td>".$datatmp['apellidos']."</td>";
               echo "<td>".$datatmp['fechanac']."</td>";
               echo "<td>".$datatmp['Categoria_Sexo']."</td>";
               if ($datatmp['elranking']=='999'){
                        echo "<td>0</td>";
                        echo "<td></td>";
               }else{
                        echo "<td>".$datatmp['elranking']."</td>";
                        echo "<td>".$datatmp['fecha_ranking']."</td>";
               }
               
               
               echo "<td>".$datatmp['estado']."</td>";
               echo "<td>".$datatmp['fecha_registro']."</td>";
             
               if($datatmp['pagado']==1){
                echo "<td> <input  type='checkbox' name='torneopagado' id='$rowid-$cedula' checked='checked'></td>";
               // echo "<td> <a href='torneo_pago_atletas_inscritos_recibo.php?id=$rowid' id='btn$rowid' class='btnPrint' target='_blank' name='$rowid'</a>Imprimir</td>";
               }else { 
                echo "<td> <input  type='checkbox' name='torneopagado' id='$rowid-$cedula'  ></td>";
               // echo "<td> <a href='torneo_pago_atletas_inscritos_recibo.php?id=$rowid' id='btnImp' class='btnPrint' target='_blank' name='$rowid'</a>Imprimir</td>";
               }
               
               echo "</tr>";
            }
           ?>
           
            </table>
            </div>
         
            
            <?php
             if ($_SESSION['niveluser']>=0){
                if ($estatus!=null){
                   // echo "<h4>". "<td><a href='torneo_listado_atletas_pdf.php?torneo=".$codigo_torneo."&estatus=retiro"."' target='_blank'</a>Imprimir en PDF</td>"."</h4>";
                }else {
                   // echo "<h4>". "<td><a href='torneo_listado_atletas_pdf.php?torneo=".$codigo_torneo."&estatus="."' target='_blank'</a>Imprimir en PDF</td>"."</h4>";

                }
             }
            ?>
                    
                
    </div>
        
 </div>
    <script>
    
    function funPago( ) {
    
    //Obtenemos id del elemento marcado
    var Id = $(this).attr( "id" );
    var url="torneo_pago_atletas_inscritos_checked.php";
    var chkPago = $(this).is(':checked') ? 1: 0;  
    $("#mensaje").html('');
    $("#mensaje").removeClass('alert alert-danger');
    $("#mensaje").removeClass('alert alert-success');
    
    {
        
        $.ajax({
        method: "POST",
        url:url, 
        data: { id:Id, chkPago: chkPago, torneo: $("#torneoname").text()}
        })
        .done(function( data ) {
            
            if(data.Success){
                if(data.Accion==="Procesado"){
                    $("#mensaje").html(data.Mensaje).addClass('alert alert-success');
                }else{
                    $("#mensaje").html(data.Mensaje).addClass('alert alert-danger');
                }
            }
        })
        .fail(function( xhr, status, errorThrown ) {
        alert( "Sorry, there was a problem!" );
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
        });
    }     
    
}
$( "input[type=checkbox]" ).on( "click", funPago);
</script> 
    
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


    
