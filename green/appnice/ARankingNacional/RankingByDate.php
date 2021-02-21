<?php
session_start();
require_once '../funciones/funciones_bootstrap.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Rank_cls.php';


if (!isset($_SESSION['asociacion'])){
    $_SESSION['asociacion']='FVT';
    header("location: ../bsindex.php");
    exit;
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
        <title>Consulta Ranking Nacional x Fecha</title>
        <link rel="stylesheet" href="Normalize.css">
        <link rel="stylesheet" href="css/tenis_estilos.css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="shortcut icon" href="<?php echo $_SESSION['favicon']?> " />
        
     
            
    </head>
    
    <style>
        body{
            /* //font-size:10px;
            //background-image: url("../images/logo/fvt/raqueta500x334.jpeg");
            //background-color: #cccccc;
            //height:auto;
            //background-position:center ;
            //background-repeat:no-repeat;
            //background-size:auto; */
        
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
        #avatar {
            vertical-align: middle;
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
    </style>
  
<body>

    
<div class="container-fluid">  
            
            <?php  
                //Menu de usuario
               if(isset($_SESSION['niveluser']) && $_SESSION['niveluser']>0){
                   include_once '../Template/Layout_NavBar_Admin.php';
               }else{
                     //include_once '../Template/Layout_NavBar_Guess.php';
                echo ' <div class="col-xs-12 ">
                    <a target="" href=""> <img src="../images/logo/fvtlogo.png" class="img-responsive pull-left"></img></a>
                    </div>';
               }
                echo '<br><hr>';
                
        echo '<div class="col-xs-12">';
           echo '<div class="xthumbnail">';
                echo '<div class="xcaption">';
                   //echo '
                   //     <img width=100%" height="300px" src="../images/logo/fvt/raqueta500x334.jpeg">
                   //     ';
                   echo '
                       <img id="portal"  width="100%" class="img-responsive"  src="../images/logo/fvt/tennis-mediacanchaxpelota.jpg"/>
                       ';
                   
                echo '</div>';
            echo '</div>';
        echo '</div>';
        
            ?>
            
    <div >
            <h3 class="text text-center" >Ranking Por Fecha</h3>
       
        
            <div class="col-xs-12  col-md-3 ">
                <b>Disciplina</b>

                 <select id="cmbdisciplina" name="cmbdisciplina" class="form-control col-md-4"> 

                 </select>
            </div>

          
            <div class="col-xs-12  col-md-3 ">
                <b>Categoria</b>

                 <select  id="cmbcategoria" name="cmbcategoria" class="form-control col-md-4"> 

                 </select>
            </div>

            <div class="col-xs-12  col-md-3 ">
                <b>Sexo</b>

                 <select  id="cmbsexo" name="cmbsexo" class="form-control col-md-4"> 

                 </select>
            </div>
            
            <div class="col-xs-12  col-md-3 ">
                <b>Fecha</b>

                 <select data-id="<?php echo $_SESSION['asociacion']?>" id="cmbfechark" name="cmbfechark" class="form-control col-md-12"> 

                 </select>
            </div>
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
              
              <div id="detail">

              </div>
              
              
            </div>

          </div>
        </div>
        
        <div id="mensaje" class="col-xs-12 ">

        </div>

        <div id="results" class="col-xs-12 ">

        </div>
        <div id="paginacion" class="col-xs-12 text text-center">

        </div>
           
</div>

<script>

$(document).ready(function(){
    
    //Cargamos las tablas en en list box
    fillCombo('disciplina');
    fillCombo('sexo');
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
    
     
    $('#cmbsexo,#cmbcategoria').change(function(e){
        e.preventDefault();
        var x = document.getElementById("cmbfechark");
        var l = document.getElementById("cmbfechark").options.length;
        for(var i=0;i<l;i++){
            x.remove(i);
        }
        var sexo = $("#cmbsexo").val();
        
        var categoria = $("#cmbcategoria").val();
        var disciplina = $("#cmbdisciplina").val();
        if (sexo==="M"){
            $("#avatar").attr("src","../uploadFotos/perfil/foto.jpg");
        }else{
            $("#avatar").attr("src","../uploadFotos/perfil/female.jpg");
        }
        
        $('#mensaje').addClass('loader');
        $("#results").html('');
        $("#paginacion").html('');
        $.ajax({
        method: "POST",
        url: "Ranking_Datos_Combo_FechaRK.php", 
        data: {sexo:sexo,categoria:categoria,disciplina:disciplina}
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
    
    
    //Cargar las lista de jugadores con sus ranking
    $('#cmbfechark').change( function(e){
        e.preventDefault();
        rkid= $('#cmbfechark').val();
       
//        $("#mensaje").html('');
//        $('#mensaje').addClass('loader');
//        $("#results").html('');
        edo=$(this).attr('data-id');
        
        $.ajax({
        method: "POST",
        url: "RankingByDateLoad.php", 
        data:  {rkid:rkid,estado:edo,pagina:0}
        })
        .done(function( data) {
        //   $('#mensaje').removeClass('loader');
           $('#results').html(data.html);
           $('#paginacion').html(data.pagination);
            
        });
       
                         
    });
    
    //Paginando Ranking
    $(document).on('click','.page-link',function(e)  {
        e.preventDefault();
        var page = $(this).attr('data-id');
//        $("#mensaje").html('');
//        $('#mensaje').addClass('loader');
//        $("#results").html('');
//        
        $.ajax({
            method: "POST",
            url: "RankingByDateLoad.php", 
            data:  {rkid:rkid,estado:edo,pagina:page}
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
            if (!data.html) return e.preventDefault(); // stops modal from being shown
            $('#header').html(data.Nombre);
            $('#puntos').html(data.Puntos);
            if (data.Success){
                if (data.Sexo==="M"){
                    $("#avatar").attr("src","../uploadFotos/perfil/foto.jpg");
                }else{
                    $("#avatar").attr("src","../uploadFotos/perfil/female.jpg");
                }
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