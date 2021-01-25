<?PHP
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_excepciones.php';
require_once '../clases/Encriptar_cls.php';
require_once '../clases/Torneos_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Bootstrap2_cls.php';


 if(!isset($_SESSION['niveluser']) || !isset($_SESSION['logueado'])){
   header("Location:../sesion_inicio.php");
   exit;
     
 }
 if(($_SESSION['niveluser'])<8 || !($_SESSION['logueado'])){
   header("Location:../sesion_inicio.php");
   exit;
 }
$hidden='hidden="hidden"';
       
if ($_SESSION['niveluser']!=0){
    $hidden="";
}

 
header('Content-Type: text/html; charset=utf-8');


$torneo_id=(isset($_GET['t'])) ? $_GET['t'] : null;

$objTorneo = new Torneo();
$objTorneo->Fetch($torneo_id);
$codigo_torneo=$objTorneo->getCodigo();
$nombre_torneo=$objTorneo->getNombre();
$array_categoria= explode(",", $objTorneo->getCategoria());
$array_sexo= array("Femenino"=>"F","Masculino"=>"M");

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
        
        .table-head 
        { 
            font-size: 12px; 
        }
        td{
            font-size: 10px;
        }
       
        .frmfield{
            font-size:20px;
        }
       
    </style>
        <link rel="stylesheet" href="../css/master_page.css">

    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="js/jquery/1.15.0/lib/jquery-1.11.1.js"></script>
<!--    <script type="text/javascript" src="../js/jquery/1.15.0/dist/jquery.validate.js"></script>-->
    	
</head>
   
    
<body>
    <div class="container" >
        <div class="row col-sm-12 frmfield" >
      
           
       <a > <img width="200" id="Logo" src="../images/logo/fvtlogo.png"></a>
        <hr><br>
        <div class="col-sm-12 ">
        <form name="frm" <?php echo $hidden ?> method="GET" action="AdminTorneosConsultaAtletasInscritosListado.php" >
            <div class="col-sm-12 ">
            <label  for="t">Codigo</label> 
            <input class="form-group" type="text" name="t" required="required" readonly="readonly" value="<?php echo $codigo_torneo; ?>"/><br />
            </div>
            <div class="col-sm-12">
            <label for="nombre_torneo">Torneo</label> 
            <input class="form-group" type="text" name="nombre_torneo" required="required" readonly="readonly" value="<?php echo $nombre_torneo; ?>"/><br />
            </div>
            
            <div class="col-sm-12 ">
                <label for="categoria">Categoria : </label> 
                <?php
                    
                    foreach ($array_categoria as $key => $value) {
                       $vcategoria= substr($value,0,2);
                        echo "<input  type='radio' name='radioCategoria' value='$vcategoria' />$value";
                    }
                ?>
            </div>
            <div class="col-sm-12">
                <label for="sexo">Sexo : </label> 
                <?php
                    foreach ($array_sexo as $key => $value) {
                        echo "<input class='radioSexo' type='radio' name='radioSexo' value='$value' />$value";
                    }
                ?>
            </div>
            
            <div class="col-sm-12">
                <input  type="radio" name="radioEstatus" value="Retiro" />Retirados
                <input type="radio"  name="radioEstatus" value=""/>Inscritos
            </div>
            
            <div class="col-sm-12">
                <input class="form-group" type="checkbox"  id ="chkpagaron" name="chkpagaron" />Formalizaron
                <br><br>
            </div>
            
            <div class="col-sm-1">
                <input class="btn btn-info" type="submit"    value="Buscar " />
            </div>
            <div class="col-sm-1">
                <button class="btn btn-default" type="button"  id="recargarPage">Limpiar</button>
            </div>
        </form>
        </div>
        </div> 
    </div>    
    <script src="js/Torneos.js"></script>
</body>
</html>


