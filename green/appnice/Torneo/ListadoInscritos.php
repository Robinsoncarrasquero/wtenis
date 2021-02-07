<?PHP
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_excepciones.php';
require_once '../clases/Encriptar_cls.php';
require_once '../clases/SQL_PDO_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Rank_cls.php';


 if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $logueado=true;
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    $logueado=false;
   // header('Location: sesion_inicio.php');
    
 }
// Le decimos a PHP que usaremos cadenas UTF-8 hasta el final del script
//mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
//mb_http_output('UTF-8');

//header('Content-Type: text/html; charset=utf-8');
error_reporting(1);

$codigo_torneo=(isset($_GET['t'])) ? Encrypter::decrypt($_GET['t']) : null;
$categoria=(isset($_GET['categoria'])) ? $_GET['categoria'] : null;
$sexo=(isset($_GET['sexo'])) ? $_GET['sexo'] : null;
$estatus=(isset($_GET['estatus'])) ? $_GET['estatus'] : null; // Inscrito o Retirado
$chk="checked";
$chkpagado=0;

if ($codigo_torneo!=null)
{ 
    $codigo_torneo=strtoupper($codigo_torneo);
    $codigo_torneo=mysqli_real_escape_string($conn,$codigo_torneo);
    $categoria=  strtoupper($categoria);
    $categoria=mysqli_real_escape_string($conn,$categoria);
    $sexo=  strtoupper($sexo);
    $sexo=mysqli_real_escape_string($conn,$sexo);
    $estatus=mysqli_real_escape_string($conn,$estatus);
    
    //Obtenemos los registros desde MySQL
    //Ahora procedemos a extraer los registros de nuestra base de datos, 
    //en este caso solo obtenemos el nombre, dirección y telefono de la tabla empresa de nuestra base de datos.
    
    $categoria = trim($categoria);
    $codigo_torneo = trim($codigo_torneo);
    $sql = 
    "SELECT torneo.categoria as categoria,torneo.tipo as grado,torneo.numero as numero,
    torneo.entidad as entidad,torneo.ano as ano,tipo_torneo,nombre as nombre_torneo 
    FROM torneo 
    where codigo='".$codigo_torneo."'";

    $records = SQL_PDO::SelectRecords($sql);
    foreach ($records as $record) {
        $nombre_torneo=$record['nombre_torneo'];
    }
    
    $sql_lista = 
    "SELECT atleta.atleta_id,atleta.estado,atleta.nombres, atleta.apellidos, atleta.cedula,"
    ."DATE_FORMAT(atleta.fecha_nacimiento, '%d-%m-%Y') as fechanac,"
    ."torneoinscritos.categoria as categoria, CONCAT(torneoinscritos.categoria,'-',torneoinscritos.sexo) as Categoria_Sexo,"
    ."torneoinscritos.fecha_registro,torneoinscritos.fecha_ranking,"
    ."torneoinscritos.pagado,torneo.fecha_fin_torneo,torneo.empresa_id,"
    ."torneoinscritos.afiliado,torneoinscritos.modalidad,"
    .'torneoinscritos.rknacional as elranking '
    ."FROM atleta "
    ."INNER JOIN torneoinscritos on atleta.atleta_id=torneoinscritos.atleta_id "
    ."INNER JOIN torneo on torneoinscritos.torneo_id=torneo.torneo_id "
    ."WHERE torneo.codigo='".$codigo_torneo."' " ;
    
    if ($estatus!=null){
        $sql_lista .=" AND torneoinscritos.estatus='". $estatus."'";
    }
    if ($sexo!=null){
        $sql_lista .=" AND atleta.sexo='".$sexo."'";
    }
    if ($categoria!=null) {
        $sql_lista .=" AND torneoinscritos.categoria='".$categoria."' ";
    }
    $chk=" ";
    $chkpagado=1;
    if ($_GET['chkpagaron']) {
        $sql_lista .=" AND torneoinscritos.pagado=1 ";
          $chk="checked";
          $chkpagado=0;
    }
    $sql_lista.=" ORDER BY Categoria_Sexo,elranking";
    //Generamos la lista
    $data_listado = SQL_PDO::SelectRecords($sql_lista);
    
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
    $txtsistit = " ";
    if ($estatus!=null){
        $txttit  = "<b>LISTA DE ATLETAS RETIRADOS </b>";       
    } else{
        $txttit  = "<b>LISTA DE ATLETAS PRE-INSCRITOS</b> ";
           
    }

    $txttit  .="<br>Torneo: $nombre_torneo $txttit2";
    $txttit  .="<br>Ano: ".$record['ano']."<br> Numero: ".$record['numero']." Grado: ".$record['grado']." Categoria: ".$record['categoria']."<br> Entidad: ".$record['entidad'];
    
    
    ?>
<head>
	
    
    <title>Listado de Jugadores Inscritos</title>
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
        body { font-size: 12px; }
        .texto { font-size: 1em; }
 
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
<!--    <script type="text/javascript" src="../js/jquery/1.15.0/dist/jquery.validate.js"></script>-->
    
  		
</head>
   
    
    <body>
        <div class="container-fluid" >
            <div class="row col-md-12" >
        <?php
        $hidden='HIDDEN="HIDDEN"';
       
        if ($_SESSION['niveluser']!=0){
            $hidden="";
        }
        ?>
          
        <form name="frm" <?php echo $hidden ?> method="GET" action="<?PHP echo$_SERVER['PHP_SELF']?>" >
            <label for="torneo">Torneo Ej:(20181G21216MIR) </label> 
            <input type="text" name="torneo" required="required" value="<?php echo $codigo_torneo; ?>"/><br />
            <label for="categoria">Categoria Ej:(16)   </label> 
            <input type=’text’ name="categoria" /><br/><br/>
            <label for="sexo">Sexo Ej:(F)   </label> 
            <input type=’text’ name="sexo" /><br/><br/>
            <input type="checkbox"  id ="chkpagaron" name="chkpagaron" <?php echo $chk ?> />Listar solo los que Formalizaron<br/><br/>
            <input type="submit"  value="Buscar " />
        </form>
            
           
         <!-- Creamos la tabla con el encabezado -->
         <a > <img width="10%" id="Logo" src="../images/logo/fvtlogo.png"   ></a>
         <h6> <?php echo $txtsistit ?>  </h6>  
         <h6> <?php echo $txttit ?>  </h6>  
         
        
      
        <div class="row"> 
            <div class="col-xs-12">
              <section class="table-torneo ">
                <div class="table">
           
                 <table class="table table-bordered table-condensed">
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
                        <th>Modal</th>
                        <th>Status</th>
                        
                    </tr>
             </thead>
             <tbody>
            <?php
            $ixx = 0;
            $ano_afiliacion=date("Y");
           
           
            foreach($data_listado as $datatmp) {
                $atleta_id=$datatmp['atleta_id'];
                $fecha_fin_torneo=$datatmp['fecha_fin_torneo'];
                $empresa_id=$datatmp['empresa_id'];
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
                    // if ($datatmp['elranking']=='999'){
                    //     echo "<td></td>";
                    // }else{
                    //     echo "<td>".$datatmp['fecha_ranking']."</td>";
                    // }
                    echo "<td>".$datatmp['modalidad']."</td>";
                    if ($_SESSION['niveluser']>=0){
                        if ($datatmp['pagado']>0){
                            //echo "<td>OK</td>";
                            echo '<th><p class="glyphicon glyphicon-thumbs-up"<p></th>';
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
           
                  </div></div></div>
                
   
    
    </div> 
            
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

