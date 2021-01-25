<?php
session_start();
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Encriptar_cls.php';
require_once '../funciones/Imagenes_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Bootstrap2_cls.php';

if(isset($_SESSION['niveluser']) && $_SESSION['niveluser']!=0){
    header('Location: ../sesion_inicio.php');
}
 
$nrotorneos=0;
$atleta_id =$_SESSION['atleta_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Torneos</title>
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
        tr[class~="table-head"]{
            background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
            color:<?php echo $_SESSION['color_jumbotron'] ?>;
        };
        

    </style>      		
</head>
<body>
    
<div class="container-fluid">  
<?php  
    echo ''; //Container main
    //Menu de usuario
    include_once '../Template/Layout_NavBar_User.php';
    
    //Presentar un Usuario
    echo '<br>';
    echo '<div class="col-xs-12">';
    echo '<hr>';
    echo '<h2>Mis Torneos</h2>';
    echo '<h6 class="titulo-name">Bienvenido :'.$_SESSION['nombre'].'</h6>';
    echo '<h4  hidden id="atleta_id">'.Encrypter::encrypt($atleta_id).'</h4>';

    echo '</div>'; //Container   
    
        
    
    ?>
        <div id="mensaje" class="col-xs-12">

        </div>

        <div id="results">

        </div>
        <div id="paginacion" class="col-xs-12 text text-center">

        </div>
   
    </div>
<script>

$(document).ready(function(){
    
    var id=$("#atleta_id").text();
    
    $("#mensaje").html('');
    $('#mensaje').addClass('loader');
    $("#results").html('');
    $.ajax({
        method: "POST",
        url: "MisTorneosList.php", 
        data:  {id:id,pagina:0}
    })
    .done(function( data) {
       $('#mensaje').removeClass('loader');
       $('#results').html(data.html);
       $('#paginacion').html(data.pagination);
       
    });
    //Paginando Torneos
    $(document).on('click','.page-link',function(e)  {
        var page = $(this).attr('data-id');
        $.ajax({
            method: "POST",
            url: "MisTorneosList.php", 
            data:  {id:id,pagina:page}
        })
        .done(function( data) {
          // $('#mensaje').removeClass('loader');
           $('#results').html(data.html);
           $('#paginacion').html(data.pagination);
          });
                  
    });
    //Cargamos el icono de ajaxloader y la lista de personas
    //readRecords();
    
    //Link de documentos a visualizar
    $(document).on('click','.edit-record',function(e)  {
        e.preventDefault();
        var url = $(this).attr('href');
        var target = $(this).attr('target');
        if(url) {
            // # open in new window if "_blank" used
            if(target == '_blank') { 
                window.open(url, target);
            } else {
                window.location = url;
            }
        }          
    });
   
    
    
    //Aqui regresamos a una direccion referenciada
    $('#btn-salir').click(function(){
         location.href = this.href; // ir al link    
            
    });
    
    
    // Cargamos la lista de items
    function readRecords() {
      
        $('#list').html('');
        $('#list').addClass('loader');
        $("#list").load("MisTorneosList.php",function(){;
            $("#list").removeClass('loader');
        });
        $( "#New" ).prop( "disabled", false );

    }
 

    

   

 
    

   

    
    

});



	
</script>


    
    
 
</body>
</html>

