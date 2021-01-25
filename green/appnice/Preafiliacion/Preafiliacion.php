<?php
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Nacionalidad_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Bootstrap_Class_cls.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Disciplina_cls.php';

//Programa para realizar la preafiliaciones

$nacionalidad=1;
$rsNaciones= Nacionalidad::ReadAll();

//Llenamos una recordset con las entidades para hacer seleccion en listbox

$estado=$_SESSION['asociacion'];
$array_entidades=Empresa::Entidades();

$indice = array_search($estado, array_column($array_entidades, 'estado'));
if ($indice >= 0) {
    if (strtoupper($estado) != 'FVT') {

        $rsEntidades[] = $array_entidades[$indice];
    } else {
        $rsEntidades = $array_entidades;
    }
} else {
    $rsEntidades = $array_entidades;
}

//Carga la disciplina de juego
$array_disciplina= Disciplina::ReadAll();
$rsDisciplina = $array_disciplina;

?>

<!DOCTYPE html>
<html lang="es">
<head>
   
    <title>Asociaciones</title>
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
    <div class="row">
        <div class="col-xs-8">
            <h2>Pre-Afiliacion Nuevo</h2>
        </div>
    </div>
</div>

<div class="signin-form">
   <div class="container">
        <?php 
        
        echo '<p class="alert alert-warning">'.Bootstrap_Class::label("Notificacion:","warning").'<br>AVISO:<br> Mediante esta Afiliacion usted podr&aacute participar en el Circuito Oficial de Competencias Nacionales e Internacionales
                y ser&aacute Afiliado al Estado <b>'.$Entidad.'</b> en donde usted formalizar&aacute(pago) su afiliaci&oacuten directamente. 
        </p>';
        
        ?>
         
        <div class="row">   
            <div class="col-xs-12">
                <form class="form-signin " method="post" id="register-form" >
                     
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="txt_asociacion">Estado</label>
                        <select name="txt_asociacion" class="form-control">
                        <?php
                        // Recorremos todas las lineas del archivo
                        foreach ($rsEntidades as $value) {
                          echo  '<option value="'.$value[estado].'">'.ucwords($value[entidad]).'</option>'; 
                        }
                        ?>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="txt_disciplina">Disciplina</label>
                        <select name="txt_disciplina" class="form-control">
                        <option value="TDP">Tenis de Playa</option>
                        <option selected value="TDC">Tenis de Campo</option>
                        </select>
                     </div>
                    
                    <div class="form-group col-xs-12 col-sm-4">
                    <label for="txt_nacionalidad">Nacionalidad</label>
                    <select name="txt_nacionalidad" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    foreach ($rsNaciones as $record) {
                       $pais=$record['pais'];
                       $id=$record['id'];
                       if ($id==nacion_id){
                            echo  '<option selected value="'.$record['id'].'">'.$pais.'</option>';
                       }else{
                           echo  '<option  value="'.$record['id'].'">'.$pais.'</option>';
                       }
                    }
                    ?>
                    </select>
                   </div>
                    
                    <div class="form-group col-xs-12 col-sm-4 ">
                    <label for="txt_cedula">Cedula</label>
                    <input type="text" class="form-control" lenght="20" id="txt_cedula" name="txt_cedula" placeholder="Cedula" >
                    </div>
                    
                     <div class="form-group col-xs-12 col-sm-6">
                      <label for="txt_nombres">Nombre</label>
                      <input type="text" class="form-control" lenght="50" id="txt_nombres" name="txt_nombres" placeholder="Nombre" >
                    </div>


                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="txt_apellidos">Apellido</label>
                      <input type="text" class="form-control" lenght="50" id="txt_apellidos" name="txt_apellidos" placeholder="Apellido" >
                    </div>
                    
                    <div class="form-group col-xs-12 col-sm-6">
                    <label for="txt_sexo">Sexo</label>
                        <select name="txt_sexo" class="form-control">
                        <option selected value="F">Femenino</option>
                        <option value="M">Masculino</option>
                    </select>
                     </div>
                     <div class="form-group col-xs-12 col-sm-6">
                        <label for="txt_fechaNacimiento">Fecha Nacimiento</label>
                        <input type="date" class="form-control"  id="txt_fechaNacimiento" name="txt_fechaNacimiento">
                     </div>
                    
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="txt_lugar_nac">Lugar de Nacimiento</label>
                      <input  type="text" class="form-control" lenght="20" placeholder="Lugar de nacimiento" id="txt_lugar_nac" lenght="30" name="txt_lugar_nac"  >
                    </div>
              
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                    <label for="txt_cedularep">Cedula Representante</label>
                    <input  type="text" class="form-control" lenght="20" placeholder="Cedula del Representante para menores" id="txt_cedularep" name="txt_cedularep" >
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                    <label for="txt_nombrerep">Nombre Representante</label>
                    <input  type="text" class="form-control" lenght="50" placeholder="Nombre del Representante para menores" id="txt_nombrerep" name="txt_nombrerep" >
                    </div>
                     
                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <label for="txt_lugar_trabajo">Lugar de Trabajo o Empresa</label>
                      <input type="text" class="form-control" lenght="20" id="txt_lugar_trabajo" lenght="40" placeholder="Lugar de Trabajo" name="txt_lugar_trabajo" >
                    </div>
                     
                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <label for="txt_celular">Celular</label>
                      <input  type="text" class="form-control" lenght="20" id="txt_celular" lenght="20" placeholder="Celular" name="txt_celular" >
                    </div>
                    
                    <div class="form-group col-xs-12">
                      <label for="txt_direccion">Direccion</label>
                      <textarea class="form-control" rows="2" lenght="150" id="txt_direccion" name="txt_direccion" placeholder="Direccion"></textarea>
                    </div>

                     <div class="form-group col-xs-12 col-sm-4 col-md-4">
                      <label for="txt_telefonos">Telefono</label>
                      <input type="text" class="form-control" lenght="45" id="txt_telefonos" name="txt_telefonos" placeholder="Telefono">
                    </div>
                   <div class="form-group col-xs-12 col-sm-8 col-md-8">
                      <label for="txt_email">Email</label>
                      <input type="email" class="form-control" lenght="100" id="txt_email" name="txt_email" placeholder="Email">
                    </div>

                    <div class="form-group hidden">
                      <label for="txt_id">Atleta</label>
                      <input type="text" class="form-control" id="txt_id" name="txt_id">
                    </div>  
                     <div id="error" class='span6'>
                    <!-- error will be showen here ! -->
                    </div>
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block" name="btn-save" id="btn-submit">
                        <span class="glyphicon glyphicon-log-in"></span> &nbsp; Pre-afiliarme
                        </button> 
                    </div>  
                    

                </form>
        
            </div> 
        </div>
    </div>
       
</div>

<script>

$(document).ready(function (){
    
    $.validator.addMethod("alfanumerico", function(value, element) {
        return /^[a-z0-9]*$/i.test(value);
    }, "Ingrese sólo letras o números.");
    
    $.validator.addMethod("formatoEmail", function(value, element) {
        return /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "Ingrese un Email Valido.");
 
    //Validar Formulario
    $( "#register-form" ).validate( {
            rules: {
                    txt_cedula: {
                        required: true,
                        minlength: 6,
                        alfanumerico: true
                     },
                    txt_nombres: "required",
                    txt_apellidos: "required",
                    txt_fechaNacimiento: "required",
                    txt_lugar_nac: "required",
                    txt_celular: "required",
                    txt_direccion:"required",
                    txt_telefonos: "required",
                    txt_email: {
                        required: true,
                        formatoEmail:true
                    }
            },
            messages: {
                    txt_nombres: "Ingrese un Nombre",
                    txt_cedula: "Ingrese una cedula",
                    txt_apellidos: "Ingrese un apellido",
                    txt_fechaNacimiento: "Ingrese una fecha de nacimiento",
                    txt_lugar_nac: "Lugar de Nacimiento es requerido",
                    txt_direccion: "Ingrese una direccion!",
                    txt_telefonos: "Por favor ingrese un numero de telefono!",
                    txt_email : "Ingrese un Email Valido!",
                    txt_celular: "Por favor ingrese un numero de celular!!",
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
    
    function calcular(){
	var fechanac = new Date(document.getElementById('txt_fechaNacimiento').value);
        var yyyy_nac=fechanac.getFullYear();
	var hoy = new Date();
        var yyyy_hoy=hoy.getFullYear();
	var edad= yyyy_hoy-yyyy_nac;
	if (edad<19){
            if (document.getElementById('txt_cedularep').value===null || document.getElementById('txt_nombrerep').value===null) {
                return false;
            }else{
                return false;
            }
        }else{
            return false;    
        }
    }
        
                
   function submitForm(){     
   //$('#register-form').on('submit',function(e){
           {
            //var data = new FormData(document.getElementById("myform"));
            //formData.append("operacion", op);
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            var data = $("#register-form").serialize();
            $.ajax({
                url: "PreafiliacionSave.php",
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
                                $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error cedula ya exite o datos invalidos!</div>');

                                $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp;  Pre-afiliarme');

                            });
                        }
                        else if(data=="registered")
                        {
                           $("#btn-submit").html('<img src="../images/btn-ajax-loader.gif" /> &nbsp; Registrando espere...');
                           setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("PreafiliacionSuccess.php"); }); ',5000);
                       }
                        else{
                           $("#error").fadeIn(1000, function(){
                           $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
                           $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Pre-afiliarme');
                           });
                        }
                    }
                });
                return false;
        }
    };
    //Link
    $('#btn-salir').click(function(){
        location.href = this.href; // ir al link    
    });
  
});
	
</script>
 
</body>
</html>

