<?php
session_start();
//require_once '../conexion.php';
//require_once '../funciones/funcion_email.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once '../funciones/bsTemplate.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once  '../clases/Torneos_cls.php';
require_once  '../clases/Torneos_Inscritos_cls.php';

if (!isset($_SESSION['logueado']) || !$_SESSION['logueado']){
    //Si el usuario no está logueado redireccionamos al login.
    $msg="<div style='color:red;margin-top:100;margin-left: 200px' ><h1 >ACCESO DENEGADO, USUARIO NO AUTORIZADO</h1></div> ";
//    for($i=0;$i<4;$i++){
//     echo $msg; }
     //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_cerrar.php');
    exit;
}

 echo bsTemplate::header('Cambio de Clave',$_SESSION['nombre']);
 echo bsTemplate::aside();
 //Main content
 $main = [];
 $dmain =["opcion"=>"Cambio Clave","icono"=>"glyphicon glyphicon-lock","href"=>""];
 array_push($main, $dmain);
 echo  bsTemplate::main_content('Cambio de Clave',$main);
 
?>

<div class=" row col-xs-12 col-sm-12 col-md-8">
    
    <div class="signin-form ">
        
        <form class="form-signin" method="post" id="register-form">
      
            <div id="error">
            <!-- error will be showen here ! -->
            </div>
            <p class="lead">La clave debe contener un minimo de 6 caracteres y un maximo de 12</p>
                        
            <div class="form-group ">
                <input type="password" minlength="6" maxlength="12" class="form-control" placeholder="Ingrese una clave" name="password" id="password" />
            </div>
            
            <div class="form-group ">
                <input type="password" minlength="6" maxlength="12" class="form-control" placeholder="Repita la clave" name="cpassword" id="cpassword" />
            </div>

            <div class="form-group">
                
                <button type="submit" class="btn btn-primary" name="btn-save" id="btn-submit">
                <span ></span> &nbsp; Aceptar
                </button> 
                
            </div> 
        
        </form>

    </div> 
</div>

<?php
    $texto =' '
    . 'Es importante cambiar la clave peri&oacutedicamente para mantener la seguridad de sus datos.'
    . ' La clave debe tener un minimo de 6 caracteres y un maximo 12.' 
    . ' Debe estar compuesta por caracteres alfanumericos y al menos un numero o mas al final de la clave.';
    echo bsTemplate::panel('<i class="icon_key label label-warning"></i>
    Clave',$texto,'alert alert-warning','hidden-xs hidden-sm col-md-4');
?>
        
<?php echo bsTemplate::footer();?>

<script>    

$('document').ready(function(){ 
    
    $('#register-form').on('submit',function(e){
        //var ok=confirm("Esta Seguro de Modificar Los Datos");
        var data = $("#register-form").serialize();
        $.ajax({
        type : 'POST',
        url  : 'ChangeKeySubmit.php',
        data : data,
        // beforeSend: function()
        // {	
        //     $("#error").fadeOut();
        //     $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Procesando ...');
        // },
        success :  function(data)
            {						
                if(data.Success==false){
                    $("#error").fadeIn(1000, function(){
                        $("#error").html('<div class="alert alert-danger">'
                        +'<span class="glyphicon glyphicon-circle"></span>'+data.Mensaje+'</div>');
                    
                        $("#btn-submit").html('<span></span> &nbsp; Aceptar');
                    });
                    swal("¡ Error !", "Cambio de clave no fue procesada :)", "warning");
                }else{
                    $("#error").fadeIn(1000, function(){
                        $("#error").html('<div class="alert alert-success"><span class="glyphicon glyphicon-thumbs-up">'
                        +'</span> &nbsp; En hora buena, su clave ha sido cambiada exitosamente</div>');
                        $("#btn-submit").html('<span class="glyphicon glyphicon-ok"></span> &nbsp; Aceptar');
                    // 
                        $("#password").prop('value',"");
                        $("#cpassword").prop('value',"");
                    // $("#btn-close").prop('href', 'bsPanel.php');
                    swal("¡Bien!", "Cambio de clave fue efectuada. Un correo fue enviado :)", "success");
                    });
                }
            }
        });
        return false;
	})
	   

});
</script>
</body>
</html>

