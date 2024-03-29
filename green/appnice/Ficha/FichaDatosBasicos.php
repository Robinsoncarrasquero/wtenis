<?php
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Nacionalidad_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Bootstrap_Class_cls.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Disciplina_cls.php';
require_once '../clases/Encriptar_cls.php';

if (!isset($_SESSION['niveluser']) || !isset($_SESSION['logueado'])){
    header("Location:../Login.php");
    
}
 

$hidden="";
if ($_SESSION['niveluser']==9){
    $readonly="readonly";
    $disabled="disabled";
    $atleta_id = htmlentities($_GET['id']);
    $hidden_btn_regresar=" ";
    $hidden_btn_guardar="hidden";
}
if ($_SESSION['niveluser']>9){
    $readonly=" ";
    $disabled=" ";
    $atleta_id = htmlentities($_GET['id']);
    $hidden_btn_regresar=" ";
    $hidden_btn_guardar=" ";
}
if ($_SESSION['niveluser']==0){
    if ($_SESSION['deshabilitado']){
        $readonly=" ";
        $disabled=" ";
   
    }else{
        $readonly="readonly ";
        $disabled="disabled";
    }
    $atleta_id = $_SESSION['atleta_id'];
    $hidden_btn_regresar=" ";
    $hidden_btn_guardar=" ";
   
}

$ObjAtleta = new Atleta();
$ObjAtleta->Find($atleta_id);
if ($ObjAtleta->edad()<19){
    $junior=TRUE;
    $hidden_datos_representante="";
}else{
    $junior=FALSE;
    $hidden_datos_representante="hidden";
}
//Obtenemos los datos de la empresa o asociacion del atleta
//para verificar si puede ver la clave del afiliado de la asociacion
$objEmpresa = new Empresa();
$objEmpresa->Fetch($ObjAtleta->getEstado());
if ($_SESSION['niveluser']>=99 || ($_SESSION['niveluser']>=9 && $objEmpresa->get_Empresa_id()==$_SESSION['empresa_id'])){
    $puedeverclave=true;
}else{
    $puedeverclave=false;
}

//Obtenemos la afiliacion del atleta del ano para que pueda afiliar y aceptar la afiliacion
$objAfiliado = new Afiliaciones();
$objAfiliado->Find_Afiliacion_Atleta($ObjAtleta->getID(),date("Y"));

$deshabilitado = $objAfiliado->getPagado() > 0 ? FALSE : TRUE;
if ($_SESSION['niveluser']==9 && $deshabilitado){
    $readonly=" ";
    $disabled=" ";
    $hidden_btn_regresar=" ";
    $hidden_btn_guardar=" ";
}

$objAfiliaciones = new Afiliaciones();
$objAfiliaciones->Atleta($atleta_id);//Se busca la ultima afiliacion registrada 
$nacionalidad=$ObjAtleta->getNacionalidadID();
$rsNaciones= Nacionalidad::ReadAll();

//Llenamos una recordset con las entidades para hacer seleccion en listbox

$estado=$ObjAtleta->getEstado();
$array_entidades=Empresa::Entidades();

$indice = array_search($estado, array_column($array_entidades, 'estado'));

if ($indice >= 0 ) {
    if ($_SESSION['niveluser']<99) {
        $rsEntidades[] = $array_entidades[$indice];
    } else {
        $rsEntidades = $array_entidades;

    }
} else {
    $rsEntidades = $array_entidades;
}

//Carga la disciplina de juego
$array_disciplina= Disciplina::ReadAll();
$indice = array_search($ObjAtleta->getDisciplina(), array_column($array_disciplina, 'disciplina'));
if ($indice >= 0) {
    if ($_SESSION['niveluser']<99) {
       $rsDisciplina[] = $array_disciplina[$indice];
    } else {
       $rsDisciplina = $array_disciplina;
    }
} else {
    $rsDisciplina = $array_disciplina;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Ficha</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style >
            .loader{
                   background-image: url("../images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
            body{
                max-height: 50%;
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
    
<div class="container-fluid">

     
<?php  
    //Menu de usuario
    if ($_SESSION['niveluser']>0){
        include_once '../Template/Layout_NavBar_Admin.php';
        echo '<br><hr>';
    }else{
       include_once '../Template/Layout_NavBar_User.php';
       echo '<br><hr>';
    }
    
    echo '<h2>Ficha</h2>';
    //Mensaje de cambios de la ficha
    $objAtleta= $ObjAtleta;
    if ($objAtleta->getCelular()==NULL || $objAtleta->getLugarNacimiento()==NULL || 
        $objAtleta->getCedulaRepresentante()==NULL || $objAtleta->getNombreRepresentante()==NULL ||
        $objAtleta->getDireccion()==NULL){
            if ($objAtleta->edad()<19){
                
                echo '<div class="col-xs-12">';
                echo '<h6><p class="alert alert-danger">'.Bootstrap_Class::label("Notificacion:","danger").'<br>Los datos del Representante del Atleta menor deben estar actualizados.'
                        . 'Llene la informacion de contacto de su representante, padres o responsables..'.'</p><h6>';
                echo '</div>';
                echo '</div>';
            }else{
                
                echo '<div class="col-xs-12">';
                echo '<h6><p class="alert alert-danger">'.Bootstrap_Class::label("Notificacion:","danger").'<br>Los datos del Atleta no estan actualizados.'
                        . 'LLene la informacion en las planilla de datos basicos.'.'</p><h6>';
                echo '</div>';
                
            }         
    }else{
        
        echo '<div class="col-xs-12">';
        //echo '<p class="alert alert-info">'.Bootstrap_Class::texto("Notificacion:","warning").' Es muy importante que actualice los datos del Perfil como Sexo, Telefonos, Direccion, Correo'.'</p>';
        echo '<p class="alert alert-success">'.Bootstrap_Class::texto("Notificacion:","success").'<br>Los datos del atleta parecen estar completos y actualizados. Fecha de Actualizacion :'.$objAtleta->getFechaModificacion().'</p>';
        echo '</div>';
        
        
    }


?>
    <div class="signin-form">

        <form class="form-signin " method="post" id="register-form" >
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="txt_asociacion">Estado</label>
                        <select  name="txt_asociacion" class="form-control">
                        <?php
                        // Recorremos todas las lineas del archivo
                        foreach ($rsEntidades as $value) {
                           if ($value['estado']==$estado){
                                echo  '<option selected value="'.$value['estado'].'">'.ucwords($value['entidad']).'</option>'; 
                            }else{
                                echo  '<option value="'.$value['estado'].'">'.ucwords($value['entidad']).'</option>'; 
                           }
                           
                        }
                        ?>
                            

                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="txt_disciplina">Disciplina</label>
                        <select   name="txt_disciplina" class="form-control">
                                               
                        <?php
                        // Recorremos todas las lineas del archivo
                        foreach ($rsDisciplina as $record) {
                           
                           if ($ObjAtleta->getDisciplina()==$record['disciplina']){
                                echo  '<option selected value="'.$record['disciplina'].'">'.$record['descripcion'].'</option>';
                           }else{
                                echo  '<option  value="'.$record['disciplina'].'">'.$record['descripcion'].'</option>';
                   
                           }
                        }
                        ?>
                        
                        </select>
                     </div>
           
                    <div class="form-group col-xs-12 col-sm-4 ">
                    <label for="txt_cedula">Cedula</label>
                    <input <?php echo $readonly?>  type="text" class="form-control" lenght="20" id="txt_cedula" name="txt_cedula" value="<?php echo $ObjAtleta->getCedula()?>" >
                    </div>
                    
                     <div class="form-group col-xs-12 col-sm-4">
                      <label for="txt_nombres">Nombre</label>
                      <input <?php echo $readonly?>   type="text" class="form-control" lenght="50" id="txt_nombres" name="txt_nombres" value="<?php echo $ObjAtleta->getNombres()?>"  >
                    </div>
                    
                    
                    <div class="form-group col-xs-12 col-sm-4">
                      <label for="txt_apellidos">Apellido</label>
                      <input <?php echo $readonly?>  type="text" class="form-control" lenght="50" id="txt_apellidos" name="txt_apellidos"value="<?php echo $ObjAtleta->getApellidos()?>"  >
                    </div>
                    
                    <div class="form-group col-xs-12 col-sm-4">
                        <label for="txt_fechaNacimiento">Fecha Nacimiento</label>

                        <input <?php echo $readonly?> type="date" class="form-control"  id="txt_fechaNacimiento" name="txt_fechaNacimiento" value="<?php echo $ObjAtleta->getFechaNacimiento()?>">

                    </div>
           
                     <div class="form-group col-xs-12 col-sm-4">
                    <label for="txt_sexo">Sexo</label>
                        <select   name="txt_sexo" class="form-control">
                        <?php
                        if ($ObjAtleta->getSexo()=='F'){
                            echo '<option selected value="F">Femenino</option>';
                            echo '<option value="M">Masculino</option>';
                        }else{
                           echo '<option value="F">Femenino</option>';
                           echo '<option selected value="M">Masculino</option>';
                        }     
                        ?>
                    </select>
                     </div>
                    <div class="form-group  col-xs-12 col-sm-4 hidden">
                      <label for="txt_id">Atleta</label>
                      <input  readonly type="text" class="form-control" id="txt_id" name="txt_id" value="<?php echo $ObjAtleta->getID()?> ">
                    </div>
                   
                     <div class="form-group col-xs-12 col-sm-4">
                    <label for="txt_nacionalidad">Nacionalidad</label>
                    <select  name="txt_nacionalidad" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    foreach ($rsNaciones as $record) {
                       $pais=$record['pais'];
                       $id=$record['id'];
                       if ($id==$ObjAtleta->getNacionalidadID()){
                            echo  '<option selected value="'.$record['id'].'">'.$pais.'</option>';
                       }else{
                            echo  '<option  value="'.$record['id'].'">'.$pais.'</option>';
                       }
                    }
                    ?>
                    </select>
                    </div>
                    
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="txt_lugar_nac">Lugar de Nacimiento</label>
                      <input  type="text" class="form-control" lenght="20" placeholder="Lugar de nacimiento" id="txt_lugar_nac" lenght="30" name="txt_lugar_nac" value="<?php echo $ObjAtleta->getLugarNacimiento()?>" >
                    </div>
              
                    <div class="form-group col-xs-12 col-sm-6 col-md-6 <?php echo $hidden_datos_representante?>">
                    <label for="txt_cedularep">Cedula Representante</label>
                    <input  type="text" class="form-control" lenght="20" placeholder="Cedula del Representante" id="txt_cedularep" name="txt_cedularep" value="<?php echo $ObjAtleta->getCedulaRepresentante()?>">
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6 <?php echo $hidden_datos_representante?>">
                    <label for="txt_nombrerep">Nombre Representante</label>
                    <input  type="text" class="form-control" lenght="50" placeholder="Nombre del Representante" id="txt_nombrerep" name="txt_nombrerep" value="<?php echo $ObjAtleta->getNombreRepresentante()?>">
                    </div>
                     
                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <label for="txt_lugar_trabajo">Lugar de Trabajo o Empresa</label>
                      <input type="text" class="form-control" lenght="20" id="txt_lugar_trabajo" lenght="40" placeholder="Lugar de Trabajo" name="txt_lugar_trabajo" value="<?php echo $ObjAtleta->getLugarTrabajo()?>" >
                    </div>
                     
                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <label for="txt_celular">Celular</label>
                      <input  type="text" class="form-control" lenght="20" id="txt_celular" lenght="20" placeholder="Celular" name="txt_celular" value="<?php echo $ObjAtleta->getCelular()?>" >
                    </div>
                    
                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <label for="txt_telefonos">Telefono</label>
                      <input   type="text" class="form-control" lenght="45" placeholder="Telefono" id="txt_telefonos" name="txt_telefonos" value="<?php echo $ObjAtleta->getTelefonos()?>" >
                    </div>

                    <div class="form-group col-sm-12">
                      <label for="txt_direccion">Direccion</label>
                      <textarea   class="form-control" rows="2" lenght="150" placeholder="Direcccion" id="txt_direccion" name="txt_direccion" placeholder="Direccion"><?php echo $ObjAtleta->getDireccion()?></textarea>
                    </div>
      
                   <div class="form-group col-sm-12">
                      <label for="txt_email">Email</label>
                      <input <?php echo $readonly?> type="email" class="form-control" lenght="100" id="txt_email" name="txt_email" value="<?php echo $ObjAtleta->getEmail()?>" >
                    </div>
                    
                    <?php
                    
                    if ($puedeverclave){
                        echo '<div class="form-group col-xs-12">';
                        echo ' <label for="txt-clave">Clave</label>';
                        echo ' <input type="text" class="form-control" lenght="100" id="txt_clave" name="txt_clave" value="'.$ObjAtleta->getContrasena().'" >';
                        echo '</div>';
                    }
                    
                   
                    ?>

                      
                    <div id="error" class='span6'>
                    <!-- error will be showen here ! -->
                    </div>
                    
                    
                     
                    <div class="form-group col-xs-12 col-md-6 <?php echo $hidden_btn_regresar; ?> ">
                        <a  href="#" id="btn-salir" class="btn btn-primary btn-block " role="button">
                        <span class="glyphicon glyphicon-backward"></span> &nbsp; Regresar
                        </a>      
                    </div>

                     <div class="form-group col-xs-12 col-md-6 <?php echo $hidden_btn_guardar ?>  ">
                        <button  type="submit" class="btn btn-primary btn-block" name="btn-save" id="btn-submit">
                        <span class="glyphicon glyphicon-log-in"></span> &nbsp; Guardar
                    </div>
                    
                    
                    
                     <div id="success" class='span6'>
                    <!-- error will be showen here ! -->
                    </div>
                   </form>
          
    </div>
       
</div>
<!-- /Content Section -->

<script>

$(document).ready(function (){
    
    $.validator.addMethod("alfanumerico", function(value, element) {
        return /^[a-z0-9]*$/i.test(value);
    }, "Ingrese sólo letras o números.");
    
    $.validator.addMethod("formatoEmail", function(value, element) {
        return /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "Ingrese un Email Valido.");
    
   
     //Aqui regresamos a una direccion referenciada
    $('#btn-salir').click(function(){
        $("#btn-salir").html('Cerrando ventana ...').addClass("alert alert-success");
                          
        setTimeout('$(".form-signin").fadeOut(100, function(){ $(".signin-form").load("FichaDatosBasicosSuccess.php"); }); ',0);
                   
        //location.href = this.href; // ir al link   
        
            
    });
    
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
                    txt_cedularep: {
                            required: true,
                            minlength: 6,
                            alfanumerico: true
                     },
                    txt_celular: "required",
                    txt_nombrerep: "required",
                    txt_direccion:"required",
                    txt_telefonos: "required",
                   
                    txt_email: {
                            required: true,
                            formatoEmail:true
                    }
                   

            },
            messages: {
                    
                    txt_nombres: "Ingrese un Nombre",
                    txt_apellidos: "Ingrese un Apellido",
                    txt_lugar_nac: "Ingrese una lugar de nacimiento ejemplo(Caracas)",
                    txt_fechaNacimiento: "Ingrese una fecha de nacimiento",
                    txt_cedularep: "Cedula del Representate requerida!",
                    txt_nombrerep: "Nombre del Representate requerido!",
                    txt_direccion: "Ingrese una direccion!",
                    txt_telefonos: "Por favor indique un telefono!",
                    txt_celular  : "Por favor indique un Celular!",
                    txt_email : "Ingrese un Email Valido!"
                   
                    

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
        //var ok=confirm("Esta Seguro de Modificar Los Datos");
        var ok=true;
        if (ok){
            //var data = new FormData(document.getElementById("myform"));
            //formData.append("operacion", op);
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            var data = $("#register-form").serialize();
            $.ajax({
                url: "FichaDatosBasicosSave.php",
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

                                $("#error").fadeIn(800, function(){
                                $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error cedula ya exite o datos invalidos!</div>');

                                $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp;');

                            });

                        }else if(data==2){
                           $("#btn-submit").html(' Datos actualizados exitosamente ...').addClass("alert alert-success");
                           $("#btn-submit").attr('disabled',true);
                          
                           setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("FichaDatosBasicosSuccess.php"); }); ',2000);
                        }else{
                            
                            $("#error").fadeIn(1000, function(){

                                $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');

                                $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Guardar');

                            });
                        }
                        
                    }
                });
                return false;
                
         }
           
        

    };
        
   //Aqui regresamos a una direccion referenciada
    $('#btn-salir').click(function(){
         location.href = this.href; // ir al link    
            
    });
    
    
    
    


});



	
</script>
	
 
 
</body>
</html>
