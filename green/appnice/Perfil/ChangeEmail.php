<?php
session_start();
//require_once '../conexion.php';
//require_once '../funciones/funcion_email.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once '../funciones/bsTemplate.php';
require_once '../clases/Atleta_cls.php';
require_once  '../sql/ConexionPDO.php';
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
$objAtleta = new  Atleta();
$objAtleta->Fetch(0,$_SESSION['cedula']);

 echo bsTemplate::header('Cambio de Email',$_SESSION['nombre']);
 echo bsTemplate::aside();
 //Main content
 $main = [];
 $dmain =["opcion"=>"Cambio Email","icono"=>"glyphicon glyphicon-envelope","href"=>""];
 array_push($main, $dmain);
 echo  bsTemplate::main_content('Cambio de Email',$main);
    
?>


<div class="col-xs-12 col-sm-12 col-md-8">

    <div class="signin-form ">
       
        <form class="form-signin" method="post" id="register-form">

            <div id="error">
            <!-- error will be showen here ! -->
            </div>
             
            <div class="form-group ">
                <section class="panel">
                    <header class="panel-heading" ">
                        Email Actual: <span id="my_email"><?php echo $objAtleta->getEmail() ?></span>
                    </header>
                </section>
            </div>
                                                   
            <div class="form-group ">
               
                <input type="email" class="form-control" placeholder="Ingrese un Email" name="email" id="email"/>
            </div>

            <div class="form-group ">
                <input type="email" class="form-control" placeholder="Repita el Email" name="cemail" id="cemail" />
            </div>
    

            <div class="form-group  ">

                <button type="submit" class="btn btn-primary" name="btn-save" id="btn-submit">
                    <span ></span> &nbsp; Aceptar

                </button> 

            </div> 

        </form>

    </div>

</div>

<?php
    $texto =' '
    ."En este correo personal usted recibir&aacute toda la informacion que realice en esta plataforma";
    echo bsTemplate::panel('<i class="icon_mail label label-warning"></i>Email',
    $texto,'alert alert-warning','hidden-xs hidden-sm col-md-4');
?>
       
        

<?php echo bsTemplate::footer();?>
    
   
<script>    

$('document').ready(function()
{ 
    $('#register-form').on('submit',function(e){
        //var ok=confirm("Esta Seguro de Modificar Los Datos");
        var data = $("#register-form").serialize();
        $.ajax({
        type : 'POST',
        url  : 'ChangeEmailSubmit.php',
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
                        +'<span class="glyphicon glyphicon-info-sign"></span>'+data.Mensaje+'</div>');
                    
                        $("#btn-submit").html('<span></span> &nbsp; Aceptar');
                        swal("¡ Error !", "Cambio de correo no fue procesado :)", "warning");
                    });
                }else{
                    $("#error").fadeIn(1000, function(){
                        $("#error").html('<div class="alert alert-success"><span class="glyphicon glyphicon-thumbs-up">'
                        +'</span> &nbsp; '+data.Mensaje+'</div>');
                        $("#btn-submit").html('<span class="glyphicon glyphicon-ok"></span> &nbsp; Aceptar');
                    // 
                        $("#my_email").html($("#email").val());
                        
                        $("#email").prop('value',"");
                        $("#cemail").prop('value',"");
                    // $("#btn-close").prop('href', 'bsPanel.php');
                    swal("¡Bien!", "Cambio de correo fue procesado :)", "success");
                    });
                }
            }
        });
        return false;
	})
    /* form submit */

});
</script>
</body>
</html>

