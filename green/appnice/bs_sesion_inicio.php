<?php
session_start();
include_once 'extensions/Mobile-Detect.php';
require_once 'conexion.php';


// header('Location: mantenimiento.php'); 

// Deshabilitar todo reporte de errores 
//error_reporting(1); 
//$usuarios = array(
//    array('nombre' => 'roberto', 'contrasena' => '1234'),
//    array('nombre' => 'jorge', 'contrasena' => '1234'),
//    array('nombre' => 'toni', 'contrasena' => '1234')
// );
 $usuarios = array();
// if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
//    echo 'We don\'t have mysqli Connection failed:';
//    exit;
//    
//} else {
//    echo 'Phew we have it!';
 
 //Aqui vamos a colocar codigo de Asociacion que este en browser
 
 
 
?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Login</title>
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
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script type="text/javascript" src="js/jquery/1.15.0/lib/jquery-1.11.1.js"></script>-->
    <script type="text/javascript" src="js/jquery/1.15.0/dist/jquery.validate.js"></script>
    
  		
</head>
<body>
    
<!-- Content Section -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2>Login</h2>
            
            
        </div>
    </div>
</div>
   
<div class="signin-form">
    <div class="container">    
        <div class="row">
            
                <form class="form-signin " method="post" id="register-form" >
                    
                     <div class="form-group col-xs-12 ">
                        <input type="text" class="form-control" id="usuario" name="usuario" maxlength="20" placeholder="Cedula">
                     </div>

                     <div class="form-group col-xs-12 ">
                        <input type="password" class="form-control" placeholder="Password" name="contrasena" id="contrasena" />
                    </div>
                    
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn btn-primary" name="btn-save" id="btn-submit">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Entrar
                        </button> 
                    </div>  

                <div class="form-group col-xs-12 ">     
                    <p> <a href="Perfil/bsRecoveryKey.php">Restablecer la clave</a> </p>
                </div>
                </form>
                <div id="error" class="span6">

                </div>
            
            
        </div>
    </div>
</div>
         
<script>
$(document).ready(function (){
    
    
    //Validar Formulario
    $( "#register-form" ).validate( {
            rules: {
                    usuario: {
                            required: true,
                            minlength: 6
                    },
                    contrasena:{required: true}
                    
                    
                   

            },
            messages: {
                    usuario: "Usuario requerido",
                    contrasena: "Password requerido"
                   
                  

            },
            
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                    // Add the `help-block` class to the error element
                    error.addClass( "alert alert-danger" );

                    if ( element.prop( "type" ) === "checkbox" ) {
                            error.insertAfter( element.parent( "label" ) );
                    } else {
                            error.insertAfter( element );
                    }
            },
            highlight: function ( element, errorClass, validClass ) {
                    $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
                    $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: submitForm
           
    } );
    
    
   function submitForm(){     
   //$('#register-form').on('submit',function(e){
           
           
                
           // var data = new FormData(document.getElementById("#register-form"));
            
            var data = $("#register-form").serialize();
            $.ajax({
                url: "bs_sesion_inicio_submit.php",
                type: "POST",
                data:data,
                beforeSend: function()
                {	
                        $("#error").fadeOut();
                        $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
                },
                success :  function(data)
                    {						
                        if(data==1){

                            $("#error").fadeIn(1000, function(){
                                $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Clave o Usuario Invalido!</div>'+data);

                                $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp;  Entrar');

                            });

                        }
                        else if(data==0)
                        {
                            
                            $("#btn-submit").html('<img src="images/btn-ajax-loader.gif" /> &nbsp; Logueando...');
                             var href='sesion_usuario.php';
                            location.href = href;
                             

                        }
                         else 
                        {
                             $("#error").fadeIn(1000, function(){
                            $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Servicio no disponible,Intente mas tarde..</div>'.data);

                            $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp;  Entrar');
                        });
                             

                        }
                        
                    }
                });
                return false;
           
        

    };
        
    
     //Aqui regresamos a una direccion referenciada
     
    
    
    
});
    
</script>


  
    
</body>

     
</html>
