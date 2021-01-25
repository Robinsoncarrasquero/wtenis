<?php
session_start();
include_once '../funciones/funciones_bootstrap.php';
include_once '../funciones/funciones.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once "../clases/Torneo_Draw_cls.php";
require_once "../clases/Atleta_cls.php";
require_once '../sql/ConexionPDO.php';


$atleta_id=$_GET['id'];//  487;//2681;//487;//htmlspecialchars($_GET['playerid']);
//$atleta_id=437;//  487;//2681;//487;//htmlspecialchars($_GET['playerid']);

$ObjAtleta = new Atleta();
$ObjAtleta->Find($atleta_id);

$foto="../fotos/ft".trim($ObjAtleta->getCedula()).'.jpg';

if (!file_exists($foto)){
   $foto="../fotos/ftdefault.jpg";
}
$rsHistorico = Torneo_Draw::AcividadDistinct($atleta_id);
$juegos=  count($rsHistorico);
$puntos=0;
foreach ($rsHistorico as $dataRow){
            
    $rsH2H = Torneo_Draw::PuntosObtenidos($atleta_id,$dataRow['categoria_id']);
    foreach ($rsH2H as $record){
        $puntos +=$record['puntos'];
    }
            
}
?>


<!doctype html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="Normalize.css">    
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
    </style>
  
<body>
    
<div class="container col-xs-12">
   
        <h3>Bio Player  </h3>
        <div class="col-xs-2">
            
            
            <img src="<?php echo $foto ?>" alt="..." class="img-responsive">
            
            
        </div>
    
        <div class="col-xs-2">
            
            <img src="../banderas/flagvenezuela.png" alt="..." class="img-responsive">
           
        </div>
   
</div>
    

  
<div class="container row-fluid"  > 
    <div class="col-md-12">
       
            <!-- Section de Calendario de Torneos -->
            
            <div class="form-group col-xs-12 col-md-6 ">
                    <label for="nombre">Nombre:</label>
                    <input disabled type="text" class="form-control" id="nombre"    value=" <?php echo $ObjAtleta->getNombreCompleto()?>">
            </div>
             <div class="form-group col-xs-12 col-md-6 ">
                    <label for="nacion">Nacionalidad:</label>
                    <input disabled type="text" class="form-control" id="nacion"    value="Portugal">
            </div>
            <div class="form-group col-xs-12 col-md-6 ">
                    <label for="fechanac">Fecha Nacimiento:</label>
                    <input disabled type="text" class="form-control" id="fechanac"    value=" <?php echo $ObjAtleta->getFechaNacimiento()?>">
            </div>
<!--            <div class="form-group col-xs-4 col-md-6 ">
                    <label for="sexo">sexo:</label>
                    <input disabled type="text" class="form-control" id="sexo"    value=" <?php echo $ObjAtleta->getSexo()?>">
            </div>-->
           
            <div class="form-group col-xs-6 col-md-6 hidden ">
                    <label for="Player">atleta:</label>
                    <input disabled type="text" class="form-control" id="cedula"    value=" <?php echo $ObjAtleta->getCedula()?>">
            </div>
           
            <div  id="results">
            
            </div>
             <div  id="respuesta">
            
            </div>
            
            
            <ul class="nav nav-pills nav-pills-meses">
               <?php
             
              
             
                  $bio=1;
                  //$puntos=1;
                  //$juegos=2;
                   
                   echo  '<li role="presentation" class="edit" data-id="1"><a href="#">Biografia'.'<span class="badge">'.$bio.'</span></a></li>';
                   echo  '<li role="presentation" class="edit" data-id="2"><a href="#">Actividad'.'<span class="badge">'.$juegos.'</span></a></li>';
                   echo  '<li role="presentation" class="edit" data-id="3"><a href="#">Puntos'.'<span class="badge">'.$puntos.'</span></a></li>';
            
               
               ?>
               </ul>
            
            
            
            
             
           
            
                    
            <div id="list">
                 
            </div>
         
             
           
        
   </div> <!-- Fin de orw container Principal -->
    
  
</div>

    


   
<!--<script src="js/jquery-1-12-4.min.js"></script>
<script src="bootstrap/3.3.6/js/bootstrap.min.js"></script>-->




<script>

$(document).ready(function(){
   
    
    //Variable global para controlar la categoria
    var op ;
    
    
    // Manejamos la tabla de meses tabuladas con pildoras 
    // Al seleccionar un mes disparamos un ajax para presentar
    // el calendario
    $('.nav-pills-meses li').click(function(e){
        
        e.preventDefault();
        $("#results").html('');
        $('#results').addClass('loader');
        if (!$(this).hasClass("active")){
            $(".nav-pills-meses li").removeClass('active');
            $(this).addClass("active");
            op = $(this).index() + 1;
            tid=$(this).closest('li').attr('data-id');
           
            var data_array = tid.split("-");
                       
            if (op==2){
                bactividad();
            }
            if (op==3){
                puntos();
            }
            
        }
       
    });
    
    
    function aactividad() {
        
	$("#results").html('');
        $('#results').addClass('loader');
	var opcion = "actividad",
        cedula = $("#cedula").val(),
	nombre = $("#nombre").val(),
        
	       
	//"nombre del parámetro POST":valor (el cual es el objeto guardado en las variables de arriba)
	datos = {"opcion":opcion,"cedula":cedula, "nombre":nombre};
        //alert (JSON.stringify(datos));
	$.post("H2H.php", 
            datos,
            function(html){
                
                $('#results').removeClass('loader');
                $('#list').html(html);
                if (html!==''){
                    
               }
               
            });
            
            
            
	
    };
    
    function puntos() {
        
	$("#results").html('');
        $('#results').addClass('loader');
	var opcion = "actividad",
        cedula = $("#cedula").val(),
	nombre = $("#nombre").val(),
        
	       
	//"nombre del parámetro POST":valor (el cual es el objeto guardado en las variables de arriba)
	datos = {"opcion":opcion,"cedula":cedula, "nombre":nombre};
        //alert (JSON.stringify(datos));
	$.post("Puntos.php", 
        datos,
        function(html){

            $('#results').removeClass('loader');
            $('#list').html(html);
            if (html!==''){
            }

        });

            
            
	
    };
    
    
     function bactividad() {
        
	$("#results").html('');
        $('#results').addClass('loader');
	var opcion = "actividad",
        cedula = $("#cedula").val(),
	nombre = $("#nombre").val(),
        
	       
	//"nombre del parámetro POST":valor (el cual es el objeto guardado en las variables de arriba)
	datos = {"opcion":opcion,"cedula":cedula, "nombre":nombre};
        //alert (JSON.stringify(datos));
	$.post("DataDinamica2.php", 
            datos,
            function(html){
                
                $('#results').removeClass('loader');
                $('#list').html(html);
                if (html!==''){
                    
               }
               
            });
            
            
            
	
    };
    
     function actividad() {
        
	$("#results").html('');
        $('#results').addClass('loader');
	var opcion = "actividad",
        cedula = $("#cedula").val(),
	nombre = $("#nombre").val(),
        
	       
	//"nombre del parámetro POST":valor (el cual es el objeto guardado en las variables de arriba)
	datos = {"opcion":opcion,"cedula":cedula, "nombre":nombre};
//        alert (JSON.stringify(datos));
	$.ajax({
            url: "DataDinamica.php",
            type: "POST",
            data: datos
	}).done(function(respuesta){
            if (respuesta.estado === "ok") {
                    console.log(JSON.stringify(respuesta));
                    var html = respuesta.html;
                    $("#list").html('');
                    $('#results').removeClass('loader');
                    $('#results').removeClass("alert alert-info");
                    $("#list").html(html);
                    //$("#respuesta").html("Servidor:<br><pre>"+JSON.stringify(respuesta, null, 2)+"</pre>");
                            
            }else{
                 
                alert("Servidor no responde, tenemos problemas");
            }
	});
    };
    
    
    
    
     
    
    
    
    
    
   
    
    $('#btn-salir').click(function(){
        var url =$(this).attr('href');
        var target =$(this).attr('target');
        if(url) {
           // # open in new window if "_blank" used
           if(target == '_blank') { 
               window.open(url, target);
           } else {
               window.location = url;
           }
        }  
            
    });
    
   
    
     
      
    
    
    
 
});



	
</script>


</body>
</html>