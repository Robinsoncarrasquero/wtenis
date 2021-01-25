<?php
session_start();
require_once '../conexion.php';
require_once '../clases/Torneos_cls.php';
require_once '../funciones/funcion_fecha.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Modalidad_cls.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Encriptar_cls.php';

if (isset($_SESSION['logueado']) and $_SESSION['logueado']) {
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
   
} else {
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_inicio.php');
    exit;
}
if ($_SESSION['niveluser'] > 8) {
    header('Location: ../sesion_inicio.php');
    exit;
}
error_reporting(1);
$afiliado = $_SESSION['afiliado'];
$sweb= $_SESSION['SWEB'];
//print_r("AFILIADO --> :".$afiliado);

//Validamos que la afiliacion sea confirmada
$atleta_id=$_SESSION['atleta_id'];
if($_SESSION['niveluser']==1){
   $nombre="(** ".$_SESSION['nombre']." **)";
    
}

$cedulaid=$cedula;
//mb_http_output('UTF-8');

header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inscripcion</title>
        <link rel="stylesheet" href="../css/master_page.css">
        <link rel="shortcut icon" href="<?php echo $_SESSION['favicon']?> " />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
           
    </head>
    <style>
        
        td{
           font-size:10px;
            
        }
        thead{
            
                      font-size:10px;

        }
        .btn-guardar{
            margin:0;
            float:left;
        }
        
     
       
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
        
        .title-table{
                background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
                color: <?php echo $_SESSION['color_jumbotron'] ?>;
                
        }
        .table-head{
            background-color:#ac2925;//<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
            //color: <?php echo $_SESSION['color_jumbotron'] ?>;
            color:#FFFFFF;

        }
        
        .apuntar{
            background-color:gold;
        }
        .borrar{
            background-color:#46b8da;
        }
        
    </style>
<body>
 
    
<?php  
//Container

    echo '<div class="container ">';

    //Presentar los iconos de la pagina
    
    Bootstrap::master_page();
   
    //Para generar las miga de pan mediante una clase estatica
    $arrayNiveles=array(
       array('nivel'=>1,'titulo'=>'Inicio','url'=>'../bsPanel.php','clase'=>' '),
       array('nivel'=>2,'titulo'=>'Retiros','url'=>'bsInscripcion_Retiros.php','clase'=>' '),
       array('nivel'=>3,'titulo'=>'Inscripcion','url'=>'bsInscripcion.php','clase'=>'active')
       );
    echo '<div class="col-xs-12">';
       echo Bootstrap::breadCrum($arrayNiveles) ;
    echo '</div>';
    //Conectamo
       
     //Presentar un Usuario
    echo '<div class="col-xs-12">';
    echo '<hr>';
    echo '<h6 class="titulo-name" >Bienvenido :'.$_SESSION['nombre'].'</h6>';
    echo '</div>'; //Container    
    
?>

    <div class="col-sm-12 col-md-8">

<?PHP

require_once 'Inscripcion_cls.php';

  $strHTML='
    <div  class="table">      
        <table class="table table-bordered table-responsive  table-condensed">
            <thead>
                <tr class="table-head" >
                <th><p class="glyphicon glyphicon-dashboard"<p></th>
                <th>Ent</th>
                <th>Grado</th>
                <th>Fecha</th>
                <th>Categoria</th>
                <th>Modalidad</th>
                <th >Accion</th>
                <th >Lista</th>
             </tr>

           
        </thead>';
  $strHTML .= Inscripcion_cls::inscripcion_reload($cedulaid);
  
?>
<!--//Fin lado izquierdo-->
<div id="dale" class="col-md-12">
    <?php echo $strHTML; ?>
</div>

<!--//Div Side Left-->
</div>
  
<?php  
  

//Inicio Lado derecho
echo '<div class="hidden-xs col-sm-12 col-md-4">';
      echo '<div id="mensaje"></div>';
        echo '<div class="notas-left ">';
            echo '<p class="alert alert-warning">'.Bootstrap_Class::texto("Notificacion :","success").'<br> '
               . 'Solo est&aacute permitido inscribir un evento en la misma fecha del calendario.</P>';

        
            echo '<p class="alert alert-info">'.Bootstrap_Class::texto("Inscripcion :","success").'<br>
                     1. Selecciona la categoria y la columna (Apuntar).<br>
                     2. Pulsa el boton (Guardar).<br>
                     3. Asegurate que el torneo seleccionado sea de color verde agua.</p>';
        echo '</div>'; 
//Fin lado derecho
echo '</div>';

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
        return  (f.getDate()+ "/" + (f.getMonth()+1) +  "/" + f.getFullYear());
    }
}
function selectcategoria(obj) {
var valorSeleccionado = obj.options[obj.selectedIndex].value; 
   <?php 
    $categoriainscrita="<script> document.write(valorSeleccionado) </script>";
    $dato=$torneo_id.",".$atleta_id.",".$torneo_inscrito_id.",".$categoriainscrita.",INS";
    
  ?>
//   if ( valorSeleccionado == 1 ) {
//      // document.location = 'http://mipagina1.com' ;
//   }
//   if ( valorSeleccionado == 2 ) {
//      // document.location = 'http://mipagina2.com' ;
//   }
// etc..
}

function Apuntarme(){  
    
    var myid= $(this).attr("id");
    
    var selectModalidad = $("#Modalidad"+myid).val() || [];
    $("#resultadoValue").text(selectModalidad);
    // Obtener el texto del las opciones selecionadas
    
    var selectCategoria = $("#Categoria"+myid).val() || [];
    $("#resultadoValueCategoria").text(selectCategoria);
    
    var datos = $(this).attr( "data-id" );
    var Id = $(this).attr( "data-id" );
    var chkimprime=Id.substr(0,3);
    
    var url="bsInscripcionajaxchange.php";

    //Obtenemos  checkbo
    //var chkOperacion = $("#"+Id).is(':checked') ? 1: 0;  
    //alert ("Valor chkOperacion: "+chkOperacion);
    
    
    $.ajax({
    method: "POST",
    url: url, 
    data: {datos:datos,modalidad:selectModalidad,categoria:selectCategoria}
    })
    .done(function( data ) {
        
        $("#dale").htm(data.HTML);
        $("#mensaje").html(data.Mensaje);
        
        if (data.Success){
            alert ("Operacion Realizada exitosamente");
         }else{
            alert ("Error: Operacion no fue exitosamente");
        }
     })
    .fail(function( xhr, status, errorThrown ) {
            alert( "Sorry, there was a problem!" );
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
    });
    
}





   

$( "input[type=checkbox]" ).on( "click", Apuntarme);


$('.miselect').change(function () {
    alert("miselect");
                // Obtener valor del las opciones selecionadas
                var selectValue = $("#miselect").val() || [];
                $("#resultadoValue").text(selectValue);
                // Obtener el texto del las opciones selecionadas
                var selectText = $("#miselect option:selected").map(function () {
                    return $(this).text();
                }).get().join(',');
                $('#resultadoTexto').text(selectText);
                
            });

</script>


</body>

</html>







 