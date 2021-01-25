<?php
session_start();
require_once '../funciones/funciones_bootstrap.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Rank_cls.php';




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
        <title>Consulta Ranking Individual</title>
        <link rel="stylesheet" href="Normalize.css">
        <link rel="stylesheet" href="css/tenis_estilos.css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="shortcut icon" href="<?php echo $_SESSION['favicon']?> " />
    </head>
        
    <style>
        body{
             
            /* font-size:10px;
            background-image: url("../images/logo/fvt/tennis-mediacanchaxpelota.jpg");
            background-image: url("../images/logo/fvt/raqueta500x334.jpeg");
            background-color: #cccccc;
            height:auto;
            background-position:center ;
            background-repeat:no-repeat;
            background-size:auto;
            background-color:azure; */
            position: relative;
        }
        table{
            font-size: 10px;
        }
        #header{
            margin:0;
            
            
        }
        
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
        #title-ranking{
           
           background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
            color: <?php echo $_SESSION['color_jumbotron']?>;
            padding:10px;
        }
       .table-head{
            background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
            color: <?php echo $_SESSION['color_jumbotron']?>;

        }
        #myModal{
            font-size:10px;
           
        }
        #avatar{
            vertical-align: middle;
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
        #key {
            
            position: relative;
            /* //top:450px; */
            z-index:1;
            
        }
        #suggestions {
            box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
            height: auto;
            position: relative;
            /* top:5px; */
            z-index:2;
            width: 206px;
            left:50px;
            
        }
 
        #suggestions .suggest-element {
            font-size:10px;
            background-color: #EEEEEE;
            border-top: 1px solid #000;
            cursor: pointer;
            
            padding: 10px;
            width: 100%;
            float: left;
        }
        
        
        @media (min-width: 798px) {
            /* Los estilos aquí contenidos solo se aplicarán a partir
            del tamaño de pantalla indicado */
            #pportal{
              width: 100%;
            }
        }
        
        #key{
          color: #080808;
          font-size:small ;
          border:1px solid ;
        }
        .txtsearch{
          color:darkslategrey ;
          font-size:20px ;
          font-family:'Times New Roman', serif 'Courier New';
          padding: 5px 5px;
          
        }
        
    </style>
      

<body>
    <div class="container-fluid">  
            
            <?php  
               echo ' <div class="col-xs-12 ">
                    <img src="../images/logo/fvtlogo.png" class="img-responsive pull-left"></img>
                    </div>';
              
                echo '<br><hr>';
                
         echo '<div class="col-xs-12">';
           echo '<div class="imgportal">';
                echo '<div class="xcaption" >';
//                    echo '
//                    <img width=100%" height="300px" src="../images/logo/fvt/raqueta500x334.jpeg"/>
//                    ';
//                    echo '
//                    <img id="portal"  class="img-responsive"  src="../images/logo/fvt/tennis200.jpg"/>
                   echo '
                    <img id="portal"  width="100%" class="img-responsive"  src="../images/logo/fvt/tennis-mediacanchaxpelota.jpg"/>
                   
                    ';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        
            ?>
            <div class="col-xs-12 ">
                <h3 class="text text-center" >Ranking Individual</h3>
                <hr>
            </div>      
            <div class="col-xs-12  col-sm-6 col-sm-offset-3">
                <p class="txtsearch text text-center bg-success" >Introduzca el Apellido del Jugador que desea Consultar</p>
            </div>      
            <div class="col-xs-12  col-sm-6 col-sm-offset-3">
                <input type="text" id="key" name="key"   placeholder="Martinez" class="form-control  glyphicon glyphicon-search"/>
              
            </div>
            
            <div id="suggestions" class="col-xs-12">
    
            </div>
               
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content col-xs-12  ">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="col-xs-12 ">
                    
                    <div class="col-xs-6">
                        <img id="avatar"  src="../uploadFotos/perfil/female.jpg" ></img>
                    </div>
                    <div class="col-xs-offset-2 col-xs-4">
                        <img class="img-responsive"   src="../images/logo/fvtlogo.png" ></img>
                    </div>
                
                </div>
                
                    
                
                <div class="col-xs-10">
                    Tenista :<span class="text text-danger" id="header"></span>
                </div>

                <div class="col-xs-12">
                    Puntos :<span class="text text-danger" id="puntos"></span>
                </div>
    
              </div>
              
              <div  id="detail">
                  
              </div>
              
              
            </div>

          </div>
        </div>
        
        
            
        
        <div id="foto" class="col-xs-4 ">
<!--            <img id="avatar2"  src="../uploadFotos/perfil/female.jpg" ></img>-->
            
        </div>
        
        <div id="results" class="col-xs-12">
            
        </div>
        
      <div id="paginacion" class="col-xs-12 text text-center">

      </div>
</div>


<script>

$(document).ready(function(){
    
    //
    $("#key").keyup(function(e){
        e.preventDefault();
        var key = $(this).val();		
        var dataString = key;
        
            
        search=key;
//        $('#mensaje').addClass('loader');
//        $("#results").html('');
//        $("#paginacion").html('');
//        $('#foto').html(""); 
//        $("#avatar2").removeClass("img-responsive");
//                     
        if (key.length>4){
                    
            $.ajax({
            method: "POST",
            url: "BuscarNombre.php", 
            data: {search:dataString}
            })
            .done(function( data) {
                $('#suggestions').fadeIn(500).html(data.html2);
                $('.suggest-element').on('click', function(){
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    //Editamos el valor del input con data de la sugerencia pulsada
                    $('#key').val($('#'+id).attr('data'));
                    //Hacemos desaparecer el resto de sugerencias
                    $('#suggestions').fadeOut(500);
                    //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                    var sexo= $('#'+id).attr('sexo');
                    if (sexo!=="F"){
                        $("#avatar").attr("src","../uploadFotos/perfil/foto.jpg");
                        var img = document.createElement("img");
                        img.src = "../uploadFotos/perfil/foto.jpg";
                        img.id = "avatar2";
                    }else{
                        $("#avatar").attr("src","../uploadFotos/perfil/female.jpg");
                        var img = document.createElement("img");
                        img.src = "../uploadFotos/perfil/female.jpg";
                        img.id = "avatar2";
                    }
                    $('#foto').html(img); 
                    //$('#avatar2').addClass("img-responsive");
                    $("#avatar2").attr("class","img-responsive");
                    
                    Ranking(id);
                    return false;
                });
            });
        }
    });
    
    //Cargar las lista de jugadores con sus ranking
    function Ranking(dataid){
        id= dataid;
        $.ajax({
        method: "POST",
        url: "RankingByAtletaLoad.php", 
        data:  {id:id,pagina:0}
        })
        .done(function( data) {
        //   $('#mensaje').removeClass('loader');
           
            $('#results').html(data.html);
            $('#paginacion').html(data.pagination);
           
        });
    };
    
    //Paginando Ranking
    $(document).on('click','.page-link',function(e)  {
        e.preventDefault();
        var page = $(this).attr('data-id');   
        $.ajax({
            method: "POST",
            url: "RankingByAtletaLoad.php", 
            data:  {id:id,pagina:page}
        })
        .done(function( data) {
          // $('#mensaje').removeClass('loader');
           $('#results').html(data.html);
           $('#paginacion').html(data.pagination);
        
          // console.log(data.pagination);
        });
                  
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
           $('#header').html(data.Nombre);
           $('#puntos').html(data.Puntos);
           if (data.Success){
                $('#detail').html(data.html);
           }else{
              $('#detail').html("");
           }   
        });
                  
    });
     
});

</script>

</body>
</html>