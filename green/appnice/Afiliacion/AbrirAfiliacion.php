<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Helper_cls.php';

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
    header('Location: ../sesion_inicio.php');
    exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<10){
   header('Location: ../sesion_inicio.php');
   exit;
}
?>
<!DOCTYPE HTML>
    <html lang="es">
    <head>
    <title>Abrir afiliacion anual</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php Helper::get_stylesheet();?>

    <style>
        .loader{
            background-image: url("../images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 180px;
        }
            
    </style>
        
    </head>
    
    <body>
    
    <div class="container-fluid">
            <?php  
                //Menu de usuario
                include_once '../Template/Layout_NavBar_Admin.php';
                echo '<br><hr>';
            ?>


    
<!-- Content Section -->
<div class="container">
    <div class="row">
        <div class="col-xs-8">
            <h2>Datos de Apertura</h2>
        </div>
    </div>
</div>




    <div class="container">
               
        <div class="row">  

            <div class="form-group col-xs-12 col-sm-4 ">
                <label for="periodo">Periodo</label>
                <input type="number" class="form-control" lenght="4" id="periodo" name="periodo" value="<?php echo date('Y')?>" >
            </div>
                                
            <div class="form-group  col-xs-12 col-sm-4">
                <label for="moneda">Moneda</label>
                <input class="form-control"  lenght="3" id="moneda" name="moneda" placeholder="$" value="$" >
            </div>

            <div class="form-group  col-xs-12 col-sm-4">
                <label for="txt_tarifa">Tarifa</label>
                <input type="number" class="form-control" maxlength="5"  id="tarifa" name="tarifa" value=25>
            </div>

            
            
            <div id="mensaje" class='span6'>
            <!-- error will be showen here ! -->
            </div>
            <div id="error" class='span6'>
            <!-- error will be showen here ! -->
            </div>
            <div class="form-group col-xs-4">
                <button  type="button" class="btn btn-primary" name="btn-procesar" id="btn-procesar">
                <span class="glyphicon glyphicon-log-in"></span> &nbsp; Procesar
                </button> 
            </div> 
            <div id="list" class='span6'>
            
            </div>
            
        </div>
    </div>
       

<!-- /Content Section -->

<script>

$(document).ready(function() {
    //$(document).on('click', '.Procesar', function(e){
    
        $('#btn-procesar').click(function(e){
        
          var periodo = $("#periodo").val();
         
          var moneda = $("#moneda").val();
          
          var tarifa = $("#tarifa").val();
         
          
          e.preventDefault();
          
             
          if ($("#mensaje").has("alert alert-success")){
              $("#mensaje").removeClass("alert alert-success");
          }
          if ($("#mensaje").has("alert alert-info")){
              $("#mensaje").removeClass("alert alert-info");
          }
          if ($("#mensaje").has("alert alert-warning")){
              $("#mensaje").removeClass("alert alert-warning");
          }
          
          $('#list').html('');
          $('#list').addClass('loader');
          $('#paginacion').html('');
          $('#mensaje').html('');
          
                 
          $.ajax({
          method: "POST",
          url: "abrir_afiliacion_post.php", 
          data: { periodo:periodo,moneda:moneda,tarifa:tarifa}
          })
          .done(function( data ) {
             
              if (data.success){
                  $('#list').removeClass('loader');
                  $("#list").html(data.html);
                  $("#mensaje").addClass("alert alert-success");
                  $("#mensaje").html(data.msg);
               }else{
                  $('#list').html('');
                  $('#list').removeClass('loader');
                  $("#mensaje").addClass("alert alert-danger");
                  $("#mensaje").html(data.msg);
              }
             
          });
           
        });
      
      
             
  });


</script>
</body>
</html>
