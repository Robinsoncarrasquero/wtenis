<?php
//Programa para agregar un jugador a la lista de aceptacion
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../sql/Crud.php';

require_once '../funciones/funcion_fecha.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../clases/Torneos_cls.php';
require_once '../clases/Atleta_cls.php';
if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula =$_SESSION['cedula'];
    $email =$_SESSION['email'];
    
       
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_inicio.php');
    exit;
 }
if ( $_SESSION['niveluser']<9){
    header('Location: ../sesion_usuario.php');
    exit;
}


$key_id =explode("-",$_GET['tid']); 
//$key_id =explode("-","273-18-F"); 
$torneo_id=$key_id[0];
$categoria=$key_id[1]; // Categoria
$sexo = $key_id[2]; //Sexo



$objTorneo = new Torneo();
$objTorneo->Fetch($torneo_id);

    





?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Editando un Jugador</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    

    <style >
            .loader{

                    background-image: url("../images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
    </style>

    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script type="text/javascript" src="js/jquery/1.15.0/lib/jquery-1.11.1.js"></script>-->
    <script type="text/javascript" src="../js/jquery/1.15.0/dist/jquery.validate.js"></script>
    
  		
</head>
<body>
    
<!-- Content Section -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2>Agregar Jugador</h2>
            
           
        </div>
    </div>
</div>
   
<div class="signin-form">

    <div class="container">
        <div class="row">   
            <div class="col-xs-12">
                <form class="form-signin" method="post" id="register-form"  >
                 <div  class="respuesta">
            
                 </div>
                 <div class="form-group col-xs-12 ">
                     <label for="cedula">Cedula:</label>
                     <input type="text" class="form-control" name="cedula" id ="cedula" maxlength="10"  placeholder="cedula" value="">
                     <button type="button" class="btn btn-primary" name="btn-buscar" id="btn-buscar">
                            <span class="glyphicon glyphicon-folder-close"></span> &nbsp; Buscar
                     </button>
                 </div>
                  <div class="form-group col-xs-6 ">
                     <label for="nombre">Nombre:</label>
                     <input disabled type="text" class="form-control" name="nombre" id="nombre"   >
                 </div>
                 <div class="form-group col-xs-6 ">
                     <label for="apellido">Apellido:</label>
                     <input disabled type="text" class="form-control" name="apellido" id="apellido" >
                 </div>
                 <div class="form-group col-xs-12 col-md-6">
                     <label for="categoria">Categoria:</label>
                     <input type="text" class="form-control" id="categoria"    value=" <?php echo $categoria?>">
                 </div>
                    
                <div class="form-group col-xs-12 col-md-6">
                     <label for="sexo">Sexo:</label>
                     <input type="text" class="form-control" id="sexo"    value=" <?php echo $sexo?>">
                </div>
                    
                <div class="form-group col-xs-12 col-md-6 hidden">
                    <label for="torneo">Torneo:</label>
                     <input disabled type="text" class="form-control" id="torneo_id"    value=" <?php echo $torneo_id?>">
                </div>
                 
                                
                <div class="form-group col-xs-12">
                        <button type="button" class="btn btn-primary" name="btn-close" id="btn-close">
                            <span class="glyphicon glyphicon-folder-close"></span> &nbsp; Salir
                        </button>
                        <button type="button" class="btn btn-primary" name="btn-save" id="btn-save">
                      
                         <span class="glyphicon glyphicon-floppy-save"></span> &nbsp; Guardar
                        </button> 
                </div>  
                
                    
                </form>
<!--            </div>-->

    </div>


    </div>
 </div>
<script>

$(document).ready(function (){
    
    
    $("#btn-buscar").click(function(e) {
        
	e.preventDefault();
	var cedula = $("#cedula").val(),
	nombre = $("#nombre").val(),
	apellido = $("#apellido").val(),
        
	//"nombre del parámetro POST":valor (el cual es el objeto guardado en las variables de arriba)
	datos = {"cedula":cedula, "nombre":nombre,"apellido":apellido};
//        alert (JSON.stringify(datos));
	$.ajax({
            url: "BuscarCedula.php",
            type: "POST",
            data: datos
	}).done(function(respuesta){
            if (respuesta.estado === "ok") {
                    //console.log(JSON.stringify(respuesta));
                    
                    var nombre = respuesta.nombre,
                    apellido = respuesta.apellido,
                    cedula = respuesta.cedula,
                    atleta_id = respuesta.atleta_id;
                    $("#nombre").val(nombre);
                    $("#apellido").val(apellido);
                    //$("#respuesta").html("Servidor:<br><pre>"+JSON.stringify(respuesta, null, 2)+"</pre>");
                            
            }
	});
    });
    
    $("#btn-save").click(function(e) {
        
	e.preventDefault();
	var cedula = $("#cedula").val(),
	categoria = $("#categoria").val(),
	sexo = $("#sexo").val(),
        torneo_id = $("#torneo_id").val(),
        rk =0,
        
	//"nombre del parámetro POST":valor (el cual es el objeto guardado en las variables de arriba)
	datos = {"cedula":cedula, "categoria":categoria,"sexo":sexo,"torneo_id":torneo_id};
        //alert (JSON.stringify(datos));
	$.ajax({
            url: "TorneoListaAceptacionJugadorSave.php",
            type: "POST",
            data: datos
	}).done(function(respuesta){
            if (respuesta.estado === "ok") {
                    //console.log(JSON.stringify(respuesta));
                    
                    var nombre = respuesta.nombre,
                    apellido = respuesta.apellido,
                    cedula = respuesta.cedula,
                    mensaje = respuesta.mensaje;
                    
                   // $("#respuesta").html("Servidor:<br><pre>"+JSON.stringify(respuesta, null, 2)+"</pre>");
                   
                    $(".respuesta").html('');
            
                    $(".respuesta").addClass("alert alert-success").text("Datos registrados con exito");
                
            }else{
                
                var nombre = respuesta.nombre,
                    apellido = respuesta.apellido,
                    cedula = respuesta.cedula,
                    mensaje = respuesta.mensaje;
                    $(".respuesta").html('');
            
                    $(".respuesta").addClass("alert alert-danger").text("Registro ya existe");
                
            }
	});
    });
    
    
    //Aqui cerramos la window
    $('#btn-close').click(function(){
         window.close();
            
    });
    
    
    
    


});



	
</script>
    
</body>
</html>
