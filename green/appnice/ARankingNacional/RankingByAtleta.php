<?php
session_start();
require_once '../funciones/funciones_bootstrap.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once '../clases/Bootstrap2_cls.php';

if (!isset($_SESSION['atleta_id'])){
    $_SESSION['asociacion']='FVT';
    header("location: ../Login.php");
    exit;
}

//Tabla de atleta
$objAtleta= new Atleta();
$objAtleta->Find($_SESSION['atleta_id']);
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ranking</title>
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
        #header{
            margin:0;
            
        }
        #puntos{
            margin:0;
        }
        .table-head{
            background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
            color:<?php echo $_SESSION['color_jumbotron'] ?>;
        }
        #myModal{
            font-size:10px;
           
        }
        #avatar {
            vertical-align: middle;
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
    </style>
    </head>
  
<body>

    
<div class="container">  
 
        <?php 

            include_once '../Template/Layout_NavBar_User.php';
            
            //Presentar un Usuario
            echo "<br>";
            echo '<div class="col-xs-12">';
            echo '<hr>';
            echo '<h2>Mis Rankings</h2>';
            echo '<h6 class="titulo-name">Ranking Nacional de :'.($objAtleta->getNombreCompleto()).'</h6>';
            echo '<h4  hidden id="id">'.($objAtleta->getID()).'</h4>';
            echo '<h4  hidden id="sexo">'.$objAtleta->getSexo().'</h4>';

            echo '</div>'; //Container    

        
        ?>
             

     
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content col-xs-12  ">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="col-xs-12 ">
                    <div class="col-xs-4">
                        <img class="img-responsive"   src="../images/logo/fvtlogo.png" ></img>
                    </div>
                    
                    <div class="col-xs-offset-4 col-xs-4">
                        <img id="avatar"  src="../uploadFotos/perfil/foto.jpg" ></img>
                    </div>
                
                </div>
                    
                
                 <div class="col-xs-10">
                     Tenista :<span class="text text-danger" id="header"></span>
                 </div>
                 
                 <div class="col-xs-12">
                     Puntos :<span class="text text-danger" id="puntos"></span>
                 </div>
                <div class="col-xs-12" id="detail">

                </div>
             
              </div>
              
            </div>

          </div>
        </div>
        
        <div id="mensaje" class="col-xs-12">

        </div>

        <div id="results" class="col-xs-12 ">

        </div>
        <div id="paginacion" class="col-xs-12 text text-center ">

        </div>
    

<script>

$(document).ready(function(){
    
    var id=$("#id").text();
    var sexo=$("#sexo").text();
    if (sexo==="M"){
        $("#avatar").attr("src","../uploadFotos/perfil/foto.jpg");
    }else{
        $("#avatar").attr("src","../uploadFotos/perfil/female.jpg");
    }
    
    $("#mensaje").html('');
    $('#mensaje').addClass('loader');
    $("#results").html('');
    $.ajax({
        method: "POST",
        url: "RankingByAtletaLoad.php", 
        data:  {id:id,pagina:0}
    })
    .done(function( data) {
       $('#mensaje').removeClass('loader');
       $('#results').html(data.html);
       $('#paginacion').html(data.pagination);
       
    });
    
    
    //Ranking detallado
    $("#myModal").on('show.bs.modal', function(e){
       
        var button = $(e.relatedTarget); // Button that triggered the modal
        var rkid = button.data('whatever'); // Extract info from data-* attributes
        var id = button.data('id'); // Extract info from data-* attributes
        
        
        $.ajax({
        method: "POST",
        url: "RankingDetail.php", 
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
     
    //Ranking detallado
    $(document).on('click','.page-link',function(e)  {
        e.preventDefault();
        var page = $(this).attr('data-id');
        
        $.ajax({
            method: "POST",
            url: "RankingByAtletaLoad.php", 
            data:  {id:id,pagina:page}
        })
        .done(function( data) {
           $('#mensaje').removeClass('loader');
           $('#results').html(data.html);
           $('#paginacion').html(data.pagination);
           
        });
                  
    });
        
        
     
});

</script>

</body>
</html>