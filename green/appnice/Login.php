<?php
session_start();
include 'extensions/Mobile-Detect.php';
require_once 'conexion.php';
require_once 'clases/Html_cls.php';



?>


<!DOCTYPE html>
<html lang="es">
    <head>
    
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
       
    <style >
        .loader{

        background-image: url("images/ajax-loader.gif");
        background-repeat: no-repeat;
        background-position: center;
        height: 100px;
        }
        #gwd-reCAPTCHA{
            transform: scale(0.90);
            transform-origin: 0 0;

        }
    </style>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="js/jquery/1.15.0/dist/jquery.validate.js"></script>
    

<script type="text/javascript">
    var verifyCallback = function(response) {
        //alert(response);
        $("#btn-submit").removeAttr('disabled');
        $("#usuario").removeAttr('disabled');
        $("#contrasena").removeAttr('disabled');
        $("#lk-restablecer").removeAttr('hidden');
      };
      var expCallback = function(response) {
        //alert(response);
        $("#btn-submit").addAttr('disabled');
        $("#usuario").addAttr('disabled');
        $("#contrasena").addAttr('disabled');
        $("#lk-restablecer").addAttr('hidden');
      };
      
      
      var onloadCallback = function() {
        
        grecaptcha.render('gwd-reCAPTCHA', {
          'sitekey' : '6LdLe0oUAAAAAKGVN0BNUDwTkKLlkcVAGI_LXyzU',
          'callback' : 'verifyCallback',
          'expired-callback':'expCallback'
        });
      };
    </script>

</head>
<body>
  
<!-- Content Section -->
<div class="container">
    <div class="col-xs-12 ">
        <a href="<?php echo $_SESSION['home']?>"   ><img  src="images/logo/fvtlogo.png" class="img-responsive pull-left"></img></a>
    </div>
     <div class="col-xs-12 ">
         <br>
    </div>
    
    
</div>


<div class="signin-form">
    
    
    <div class="container">    
        
            <form   class="form-signin " method="post" id="register-form" >
                    
                     <div class="form-group col-xs-12 ">
                         <input type="text" class="form-control" id="usuario" name="usuario" maxlength="20" placeholder="Cedula" >
                     </div>

                     <div class="form-group col-xs-12 ">
                         <input type="password" class="form-control" placeholder="Password" name="contrasena" id="contrasena">
                    </div>
                
                    <div class="form-group col-xs-12">
                        <?php 
                        if (MODO_DE_TEST==0) {
                            echo '<button type="submit" class="btn btn-primary" name="btn-save" id="btn-submit" disabled="disabled">';
                        }else{
                            echo '<button type="submit" class="btn btn-primary" name="btn-save" id="btn-submit">';
                        }
                      ?>
                            
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Entrar
                        </button> 
                    </div>  

                <div id="lk-restablecer" class="form-group col-xs-12" >     
                    <p> <a  href="Perfil/bsRecoveryKey.php" >Restablecer la clave</a> </p>
                </div>
                </form>
                <div id="error" class="span6">

                </div>
               
                <div id="gwd-reCAPTCHA" class="col-xs-12">
                    

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
                            minlength: 4
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
           
        {

        // var data = new FormData(document.getElementById("#register-form"));

         var data = $("#register-form").serialize();
         $.ajax({
             url: "Login_Submit.php",
             type: "POST",
             data:data,
             beforeSend: function()
             {	
                     $("#error").fadeOut();
                     $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
             },
             success :  function(data)
                 {						
                     if(data===1){

                         $("#error").fadeIn(1000, function(){
                             $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Clave o Usuario Invalido!</div>');

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
                         $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Servicio no disponible,Intente mas tarde..</div>');

                         $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp;  Entrar');
                     });


                     }

                 }
             });
             return false;



        };
    };
        
    
    
});
    
</script>
 <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
                    async defer>
 </script>

  
    
</body>

     
</html>
