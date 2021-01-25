

<!DOCTYPE html>
<html lang="es">
<head>   
    <title>Recuperar Clave</title>
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery/1.15.0/dist/jquery.validate.js"></script> 		
</head>
<body>
     
<!-- Content Section -->
<div class="container">
    
        
    <div class="col-xs-12 ">
        <a href="bsindex.php"   ><img  src="../images/logo/fvtlogo.png" class="img-responsive pull-left"></img></a>
    </div>
     <div class="col-xs-12 ">
         <br>
    </div>
    
    

 
<div class="signin-form">
    
            <div class="col-xs-12">
                <form class="form-signin " method="post" id="register-form" >
                   
                   <div class="form-group col-xs-12">
                    <label for="txt_cedula">Cedula</label>
                    <input type="text" class="form-control" lenght="20" id="txt_cedula" name="txt_cedula" placeholder="Cedula" >
                    </div>
                    <div class="form-group col-xs-6">
                        <p class="alert alert-warning">Mensaje: Introduzca la fecha de nacimiento solo en caso de no poseer un correo registrado.</P>
                    </div>
                    
                    <div class="form-group col-xs-6">
                        <label for="txt_fechaNacimiento">Fecha Nacimiento</label>

                        <input type="date" class="form-control"  id="txt_fechaNacimiento" name="txt_fechaNacimiento">

                    </div>
                
                    <div class="form-group col-xs-12">
            
                        <button type="button" class="btn btn-primary" name="btn-close" id="btn-close">
                           <span ></span> &nbsp; Continuar
                       </button>
                       <button type="submit" class="btn btn-warning" name="btn-save" id="btn-submit">
                           <span class="glyphicon glyphicon-log-in"></span> &nbsp; Aceptar

                       </button> 
            
                    </div> 
                                      
                </form>
                <div id="error" class="span6">
                    
                </div>
          
                <div id="mensaje" >

                </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function (){
       
    //Validar Formulario
    $( "#register-form" ).validate( {
            rules: {
                    txt_cedula: {
                        required: true,
                        minlength: 6
                    },
                    txt_fechaNacimiento: {
                        required:false},
           },
            messages: {
                    txt_cedula: "Cedula requerida",
                    txt_fechaNacimiento: "Fecha Nacimiento requerida"
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
                    $( element ).parents( ".col-sm-6" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
                    $( element ).parents( ".col-sm-6" ).addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: submitForm
           
    } );
    
    
   function submitForm(){     
    
            var data = $("#register-form").serialize();
            $.ajax({
                url: "bsRecoveryKeySubmit.php",
                type: "POST",
                data:data,
                beforeSend: function()
                {	
                    $("#error").fadeOut();
                    $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
                },
                success :  function(data)
                    {						
                         if(data.Success)
                        {
                            $("#error").fadeIn(1000, function(){
                            $("#btn-submit").html('<span class="glyphicon glyphicon-ok">OK</span> &nbsp;');
                            $("#btn-submit").addClass('hidden');
                            $("#btn-close").removeClass("hidden");
                            $("#btn-close").prop('href', '../sesion_cerrar.php');
                            $("#btn-close").html('<span class="glyphicon glyphicon-info-sign"></span> &nbsp; Continuar');
                            });
                            $("#mensaje").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-thumbs-up">'+data.Mensaje+'</span>&nbsp;...</div>');
                        }
                        else
                        {
                            $("#error").fadeIn(1000, function(){
                           // $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-thumbs-down"></span> &nbsp; '+data.Mensaje+'</div>');
                            $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp;  Aceptar');
                            });
                            $("#mensaje").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-thumbs-down">'+data.Mensaje+'</span>&nbsp;...</div>');
                        }
                        
                    }
                });
                return false;
    };
        
    $('#btn-close').click(function(){
         var href="../sesion_inicio.php";
         location.href = href; // ir al link    
            
    });	   
});
    
</script>
    
</body>
</html>

