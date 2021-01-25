<?php
session_start();
include_once '../funciones/funciones_bootstrap.php';

require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
 
//mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
//mb_http_output('UTF-8');  
//print_r($_SESSION['empresa_id']);

if (!isset($_SESSION['asociacion'])){
    header("location:http://mytenis");
}
?>


<!doctype html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="../css/tenis_estilos.css">
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
       
    </head>
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
  
<body>
    
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Ranking de Atletas</h2>
            
        </div>
    </div>
</div>
  
<div class="container"  > 
    <div class="row">
       
            <!-- Section de Calendario de Torneos -->
            <h4  class="title-table">RANKING : <?php echo $_SESSION['asociacion']?></h4>
            
            
            <ul class="nav nav-pills nav-pills-meses ">
                <li class="tab-presentation" role="presentation"><a href="#"   class="edit-record2" data-id="<?PHP echo $_SESSION['asociacion'] ?>">12 FEM</a></li>
                <li class="tab-presentation" role="presentation"><a href="#"   class="edit-record2" >12 MAS</a></li>
                <li class="tab-presentation" role="presentation"><a href="#"  class="edit-record2" >14 FEM</a></li>
                <li class="tab-presentation" role="presentation"><a href="#"  class="edit-record2>">14 MAS</a></li>
                <li class="tab-presentation" role="presentation"><a href="#"   class="edit-record2" >16 FEM</a></li>
                <li class="tab-presentation" role="presentation"><a href="#"   class="edit-record2" >16 MAS</a></li>
                <li role="presentation"><a href="#"   class="edit-record2" >18 FEM</a></li>
                <li role="presentation"><a href="#"   class="edit-record2" >18 MAS</a></li>
                <li role="presentation"><a href="#"  class="edit-record2" >PN FEM</a></li>
                <li role="presentation"><a href="#"  class="edit-record2" >PN MAS</a></li>
                <li role="presentation"><a href="#"  class="edit-record2" >PV FEM</a></li>
                <li role="presentation"><a href="#"  class="edit-record2" >PV MAS</a></li>
            </ul>
             
            <div class="calendario2">
            
            </div>
            
                    
            <div id="puntos">
                 
            </div>

                           
       
                        
                    
            
            
             <div id="results2">
            
            </div>
<!--  <div class="container"  >  
    Car:
<select class="field" name="cars">
  <option value="volvo">Volvo</option>
  <option value="saab">Saab</option>
  <option value="fiat">Fiat</option>
  <option value="audi">Audi</option>
</select>
   </div>-->
            
        
   </div> <!-- Fin de orw container Principal -->
    
  
</div>

    


   
<!--<script src="js/jquery-1-12-4.min.js"></script>
<script src="bootstrap/3.3.6/js/bootstrap.min.js"></script>-->




<script>

$(document).ready(function(){
   
  var cind ;
  
  // Manejamos la tabla de meses tabuladas con pildoras 
  // Al seleccionar un mes disparamos un ajax para presentar
  // el calendario
    $('.nav-pills-meses li').click(function(e){
        
        e.preventDefault();
         $("#results2").html('');
        if (!$(this).hasClass("active")){
            $(".nav-pills-meses li").removeClass('active');
            $(this).addClass("active");
            cind = $(this).index() + 1;
            var edo=$(".edit-record2").attr('data-id');
            $("#puntos").html('');
            $('#puntos').addClass('loader');

            $.post("bsranking_nacional_load.php",
                {estado:edo,catid: cind}, 
                function(html){
                        $('#puntos').removeClass('loader');
                        $('#puntos').html(html);
                       
            });

            $('.calendario2').show(100);
        }else{
            
            $('.calendario2').toggle(100);

        }
       
    });
    
    
    $("input").change(function(){
    alert("The text has been changed.");
    });
    $( "select" ).change(function() {
        alert( "Handler for .change() called." );
    });

    
  
   
    
   
});



	
</script>


</body>