<?php
session_start();
include_once '../funciones/funciones_bootstrap.php';

require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Rank_cls.php';
require_once '../clases/Html_cls.php';
require_once '../clases/Bootstrap_Class_cls.php';
require_once '../clases/Bootstrap2_cls.php';
//mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
//mb_http_output('UTF-8');  
//print_r($_SESSION['empresa_id']);

if (!isset($_SESSION['asociacion'])){
    header("location:../sesion_inicio.php");
}

//Presentar los iconos de la pagina
//    echo '<div class="col-xs-12">';
//      Bootstrap::master_page();
//    echo '</div>'; //Container    

?>


<!DOCTYPE html>
<html lang="en">
    
     <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Asociaciones</title>
        <meta name="description" content="Sitio web para Inscripciones onLine para Torneos de Tenis de Campo y Tenis de Playa">
<!--        <link rel="stylesheet" href="Normalize.css">
        <link rel="stylesheet" href="css/tenis_estilos.css">-->
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="shortcut icon" href="<?php echo $_SESSION['favicon']?> " />
        
     
            
    </head>
    
    <style>
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

    
<div class="container-fluid">  
    
   
    <div class="row">
        
    
        <div class="col-xs-12 col-md-12" >
             <img  src="../images/logo/fvtlogo.png" class="img-responsive"></img>


            <div class="text text-left col-xs-12" >
                 <h4  class="title-table">Ranking : <?php echo $_SESSION['asociacion']?></h4>

            </div>


            <div class="col-xs-12  col-md-4 ">
                <b>Disciplina</b>

                 <select id="cmbdisciplina" name="cmbdisciplina" class="form-control col-md-4"> 

                 </select>
            </div>

            <div class="col-xs-12  col-md-4 ">
                <b>Categoria</b>

                 <select  id="cmbcategoria" name="cmbcategoria" class="form-control col-md-4"> 

                 </select>
            </div>


            <div class="col-xs-12  col-md-4 ">
                <b>Fecha</b>

                 <select data-id="<?php echo $_SESSION['asociacion']?>" id="cmbfechark" name="cmbfechark" class="form-control col-md-12"> 

                 </select>
            </div>

        </div>         
    
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content ">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="col-xs-12">
                <a> <img width="20%" src="../images/logo/fvtlogo.png" class="img-responsive"></img></a>
                </div>
                <h5 class="text text-center">Ranking Nacional</h5>
                <h5>Nombre :
                <div id="header" class="label label-default">

                </div>
                </h5> 
                <h5>Puntos :
                <div id="puntos" class="label label-default">

                </div>
                </h5>
              </div>
              <div class="modal-body">

                <div id="detail">

                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
        
        <div id="mensaje" class=col-xs-12 col-md-12">

        </div>

        <div id="results" class="col-xs-12 col-md-12">

        </div>
        
    </div>
   
</div>

<script>

$(document).ready(function(){
    
    //Cargamos las tablas en en list box
    fillCombo('disciplina');
    fillCombo('categoria');
        
    function fillCombo(tabla){
        var latabla=tabla;
        $.ajax({
        method: "POST",
        url: "Ranking_Datos_Combo.php", 
        data: { tabla:latabla}
        })
        .done(function(data ) {
           //Empresa o Estados
            var ecount = Object.keys(data.tabla).length;
            var datalistbox = document.getElementById("cmb"+latabla);
            console.log(ecount);
            console.log(data);
            for(var i=0;i<ecount;i++){
               datalistbox.options[i] = new Option(data.tabla[i].texto,data.tabla[i].value);
            }
        });
     
    }
    
     
    $('#cmbcategoria').change(function(e){
       
        e.preventDefault();
        var categoria = $("#cmbcategoria").val();
        var disciplina = $("#cmbdisciplina").val();
        $('#mensaje').addClass('loader');
        $.ajax({
        method: "POST",
        url: "Ranking_Datos_Combo_FechaRK.php", 
        data: {categoria:categoria,disciplina:disciplina}
        })
        .done(function( data) {
            var ecount = Object.keys(data.tabla).length;
            var datalistbox = document.getElementById("cmbfechark");
            console.log(ecount);
            console.log(data);
            for(var i=0;i<ecount;i++){
               datalistbox.options[i] = new Option(data.tabla[i].texto,data.tabla[i].value);
            }
            $('#mensaje').removeClass('loader');
         });
    });
    
    
    //Control de calendario
    $('#cmbfechark').change( function(e){
        e.preventDefault();
        var rkid= $('#cmbfechark').val();
       
        $("#mensaje").html('');
        $('#mensaje').addClass('loader');
        $("#results").html('');
        var edo=$(this).attr('data-id');
       
        $.post("ranking_Load_Ranking_By_Date.php",
        {rkid:rkid,estado:edo}, 
        function(html){
           $('#mensaje').removeClass('loader');
           $('#results').html(html);
        });
                  
    });
    
       
    //Ranking detallado
    $("#myModal").on('show.bs.modal', function(e){
       
        var button = $(e.relatedTarget); // Button that triggered the modal
        var rkid = button.data('whatever'); // Extract info from data-* attributes
        var id = button.data('id'); // Extract info from data-* attributes
        $.ajax({
        method: "POST",
        url: "rankingDetail.php", 
        data: {rkid:rkid,id:id}
        })
        .done(function( data) {
              //console.log(data.html);
           if (!data.html) return e.preventDefault(); // stops modal from being shown
           $('#header').html(data.Nombre);
           $('#puntos').html(data.Puntos);
           $('#detail').html(data.html);
        });
                  
    });
     
});

</script>

</body>
</html>