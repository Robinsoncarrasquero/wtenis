<?PHP

session_start();
require_once '../funciones/funcion_monto.php';
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';

 if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}


$por_post = ($_SERVER['REQUEST_METHOD'] == 'POST');



if ($_SESSION['niveluser']>9){
    //Filtro para la federacion
    $empresa_id=0; 
}else{
    //Filtro para la asociacion
    $empresa_id=$_SESSION['empresa_id']; 
}


//Ano de afiliacion = actual + 1
//$ano_afiliacion = date ("Y") + 1;

$empresa_id=$_SESSION['empresa_id'];

//Instanciamos la clase empresa para obtener la empresa_id
//de la asociacion registrada
$objEmpresa= new Empresa();
$objEmpresa->Find($empresa_id);
if ($objEmpresa->Operacion_Exitosa()){
    $objAfiliacion = new Afiliacion();
    $objAfiliacion->Fetch($objEmpresa->get_Empresa_id());
    $monto_aso=$objAfiliacion->getAsociacion();
    $monto_fvt=$objAfiliacion->getFVT();
    $monto_sis=$objAfiliacion->getSistemaWeb();

    //Aqui colocamos el ano de afiliacion que cambiara cada ano
    $ano_afiliacion=$objAfiliacion->getAno();
    $Afiliacion_id=$objAfiliacion->get_ID();
}

$empresa_id=0; 
//$objAfiliacion = new Afiliacion();
//$rsAfiliaciones = $objAfiliacion->ReadAllByAno($empresa_id,$ano_afiliacion);
$rsAfiliaciones = Afiliacion::ReadByCiclo($empresa_id, $ano_afiliacion, 1);


//En caso de haber alguna afiliacion activa se le presenta al usuario para que la realice   
if ($rsAfiliaciones)
{ 
    
    
    
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
    <title>Consulta Federados</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <style >
        .loader{
            background-image: url("../images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 80px;
        }
            
    </style>    
    
    </head>
    
    <body>
     
        
    <!-- Creamos la tabla con el encabezado -->

    <div class="container-fluid">

            <?php  
                //Menu de usuario
            //    include_once '../Template/Layout_NavBar_Admin.php';
            //    echo '<br><hr>';
            ?>
            <div class="col-xs-12">
               <h3>Consulta Afiliaciones Federadas <?php echo $ano_afiliacion ?>  </h3>  
            </div>
            <div class="col-xs-12">
                <span ><a  class="glyphicon glyphicon-backward" href="../bsPanel.php"><a/></span>     
            </div>
        
            <form class="col-xs-12-12 form-signin" method="post" id="register-form" > 
                <div class="col-xs-12 ">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="fdesde">Fecha Desde:</label>
                       <input type="date" id="fdesde" class="form-group" value="<?php echo date("Y-m-d")?>">
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="fhasta">Fecha Hasta:</label>
                       <input type="date" id="fhasta" class="form-group" value="<?php echo date("Y-m-d")?>">
                    </div>
                  
                    <div class="form-group col-xs-12">
                       <button  type="button" class="btn btn-primary" name="btn-buscar" id="btn-buscar">
                       <span class="glyphicon glyphicon-search" ></span> &nbsp; Buscar
                       </button>
                    </div> 

                    <div class="lista">

                    </div>

                </div>
            </form>


    </div>  
  
<script>

$(document).ready(function() {
   // Manejamos la busqueda del combo 
   // y cargamos la lista
  
    $('#btn-buscar').click(function(e){
        var fechaInicio = new Date($("#fdesde").val());
        var fechaFin = new Date($("#fhasta").val());
        var diff = fechaFin - fechaInicio;
        var x = diff /(1000*60*60*24);
        if (x > 90){
            alert("Debe especificar un rango de fecha menor a 90 dias");
            exit();
        }
        var fdesde = $("#fdesde").val();
        var fhasta = $("#fhasta").val();
        e.preventDefault();
        $(".lista").html('');
        $('.lista').addClass('loader');

        $.post("ConsultaAfiliacionesFederadasPorFecha.php",
            {fdesde:fdesde,fhasta:fhasta}, 
            function(html){
                $('.lista').removeClass('loader');
                $('.lista').html(html);
        });
    });
    
    
       
});
	
</script>
    
</body>

</html>
<?php
}
else {
    $error_login=true;
    $mensaje="<p>NO HAY DATOS PARA LA INFORMACION SOLICITADA</p>";
    
    header("Location: ../sesion_usuario_admin.php ");
  
    exit;
   
}



?>


    
