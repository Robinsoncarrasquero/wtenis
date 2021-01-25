<?php
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_email.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Encriptar_cls.php';

 if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula =$_SESSION['cedula'];
    $menuuser= $_SESSION['menuuser'];
  
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    $msg="<div style='color:red;margin-top:100;margin-left: 200px' ><h1 >ACCESO DENEGADO, USUARIO NO AUTORIZADO</h1></div> ";
//    for($i=0;$i<4;$i++){
//     echo $msg; }
     //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_cerrar.php');
    exit;
}
 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Cambio de Email</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style >
            .loader{

                    background-image: url("images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
    </style>

    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
    <link rel="stylesheet" href="../css/master_page.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery/1.15.0/dist/jquery.validate.js"></script>
    		
</head>
<body>
    
<div class="container-fluid">

    <?php   
        
        //Menu de usuario
        include_once '../Template/Layout_NavBar_User.php';
        echo '<br><hr>';
    ?>
    <h2>Cambio de Correo</h2>
<div class="col-xs-12 col-sm-8">

    <div class="signin-form">
       
        <form class="form-signin" method="post" id="register-form">

            <div id="error">
            <!-- error will be showen here ! -->
            </div>
             
            <div class="form-group col-xs-12">
               
                <input type="email" class="form-control" placeholder="Ingrese un Email" name="user_email" id="user_email" />
            </div>

            <div class="form-group col-xs-12">
                <input type="email" class="form-control" placeholder="Repita Email" name="cuser_email" id="cuser_email" />
            </div>
            <hr />

            <div class="form-group col-xs-12">

                 <button type="button" class="btn btn-primary" name="btn-close" id="btn-close">
                    <span class="glyphicon glyphicon-chevron-left "></span> &nbsp; Cancelar
                </button>
                <button type="submit" class="btn btn-warning" name="btn-save" id="btn-submit">
                    <span class="glyphicon glyphicon-chevron-right"></span> &nbsp; Aceptar

                </button> 

            </div> 

        </form>

    </div>
</div>
    
<div class="col-xs-12 col-sm-4">
    <div class="notas-left">
    <?php
    
     Bootstrap_Class::mensajes_notas("Notificacion:","text-primary",
                "En este correo personal usted recibir&aacute toda la informacion que realice en esta plataforma",
                "text-default","alert-warning");
       
    ?>
    </div>
</div>
    
    

    
    
<script>    
// JavaScript Document

$('document').ready(function()
{ 
     /* validation */
	 $("#register-form").validate({
      rules:
	  {
                    
			user_email: {
                        required: true,
                        email: true},
			cuser_email: {
			required: true,
			equalTo: '#user_email'}
			
			
			
	   },
       messages:
	   {
                    
                    user_email: {
                        required: "Por favor introduzca un email valido",
                        
                    },
                    
                    cuser_email: {
                        required: "Por favor introduzca un email valido",
                        equalTo: "Email deben ser identicos !"
                    }
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	   function submitForm()
	   {		
                    var data = $("#register-form").serialize();

                    $.ajax({

                    type : 'POST',
                    url  : 'bsChangeEmailSubmit.php',
                    data : data,
                    beforeSend: function()
                    {	
                            $("#error").fadeOut();
                            $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
                    },
                    success :  function(data)
                        {						
                            if(data==1){

                                $("#error").fadeIn(1000, function(){
                                    $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry Hubo un error!</div>');

                                    $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Proceder');

                                });

                            }
                            else if(data==0)
                            {

                                $("#error").fadeIn(1000, function(){
                                $("#error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-thumbs-up"></span> &nbsp;  En hora buena, su e-mail ha sido cambiado exitosamente !</div>');
                                $("#btn-submit").addClass('hidden');
                                $("#btn-close").removeClass("hidden");
                                $("#btn-close").prop('href', 'bsPanel.php');
                                $("#btn-close").html('<span class="glyphicon glyphicon-info-sign"></span> &nbsp; Continuar');

                                    });

                            }
                            else{

                                $("#error").fadeIn(1000, function(){

                                $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');

                                $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Proceder');

                                });

                            }
                        }
                    });
                    return false;
		}
	   /* form submit */
	   
	   
//Aqui regresamos a una direccion referenciada
    $('#btn-close').click(function(){
         var href="../bsPanel.php";
         location.href = href; // ir al link    
            
    });	 

});
</script>
</body>
</html>

